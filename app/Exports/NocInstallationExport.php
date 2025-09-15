<?php

namespace App\Exports;

use App\Models\NocInstallationRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NocInstallationExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return NocInstallationRequest::orderBy('created_at', 'desc')->get();
    }

    /**
     * Define the headings for the export
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nomor Tenant',
            'Nomor Tiket',
            'Nama Perusahaan',
            'Kontak Person',
            'Nomor Telepon',
            'Lokasi Instalasi',
            'Jenis Layanan',
            'Kecepatan Bandwidth',
            'Tanggal Permintaan',
            'Tanggal Instalasi',
            'Waktu Instalasi',
            'Catatan Tambahan',
            'Status',
            'Dokumen Path',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map the data for the export
     */
    public function map($installation): array
    {
        return [
            $installation->id,
            $installation->nomor_tenant,
            $installation->nomor_tiket,
            $installation->nama_perusahaan,
            $installation->kontak_person,
            $installation->nomor_telepon,
            $installation->lokasi_instalasi,
            $installation->jenis_layanan,
            $installation->kecepatan_bandwidth,
            $installation->tanggal_permintaan,
            $installation->tanggal_instalasi,
            $installation->waktu_instalasi,
            $installation->catatan_tambahan,
            $installation->status,
            $installation->dokumen_path,
            $installation->created_at,
            $installation->updated_at,
        ];
    }
}
