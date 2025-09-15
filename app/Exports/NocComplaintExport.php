<?php

namespace App\Exports;

use App\Models\NocComplaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NocComplaintExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return NocComplaint::orderBy('created_at', 'desc')->get();
    }

    /**
     * Define the headings for the export
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nomor Tenant',
            'Nama Tenant',
            'Kontak Person',
            'Nomor Tiket',
            'Jenis Gangguan',
            'Waktu Mulai Gangguan',
            'Deskripsi Gangguan',
            'Status',
            'Bukti Path',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map the data for the export
     */
    public function map($complaint): array
    {
        return [
            $complaint->id,
            $complaint->nomor_tenant,
            $complaint->nama_tenant,
            $complaint->kontak_person,
            $complaint->nomor_tiket,
            $complaint->jenis_gangguan,
            $complaint->waktu_mulai_gangguan,
            $complaint->deskripsi_gangguan,
            $complaint->status,
            $complaint->bukti_path,
            $complaint->created_at,
            $complaint->updated_at,
        ];
    }
}
