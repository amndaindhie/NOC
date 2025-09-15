<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    use WithPagination;

    public $stats = [
        'users' => 0,
        'emails' => 0,
        'tenants' => 0,
        'tenant_entries' => 0,
        'new_tenants_today' => 0,
        'noc_requests' => 0,
        'selesai' => 0,
        'proses' => 0,
        'ditolak' => 0,
        'unread_notifications' => 0,
    ];

    public $recentNotifications = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadNotifications();
    }

    public function loadStats()
    {
        // Get user count
        $this->stats['users'] = User::count();

        // Get tenant count from all forms
        $tenantNumbers = collect()
            ->merge(\App\Models\NocInstallationRequest::pluck('nomor_tenant'))
            ->merge(\App\Models\NocTermination::pluck('nomor_tenant'))
            ->merge(\App\Models\NocMaintenanceRequest::pluck('nomor_tenant'))
            ->merge(\App\Models\NocComplaint::pluck('nomor_tenant'))
            ->unique()
            ->filter()
            ->values();

        $this->stats['tenants'] = $tenantNumbers->count();
        $this->stats['tenant_entries'] = $tenantNumbers->count();

        // Get new tenants today from forms
        $today = now()->toDateString();
        $newTenantsToday = collect()
            ->merge(\App\Models\NocInstallationRequest::whereDate('created_at', $today)->pluck('nomor_tenant'))
            ->merge(\App\Models\NocTermination::whereDate('created_at', $today)->pluck('nomor_tenant'))
            ->merge(\App\Models\NocMaintenanceRequest::whereDate('created_at', $today)->pluck('nomor_tenant'))
            ->merge(\App\Models\NocComplaint::whereDate('created_at', $today)->pluck('nomor_tenant'))
            ->unique()
            ->filter()
            ->values();

        $this->stats['new_tenants_today'] = $newTenantsToday->count();

        // Calculate total NOC requests count (excluding completed and rejected requests)
        $this->stats['noc_requests'] =
            \App\Models\NocInstallationRequest::whereNotIn('status', ['Selesai', 'Ditolak'])->count() +
            \App\Models\NocTermination::whereNotIn('status', ['Selesai', 'Ditolak'])->count() +
            \App\Models\NocMaintenanceRequest::whereNotIn('status', ['Selesai', 'Ditolak'])->count() +
            \App\Models\NocComplaint::whereNotIn('status', ['Selesai', 'Ditolak'])->count();

        // Calculate status counts
        $this->stats['selesai'] =
            \App\Models\NocInstallationRequest::where('status', 'Selesai')->count() +
            \App\Models\NocTermination::where('status', 'Selesai')->count() +
            \App\Models\NocMaintenanceRequest::where('status', 'Selesai')->count() +
            \App\Models\NocComplaint::where('status', 'Selesai')->count();

        $this->stats['proses'] =
            \App\Models\NocInstallationRequest::where('status', 'Proses')->count() +
            \App\Models\NocTermination::where('status', 'Proses')->count() +
            \App\Models\NocMaintenanceRequest::where('status', 'Proses')->count() +
            \App\Models\NocComplaint::where('status', 'Proses')->count();

        $this->stats['ditolak'] =
            \App\Models\NocInstallationRequest::where('status', 'Ditolak')->count() +
            \App\Models\NocTermination::where('status', 'Ditolak')->count() +
            \App\Models\NocMaintenanceRequest::where('status', 'Ditolak')->count() +
            \App\Models\NocComplaint::where('status', 'Ditolak')->count();

        // Use placeholders for tables that don't exist yet
        $this->stats['emails'] = 0; // Placeholder for email logs count
        $this->stats['customers'] = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->count();

        // Load unread notifications count
        $this->stats['unread_notifications'] = \App\Models\NocNotification::where('is_read', false)->count();
    }

    public function loadNotifications()
    {
        $this->recentNotifications = \App\Models\NocNotification::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = \App\Models\NocNotification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
            $this->loadStats(); // Refresh stats
            $this->loadNotifications(); // Refresh notifications
        }
    }

    public function render()
    {
        // Get recent users for the dashboard
        $recentUsers = User::latest()->take(3)->get();

        // Get recent NOC requests sorted by ID ascending
        $recentNocRequests = collect()
            ->merge(\App\Models\NocInstallationRequest::orderBy('id', 'asc')->take(5)->get())
            ->merge(\App\Models\NocMaintenanceRequest::orderBy('id', 'asc')->take(5)->get())
            ->merge(\App\Models\NocComplaint::orderBy('id', 'asc')->take(5)->get())
            ->merge(\App\Models\NocTermination::orderBy('id', 'asc')->take(5)->get())
            ->sortBy('id')
            ->take(5);

        return view('livewire.admin.dashboard', [
            'recentUsers' => $recentUsers,
            'recentNocRequests' => $recentNocRequests
        ]);
    }
}
