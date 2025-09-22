<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NocInstallationRequest;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use App\Models\NocTermination;
use Illuminate\Http\Request;

class NocAdminController extends Controller
{
    public function instalasi()
    {
        $instalasi = NocInstallationRequest::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.instalasi', compact('instalasi'));
    }

    public function maintenance()
    {
        $maintenance = NocMaintenanceRequest::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.maintenance', compact('maintenance'));
    }

    public function keluhan()
    {
        $keluhan = NocComplaint::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.keluhan', compact('keluhan'));
    }

    public function terminasi()
    {
        $terminasi = NocTermination::orderBy('id', 'asc')->paginate(10);
        return view('admin.noc.terminasi', compact('terminasi'));
    }
}
