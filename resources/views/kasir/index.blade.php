@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>POS Kasir Utama</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Order</th>
                        <th>Tenant</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trx->nomor_order }}</td>
                            <td>{{ $trx->tenant->nama }}</td>
                            <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-warning">{{ $trx->status }}</span></td>
                            <td>
                                <form action="{{ route('kasir.proses', $trx->id) }}" method="POST"
                                    onsubmit="return confirm('Proses pembayaran?')">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Proses</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi pending.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
