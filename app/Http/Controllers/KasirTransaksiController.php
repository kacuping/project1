<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class KasirTransaksiController extends Controller
{
    public function print($id)
    {
        $transaksi = Transaction::with(['transactionDetails.produk', 'tenant'])->findOrFail($id);

        return view('kasir.print', compact('transaksi'));
    }
}
