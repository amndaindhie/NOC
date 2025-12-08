<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NocInstallationRequest;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use App\Models\NocTermination;
use App\Services\TicketTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NocInstallationExport;
use App\Exports\NocMaintenanceExport;
use App\Exports\NocComplaintExport;
use App\Exports\NocTerminationExport;

class NocCrudController extends Controller
{
    protected $trackingService;

    public function __construct(TicketTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    // Installation CRUD
    public function indexInstallation()
    {
        $instalasi = NocInstallationRequest::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.instalasi', compact('instalasi'));
    }

    public function exportExcelInstallation()
    {
        return Excel::download(new NocInstallationExport, 'instalasi.xlsx');
    }

    public function exportCsvInstallation()
    {
        return Excel::download(new NocInstallationExport, 'instalasi.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function createInstallation()
    {
        return view('admin.noc.instalasi-create');
    }

    public function storeInstallation(Request $request)
    {
        $request->validate([
            'nomor_tenant' => 'required|string|max:50',
            'nama_perusahaan' => 'required|string|max:100',
            'kontak_person' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:20',
            'lokasi_instalasi' => 'required|string|max:255',
            'jenis_layanan' => 'required|in:Dedicated,Broadband',
            'kecepatan_bandwidth' => 'nullable|string|max:50',
            'tingkat_urgensi' => 'required|in:Low,Medium,High,Critical',
            'catatan_tambahan' => 'nullable|string',
            'email' => 'nullable|email|max:100',
            'nama_isp' => 'nullable|string|max:50',
            'nomor_npwp' => 'nullable|string|max:50',
            'lokasi_pemasangan' => 'nullable|string|max:255',
            'skema_topologi' => 'nullable|string|max:255',
            'tanggal_permintaan' => 'required|date',
            'tanggal_instalasi' => 'nullable|date',
            'waktu_instalasi' => 'nullable|string|max:20',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
        ]);

        $data = [
            'nomor_tiket' => $request->nomor_tiket ?: 'INS-' . strtoupper(uniqid()),
            'nomor_tenant' => $request->nomor_tenant,
            'nama_perusahaan' => $request->nama_perusahaan,
            'kontak_person' => $request->kontak_person,
            'email' => $request->email,
            'nama_isp' => $request->nama_isp,
            'nomor_npwp' => $request->nomor_npwp,
            'lokasi_instalasi' => $request->lokasi_instalasi,
            'lokasi_pemasangan' => $request->lokasi_pemasangan,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_layanan' => $request->jenis_layanan,
            'kecepatan_bandwidth' => $request->kecepatan_bandwidth,
            'skema_topologi' => $request->skema_topologi,
            'tingkat_urgensi' => $request->tingkat_urgensi,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'tanggal_instalasi' => $request->tanggal_instalasi,
            'waktu_instalasi' => $request->waktu_instalasi,
            'catatan_tambahan' => $request->catatan_tambahan,
            'status' => $request->status,
        ];

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen-instalasi', $filename, 'public');
            $data['dokumen_path'] = $path;
        }

        $installation = NocInstallationRequest::create($data);

        // Create admin notification
        try {
            \App\Models\NocNotification::create([
                'type' => 'instalasi',
                'request_id' => $installation->id,
                'title' => 'New Installation Request',
                'message' => 'New installation request from tenant ' . $installation->nomor_tenant,
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create notification for installation', [
                'error' => $e->getMessage(),
                'ticket' => $installation->nomor_tiket
            ]);
        }

        // Add initial tracking entry
        try {
            $this->trackingService->addTrackingEntry(
                $installation->nomor_tiket,
                'instalasi',
                $installation->status,
                'Permintaan instalasi telah ' . strtolower($installation->status),
                Auth::user()->name ?? 'Admin'
            );
        } catch (\Exception $e) {
            Log::error('Failed to add tracking entry for installation', [
                'error' => $e->getMessage(),
                'ticket' => $installation->nomor_tiket
            ]);
        }

        return redirect()->route('admin.noc.instalasi')->with('success', 'Permintaan instalasi berhasil ditambahkan');
    }

    public function showInstallation($id)
    {
        $instalasi = NocInstallationRequest::findOrFail($id);

        // Mark related notification as read
        \App\Models\NocNotification::where('type', 'instalasi')
            ->where('request_id', $id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('admin.noc.instalasi-show', compact('instalasi'));
    }

    public function editInstallation($id)
    {
        $instalasi = NocInstallationRequest::findOrFail($id);
        return view('admin.noc.instalasi-edit', compact('instalasi'));
    }

    public function updateInstallation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
            'comment' => 'nullable|string|max:500',
        ]);

        $instalasi = NocInstallationRequest::findOrFail($id);

        $data = ['status' => $request->status];

        if ($request->status === 'Ditolak') {
            $data['tanggal_instalasi'] = null;
        } elseif ($request->status === 'Selesai') {
            $data['tanggal_selesai'] = now();
        }

        $this->trackingService->updateTicketData(
            $instalasi->nomor_tiket,
            $data,
            Auth::user()->name ?? 'Admin',
            $request->comment
        );

        // Tambahin log manual
        Log::info('Installation status updated', [
            'ticket' => $instalasi->nomor_tiket,
            'id' => $instalasi->id,
            'new_status' => $request->status,
            'updated_by' => Auth::user()->name ?? 'Admin',
        ]);

        return redirect()->route('admin.noc.instalasi')->with('success', 'Permintaan instalasi berhasil diperbarui');
    }


