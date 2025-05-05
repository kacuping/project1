<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantTransactionController extends Controller
{
    public function index()
    {
        $tenantId = Auth::user()->tenant_id;

        $orders = Transaction::with('transactionDetails.produk')
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tenant.status-order', compact('orders'));
    }

    public function cancel($id)
    {
        $order = Transaction::where('id', $id)
            ->where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'pending') // hanya pending yang bisa dibatalkan
            ->firstOrFail();

        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Order berhasil dibatalkan.');
    }
}
