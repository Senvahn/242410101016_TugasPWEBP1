<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_booking',
        'nama_pemilik',
        'email',
        'service_id',
        'jenis_layanan',
        'nama_hewan',
        'jenis_hewan',
        'tanggal_reservasi',
        'pilihan_jam',
        'status',
        'foto_hewan',
        'pet_photo',
        'catatan',
        'payment_method',
        'payment_proof',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}