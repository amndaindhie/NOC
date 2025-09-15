<?php

namespace App\Models;

use App\Helpers\TicketNumberGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NocComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tenant',
        'nama_tenant',
        'kontak_person',
        'jenis_gangguan',
        'waktu_mulai_gangguan',
        'deskripsi_gangguan',
        'bukti_path',
        'status',
        'nomor_tiket',
        'email',
        'tingkat_urgensi'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->nomor_tiket = TicketNumberGenerator::generateForType('keluhan');
        });
    }
}
