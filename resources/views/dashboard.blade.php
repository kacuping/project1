@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h4 class="fw-bold py-3 mb-4">Dashboard</h4>

    <div class="row">
        <!-- Card Tenant -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Total Tenant</span>
                            <div class="d-flex align-items-center my-1">
                                <h3 class="mb-0 me-2">{{ $totalTenants ?? 0 }}</h3>
                            </div>
                            <small>Tenant terdaftar</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-store fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Produk -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Total Produk</span>
                            <div class="d-flex align-items-center my-1">
                                <h3 class="mb-0 me-2">{{ $totalProducts ?? 0 }}</h3>
                                {{-- <span class="text-success">{{ $productGrowth }}%</span> --}}
                            </div>
                            <small>Produk tersedia</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-food-menu fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pendapatan -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Pendapatan</span>
                            <div class="d-flex align-items-center my-1">
                                <h3 class="mb-0 me-2">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                            </div>
                            <small>Bulan ini</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="bx bx-wallet fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Transaksi -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Transaksi</span>
                            <div class="d-flex align-items-center my-1">
                                <h3 class="mb-0 me-2">{{ $totalTransactions ?? 0 }}</h3>
                                {{-- <span class="text-success">{{ $transactionGrowth }}%</span> --}}
                            </div>
                            <small>Transaksi hari ini</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-shopping-bag fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Penjualan -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Statistik Penjualan</h5>
                </div>
                <div class="card-body">
                    <div id="salesChart" style="min-height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produk Terlaris</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($topProducts ?? [] as $product)
                            <li class="d-flex mb-3 pb-1 align-items-center">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-dish"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $product->name ?? 'Produk' }}</h6>
                                        <small class="text-muted">{{ $product->tenant ?? 'Tenant' }}</small>
                                    </div>
                                    <div class="user-progress">
                                        <small>{{ $product->total_sold ?? 0 }} Terjual</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tenant Terbaik -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tenant Terbaik</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($topTenants ?? [] as $tenant)
                            <li class="d-flex mb-3 pb-1 align-items-center">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-store-alt"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $tenant->name ?? 'Tenant' }}</h6>
                                        <small class="text-muted">{{ $tenant->category ?? 'Kategori' }}</small>
                                    </div>
                                    <div class="user-progress">
                                        <small>Rp {{ number_format($tenant->total_revenue ?? 0, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
