<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class KasirOrderStatusController extends Controller
{
    public function index()
    {
        // Menampilkan hanya transaksi yang sudah terbayar
        $transactions = Transaction::where('status', 'completed')
            ->latest()
            ->with('tenant', 'transactionDetails.produk')
            ->get();

        return view('kasir.status-order.index', compact('transactions'));
    }

    public function print($id)
    {
        $transaction = Transaction::with(['transactionDetails.produk', 'tenant'])->findOrFail($id);

        return view('kasir.status-order.print', compact('transaction'));
    }
}
