<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTracking extends Model
{
    use HasFactory;

    protected $table = 'ticket_tracking';

    protected $fillable = [
        'nomor_tiket',
        'tipe_tiket',
        'status',
        'keterangan',
        'waktu_perubahan',
        'dilakukan_oleh'
    ];

    protected $casts = [
        'waktu_perubahan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public const TIPE_TIKET = [
        'instalasi' => 'Instalasi',
        'maintenance' => 'Maintenance',
        'keluhan' => 'Keluhan',
        'terminasi' => 'Terminasi',
    ];

    public const STATUS = [
        'pending' => 'Menunggu',
        'diproses' => 'Diproses',
        'dikerjakan' => 'Dikerjakan',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        'dibatalkan' => 'Dibatalkan',
    ];
}
