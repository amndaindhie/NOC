<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NocMaintenanceRequest;

class NocMaintenanceController extends Controller
{
    public function create()
    {
        return view('frontend.maintenance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_tenant' => 'required|string|max:255',
            'nama_tenant' => 'required|string|max:255',
            'lokasi_perangkat' => 'required|string|max:255',
            'jenis_maintenance' => 'required|string|max:255',
            'deskripsi_masalah' => 'nullable|string',
            'tingkat_urgensi' => 'required|string|max:50',
            'tanggal_permintaan' => 'required|date',
        ]);

        NocMaintenanceRequest::create($validated);

        return redirect()->back()->with('success', 'Permintaan maintenance berhasil dikirim.');
    }
}
