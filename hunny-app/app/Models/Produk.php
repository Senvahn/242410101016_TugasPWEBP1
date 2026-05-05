<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori',
        'jumlah',
        'satuan',
        'status_tersedia', 
        'tanggal_masuk',
    ];

    protected $casts = [
        'status_tersedia' => 'boolean', 
        'jumlah' => 'integer',
        'tanggal_masuk' => 'date', 
    ];


    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'produk_supplier');
    }
}