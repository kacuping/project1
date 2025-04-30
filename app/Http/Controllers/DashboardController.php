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

        // Total Pendapatan (contoh asumsi field 'total' di tabel transaksi)
        $totalRevenue = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        // Total Transaksi Hari Ini
        $totalTransactions = Transaction::whereDate('created_at', Carbon::today())->count();

        // Produk Terlaris (top 5)
        $topProducts = Produk::with('tenant')
            ->withSum('transactions as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Tenant Terbaik (berdasarkan total pendapatan)
        $topTenants = Tenant::with(['products.transactions'])
            ->get()
            ->map(function ($tenant) {
                $totalRevenue = $tenant->products->flatMap->transactions->sum('total');
                return (object)[
                    'name' => $tenant->name,
                    'category' => $tenant->category,
                    'total_revenue' => $totalRevenue,
                ];
            })
            ->sortByDesc('total_revenue')
            ->take(5);

        return view('dashboard', compact(
            'totalTenants',
            'tenantGrowth',
            'totalProducts',
            'totalRevenue',
            'totalTransactions',
            'topProducts',
            'topTenants'
        ));
    }
}
