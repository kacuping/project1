<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransactionDetail;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'total_harga',
        'nomor_order',
        'status',
    ];


    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateNomorOrder()
    {
        $date = now()->format('Ymd');
        $last = self::whereDate('created_at', now())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);

        $strukId = 'STRK-' . now()->format('Ymd') . '-' . str_pad($transaction->id, 3, '0', STR_PAD_LEFT);


        // $date = now()->format('Ymd');
        // $last = self::whereDate('created_at', now())->count() + 1;

        // do {
        //     $nomorOrder = 'ORD-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
        //     $last++;
        // } while (self::where('nomor_order', $nomorOrder)->exists());

        // return $nomorOrder;
        // return 'ORD-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
