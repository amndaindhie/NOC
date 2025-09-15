<?php

namespace App\Models;

use App\Helpers\TicketNumberGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NocTermination extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tenant',
        'nama_tenant',
        'lokasi',
        'alasan_terminasi',
        'tanggal_efektif',
        'dokumen_path',
        'status',
        'nomor_tiket',
        'prioritas_terminasi',
        'keterangan_tambahan',
        'email'
    ];

    protected $dates = [
        'tanggal_efektif',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->nomor_tiket = TicketNumberGenerator::generateForType('terminasi');
        });
    }
}
