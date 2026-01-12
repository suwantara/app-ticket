<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Passenger;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookingForm extends Component
{
    // Booking session data
    public $schedule;

    public $returnSchedule;

    public $travelDate;

    public $returnDate;

    public $passengerCount;

    public $isRoundTrip;

    // Contact information
    public $contactName = '';

    public $contactEmail = '';

    public $contactPhone = '';

    // Passengers data
    public $passengers = [];

    // UI state
    public $currentStep = 1;

    public $isProcessing = false;

    public function mount()
    {
        $booking = session('booking');

        if (! $booking || ! isset($booking['schedule_id'])) {
            return redirect()->route('home')->with('error', 'Silakan pilih jadwal terlebih dahulu.');
        }

        $this->schedule = Schedule::with(['route.origin', 'route.destination', 'ship'])
            ->find($booking['schedule_id']);

        if (! $this->schedule) {
            return redirect()->route('home')->with('error', 'Jadwal tidak ditemukan.');
        }

        if ($booking['return_schedule_id']) {
            $this->returnSchedule = Schedule::with(['route.origin', 'route.destination', 'ship'])
                ->find($booking['return_schedule_id']);
        }

        $this->travelDate = $booking['travel_date'];
        $this->returnDate = $booking['return_date'];
        $this->passengerCount = $booking['passengers'];
        $this->isRoundTrip = $booking['is_round_trip'];

        // Auto-fill for logged in users
        if (Auth::check()) {
            $user = Auth::user();
            $this->contactName = $user->name;
            $this->contactEmail = $user->email;
            // Phone is not standard in user table usually, so we leave it empty or check if column exists
        }

        // Initialize passengers array
        for ($i = 0; $i < $this->passengerCount; $i++) {
            $this->passengers[$i] = [
                'name' => '',
                'type' => 'adult',
                'id_type' => 'ktp',
                'id_number' => '',
                'gender' => '',
            ];
        }
    }
    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validateContactInfo();
        } elseif ($this->currentStep === 2) {
            $this->validatePassengers();
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    protected function validateContactInfo()
    {
        $this->validate([
            'contactName' => 'required|min:3|max:100',
            'contactEmail' => 'required|email',
            'contactPhone' => 'required|min:10|max:15',
        ], [
            'contactName.required' => 'Nama kontak wajib diisi',
            'contactName.min' => 'Nama minimal 3 karakter',
            'contactEmail.required' => 'Email wajib diisi',
            'contactEmail.email' => 'Format email tidak valid',
            'contactPhone.required' => 'Nomor telepon wajib diisi',
            'contactPhone.min' => 'Nomor telepon minimal 10 digit',
        ]);
    }

    protected function validatePassengers()
    {
        $rules = [];
        $messages = [];

        for ($i = 0; $i < $this->passengerCount; $i++) {
            $rules["passengers.{$i}.name"] = 'required|min:3|max:100';
            $rules["passengers.{$i}.type"] = 'required|in:adult,child,infant';
            $rules["passengers.{$i}.gender"] = 'required|in:male,female';

            $messages["passengers.{$i}.name.required"] = 'Nama penumpang '.($i + 1).' wajib diisi';
            $messages["passengers.{$i}.gender.required"] = 'Jenis kelamin penumpang '.($i + 1).' wajib dipilih';
        }

        $this->validate($rules, $messages);
    }

    public function getTotalPriceProperty()
    {
        $total = $this->schedule->price * $this->passengerCount;

        if ($this->returnSchedule) {
            $total += $this->returnSchedule->price * $this->passengerCount;
        }

        return $total;
    }
    public function submitBooking()
    {
        $this->isProcessing = true;

        try {
            DB::beginTransaction();

            $userId = Auth::id();

            // Create outbound order
            $order = Order::create([
                'schedule_id' => $this->schedule->id,
                'user_id' => $userId,
                'travel_date' => $this->travelDate,
                'passenger_count' => $this->passengerCount,
                'total_amount' => $this->schedule->price * $this->passengerCount,
                'contact_name' => $this->contactName,
                'contact_email' => $this->contactEmail,
                'contact_phone' => $this->contactPhone,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // Create passengers for outbound
            foreach ($this->passengers as $passengerData) {
                Passenger::create([
                    'order_id' => $order->id,
                    'name' => $passengerData['name'],
                    'type' => $passengerData['type'],
                    'id_type' => $passengerData['id_type'] ?? null,
                    'id_number' => $passengerData['id_number'] ?? null,
                    'gender' => $passengerData['gender'],
                ]);
            }

            // Create return order if round trip
            $returnOrder = null;
            if ($this->returnSchedule) {
                $returnOrder = Order::create([
                    'schedule_id' => $this->returnSchedule->id,
                    'user_id' => $userId,
                    'travel_date' => $this->returnDate,
                    'passenger_count' => $this->passengerCount,
                    'total_amount' => $this->returnSchedule->price * $this->passengerCount,
                    'contact_name' => $this->contactName,
                    'contact_email' => $this->contactEmail,
                    'contact_phone' => $this->contactPhone,
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    'notes' => 'Return trip for order: '.$order->order_number,
                ]);

                // Create passengers for return
                foreach ($this->passengers as $passengerData) {
                    Passenger::create([
                        'order_id' => $returnOrder->id,
                        'name' => $passengerData['name'],
                        'type' => $passengerData['type'],
                        'id_type' => $passengerData['id_type'] ?? null,
                        'id_number' => $passengerData['id_number'] ?? null,
                        'gender' => $passengerData['gender'],
                    ]);
                }

                // Link orders
                $order->update(['notes' => 'Return order: '.$returnOrder->order_number]);
            }

            DB::commit();

            // Clear booking session
            session()->forget('booking');

            // Store order info for payment redirect
            session(['last_order' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'return_order_id' => $returnOrder?->id,
                'return_order_number' => $returnOrder?->order_number,
            ]]);

            // Redirect to payment page instead of confirmation
            return redirect()->route('payment.show', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat memproses pemesanan. Silakan coba lagi.');
            $this->isProcessing = false;
        }
    }

    #[Layout('components.layouts.app')]
    #[Title('Pemesanan Tiket')]
    public function render()
    {
        return view('livewire.booking-form');
    }
}
