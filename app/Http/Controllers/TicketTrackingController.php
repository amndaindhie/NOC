<?php

namespace App\Http\Controllers;

use App\Services\TicketTrackingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketTrackingController extends Controller
{
    protected $trackingService;

    public function __construct(TicketTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Track ticket by number
     * GET /api/tracking/{nomor_tiket}
     */
    public function track(string $nomorTiket): JsonResponse
    {
        try {
            $result = $this->trackingService->trackTicket($nomorTiket);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket tidak ditemukan'
                ], 404);
            }

            // Format dates in the response
            $result = $this->formatDatesInResult($result);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat tracking tiket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update ticket data (admin)
     * PUT /api/tracking/{nomor_tiket}
     */


public function updateTicket(Request $request, string $nomorTiket): JsonResponse
{
    try {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            Log::warning('Unauthorized ticket update attempt', [
                'ticket' => $nomorTiket,
                'user' => Auth::user()->name ?? 'Guest'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $updateData = $request->only(['status']);
        $updatedTicket = $this->trackingService->updateTicketData(
            $nomorTiket,
            $updateData,
            Auth::user()->name
        );

        if (!$updatedTicket) {
            Log::warning('Ticket not found during update', [
                'ticket' => $nomorTiket,
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan'
            ], 404);
        }

        // ✅ Log sukses update
        Log::info('Ticket updated successfully', [
            'ticket' => $nomorTiket,
            'status' => $updateData['status'],
            'updated_by' => Auth::user()->name
        ]);

        return response()->json([
            'success' => true,
            'data' => $updatedTicket,
            'message' => 'Tiket berhasil diperbarui'
        ]);

    } catch (\Exception $e) {
        Log::error('Error updating ticket', [
            'ticket' => $nomorTiket,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memperbarui tiket',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Get all tickets for a tenant
     * GET /api/tracking/tenant/{nomor_tenant}
     */
    public function getByTenant(string $nomorTenant): JsonResponse
    {
        try {
            $results = $this->trackingService->searchTickets(
                null,
                $nomorTenant,
                null
            );

            return response()->json([
                'success' => true,
                'data' => $results,
                'total' => $results->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data tiket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add tracking entry (for admin/internal use)
     * POST /api/tracking/add
     */
    public function addTrackingEntry(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nomor_tiket' => 'required|string|max:50',
                'tipe_tiket' => 'required|in:instalasi,maintenance,keluhan,terminasi',
                'status' => 'required|string|max:50',
                'keterangan' => 'nullable|string|max:500',
                'dilakukan_oleh' => 'nullable|string|max:100'
            ]);

            $tracking = $this->trackingService->addTrackingEntry(
                $request->input('nomor_tiket'),
                $request->input('tipe_tiket'),
                $request->input('status'),
                $request->input('keterangan'),
                $request->input('dilakukan_oleh') ?? (Auth::check() ? Auth::user()->name : 'Sistem')
            );

            return response()->json([
                'success' => true,
                'data' => $tracking,
                'message' => 'Tracking entry berhasil ditambahkan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan tracking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format dates in the result array to remove timezone suffix
     */
    private function formatDatesInResult(array $result): array
    {
        // Format ticket data dates
        if (isset($result['ticket']) && isset($result['ticket']['data'])) {
            $ticketData = $result['ticket']['data'];

            // Format tanggal_permintaan if it exists
            if (isset($ticketData['tanggal_permintaan'])) {
                $result['ticket']['data']['tanggal_permintaan'] = $this->formatDateField($ticketData['tanggal_permintaan']);
            }

            // Format created_at if it exists
            if (isset($ticketData['created_at'])) {
                $result['ticket']['data']['created_at'] = $this->formatDateField($ticketData['created_at']);
            }

            // Format other date fields that might exist
            $dateFields = ['tanggal_instalasi', 'tanggal_mulai', 'tanggal_selesai', 'waktu_mulai_gangguan', 'tanggal_efektif'];
            foreach ($dateFields as $field) {
                if (isset($ticketData[$field])) {
                    $result['ticket']['data'][$field] = $this->formatDateField($ticketData[$field]);
                }
            }
        }

        // Format timeline dates
        if (isset($result['timeline']) && is_array($result['timeline'])) {
            foreach ($result['timeline'] as $key => $entry) {
                if (isset($entry['waktu'])) {
                    $result['timeline'][$key]['waktu'] = $entry['waktu'];
                }
            }
        }

        return $result;
    }

    /**
     * Format a date field to Y-m-d format, handling both Carbon instances and strings
     */
    private function formatDateField($dateValue): string
    {
        if ($dateValue instanceof \Carbon\Carbon) {
            return $dateValue->format('Y-m-d');
        }

        if (is_string($dateValue)) {
            try {
                // Parse the string date and format to Y-m-d
                return \Carbon\Carbon::parse($dateValue)->format('Y-m-d');
            } catch (\Exception $e) {
                // If parsing fails, return the original value
                return $dateValue;
            }
        }

        // If not a date, return as string
        return (string) $dateValue;
    }
}
