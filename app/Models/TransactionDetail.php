<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $table = 'transaction_details';

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
