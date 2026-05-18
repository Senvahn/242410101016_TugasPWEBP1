<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'order_code',
        'nama_pemesan',
        'telepon',
        'email',
        'qty',
        'payment_method',
        'total',
        'status',
        'note',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'decimal:2',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
