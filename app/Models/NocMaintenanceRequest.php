<?php

namespace App\Models;

use App\Helpers\TicketNumberGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NocMaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tenant',
        'nama_tenant',
        'lokasi_perangkat',
        'jenis_maintenance',
        'deskripsi_masalah',
        'foto_path',
        'video_path',
        'tingkat_urgensi',
        'tanggal_permintaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'nomor_tracking',
        'email',
        'dokumen_path',
        'dokumen_filename',
        'dokumen_mime_type',
        'dokumen_size',
        'bukti_selesai_path',
        'bukti_selesai_filename'
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->nomor_tracking = TicketNumberGenerator::generateForType('maintenance');
        });
    }
}
