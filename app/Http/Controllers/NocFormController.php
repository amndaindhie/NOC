<?php

namespace App\Http\Controllers;

use App\Models\NocInstallationRequest;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use App\Models\NocTermination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TenantInstallationNotification;
use App\Mail\TenantMaintenanceNotification;
use App\Mail\TenantComplaintNotification;
use App\Mail\TenantTerminationNotification;
use App\Services\TenantNotificationService;
use App\Services\TicketTrackingService;
use Illuminate\Support\Facades\Auth;
class NocFormController extends Controller
{
    // Form Instalasi Jaringan - VERSI TERPERBAIKI
    public function storeInstallation(Request $request)
    {
        // Validasi autentikasi - redirect ke login jika belum login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mengirim form permintaan instalasi.');
        }

        try {
            // Log request yang masuk
            \Illuminate\Support\Facades\Log::info('Instalasi request received', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'all_data' => $request->all()
            ]);

            // Validasi input dengan pesan error yang lebih jelas - disesuaikan dengan frontend form
            $validated = $request->validate([
                'nomor_tenant' => 'required|string|max:50',
                'nama_perusahaan' => 'required|string|max:100',
                'kontak_person' => 'required|string|max:100',
                'nomor_telepon' => 'required|string|max:20',
                'lokasi_instalasi' => 'required|string|max:255',
                'jenis_layanan' => 'required|in:Dedicated,Broadband',
                'kecepatan_bandwidth' => 'required|string|max:50',
                'tingkat_urgensi' => 'required|in:Low,Medium,High,Critical',
                'catatan_tambahan' => 'nullable|string',
                'email' => 'nullable|email|max:100',
                'nama_isp' => 'required|string|max:50',
                'nomor_npwp' => 'required|string|max:50',
                'lokasi_pemasangan' => 'required|string|max:255',
                'skema_topologi' => 'required|string|max:255',
                'tanggal_instalasi' => 'nullable|date',
                'waktu_instalasi' => 'nullable|string|max:20',
                'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ], [
                'nomor_tenant.required' => 'Nomor tenant wajib diisi',
                'nama_perusahaan.required' => 'Nama perusahaan wajib diisi',
                'kontak_person.required' => 'Kontak person wajib diisi',
                'nomor_telepon.required' => 'Nomor telepon wajib diisi',
                'lokasi_instalasi.required' => 'Lokasi instalasi wajib diisi',
                'jenis_layanan.required' => 'Jenis layanan wajib dipilih',
                'kecepatan_bandwidth.required' => 'Kecepatan bandwidth wajib diisi',
                'tingkat_urgensi.required' => 'Tingkat urgensi wajib dipilih',
                'nama_isp.required' => 'Nama ISP wajib dipilih',
                'nomor_npwp.required' => 'Nomor NPWP wajib diisi',
                'lokasi_pemasangan.required' => 'Lokasi pemasangan wajib dipilih',
                'skema_topologi.required' => 'Skema topologi wajib dipilih',
                'email.email' => 'Format email tidak valid',
                'dokumen.mimes' => 'Dokumen harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG',
                'dokumen.max' => 'Ukuran dokumen maksimal 2MB'
            ]);

