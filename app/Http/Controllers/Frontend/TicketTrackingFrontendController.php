<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\TicketTrackingService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TicketTrackingFrontendController extends Controller
{
    protected $trackingService;

    public function __construct(TicketTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Show the ticket tracking page
     */
    public function index()
    {
        return view('frontend.tracking_request');
    }

    /**
     * Show the form to add tracking entry
     */
    public function create()
    {
        return view('frontend.ticket-tracking-add');
    }

    /**
     * Store a new tracking entry
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nomor_tiket' => 'required|string|max:50',
            'tipe_tiket' => 'required|in:instalasi,maintenance,keluhan,terminasi',
            'status' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
            'dilakukan_oleh' => 'nullable|string|max:100'
        ]);

        try {
            $this->trackingService->addTrackingEntry(
                $request->input('nomor_tiket'),
                $request->input('tipe_tiket'),
                $request->input('status'),
                $request->input('keterangan'),
                $request->input('dilakukan_oleh') ?? Auth::user()->name ?? 'Sistem'
            );

            return redirect()->route('ticket-tracking.index')
                ->with('success', 'Data tracking berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data tracking: ' . $e->getMessage());
        }
    }
}
