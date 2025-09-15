<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NocInstallationRequest;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use App\Models\NocTermination;

class NocDashboard extends Component
{
    public $selectedTab = 'overview';
    
    public function render()
    {
        $stats = [
            'total_instalasi' => NocInstallationRequest::count(),
            'total_maintenance' => NocMaintenanceRequest::count(),
            'total_keluhan' => NocComplaint::count(),
            'total_terminasi' => NocTermination::count(),
            'pending_instalasi' => NocInstallationRequest::where('status', 'Diterima')->count(),
            'pending_maintenance' => NocMaintenanceRequest::where('status', 'Diterima')->count(),
            'pending_keluhan' => NocComplaint::where('status', 'Diterima')->count(),
            'pending_terminasi' => NocTermination::where('status', 'Diterima')->count(),
        ];

        $recentRequests = [
            'instalasi' => NocInstallationRequest::latest()->limit(5)->get(),
            'maintenance' => NocMaintenanceRequest::latest()->limit(5)->get(),
            'keluhan' => NocComplaint::latest()->limit(5)->get(),
            'terminasi' => NocTermination::latest()->limit(5)->get(),
        ];

        return view('livewire.admin.noc-dashboard', [
            'stats' => $stats,
            'recentRequests' => $recentRequests
        ]);
    }
}
