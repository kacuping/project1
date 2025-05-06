<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Tenant;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Tenant
        $totalTenants = Tenant::count();

        // Total Produk
        $totalProducts = Produk::count();

        // Total Pendapatan Bulan Ini
        $totalRevenue = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->sum('total_harga');

        // Total Transaksi Hari Ini
        $totalTransactions = Transaction::whereDate('created_at', Carbon::today())->count();

        // Produk Terlaris (top 5)
        $topProducts = Produk::with('tenant')
            ->select('produks.*')
            ->join('transaction_details', 'produks.id', '=', 'transaction_details.produk_id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->groupBy('produks.id')
            ->selectRaw('SUM(transaction_details.jumlah) as total_sold')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Tenant Terbaik (berdasarkan total pendapatan)
        $topTenants = Tenant::select('tenants.*')
            ->selectRaw('SUM(transactions.total_harga) as total_revenue')
            ->join('transactions', 'tenants.id', '=', 'transactions.tenant_id')
            ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->groupBy('tenants.id')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTenants',
            'totalProducts',
            'totalRevenue',
            'totalTransactions',
            'topProducts',
            'topTenants'
        ));
    }
}
