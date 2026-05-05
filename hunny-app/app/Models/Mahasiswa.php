<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
    'mahasiswa';
    'nim';
    'kelas';
    'jurusan';
    ]

    protected $casts = [
        'mahasiswa' => 'string',
        'nim' => 'string',
        'kelas' => 'string',
        'jurusan' => 'string',
    ];
}
