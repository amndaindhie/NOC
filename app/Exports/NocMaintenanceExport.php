<?php

namespace App\Exports;

use App\Models\NocMaintenanceRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NocMaintenanceExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return NocMaintenanceRequest::orderBy('created_at', 'desc')->get();
    }

    /**
     * Define the headings for the export
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nomor Tenant',
            'Nomor Tracking',
            'Nama Tenant',
            'Jenis Maintenance',
            'Tanggal Permintaan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Deskripsi Masalah',
            'Tingkat Urgensi',
            'Lokasi Perangkat',
            'Status',
            'Dokumen Path',
            'Dokumen Filename',
            'Dokumen Mime Type',
            'Dokumen Size',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map the data for the export
     */
    public function map($maintenance): array
    {
        return [
            $maintenance->id,
            $maintenance->nomor_tenant,
            $maintenance->nomor_tracking,
            $maintenance->nama_tenant,
            $maintenance->jenis_maintenance,
            $maintenance->tanggal_permintaan,
            $maintenance->tanggal_mulai,
            $maintenance->tanggal_selesai,
            $maintenance->deskripsi_masalah,
            $maintenance->tingkat_urgensi,
            $maintenance->lokasi_perangkat,
            $maintenance->status,
            $maintenance->dokumen_path,
            $maintenance->dokumen_filename,
            $maintenance->dokumen_mime_type,
            $maintenance->dokumen_size,
            $maintenance->created_at,
            $maintenance->updated_at,
        ];
    }
}
