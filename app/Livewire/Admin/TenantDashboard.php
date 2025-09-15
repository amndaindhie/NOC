<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\NocInstallationRequest;
use App\Models\NocTermination;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use Illuminate\Support\Facades\DB;

class TenantDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedTenant = null;
    public $tenantStats = [];
    
    public function mount()
    {
        $this->loadTenantStats();
    }

    public function loadTenantStats()
    {
        // Get unique tenant numbers from all forms
        $tenantNumbers = collect()
            ->merge(NocInstallationRequest::pluck('nomor_tenant'))
            ->merge(NocTermination::pluck('nomor_tenant'))
            ->merge(NocMaintenanceRequest::pluck('nomor_tenant'))
            ->merge(NocComplaint::pluck('nomor_tenant'))
            ->unique()
            ->filter()
            ->values();

        $this->tenantStats = [];
        
        foreach ($tenantNumbers as $tenantNumber) {
            $this->tenantStats[$tenantNumber] = [
                'instalasi' => NocInstallationRequest::where('nomor_tenant', $tenantNumber)->count(),
                'terminasi' => NocTermination::where('nomor_tenant', $tenantNumber)->count(),
                'maintenance' => NocMaintenanceRequest::where('nomor_tenant', $tenantNumber)->count(),
                'keluhan' => NocComplaint::where('nomor_tenant', $tenantNumber)->count(),
                'total_activities' => 0,
                'last_activity' => null,
                'status' => 'aktif',
            ];
            
            // Calculate total activities
            $this->tenantStats[$tenantNumber]['total_activities'] = 
                $this->tenantStats[$tenantNumber]['instalasi'] +
                $this->tenantStats[$tenantNumber]['terminasi'] +
                $this->tenantStats[$tenantNumber]['maintenance'] +
                $this->tenantStats[$tenantNumber]['keluhan'];
                
            // Get last activity date
            $lastDates = collect([
                NocInstallationRequest::where('nomor_tenant', $tenantNumber)->max('updated_at'),
                NocTermination::where('nomor_tenant', $tenantNumber)->max('updated_at'),
                NocMaintenanceRequest::where('nomor_tenant', $tenantNumber)->max('updated_at'),
                NocComplaint::where('nomor_tenant', $tenantNumber)->max('updated_at'),
            ])->filter()->max();
            
            $this->tenantStats[$tenantNumber]['last_activity'] = $lastDates;
            
            // Check if tenant has termination
            $hasTermination = NocTermination::where('nomor_tenant', $tenantNumber)
                ->where('status', 'selesai')
                ->exists();
                
            if ($hasTermination) {
                $this->tenantStats[$tenantNumber]['status'] = 'non-aktif';
            }
        }
    }

    public function getFilteredTenants()
    {
        if (empty($this->search)) {
            return collect($this->tenantStats);
        }

        return collect($this->tenantStats)->filter(function ($stats, $tenantNumber) {
            return stripos($tenantNumber, $this->search) !== false;
        });
    }

    public function selectTenant($tenantNumber)
    {
        $this->selectedTenant = $tenantNumber;
    }

    public function getTenantDetails($tenantNumber)
    {
        return [
            'instalasi' => NocInstallationRequest::where('nomor_tenant', $tenantNumber)->get(),
            'terminasi' => NocTermination::where('nomor_tenant', $tenantNumber)->get(),
            'maintenance' => NocMaintenanceRequest::where('nomor_tenant', $tenantNumber)->get(),
            'keluhan' => NocComplaint::where('nomor_tenant', $tenantNumber)->get(),
        ];
    }

    public function render()
    {
        $tenants = $this->getFilteredTenants();
        
        return view('livewire.admin.tenant-dashboard', [
            'tenants' => $tenants,
            'totalTenants' => count($this->tenantStats),
            'activeTenants' => collect($this->tenantStats)->where('status', 'aktif')->count(),
            'inactiveTenants' => collect($this->tenantStats)->where('status', 'non-aktif')->count(),
        ]);
    }
}