    public function destroyInstallation($id)
    {
        $instalasi = NocInstallationRequest::findOrFail($id);
        $instalasi->delete();
        return redirect()->route('admin.noc.instalasi')->with('success', 'Permintaan instalasi berhasil dihapus');
    }

    // Maintenance CRUD
    public function indexMaintenance()
    {
        $maintenance = NocMaintenanceRequest::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.maintenance', compact('maintenance'));
    }

    public function exportExcelMaintenance()
    {
        return Excel::download(new NocMaintenanceExport, 'maintenance.xlsx');
    }

    public function exportCsvMaintenance()
    {
        return Excel::download(new NocMaintenanceExport, 'maintenance.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function createMaintenance()
    {
        return view('admin.noc.maintenance-create');
    }

    public function storeMaintenance(Request $request)
    {
        $request->validate([
            'nomor_tenant' => 'required|string|max:50',
            'nomor_tracking' => 'required|string|max:50',
            'nama_tenant' => 'required|string|max:100',
            'jenis_maintenance' => 'required|in:Internet,CCTV,IoT,VPN,Lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'tingkat_urgensi' => 'required|in:Low,Medium,High,Critical',
            'lokasi_perangkat' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'nomor_tenant' => $request->nomor_tenant,
            'nomor_tracking' => $request->nomor_tracking,
            'nama_tenant' => $request->nama_tenant,
            'jenis_maintenance' => $request->jenis_maintenance,
            'tanggal_permintaan' => now()->toDateString(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'deskripsi_masalah' => $request->deskripsi ?? '',
            'tingkat_urgensi' => $request->tingkat_urgensi,
            'lokasi_perangkat' => $request->lokasi_perangkat ?? '',
            'status' => $request->status,
        ];

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen-maintenance', $filename, 'public');
            $data['dokumen_path'] = $path;
        }

        $maintenance = NocMaintenanceRequest::create($data);

        // Create admin notification
        try {
            \App\Models\NocNotification::create([
                'type' => 'maintenance',
                'request_id' => $maintenance->id,
                'title' => 'New Maintenance Request',
                'message' => 'New maintenance request from tenant ' . $maintenance->nomor_tenant,
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create notification for maintenance', [
                'error' => $e->getMessage(),
                'ticket' => $maintenance->nomor_tracking
            ]);
        }

        // Add initial tracking entry
        try {
            $this->trackingService->addTrackingEntry(
                $maintenance->nomor_tracking,
                'maintenance',
                $maintenance->status,
                'Permintaan maintenance telah ' . strtolower($maintenance->status),
                Auth::user()->name ?? 'Admin'
            );
        } catch (\Exception $e) {
            Log::error('Failed to add tracking entry for maintenance', [
                'error' => $e->getMessage(),
                'ticket' => $maintenance->nomor_tracking
            ]);
        }

        return redirect()->route('admin.noc.maintenance')->with('success', 'Permintaan maintenance berhasil ditambahkan');
    }

    public function showMaintenance($id)
    {
        $maintenance = NocMaintenanceRequest::findOrFail($id);

        // Mark related notification as read
        \App\Models\NocNotification::where('type', 'maintenance')
            ->where('request_id', $id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('admin.noc.maintenance-show', compact('maintenance'));
    }

    public function editMaintenance($id)
    {
        $maintenance = NocMaintenanceRequest::findOrFail($id);
        return view('admin.noc.maintenance-edit', compact('maintenance'));
    }

    public function updateMaintenance(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
            'comment' => 'nullable|string|max:500',
            'bukti_selesai' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $maintenance = NocMaintenanceRequest::findOrFail($id);

        $data = [
            'status' => $request->status,
        ];

        // Set tanggal_selesai automatically when status is changed to "Selesai"
        if ($request->status === 'Selesai') {
            $data['tanggal_selesai'] = now();

            // Handle bukti selesai upload
            if ($request->hasFile('bukti_selesai')) {
                // Delete old file if exists
                if ($maintenance->bukti_selesai_path && Storage::disk('public')->exists($maintenance->bukti_selesai_path)) {
                    Storage::disk('public')->delete($maintenance->bukti_selesai_path);
                }

                $file = $request->file('bukti_selesai');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('maintenance/bukti_selesai', $fileName, 'public');

                $data['bukti_selesai_path'] = $filePath;
                $data['bukti_selesai_filename'] = $fileName;
            }
        }

        // Update the ticket using the service to add tracking entry
        $this->trackingService->updateTicketData(
            $maintenance->nomor_tracking,
            $data,
            Auth::user()->name ?? 'Admin',
            $request->comment
        );

        return redirect()->route('admin.noc.maintenance')->with('success', 'Status permintaan maintenance berhasil diperbarui');
    }

    public function destroyMaintenance($id)
    {
        $maintenance = NocMaintenanceRequest::findOrFail($id);
        $maintenance->delete();
        return redirect()->route('admin.noc.maintenance')->with('success', 'Permintaan maintenance berhasil dihapus');
    }

    // Complaint CRUD
    public function indexComplaint()
    {
        $keluhan = NocComplaint::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.keluhan', compact('keluhan'));
    }

    public function exportExcelComplaint()
    {
        return Excel::download(new NocComplaintExport, 'keluhan.xlsx');
    }

    public function exportCsvComplaint()
    {
        return Excel::download(new NocComplaintExport, 'keluhan.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function createComplaint()
    {
        return view('admin.noc.keluhan-create');
    }

    public function storeComplaint(Request $request)
    {
        $request->validate([
            'nomor_tenant' => 'required|string|max:255',
            'nama_tenant' => 'required|string|max:255',
            'kontak_person' => 'required|string|max:255',
            'nomor_tiket' => 'required|string|max:255',
            'jenis_gangguan' => 'required|in:Internet Tidak Terhubung,Kecepatan Lambat,Koneksi Terputus,CCTV Tidak Berfungsi,IoT Tidak Merespon,VPN Tidak Terhubung,Lainnya',
            'waktu_mulai_gangguan' => 'required|date',
            'deskripsi_gangguan' => 'required|string',
            'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
            'bukti_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $data = [
            'nomor_tenant' => $request->nomor_tenant,
            'nama_tenant' => $request->nama_tenant,
            'kontak_person' => $request->kontak_person,
            'nomor_tiket' => $request->nomor_tiket,
            'jenis_gangguan' => $request->jenis_gangguan,
            'waktu_mulai_gangguan' => $request->waktu_mulai_gangguan,
            'deskripsi_gangguan' => $request->deskripsi_gangguan,
            'status' => $request->status,
        ];

        if ($request->hasFile('bukti_path')) {
            $file = $request->file('bukti_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen', $filename, 'public');
            $data['bukti_path'] = $path;
        }

        NocComplaint::create($data);
        return redirect()->route('admin.noc.keluhan')->with('success', 'Keluhan berhasil ditambahkan');
    }

    public function editComplaint($id)
    {
        $keluhan = NocComplaint::findOrFail($id);
        return view('admin.noc.keluhan-edit', compact('keluhan'));
    }

    public function updateComplaint(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
            'comment' => 'nullable|string|max:500',
        ]);

        $keluhan = NocComplaint::findOrFail($id);

        $data = [
            'status' => $request->status,
        ];

        // Update the ticket using the service to add tracking entry
        $this->trackingService->updateTicketData(
            $keluhan->nomor_tiket,
            $data,
            Auth::user()->name ?? 'Admin',
            $request->comment
        );

        return redirect()->route('admin.noc.keluhan')->with('success', 'Status keluhan berhasil diperbarui');
    }

    public function showComplaint($id)
    {
        $keluhan = NocComplaint::findOrFail($id);

        // Mark related notification as read
        \App\Models\NocNotification::where('type', 'keluhan')
            ->where('request_id', $id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('admin.noc.keluhan-show', compact('keluhan'));
    }

    public function destroyComplaint($id)
    {
        $keluhan = NocComplaint::findOrFail($id);
        $keluhan->delete();
        return redirect()->route('admin.noc.keluhan')->with('success', 'Keluhan berhasil dihapus');
    }

    // Termination CRUD
    public function indexTermination()
    {
        $terminasi = NocTermination::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.terminasi', compact('terminasi'));
    }

    public function exportExcelTermination()
    {
        return Excel::download(new NocTerminationExport, 'terminasi.xlsx');
    }

    public function exportCsvTermination()
    {
        return Excel::download(new NocTerminationExport, 'terminasi.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function createTermination()
    {
        return view('admin.noc.terminasi-create');
    }

    public function storeTermination(Request $request)
    {
        try {
            Log::info('Termination request received', [
                'all_data' => $request->all(),
                'files' => $request->allFiles()
            ]);

            $validated = $request->validate([
                'nomor_tenant_id' => 'required|string|max:255',
                'nama_tenant' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'alasan_terminasi' => 'required|string',
                'alasan_lainnya' => 'nullable|string|max:300',
                'tanggal_efektif' => 'required|date|after_or_equal:today',
                'prioritas_terminasi' => 'nullable|string|in:Low,Medium,High,Critical',
                'status' => 'required|string|in:Diajukan,Diproses,Disetujui,Ditolak,Selesai',
                'keterangan_tambahan' => 'nullable|string|max:500',
                'dokumen_terminasi' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ], [
                'nomor_tenant_id.required' => 'Nomor tenant wajib diisi',
                'nama_tenant.required' => 'Nama tenant wajib diisi',
                'lokasi.required' => 'Lokasi wajib diisi',
                'alasan_terminasi.required' => 'Alasan terminasi wajib dipilih',
                'tanggal_efektif.required' => 'Tanggal efektif wajib diisi',
                'tanggal_efektif.after_or_equal' => 'Tanggal efektif tidak boleh sebelum hari ini',
                'status.required' => 'Status wajib dipilih',
                'dokumen_terminasi.mimes' => 'Format dokumen harus PDF, DOC, DOCX, JPG, atau PNG',
                'dokumen_terminasi.max' => 'Ukuran dokumen maksimal 5MB',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            $data = [
                'nomor_tenant' => $validated['nomor_tenant_id'],
                'nama_tenant' => $validated['nama_tenant'],
                'lokasi' => $validated['lokasi'],
                'alasan_terminasi' => $validated['alasan_terminasi'] === 'lainnya' ? $validated['alasan_lainnya'] : $validated['alasan_terminasi'],
                'tanggal_efektif' => $validated['tanggal_efektif'],
                'status' => $validated['status'],
                'prioritas_terminasi' => $validated['prioritas_terminasi'] ?? null,
                'keterangan_tambahan' => $validated['keterangan_tambahan'] ?? null,
            ];

            if ($request->hasFile('dokumen_terminasi')) {
                $file = $request->file('dokumen_terminasi');
                $filename = time() . '_' . $file->getClientOriginalName();

                Log::info('File upload detected', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize()
                ]);

                $path = $file->storeAs('dokumen_terminasi', $filename, 'public');
                $data['dokumen_path'] = $path;

                Log::info('File uploaded successfully', ['path' => $path]);
            }

            $termination = NocTermination::create($data);

            Log::info('Termination created successfully', [
                'id' => $termination->id,
                'nomor_tiket' => $termination->nomor_tiket,
                'nomor_tenant' => $termination->nomor_tenant
            ]);

            return redirect()->route('admin.noc.terminasi')->with('success', 'Permintaan terminasi berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Failed to create termination', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan data terminasi: ' . $e->getMessage()]);
        }
    }

    public function editTermination($id)
    {
        $terminasi = NocTermination::findOrFail($id);
        return view('admin.noc.terminasi-edit', compact('terminasi'));
    }

    public function updateTermination(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Diajukan,Diproses,Disetujui,Ditolak,Selesai',
            'comment' => 'nullable|string|max:500',
        ]);

        $terminasi = NocTermination::findOrFail($id);

        $data = [
            'status' => $request->status,
        ];

        // Update the ticket using the service to add tracking entry
        $this->trackingService->updateTicketData(
            $terminasi->nomor_tiket,
            $data,
            Auth::user()->name ?? 'Admin',
            $request->comment
        );

        return redirect()->route('admin.noc.terminasi')->with('success', 'Status permintaan terminasi berhasil diperbarui');
    }

    public function showTermination($id)
    {
        $terminasi = NocTermination::findOrFail($id);

        // Mark related notification as read
        \App\Models\NocNotification::where('type', 'terminasi')
            ->where('request_id', $id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('admin.noc.terminasi-show', compact('terminasi'));
    }

    public function destroyTermination($id)
    {
        $terminasi = NocTermination::findOrFail($id);
        $terminasi->delete();
        return redirect()->route('admin.noc.terminasi')->with('success', 'Permintaan terminasi berhasil dihapus');
    }
}
