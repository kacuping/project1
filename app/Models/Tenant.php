<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'nama',
        'pemilik',
        'no_hp',
        'alamat',
    ];

    public function products()
    {
        return $this->hasMany(Produk::class);
    }
}
