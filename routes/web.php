<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantPosController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\TenantTransactionController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
});

Route::resource('tenants', TenantController::class);
Route::resource('products', ProdukController::class);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
});

Route::resource('users', UserController::class)->middleware('auth');

Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/pos', [TenantPosController::class, 'index'])->name('pos');
    Route::post('/pos', [TenantPosController::class, 'store'])->name('transaksi.store');
    Route::get('/transactions/{id}/print', [TransactionController::class, 'showStruk'])->name('tenant.struk');
});

Route::get('/tenant/transactions/{id}/print', [TransactionController::class, 'print'])
    ->name('tenant.transactions.print');

Route::get('/kasir/print/{id}', [KasirTransaksiController::class, 'print'])->name('kasir.transaksi.print');
Route::get('/kasir/receipt/{id}', [KasirController::class, 'receipt']);
Route::post('/kasir/confirm/{id}', [KasirController::class, 'confirm'])->name('kasir.confirm');

Route::post('/kasir/checkout', function (Request $request) {
    // Simpan di session
    session(['cart' => json_encode($request->items)]);

    // Buat dummy order ID (misalnya pakai UUID)
    $orderId = Str::uuid();

    return response()->json([
        'success' => true,
        'orderId' => $orderId,
        'redirect_url' => url('/kasir/receipt/' . $orderId)
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/{id}/proses', [KasirController::class, 'proses'])->name('kasir.proses');
    Route::get('/kasir/struk/{id}', [App\Http\Controllers\KasirOrderStatusController::class, 'print'])->name('kasir.order.print');
});

Route::prefix('kasir')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
});

Route::prefix('tenant')->middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/status-order', [TenantTransactionController::class, 'index'])->name('tenant.orders.status');
    Route::post('/cancel-order/{id}', [TenantTransactionController::class, 'cancel'])->name('tenant.orders.cancel');
});

Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir/status-order', [App\Http\Controllers\KasirOrderStatusController::class, 'index'])->name('kasir.status-order');
});
