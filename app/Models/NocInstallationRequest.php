<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NocInstallationRequest extends Model
{
    use HasFactory;

    protected $table = 'noc_installation_requests';

    protected $fillable = [
        'nomor_tiket',
        'nomor_tenant',
        'nama_perusahaan',
        'kontak_person',
        'email',
        'nama_isp',
        'nomor_npwp',
        'lokasi_instalasi',
        'lokasi_pemasangan',
        'nomor_telepon',
        'jenis_layanan',
        'kecepatan_bandwidth',
        'skema_topologi',
        'tingkat_urgensi',
        'tanggal_permintaan',
        'tanggal_instalasi',
        'waktu_instalasi',
        'catatan_tambahan',
        'dokumen_path',
        'status',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'tanggal_instalasi' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method to set default values
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->tanggal_permintaan)) {
                $model->tanggal_permintaan = now()->toDateString();
            }
        });
    }
}
