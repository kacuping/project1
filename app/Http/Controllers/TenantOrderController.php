<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TenantOrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $nomorOrder = 'ORD-' . now()->format('Ymd') . '-' . str_pad(Transaction::count() + 1, 4, '0', STR_PAD_LEFT);

            $transaction = Transaction::create([
                'nomor_order' => $nomorOrder,
                'tenant_id' => Auth::user()->tenant_id,
                'total_harga' => $request->total_harga,
                'status' => 'pending',
            ]);

            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['jumlah'] * $item['harga_satuan'],
                ]);
            }

            DB::commit();

            return redirect()->route('tenant.tenant.struk', $transaction->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showStruk($id)
    {
        $transaction = Transaction::with(['details.produk', 'tenant'])->findOrFail($id);
        return view('transactions.print', compact('transaction'));
    }
}
