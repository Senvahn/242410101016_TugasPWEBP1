<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   public function produks()
    {
    return $this->belongsToMany(Produk::class, 'customer_produk');
    }
}
