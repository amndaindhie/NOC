<?php

namespace App\Exports;

use App\Models\NocTermination;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NocTerminationExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return NocTermination::orderBy('created_at', 'desc')->get();
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
            'Lokasi',
            'Alasan Terminasi',
            'Tanggal Efektif',
            'Prioritas Terminasi',
            'Keterangan Tambahan',
            'Status',
            'Dokumen Path',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map the data for the export
     */
    public function map($termination): array
    {
        return [
            $termination->id,
            $termination->nomor_tenant,
            $termination->nama_tenant,
            $termination->lokasi,
            $termination->alasan_terminasi,
            $termination->tanggal_efektif,
            $termination->prioritas_terminasi,
            $termination->keterangan_tambahan,
            $termination->status,
            $termination->dokumen_path,
            $termination->created_at,
            $termination->updated_at,
        ];
    }
}
