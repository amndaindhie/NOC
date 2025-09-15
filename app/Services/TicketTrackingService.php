<?php

namespace App\Services;

use App\Models\TicketTracking;
use App\Models\NocInstallationRequest;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use App\Models\NocTermination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketTrackingService
{
    public function trackTicket(string $nomorTiket)
    {
        // Search by either nomor_tiket or nomor_tracking
        $tracking = TicketTracking::where('nomor_tiket', $nomorTiket)
            ->orderBy('waktu_perubahan', 'desc')
            ->get();

        $ticketData = $this->getTicketData($nomorTiket);

        if (!$ticketData) {
            return null;
        }

        // If no tracking entries exist, create a default one based on ticket status
        if ($tracking->isEmpty()) {
            $currentStatus = $ticketData['data']->status ?? 'pending';
            $tracking = collect([
                (object) [
                    'nomor_tiket' => $nomorTiket,
                    'status' => $currentStatus,
                    'keterangan' => 'Status awal tiket',
                    'waktu_perubahan' => $ticketData['data']->created_at ?? now(),
                    'dilakukan_oleh' => 'Sistem'
                ]
            ]);
        }

        return [
            'ticket' => $ticketData,
            'tracking' => $tracking,
            'current_status' => $tracking->first()->status,
            'timeline' => $this->buildTimeline($tracking)
        ];
    }

    public function addTrackingEntry(string $nomorTiket, string $tipeTiket, string $status, ?string $keterangan = null, ?string $oleh = null)
    {
        return TicketTracking::create([
            'nomor_tiket' => $nomorTiket,
            'tipe_tiket' => $tipeTiket,
            'status' => $status,
            'keterangan' => $keterangan,
            'waktu_perubahan' => now(),
            'dilakukan_oleh' => $oleh
        ]);
    }

    public function searchTickets(?string $nomorTiket = null, ?string $nomorTenant = null, ?string $tipe = null)
    {
        $results = collect();

        // Cari di semua tabel berdasarkan nomor tiket
        if ($nomorTiket) {
            $results = $results->merge($this->searchByTicketNumber($nomorTiket));
        }

        // Cari berdasarkan nomor tenant
        if ($nomorTenant) {
            $results = $results->merge($this->searchByTenantNumber($nomorTenant));
        }

        // Filter berdasarkan tipe jika ditentukan
        if ($tipe) {
            $results = $results->where('tipe', $tipe);
        }

        return $results->unique('nomor_tiket')->values();
    }

    public function searchTicketsByEmail(string $email)
    {
        $results = collect();

        $searchEmail = strtolower(trim($email));

        // Search by email only (case-insensitive)
        $instalasi = NocInstallationRequest::whereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])->get();
        $maintenance = NocMaintenanceRequest::whereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])->get();
        $keluhan = NocComplaint::whereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])->get();
        $terminasi = NocTermination::whereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])->get();

        Log::info('Search by email: ' . $searchEmail);
        Log::info('Instalasi count: ' . $instalasi->count());
        Log::info('Maintenance count: ' . $maintenance->count());
        Log::info('Keluhan count: ' . $keluhan->count());
        Log::info('Terminasi count: ' . $terminasi->count());

        foreach ($instalasi as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'instalasi',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_perusahaan' => $item->nama_perusahaan,
                'status' => $item->status,
                'tanggal_permintaan' => $item->tanggal_permintaan
            ]);
        }

        foreach ($maintenance as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tracking,
                'tipe' => 'maintenance',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->tanggal_permintaan
            ]);
        }

        foreach ($keluhan as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'keluhan',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->created_at->format('Y-m-d')
            ]);
        }

        foreach ($terminasi as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'terminasi',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->created_at->format('Y-m-d')
            ]);
        }

        return $results;
    }

    private function getTicketData(string $nomorTiket)
    {
        // Cari di semua tabel berdasarkan nomor tiket atau nomor tracking
        $ticket = NocInstallationRequest::where('nomor_tiket', $nomorTiket)->first();
        if ($ticket) {
            return [
                'tipe' => 'instalasi',
                'data' => $ticket,
                'nomor_tenant' => $ticket->nomor_tenant,
                'nama_perusahaan' => $ticket->nama_perusahaan
            ];
        }

        $ticket = NocMaintenanceRequest::where('nomor_tracking', $nomorTiket)->first();
        if ($ticket) {
            return [
                'tipe' => 'maintenance',
                'data' => $ticket,
                'nomor_tenant' => $ticket->nomor_tenant,
                'nama_tenant' => $ticket->nama_tenant
            ];
        }

        $ticket = NocComplaint::where('nomor_tiket', $nomorTiket)->first();
        if ($ticket) {
            return [
                'tipe' => 'keluhan',
                'data' => $ticket,
                'nomor_tenant' => $ticket->nomor_tenant,
                'nama_tenant' => $ticket->nama_tenant
            ];
        }

        $ticket = NocTermination::where('nomor_tiket', $nomorTiket)->first();
        if ($ticket) {
            return [
                'tipe' => 'terminasi',
                'data' => $ticket,
                'nomor_tenant' => $ticket->nomor_tenant,
                'nama_tenant' => $ticket->nama_tenant
            ];
        }

        return null;
    }

    private function searchByTicketNumber(string $nomorTiket)
    {
        $results = collect();

        // Cari di semua tabel
        $instalasi = NocInstallationRequest::where('nomor_tiket', 'like', "%{$nomorTiket}%")->get();
        $maintenance = NocMaintenanceRequest::where('nomor_tracking', 'like', "%{$nomorTiket}%")->get();
        $keluhan = NocComplaint::where('nomor_tiket', 'like', "%{$nomorTiket}%")->get();
        $terminasi = NocTermination::where('nomor_tiket', 'like', "%{$nomorTiket}%")->get();

        foreach ($instalasi as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'instalasi',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_perusahaan' => $item->nama_perusahaan,
                'status' => $item->status,
                'tanggal_permintaan' => $item->tanggal_permintaan
            ]);
        }

        foreach ($maintenance as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tracking,
                'tipe' => 'maintenance',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->tanggal_permintaan
            ]);
        }

        foreach ($keluhan as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'keluhan',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->created_at->format('Y-m-d')
            ]);
        }

        foreach ($terminasi as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'terminasi',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->created_at->format('Y-m-d')
            ]);
        }

        return $results;
    }

    private function searchByTenantNumber(string $nomorTenant)
    {
        $results = collect();

        $searchEmail = strtolower(trim($nomorTenant));

        // Search by nomor_tenant OR email (case-insensitive)
        $instalasi = NocInstallationRequest::where('nomor_tenant', $nomorTenant)
            ->orWhereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])
            ->get();
        $maintenance = NocMaintenanceRequest::where('nomor_tenant', $nomorTenant)
            ->orWhereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])
            ->get();
        $keluhan = NocComplaint::where('nomor_tenant', $nomorTenant)
            ->orWhereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])
            ->get();
        $terminasi = NocTermination::where('nomor_tenant', $nomorTenant)
            ->orWhereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])
            ->get();

        Log::info('Search by tenant/email: ' . $searchEmail);
        Log::info('Instalasi count: ' . $instalasi->count());
        Log::info('Maintenance count: ' . $maintenance->count());
        Log::info('Keluhan count: ' . $keluhan->count());
        Log::info('Terminasi count: ' . $terminasi->count());

        foreach ($instalasi as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'instalasi',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_perusahaan' => $item->nama_perusahaan,
                'status' => $item->status,
                'tanggal_permintaan' => $item->tanggal_permintaan
            ]);
        }

        foreach ($maintenance as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tracking,
                'tipe' => 'maintenance',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->tanggal_permintaan
            ]);
        }

        foreach ($keluhan as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'keluhan',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->created_at->format('Y-m-d')
            ]);
        }

        foreach ($terminasi as $item) {
            $results->push([
                'nomor_tiket' => $item->nomor_tiket,
                'tipe' => 'terminasi',
                'nomor_tenant' => $item->nomor_tenant,
                'nama_tenant' => $item->nama_tenant,
                'status' => $item->status,
                'tanggal_permintaan' => $item->created_at->format('Y-m-d')
            ]);
        }

        return $results;
    }

    public function updateTicketData(string $nomorTiket, array $updateData, ?string $oleh = null, ?string $comment = null)
    {
        // Cari ticket di semua model
        $ticketInfo = $this->findTicketByNumber($nomorTiket);

        if (!$ticketInfo) {
            return null;
        }

        $model = $ticketInfo['model'];
        $tipeTiket = $ticketInfo['tipe'];

        // Update data ticket
        $model->update($updateData);

        // Jika status diupdate, tambahkan tracking entry dengan pesan custom
        if (isset($updateData['status'])) {
            $keterangan = $this->generateStatusMessage($updateData['status'], $tipeTiket, $comment);
            $this->addTrackingEntry(
                $nomorTiket,
                $tipeTiket,
                $updateData['status'],
                $keterangan,
                $oleh
            );
        }

        return $model->fresh();
    }

    private function findTicketByNumber(string $nomorTiket)
    {
        // Cari di NocInstallationRequest
        $ticket = NocInstallationRequest::where('nomor_tiket', $nomorTiket)->first();
        if ($ticket) {
            return ['model' => $ticket, 'tipe' => 'instalasi'];
        }

        // Cari di NocMaintenanceRequest
        $ticket = NocMaintenanceRequest::where('nomor_tracking', $nomorTiket)->first();
        if ($ticket) {
            return ['model' => $ticket, 'tipe' => 'maintenance'];
        }

        // Cari di NocComplaint
        $ticket = NocComplaint::where('nomor_tiket', $nomorTiket)->first();
        if ($ticket) {
            return ['model' => $ticket, 'tipe' => 'keluhan'];
        }

        // Cari di NocTermination
        $ticket = NocTermination::where('nomor_tiket', $nomorTiket)->first();
        if ($ticket) {
            return ['model' => $ticket, 'tipe' => 'terminasi'];
        }

        return null;
    }

    private function generateStatusMessage(string $status, string $tipeTiket, ?string $comment = null): string
    {
        $messages = [
            'instalasi' => [
                'Diterima' => 'Permintaan instalasi telah diterima dan sedang diproses',
                'Proses' => 'Sedang memulai proses instalasi jaringan',
                'Selesai' => 'Instalasi jaringan telah selesai dilakukan',
                'Ditolak' => 'Permintaan instalasi ditolak' . ($comment ? ': ' . $comment : '')
            ],
            'maintenance' => [
                'Diterima' => 'Permintaan maintenance telah diterima dan sedang diproses',
                'Proses' => 'Sedang memulai proses maintenance perangkat',
                'Selesai' => 'Maintenance perangkat telah selesai dilakukan',
                'Ditolak' => 'Permintaan maintenance ditolak' . ($comment ? ': ' . $comment : '')
            ],
            'keluhan' => [
                'Diterima' => 'Keluhan telah diterima dan sedang diproses',
                'Proses' => 'Sedang memulai proses penanganan keluhan',
                'Selesai' => 'Keluhan telah selesai ditangani',
                'Ditolak' => 'Keluhan ditolak untuk diproses' . ($comment ? ': ' . $comment : '')
            ],
            'terminasi' => [
                'Diajukan' => 'Pengajuan terminasi telah diterima dan sedang dalam proses review',
                'Diproses' => 'Sedang memproses permintaan terminasi layanan',
                'Disetujui' => 'Permintaan terminasi telah disetujui',
                'Ditolak' => 'Permintaan terminasi ditolak' . ($comment ? ': ' . $comment : ''),
                'Selesai' => 'Proses terminasi layanan telah selesai'
            ]
        ];

        return $messages[$tipeTiket][$status] ?? 'Status diperbarui oleh admin';
    }

    private function buildTimeline($tracking)
    {
        return $tracking->map(function ($item) {
            return [
                'status' => $item->status,
                'keterangan' => $item->keterangan,
                'waktu' => $item->waktu_perubahan->format('d/m/Y H:i'),
                'oleh' => $item->dilakukan_oleh ?? 'Sistem'
            ];
        });
    }
}
