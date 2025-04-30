<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kasir extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', // Misalnya ada field tenant_id
        'nama', // Misalnya ada field nama kasir
        // tambahkan field lainnya sesuai dengan tabel kasir
    ];
}
