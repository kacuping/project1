<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;


class Produk extends Model
{

    protected $fillable = [
        'nama',
        'tenant_id',
        'harga',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
