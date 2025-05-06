<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function print($id)
    {
        $transaction = Transaction::with(['transactionDetails.produk', 'tenant'])
            ->findOrFail($id);

        return view('transactions.print', compact('transaction'));
    }
}
