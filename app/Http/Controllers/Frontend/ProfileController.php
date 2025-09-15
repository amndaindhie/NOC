<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\TicketTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $trackingService;

    public function __construct(TicketTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    public function show()
    {
        $user = Auth::user();
        $tickets = collect();

        if ($user) {
            $email = strtolower(trim($user->email));
            Log::info('Fetching tickets for email: ' . $email);
            // Fetch tickets with full details by email
            $tickets = $this->trackingService->searchTicketsByEmail($email);
            Log::info('Number of tickets found: ' . $tickets->count());
        }

        return view('frontend.profile', compact('tickets'));
    }



    public function showTicketDetail($nomorTiket)
    {
        $user = Auth::user();

        // Verify that the ticket belongs to the current user
        if ($user) {
            $tenantNumber = $user->email;
            $userTickets = $this->trackingService->searchTickets(null, $tenantNumber);

            $ticket = $userTickets->firstWhere('nomor_tiket', $nomorTiket);

            if ($ticket) {
                // Get full ticket details with tracking information
                $ticketDetails = $this->trackingService->trackTicket($nomorTiket);

                return view('frontend.ticket_detail', [
                    'ticket' => $ticket,
                    'tracking' => $ticketDetails['tracking'] ?? collect(),
                    'timeline' => $ticketDetails['timeline'] ?? []
                ]);
            }
        }

        return redirect()->route('profile', ['tab' => 'service-history'])->with('error', 'Tiket tidak ditemukan atau Anda tidak memiliki akses.');
    }
}
