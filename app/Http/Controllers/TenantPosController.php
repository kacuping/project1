<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;

class TenantPosController extends Controller
{
    // Menampilkan halaman POS khusus tenant
    public function index()
    {
        $user = Auth::user();

        // Ambil produk berdasarkan tenant yang login
        $produk = Produk::where('tenant_id', $user->tenant_id)->get();

        return view('tenant.pos', compact('produk'));
    }

    // Simpan transaksi yang dilakukan oleh tenant
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|json',
        ]);

        $items = json_decode($data['items'], true);

        $nomorOrder = Transaction::generateNomorOrder();

        $transaksi = Transaction::create([
            'nomor_order' => $nomorOrder,
            'tenant_id' => Auth::user()->tenant_id,
            'total_harga' => collect($items)->sum(fn($item) => $item['qty'] * $item['price']),
            'status' => 'pending',
        ]);

        foreach ($items as $item) {
            $transaksi->transaksiDetails()->create([
                'produk_id' => $item['id'],
                'jumlah' => $item['qty'],
                'harga_satuan' => $item['price'],
                'subtotal' => $item['qty'] * $item['price'],
            ]);
        }

        // return redirect()->back()->with('success', 'Order berhasil dikirim! Nomor Order: ' . $nomorOrder);
        return redirect()->route('tenant.transactions.print', ['id' => $transaksi->id]);
    }
}
