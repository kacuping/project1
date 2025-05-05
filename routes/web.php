<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantPosController;
use App\Http\Controllers\TransactionController;
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

// Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
//     Route::get('/pos', [TenantPosController::class, 'index'])->name('tenant.pos');
//     Route::post('/transaksi', [TenantPosController::class, 'store'])->name('tenant.transaksi.store');
// });

Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/pos', [TenantPosController::class, 'index'])->name('pos');
    Route::post('/pos', [TenantPosController::class, 'store'])->name('transaksi.store');
    Route::get('/transactions/{id}/print', [TransactionController::class, 'showStruk'])->name('tenant.struk');
});

// Route::group(['middleware' => ['auth', 'role:kasir']], function () {
// Route::get('/kasir/transaksi-pending', [KasirController::class, 'pending']);
//     Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
//     Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store');
//     Route::get('/kasir/{id}/edit', [KasirController::class, 'edit'])->name('kasir.edit');
//     Route::put('/kasir/{id}', [KasirController::class, 'update'])->name('kasir.update');
//     Route::delete('/kasir/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
// });

Route::get('/tenant/transactions/{id}/print', [TransactionController::class, 'print'])
    ->name('tenant.transactions.print');

// Route::middleware(['auth'])->prefix('kasir')->name('kasir.')->group(function () {
//     Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
//     Route::get('/transaksi', [KasirController::class, 'index'])->name('transaksi.index');
//     Route::post('/transaksi/{id}/bayar', [KasirController::class, 'bayar'])->name('transaksi.bayar');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/{id}/proses', [KasirController::class, 'proses'])->name('kasir.proses');
});

Route::prefix('kasir')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
});

Route::prefix('tenant')->middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/status-order', [TenantTransactionController::class, 'index'])->name('tenant.orders.status');
    Route::post('/cancel-order/{id}', [TenantTransactionController::class, 'cancel'])->name('tenant.orders.cancel');
});
    
// Route::middleware(['auth', 'role:kasir'])->group(function () {
//     Route::get('/kasir/transaksi-pending', [KasirController::class, 'pending']);
// });
// Route::group(['middleware' => ['auth', 'role:kasir']], function () {
    // Route::get('/kasir/transaksi-pending', [KasirController::class, 'pending']);
    // Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store');
    // Route::get('/kasir/{id}/edit', [KasirController::class, 'edit'])->name('kasir.edit');
    // Route::put('/kasir/{id}', [KasirController::class, 'update'])->name('kasir.update');
    // Route::delete('/kasir/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
// });
