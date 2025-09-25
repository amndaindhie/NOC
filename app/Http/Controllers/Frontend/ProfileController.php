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

    // Halaman profile
    public function showProfile()
    {
        return view('frontend.settings.profile');
    }

    // Alias for showProfile to match route definition
    public function show()
    {
        return $this->showProfile();
    }

    // Halaman change password
    public function showPassword()
    {
        return view('frontend.settings.password');
    }

    // Halaman service history
    public function showServiceHistory()
    {
        $user = Auth::user();
        $tickets = collect();

        if ($user) {
            $email = strtolower(trim($user->email));
            Log::info('Fetching tickets for email: ' . $email);
            $tickets = $this->trackingService->searchTicketsByEmail($email);
            Log::info('Number of tickets found: ' . $tickets->count());
        }

        return view('frontend.settings.service_history', compact('tickets'));
    }

    // Halaman home
    public function showHome()
    {
        return view('frontend.settings.home');
    }

    // Detail tiket
    public function showTicketDetail($nomorTiket)
    {
        $user = Auth::user();

        if ($user) {
            $tenantNumber = $user->email;
            $userTickets = $this->trackingService->searchTickets(null, $tenantNumber);

            $ticket = $userTickets->firstWhere('nomor_tiket', $nomorTiket);

            if ($ticket) {
                $ticketDetails = $this->trackingService->trackTicket($nomorTiket);

                return view('frontend.settings.ticket_detail', [
                    'ticket' => $ticket,
                    'tracking' => $ticketDetails['tracking'] ?? collect(),
                    'timeline' => $ticketDetails['timeline'] ?? []
                ]);
            }
        }

        return redirect()->route('settings.service-history')->with('error', 'Tiket tidak ditemukan atau Anda tidak memiliki akses.');
    }

    // Tabbed settings interface
    public function showSettings(Request $request)
    {
        $user = Auth::user();
        $tickets = collect();
        $activeTab = $request->get('tab', 'profile');

        if ($user) {
            $email = strtolower(trim($user->email));
            Log::info('Fetching tickets for email: ' . $email);
            $tickets = $this->trackingService->searchTicketsByEmail($email);
            Log::info('Number of tickets found: ' . $tickets->count());
        }

        return view('frontend.settings.settings', compact('tickets', 'activeTab'));
    }
}
