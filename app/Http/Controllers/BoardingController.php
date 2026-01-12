<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\Schedule;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BoardingController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Show boarding dashboard
     */
    public function dashboard()
    {
        // Get today's schedules with ticket stats
        $schedules = Schedule::with(['route.origin', 'route.destination', 'ship'])
            ->whereHas('orders', function ($q) {
                $q->where('travel_date', today())
                  ->where('payment_status', 'paid');
            })
            ->get()
            ->map(function ($schedule) {
                $orders = $schedule->orders()
                    ->where('travel_date', today())
                    ->where('payment_status', 'paid')
                    ->pluck('id');
                
                $totalTickets = Ticket::whereIn('order_id', $orders)->count();
                $usedTickets = Ticket::whereIn('order_id', $orders)->where('status', 'used')->count();
                $unusedTickets = Ticket::whereIn('order_id', $orders)->where('status', 'unused')->count();
                
                return [
                    'schedule' => $schedule,
                    'total_tickets' => $totalTickets,
                    'used_tickets' => $usedTickets,
                    'unused_tickets' => $unusedTickets,
                    'boarding_percentage' => $totalTickets > 0 ? round(($usedTickets / $totalTickets) * 100) : 0,
                ];
            });

        // Today's stats
        $todayStats = [
            'total_orders' => Order::where('travel_date', today())->where('payment_status', 'paid')->count(),
            'total_passengers' => Ticket::whereHas('order', fn($q) => $q->where('travel_date', today()))->count(),
            'boarded' => Ticket::whereHas('order', fn($q) => $q->where('travel_date', today()))->where('status', 'used')->count(),
            'pending' => Ticket::whereHas('order', fn($q) => $q->where('travel_date', today()))->where('status', 'unused')->count(),
        ];

        return view('boarding.dashboard', compact('schedules', 'todayStats'));
    }

    /**
     * Show QR scanner page
     */
    public function scanner(Request $request)
    {
        $scheduleId = $request->get('schedule');
        $schedule = null;

        if ($scheduleId) {
            $schedule = Schedule::with(['route.origin', 'route.destination', 'ship'])
                ->find($scheduleId);
        }

        // Get today's schedules for filter
        $todaySchedules = Schedule::with(['route.origin', 'route.destination'])
            ->whereHas('orders', function ($q) {
                $q->where('travel_date', today())
                  ->where('payment_status', 'paid');
            })
            ->get();

        return view('boarding.scanner', compact('schedule', 'todaySchedules'));
    }

    /**
     * Validate QR code via API
     */
    public function validateQr(Request $request): JsonResponse
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $qrData = $request->input('qr_data');
        
        // Try to parse QR data (could be JSON or plain text)
        $qrCode = $this->extractQrCode($qrData);

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Format QR Code tidak valid',
            ]);
        }

        $result = $this->ticketService->validateTicket($qrCode);

        if ($result['valid'] && isset($result['ticket'])) {
            $ticket = $result['ticket'];
            
            return response()->json([
                'success' => true,
                'valid' => true,
                'message' => $result['message'],
                'ticket' => [
                    'id' => $ticket->id,
                    'ticket_number' => $ticket->ticket_number,
                    'qr_code' => $ticket->qr_code,
                    'status' => $ticket->status,
                    'status_label' => ucfirst($ticket->status),
                    'used_at' => $ticket->used_at?->format('d/m/Y H:i'),
                ],
                'passenger' => [
                    'name' => $ticket->passenger->name,
                    'id_type' => strtoupper($ticket->passenger->id_type),
                    'id_number' => $ticket->passenger->id_number,
                    'type' => ucfirst($ticket->passenger->type),
                ],
                'schedule' => [
                    'route' => $ticket->order->schedule->route->origin->name . ' → ' . $ticket->order->schedule->route->destination->name,
                    'date' => $ticket->order->travel_date->format('d M Y'),
                    'time' => \Carbon\Carbon::parse($ticket->order->schedule->departure_time)->format('H:i') . ' WIB',
                    'ship' => $ticket->order->schedule->ship->name,
                ],
            ]);
        }

        // Ticket exists but not valid for use
        if (isset($result['ticket'])) {
            $ticket = $result['ticket'];
            
            return response()->json([
                'success' => true,
                'valid' => true, // We found the ticket
                'message' => $result['message'],
                'ticket' => [
                    'id' => $ticket->id,
                    'ticket_number' => $ticket->ticket_number,
                    'status' => $ticket->status,
                    'status_label' => ucfirst($ticket->status),
                    'used_at' => $ticket->used_at?->format('d/m/Y H:i'),
                ],
                'passenger' => [
                    'name' => $ticket->passenger->name,
                    'id_type' => strtoupper($ticket->passenger->id_type),
                    'id_number' => $ticket->passenger->id_number,
                    'type' => ucfirst($ticket->passenger->type),
                ],
                'schedule' => [
                    'route' => $ticket->order->schedule->route->origin->name . ' → ' . $ticket->order->schedule->route->destination->name,
                    'date' => $ticket->order->travel_date->format('d M Y'),
                    'time' => \Carbon\Carbon::parse($ticket->order->schedule->departure_time)->format('H:i') . ' WIB',
                    'ship' => $ticket->order->schedule->ship->name,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'valid' => false,
            'message' => $result['message'],
        ]);
    }

    /**
     * Mark ticket as boarded (used)
     */
    public function boardPassenger(Request $request): JsonResponse
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $ticket = Ticket::find($request->input('ticket_id'));
        $staffName = Auth::user()?->name ?? 'Staff';

        $result = $this->ticketService->useTicket($ticket, $staffName);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Penumpang berhasil boarding!',
                'ticket_number' => $ticket->ticket_number,
                'passenger_name' => $ticket->passenger->name,
                'used_at' => now()->format('H:i:s'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    /**
     * Get boarding list for a schedule
     */
    public function boardingList(Request $request)
    {
        $scheduleId = $request->get('schedule');
        $status = $request->get('status', 'all');

        $query = Ticket::with(['passenger', 'order'])
            ->whereHas('order', function ($q) use ($scheduleId) {
                $q->where('travel_date', today())
                  ->where('payment_status', 'paid');
                
                if ($scheduleId) {
                    $q->where('schedule_id', $scheduleId);
                }
            });

        if ($status === 'boarded') {
            $query->where('status', 'used');
        } elseif ($status === 'pending') {
            $query->where('status', 'unused');
        }

        $tickets = $query->orderBy('updated_at', 'desc')->paginate(20);

        if ($request->ajax()) {
            return response()->json($tickets);
        }

        $schedule = $scheduleId ? Schedule::with(['route.origin', 'route.destination'])->find($scheduleId) : null;

        return view('boarding.list', compact('tickets', 'schedule', 'status'));
    }

    /**
     * Extract QR code from scanned data
     */
    protected function extractQrCode(string $data): ?string
    {
        // Try to decode as JSON first
        $decoded = json_decode($data, true);
        
        if ($decoded && isset($decoded['qr_code'])) {
            return $decoded['qr_code'];
        }

        if ($decoded && isset($decoded['ticket_number'])) {
            // Search by ticket number
            $ticket = Ticket::where('ticket_number', $decoded['ticket_number'])->first();
            return $ticket?->qr_code;
        }

        // If not JSON, assume it's the QR code directly
        // Check if it matches QR code pattern (QR + timestamp + random)
        if (preg_match('/^QR\d{14}[A-Z0-9]{8}$/', $data)) {
            return $data;
        }

        // Could also be ticket number
        if (preg_match('/^TKT-\d{8}-[A-Z0-9]{5}$/', $data)) {
            $ticket = Ticket::where('ticket_number', $data)->first();
            return $ticket?->qr_code;
        }

        return null;
    }

    /**
     * Get real-time stats via API
     */
    public function stats(Request $request): JsonResponse
    {
        $scheduleId = $request->get('schedule');

        $query = Ticket::whereHas('order', function ($q) use ($scheduleId) {
            $q->where('travel_date', today())
              ->where('payment_status', 'paid');
            
            if ($scheduleId) {
                $q->where('schedule_id', $scheduleId);
            }
        });

        $total = (clone $query)->count();
        $boarded = (clone $query)->where('status', 'used')->count();
        $pending = (clone $query)->where('status', 'unused')->count();

        return response()->json([
            'total' => $total,
            'boarded' => $boarded,
            'pending' => $pending,
            'percentage' => $total > 0 ? round(($boarded / $total) * 100) : 0,
        ]);
    }
}
