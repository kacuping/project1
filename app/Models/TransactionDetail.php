<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
