<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function produks()
    {
    return $this->belongsToMany(Produk::class, 'produk_supplier');
    }
}
