<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function print($id)
    {
        $transaction = Transaction::with(['transaksiDetails.produk', 'tenant'])
            ->findOrFail($id);

        $tenant = User::find($transaction->tenant_id);

        return view('transactions.print', [
            'transaction' => $transaction,
            'tenant' => $tenant
        ]);
    }
}
