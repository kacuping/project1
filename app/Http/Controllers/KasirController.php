<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function pending()
    {
        // Ambil semua transaksi yang belum dibayar
        $transaksi = Transaction::with(['transactionDetails.produk', 'tenant'])
            ->where('status', 'pending') // atau 'belum_dibayar'
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transaksi);
    }

    public function index()
    {
        $transaksis = Transaction::with(['transactionDetails.produk', 'tenant'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('kasir.transaksi.index', compact('transaksis'));
    }

    public function bayar($id)
    {
        $transaksi = Transaction::findOrFail($id);
        $transaksi->update(['status' => 'paid']);

        return redirect()->route('kasir.transaksi.index')->with('success', 'Pembayaran berhasil diproses.');
    }
}
