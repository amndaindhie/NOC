<?php

namespace App\Livewire\Admin;

use App\Models\NocInstallationRequest;
use Livewire\Component;
use Livewire\WithPagination;

class NocInstallationManagement extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $isEditing = false;
    public $showForm = false;
    
    // Form fields
    public $installationId;
    public $nomor_tiket;
    public $nama_perusahaan;
    public $kontak_person;
    public $lokasi_instalasi;
    public $status = 'Diterima';
    
    protected $rules = [
        'nomor_tiket' => 'required|string|max:255',
        'nama_perusahaan' => 'required|string|max:255',
        'kontak_person' => 'required|string|max:255',
        'lokasi_instalasi' => 'required|string|max:255',
        'status' => 'required|string|in:Diterima,Proses,Selesai,Ditolak',
    ];
    
    public function render()
    {
        $instalasi = NocInstallationRequest::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('nomor_tiket', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nama_perusahaan', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('kontak_person', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.noc-installation-management', [
            'instalasi' => $instalasi,
        ]);
    }
    
    public function showAddForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->isEditing = false;
    }
    
    public function edit($id)
    {
        $installation = NocInstallationRequest::findOrFail($id);
        
        $this->installationId = $installation->id;
        $this->nomor_tiket = $installation->nomor_tiket;
        $this->nama_perusahaan = $installation->nama_perusahaan;
        $this->kontak_person = $installation->kontak_person;
        $this->lokasi_instalasi = $installation->lokasi_instalasi;
        $this->status = $installation->status;
        
        $this->showForm = true;
        $this->isEditing = true;
    }
    
    public function save()
    {
        $this->validate();
        
        if ($this->isEditing) {
            $installation = NocInstallationRequest::findOrFail($this->installationId);
            $installation->update([
                'nomor_tiket' => $this->nomor_tiket,
                'nama_perusahaan' => $this->nama_perusahaan,
                'kontak_person' => $this->kontak_person,
                'lokasi_instalasi' => $this->lokasi_instalasi,
                'status' => $this->status,
            ]);
            
            session()->flash('message', 'Permintaan instalasi berhasil diperbarui.');
        } else {
            NocInstallationRequest::create([
                'nomor_tiket' => $this->nomor_tiket,
                'nama_perusahaan' => $this->nama_perusahaan,
                'kontak_person' => $this->kontak_person,
                'lokasi_instalasi' => $this->lokasi_instalasi,
                'status' => $this->status,
            ]);
            
            session()->flash('message', 'Permintaan instalasi berhasil ditambahkan.');
        }
        
        $this->resetForm();
        $this->showForm = false;
    }
    
    public function delete($id)
    {
        NocInstallationRequest::findOrFail($id)->delete();
        session()->flash('message', 'Permintaan instalasi berhasil dihapus.');
    }
    
    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }
    
    private function resetForm()
    {
        $this->reset([
            'installationId',
            'nomor_tiket',
            'nama_perusahaan',
            'kontak_person',
            'lokasi_instalasi',
            'status',
            'isEditing',
        ]);
    }
}
