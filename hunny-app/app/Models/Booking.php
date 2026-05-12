<?php

namespace App\Models;

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
        'jenis_layanan',
        'nama_hewan',
        'jenis_hewan',
        'tanggal_reservasi',
        'status',
        'foto_hewan',
        'catatan',
    ];
}