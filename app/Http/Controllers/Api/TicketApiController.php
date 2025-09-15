<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TicketTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketApiController extends Controller
{
    protected $trackingService;

    public function __construct(TicketTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Get tickets for the authenticated user
     */
    public function getUserTickets(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tenantIdentifier = $user->email;

        $tickets = $this->trackingService->searchTickets(null, $tenantIdentifier);

        return response()->json(['tickets' => $tickets]);
    }
}
