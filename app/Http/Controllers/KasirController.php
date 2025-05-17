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

    public function index(Request $request)
    {
        $keyword = $request->query('q');

        $transactions = Transaction::with(['tenant', 'transactionDetails.produk'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('nomor_order', 'like', "%{$keyword}%")
                    ->orWhereHas('tenant', fn($q) => $q->where('nama', 'like', "%{$keyword}%"));
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();



        $transactions = Transaction::with('tenant')
            ->where('status', 'pending')
            ->latest()
            // ->get();
            ->paginate(9);


        return view('kasir.index', compact('transactions'));
    }

    public function proses($id)
    {
        $transaksi = Transaction::with('details.produk', 'details.tenant')->findOrFail($id);

        $transaksi = Transaction::findOrFail($id);
        $transaksi->status = 'completed';
        $transaksi->save();

        // return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil diproses.');
        return redirect()->route('kasir.transaksi.print', $transaksi->id);
    }

    public function receipt($id)
    {
        $order = Transaction::with(['transactionDetails.produk', 'tenant'])->findOrFail($id);

        return view('kasir.receipt', compact('order'));
    }
}
