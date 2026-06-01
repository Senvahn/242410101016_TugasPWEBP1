<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'jumlah',
        'satuan',
        'harga_beli',
        'supplier_id',
        'foto_produk',
        'status_tersedia', 
        'tanggal_masuk',
    ];

    protected $casts = [
        'status_tersedia' => 'boolean', 
        'jumlah' => 'integer',
        'tanggal_masuk' => 'date', 
        'harga_beli' => 'decimal:2',
    ];


    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'produk_supplier');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}