            \Illuminate\Support\Facades\Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload dengan error handling yang lebih baik
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                try {
                    $file = $request->file('dokumen');
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumen-instalasi', $filename, 'public');
                    $dokumenPath = $path;
                    \Illuminate\Support\Facades\Log::info('File uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('File upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                                   ->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage())
                                   ->withInput();
                }
            }

            // Prepare data untuk disimpan - using new field names from migration
            $data = [
                'nomor_tiket' => 'INS-' . strtoupper(uniqid()),
                'nomor_tenant' => $validated['nomor_tenant'],
                'nama_perusahaan' => $validated['nama_perusahaan'],
                'kontak_person' => $validated['kontak_person'],
                'email' => $validated['email'] ?? null,
                'nama_isp' => $validated['nama_isp'] ?? null,
                'nomor_npwp' => $validated['nomor_npwp'] ?? null,
                'lokasi_instalasi' => $validated['lokasi_instalasi'],
                'lokasi_pemasangan' => $validated['lokasi_pemasangan'] ?? null,
                'nomor_telepon' => $validated['nomor_telepon'],
                'jenis_layanan' => $validated['jenis_layanan'],
                'kecepatan_bandwidth' => $validated['kecepatan_bandwidth'] ?? null,
                'skema_topologi' => $validated['skema_topologi'] ?? null,
                'tingkat_urgensi' => $validated['tingkat_urgensi'],
                'tanggal_permintaan' => now()->toDateString(), // Auto-set to current date
                'tanggal_instalasi' => $validated['tanggal_instalasi'] ?? null,
                'waktu_instalasi' => $validated['waktu_instalasi'] ?? null,
                'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
                'dokumen_path' => $dokumenPath,
                'status' => 'Diterima',
            ];

            \Illuminate\Support\Facades\Log::info('Attempting to save instalasi data', ['data' => $data]);

            // Simpan data ke database
            $installation = NocInstallationRequest::create($data);

            \Illuminate\Support\Facades\Log::info('Instalasi saved successfully', [
                'id' => $installation->id,
                'nomor_tiket' => $installation->nomor_tiket
            ]);

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
                \Illuminate\Support\Facades\Log::error('Failed to create notification for installation', [
                    'error' => $e->getMessage(),
                    'ticket' => $installation->nomor_tiket
                ]);
            }

            // Add initial tracking entry
            try {
                $trackingService = new TicketTrackingService();
                $trackingService->addTrackingEntry(
                    $installation->nomor_tiket,
                    'instalasi',
                    'Diterima',
                    'Permintaan instalasi telah diterima dan sedang diproses',
                    'Sistem'
                );
                \Illuminate\Support\Facades\Log::info('Initial tracking entry added for installation', [
                    'ticket' => $installation->nomor_tiket
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to add tracking entry for installation', [
                    'error' => $e->getMessage(),
                    'ticket' => $installation->nomor_tiket
                ]);
            }

            // Kirim notifikasi ke tenant
            try {
                $notificationService = new TenantNotificationService();
                $tenantEmail = $installation->email; // use real email from form

                if ($tenantEmail) {
                    Mail::to($tenantEmail)->send(new TenantInstallationNotification($installation));
                    \Illuminate\Support\Facades\Log::info('Tenant notification sent for installation', [
                        'email' => $tenantEmail,
                        'ticket' => $installation->nomor_tiket
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send tenant notification for installation', [
                    'error' => $e->getMessage(),
                    'ticket' => $installation->nomor_tiket
                ]);
            }

            // Kirim notifikasi ke admin
            try {
                $adminEmail = config('mail.admin_email', 'admin@noc-system.com');
                Mail::to($adminEmail)->send(new TenantInstallationNotification($installation));
                \Illuminate\Support\Facades\Log::info('Admin notification sent for installation', [
                    'email' => $adminEmail,
                    'ticket' => $installation->nomor_tiket
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send admin notification for installation', [
                    'error' => $e->getMessage(),
                    'ticket' => $installation->nomor_tiket
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()->back()
                           ->with('success', 'Pengajuan instalasi berhasil dikirim. Nomor tiket: ' . $installation->nomor_tiket);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::warning('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving instalasi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                           ->withInput();
        }
    }


    // Form Maintenance - VERSI TERPERBAIKI
    public function storeMaintenance(Request $request)
    {
        // Validasi autentikasi - redirect ke login jika belum login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mengirim form permintaan maintenance.');
        }

        try {
            // Log request yang masuk
            \Illuminate\Support\Facades\Log::info('Maintenance request received', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'all_data' => $request->all()
            ]);

            // Validasi input dengan pesan error yang lebih jelas
            $validated = $request->validate([
                'nomor_tenant' => 'required|string|max:50',
                'nama_tenant' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'lokasi_perangkat' => 'required|string|max:255',
                'jenis_maintenance' => 'required|in:Internet,CCTV,IoT,VPN,Lainnya',
                'deskripsi' => 'required|string',
                'tingkat_urgensi' => 'required|in:Low,Medium,High,Critical',
                'tanggal_permintaan' => 'required|date',
                'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ], [
                'nomor_tenant.required' => 'Nomor tenant wajib diisi',
                'nama_tenant.required' => 'Nama tenant wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'lokasi_perangkat.required' => 'Lokasi perangkat wajib diisi',
                'jenis_maintenance.required' => 'Jenis maintenance wajib dipilih',
                'deskripsi.required' => 'Deskripsi maintenance wajib diisi',
                'tingkat_urgensi.required' => 'Tingkat urgensi wajib dipilih',
                'tanggal_permintaan.required' => 'Tanggal permintaan wajib diisi',
                'dokumen.mimes' => 'Dokumen harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG',
                'dokumen.max' => 'Ukuran dokumen maksimal 2MB'
            ]);

            \Illuminate\Support\Facades\Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload dengan error handling yang lebih baik
            $dokumenPath = null;
            $dokumenFilename = null;
            $dokumenMimeType = null;
            $dokumenSize = null;
            
            if ($request->hasFile('dokumen')) {
                try {
                    $file = $request->file('dokumen');
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumen-maintenance', $filename, 'public');
                    $dokumenPath = $path;
                    $dokumenFilename = $file->getClientOriginalName();
                    $dokumenMimeType = $file->getClientMimeType();
                    $dokumenSize = $file->getSize();
                    \Illuminate\Support\Facades\Log::info('File uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('File upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                                   ->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage())
                                   ->withInput();
                }
            }

            // Prepare data untuk disimpan
            $data = [
                'nomor_tenant' => $validated['nomor_tenant'],
                'nama_tenant' => $validated['nama_tenant'],
                'lokasi_perangkat' => $validated['lokasi_perangkat'],
                'jenis_maintenance' => $validated['jenis_maintenance'],
                'deskripsi_masalah' => $validated['deskripsi'],
                'tingkat_urgensi' => $validated['tingkat_urgensi'],
                'tanggal_permintaan' => $validated['tanggal_permintaan'],
                'tanggal_mulai' => now(), // Default to current date/time
                'tanggal_selesai' => null, // Default to null
                'status' => 'Diterima', // Default status
                'email' => $validated['email'], // Use email from form input
                'dokumen_path' => $dokumenPath,
                'dokumen_filename' => $dokumenFilename,
                'dokumen_mime_type' => $dokumenMimeType,
                'dokumen_size' => $dokumenSize
            ];

            \Illuminate\Support\Facades\Log::info('Attempting to save maintenance data', ['data' => $data]);

            // Simpan data ke database
            $maintenance = NocMaintenanceRequest::create($data);

            \Illuminate\Support\Facades\Log::info('Maintenance saved successfully', [
                'id' => $maintenance->id,
                'nomor_tracking' => $maintenance->nomor_tracking
            ]);

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
                \Illuminate\Support\Facades\Log::error('Failed to create notification for maintenance', [
                    'error' => $e->getMessage(),
                    'tracking' => $maintenance->nomor_tracking
                ]);
            }

            // Add initial tracking entry
            try {
                $trackingService = new TicketTrackingService();
                $trackingService->addTrackingEntry(
                    $maintenance->nomor_tracking,
                    'maintenance',
                    'Diterima',
                    'Permintaan maintenance telah diterima dan sedang diproses',
                    'Sistem'
                );
                \Illuminate\Support\Facades\Log::info('Initial tracking entry added for maintenance', [
                    'tracking' => $maintenance->nomor_tracking
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to add tracking entry for maintenance', [
                    'error' => $e->getMessage(),
                    'tracking' => $maintenance->nomor_tracking
                ]);
            }

            // Kirim notifikasi ke tenant
            try {
                $notificationService = new TenantNotificationService();
                $tenantEmail = $notificationService->getTenantEmail($maintenance->nomor_tenant);

                if ($tenantEmail) {
                    Mail::to($tenantEmail)->send(new TenantMaintenanceNotification($maintenance));
                    \Illuminate\Support\Facades\Log::info('Tenant notification sent for maintenance', [
                        'email' => $tenantEmail,
                        'tracking' => $maintenance->nomor_tracking
                    ]);


                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send tenant notification for maintenance', [
                    'error' => $e->getMessage(),
                    'tracking' => $maintenance->nomor_tracking
                ]);


            }

            // Kirim notifikasi ke admin
            try {
                $adminEmail = config('mail.admin_email', 'admin@noc-system.com');
                Mail::to($adminEmail)->send(new TenantMaintenanceNotification($maintenance));
                \Illuminate\Support\Facades\Log::info('Admin notification sent for maintenance', [
                    'email' => $adminEmail,
                    'tracking' => $maintenance->nomor_tracking
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send admin notification for maintenance', [
                    'error' => $e->getMessage(),
                    'tracking' => $maintenance->nomor_tracking
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()->back()
                           ->with('success', 'Permintaan maintenance berhasil dikirim. Nomor tracking: ' . $maintenance->nomor_tracking);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::warning('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving maintenance', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Form Keluhan - VERSI TERPERBAIKI
    public function storeComplaint(Request $request)
    {
        // Validasi autentikasi - redirect ke login jika belum login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mengirim form keluhan.');
        }

        try {
            // Log request yang masuk
            \Illuminate\Support\Facades\Log::info('Keluhan request received', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'all_data' => $request->all()
            ]);

            // Validasi input dengan pesan error yang lebih jelas
            $validated = $request->validate([
                'nomor_tenant' => 'required|string|max:50',
                'nama_tenant' => 'required|string|max:100',
                'kontak_person' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'jenis_gangguan' => 'required|in:Internet Tidak Terhubung,Kecepatan Lambat,Koneksi Terputus,CCTV Tidak Berfungsi,IoT Tidak Merespon,VPN Tidak Terhubung,Lainnya',
                'waktu_mulai_gangguan' => 'required|date',
                'deskripsi_gangguan' => 'required|string',
                'tingkat_urgensi' => 'required|in:Low,Medium,High,Critical',
                'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ], [
                'nomor_tenant.required' => 'Nomor tenant wajib diisi',
                'nama_tenant.required' => 'Nama tenant wajib diisi',
                'kontak_person.required' => 'Kontak person wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'jenis_gangguan.required' => 'Jenis gangguan wajib dipilih',
                'waktu_mulai_gangguan.required' => 'Waktu mulai gangguan wajib diisi',
                'deskripsi_gangguan.required' => 'Deskripsi gangguan wajib diisi',
                'tingkat_urgensi.required' => 'Tingkat urgensi wajib dipilih',
                'bukti.mimes' => 'Bukti harus berformat JPG, JPEG, PNG, atau PDF',
                'bukti.max' => 'Ukuran bukti maksimal 2MB'
            ]);

            \Illuminate\Support\Facades\Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload dengan error handling yang lebih baik
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                try {
                    $file = $request->file('bukti');
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('bukti-keluhan', $filename, 'public');
                    $buktiPath = $path;
                    \Illuminate\Support\Facades\Log::info('File uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('File upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                                   ->with('error', 'Gagal mengupload bukti: ' . $e->getMessage())
                                   ->withInput();
                }
            }

            // Prepare data untuk disimpan
            $data = [
                'nomor_tenant' => $validated['nomor_tenant'],
                'nama_tenant' => $validated['nama_tenant'],
                'kontak_person' => $validated['kontak_person'],
                'jenis_gangguan' => $validated['jenis_gangguan'],
                'waktu_mulai_gangguan' => $validated['waktu_mulai_gangguan'],
                'deskripsi_gangguan' => $validated['deskripsi_gangguan'],
                'tingkat_urgensi' => $validated['tingkat_urgensi'],
                'bukti_path' => $buktiPath,
                'status' => 'Diterima',
                'email' => $validated['email'] ?? null, // Use email from form input if available
            ];

            \Illuminate\Support\Facades\Log::info('Attempting to save complaint data', ['data' => $data]);

            // Simpan data ke database
            $complaint = NocComplaint::create($data);

            \Illuminate\Support\Facades\Log::info('Complaint saved successfully', [
                'id' => $complaint->id,
                'nomor_tiket' => $complaint->nomor_tiket
            ]);

            // Create admin notification
            try {
                \App\Models\NocNotification::create([
                    'type' => 'keluhan',
                    'request_id' => $complaint->id,
                    'title' => 'New Complaint Request',
                    'message' => 'New complaint request from tenant ' . $complaint->nomor_tenant,
                    'is_read' => false,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to create notification for complaint', [
                    'error' => $e->getMessage(),
                    'ticket' => $complaint->nomor_tiket
                ]);
            }

            // Add initial tracking entry
            try {
                $trackingService = new TicketTrackingService();
                $trackingService->addTrackingEntry(
                    $complaint->nomor_tiket,
                    'keluhan',
                    'Diterima',
                    'Keluhan telah diterima dan sedang diproses',
                    'Sistem'
                );
                \Illuminate\Support\Facades\Log::info('Initial tracking entry added for complaint', [
                    'ticket' => $complaint->nomor_tiket
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to add tracking entry for complaint', [
                    'error' => $e->getMessage(),
                    'ticket' => $complaint->nomor_tiket
                ]);
            }

            // Kirim notifikasi ke tenant
            try {
                $notificationService = new TenantNotificationService();
                $tenantEmail = $notificationService->getTenantEmail($complaint->nomor_tenant);

                if ($tenantEmail) {
                    Mail::to($tenantEmail)->send(new TenantComplaintNotification($complaint));
                    \Illuminate\Support\Facades\Log::info('Tenant notification sent for complaint', [
                        'email' => $tenantEmail,
                        'ticket' => $complaint->nomor_tiket
                    ]);


                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send tenant notification for complaint', [
                    'error' => $e->getMessage(),
                    'ticket' => $complaint->nomor_tiket
                ]);


            }

            // Kirim notifikasi ke admin
            try {
                $adminEmail = config('mail.admin_email', 'admin@noc-system.com');
                Mail::to($adminEmail)->send(new TenantComplaintNotification($complaint));
                \Illuminate\Support\Facades\Log::info('Admin notification sent for complaint', [
                    'email' => $adminEmail,
                    'ticket' => $complaint->nomor_tiket
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send admin notification for complaint', [
                    'error' => $e->getMessage(),
                    'ticket' => $complaint->nomor_tiket
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()->back()
                           ->with('success', 'Keluhan berhasil dikirim. Nomor tiket: ' . $complaint->nomor_tiket);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::warning('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving complaint', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Form Terminasi - VERSI TERPERBAIKI
    public function storeTermination(Request $request)
    {
        // Validasi autentikasi - redirect ke login jika belum login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mengirim form permintaan terminasi.');
        }

        try {
            // Log request yang masuk
            \Illuminate\Support\Facades\Log::info('Terminasi request received', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'all_data' => $request->all()
            ]);

            // Validasi input dengan pesan error yang lebih jelas
            $validated = $request->validate([
                'nomor_tenant' => 'required|string|max:50',
                'nama_tenant' => 'required|string|max:100',
                'lokasi' => 'required|string|max:255',
                'alasan_terminasi' => 'required|in:Pindah Lokasi,Tidak Membutuhkan Layanan,Pindah Provider,Masalah Teknis,Lainnya',
                'prioritas_terminasi' => 'required|in:Low,Medium,High,Critical',
                'keterangan_tambahan' => 'nullable|string|max:500',
                'tanggal_efektif' => 'required|date',
                'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'konfirmasi_setuju' => 'required|boolean',
                'email' => 'required|email|max:100'
            ], [
                'nomor_tenant.required' => 'Nomor tenant wajib diisi',
                'nama_tenant.required' => 'Nama tenant wajib diisi',
                'lokasi.required' => 'Lokasi wajib diisi',
                'alasan_terminasi.required' => 'Alasan terminasi wajib dipilih',
                'prioritas_terminasi.required' => 'Tingkat urgensi wajib dipilih',
                'keterangan_tambahan.max' => 'Keterangan tambahan maksimal 500 karakter',
                'tanggal_efektif.required' => 'Tanggal efektif wajib diisi',
                'konfirmasi_setuju.required' => 'Konfirmasi persetujuan wajib dicentang',
                'dokumen.mimes' => 'Dokumen harus berformat PDF, DOC, atau DOCX',
                'dokumen.max' => 'Ukuran dokumen maksimal 2MB',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid'
            ]);

            \Illuminate\Support\Facades\Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload dengan error handling yang lebih baik
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                try {
                    $file = $request->file('dokumen');
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumen-terminasi', $filename, 'public');
                    $dokumenPath = $path;
                    \Illuminate\Support\Facades\Log::info('File uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('File upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                                   ->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage())
                                   ->withInput();
                }
            }

            // Prepare data untuk disimpan
            $data = [
                'nomor_tenant' => $validated['nomor_tenant'],
                'nama_tenant' => $validated['nama_tenant'],
                'lokasi' => $validated['lokasi'],
                'alasan_terminasi' => $validated['alasan_terminasi'],
                'prioritas_terminasi' => $validated['prioritas_terminasi'],
                'keterangan_tambahan' => $validated['keterangan_tambahan'] ?? null,
                'tanggal_efektif' => $validated['tanggal_efektif'],
                'email' => $validated['email'], // Use email from form input
                'dokumen_path' => $dokumenPath,
                'status' => 'Pending',
            ];

            \Illuminate\Support\Facades\Log::info('Attempting to save termination data', ['data' => $data]);

            // Simpan data ke database
            $termination = NocTermination::create($data);

            \Illuminate\Support\Facades\Log::info('Termination saved successfully', [
                'id' => $termination->id,
                'nomor_tiket' => $termination->nomor_tiket
            ]);

            // Create admin notification
            try {
                \App\Models\NocNotification::create([
                    'type' => 'terminasi',
                    'request_id' => $termination->id,
                    'title' => 'New Termination Request',
                    'message' => 'New termination request from tenant ' . $termination->nomor_tenant,
                    'is_read' => false,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to create notification for termination', [
                    'error' => $e->getMessage(),
                    'ticket' => $termination->nomor_tiket
                ]);
            }

            // Add initial tracking entry
            try {
                $trackingService = new TicketTrackingService();
                $trackingService->addTrackingEntry(
                    $termination->nomor_tiket,
                    'terminasi',
                    'Pending',
                    'Pengajuan terminasi telah diterima dan sedang dalam proses review',
                    'Sistem'
                );
                \Illuminate\Support\Facades\Log::info('Initial tracking entry added for termination', [
                    'ticket' => $termination->nomor_tiket
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to add tracking entry for termination', [
                    'error' => $e->getMessage(),
                    'ticket' => $termination->nomor_tiket
                ]);
            }

            // Kirim notifikasi ke tenant
            try {
                $notificationService = new TenantNotificationService();
                $tenantEmail = $notificationService->getTenantEmail($termination->nomor_tenant);

                if ($tenantEmail) {
                    Mail::to($tenantEmail)->send(new TenantTerminationNotification($termination));
                    \Illuminate\Support\Facades\Log::info('Tenant notification sent for termination', [
                        'email' => $tenantEmail,
                        'ticket' => $termination->nomor_tiket
                    ]);


                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send tenant notification for termination', [
                    'error' => $e->getMessage(),
                    'ticket' => $termination->nomor_tiket
                ]);


            }

            // Kirim notifikasi ke admin
            try {
                $adminEmail = config('mail.admin_email', 'admin@noc-system.com');
                Mail::to($adminEmail)->send(new TenantTerminationNotification($termination));
                \Illuminate\Support\Facades\Log::info('Admin notification sent for termination', [
                    'email' => $adminEmail,
                    'ticket' => $termination->nomor_tiket
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send admin notification for termination', [
                    'error' => $e->getMessage(),
                    'ticket' => $termination->nomor_tiket
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()->back()
                           ->with('success', 'Pengajuan terminasi berhasil dikirim. Nomor tiket: ' . $termination->nomor_tiket);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::warning('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving termination', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Tracking Status
    public function trackStatus($ticketNumber)
    {
        $forms = [
            'instalasi' => NocInstallationRequest::where('nomor_tiket', $ticketNumber)->first(),
            'maintenance' => NocMaintenanceRequest::where('nomor_tracking', $ticketNumber)->first(),
            'keluhan' => NocComplaint::where('nomor_tiket', $ticketNumber)->first(),
            'terminasi' => NocTermination::where('nomor_tiket', $ticketNumber)->first()
        ];

        foreach ($forms as $type => $form) {
            if ($form) {
                return response()->json([
                    'jenis_form' => $type,
                    'status' => $form->status,
                    'tanggal_pengajuan' => $form->created_at,
                    'estimasi_selesai' => $form->updated_at->addDays(3)
                ]);
            }
        }

        return response()->json(['message' => 'Tiket tidak ditemukan'], 404);
    }
}
