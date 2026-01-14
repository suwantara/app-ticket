<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Ticket;
use App\Services\BoardingStatsService;
use App\Services\QrCodeParserService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardingController extends Controller
{
    public function __construct(
        protected TicketService $ticketService,
        protected QrCodeParserService $qrCodeParser,
        protected BoardingStatsService $statsService
    ) {}

    /**
     * Show boarding dashboard
     */
    public function dashboard()
    {
        $schedules = $this->statsService->getTodaySchedulesWithStats();
        $todayStats = $this->statsService->getTodayStats();

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
     * Validate QR code via API (with optional auto-board)
     */
    public function validateQr(Request $request): JsonResponse
    {
        $request->validate([
            'qr_data' => 'required|string',
            'auto_board' => 'boolean',
        ]);

        $qrData = $request->input('qr_data');
        $autoBoard = $request->input('auto_board', true);

        // Use QrCodeParserService to extract QR code
        $qrCode = $this->qrCodeParser->extractQrCode($qrData);

        if (! $qrCode) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Format QR Code tidak valid',
            ]);
        }

        $result = $this->ticketService->validateTicket($qrCode);

        // Ticket not found
        if (! isset($result['ticket'])) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => $result['message'],
            ]);
        }

        // Ticket found - build response
        $ticket = $result['ticket'];

        // Auto-board: If ticket is valid and active, automatically mark as used
        $autoBoarded = false;
        if ($autoBoard && $result['valid'] && $ticket->status === 'active') {
            $staffName = Auth::user()?->name ?? 'Staff';
            $useResult = $this->ticketService->useTicket($ticket, $staffName);

            if ($useResult['success']) {
                $ticket = $useResult['ticket'];
                $autoBoarded = true;
            }
        }

        $responseData = [
            'success' => true,
            'valid' => $result['valid'],
            'auto_boarded' => $autoBoarded,
            'message' => $autoBoarded
                ? 'Penumpang berhasil boarding!'
                : $result['message'],
            'ticket' => [
                'id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'status' => $ticket->status,
                'status_label' => $this->statsService->getStatusLabel($ticket->status),
                'used_at' => $ticket->used_at?->format('d/m/Y H:i'),
            ],
            'passenger' => [
                'name' => $ticket->passenger->name,
                'id_type' => strtoupper($ticket->passenger->id_type),
                'id_number' => $ticket->passenger->id_number,
                'type' => ucfirst($ticket->passenger->type),
            ],
            'schedule' => [
                'route' => $ticket->order->schedule->route->origin->name.' → '.$ticket->order->schedule->route->destination->name,
                'date' => $ticket->order->travel_date->format('d M Y'),
                'time' => \Carbon\Carbon::parse($ticket->order->schedule->departure_time)->format('H:i').' WIB',
                'ship' => $ticket->order->schedule->ship->name,
            ],
        ];

        // Add qr_code only when ticket is valid for use
        if ($result['valid']) {
            $responseData['ticket']['qr_code'] = $ticket->qr_code;
        }

        return response()->json($responseData);
    }

    /**
     * Mark ticket as boarded (used)
     */
    public function boardPassenger(Request $request): JsonResponse
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        /** @var Ticket|null $ticket */
        $ticket = Ticket::find($request->input('ticket_id'));

        if (! $ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan',
            ], 404);
        }

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
     * Get real-time stats via API
     */
    public function stats(Request $request): JsonResponse
    {
        $scheduleId = $request->get('schedule');

        return response()->json(
            $this->statsService->getRealtimeStats($scheduleId)
        );
    }
}
