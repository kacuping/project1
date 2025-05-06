@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h4>Status Order Terbayar</h4>

        <div class="card">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Nomor Order</th>
                        <th>Tenant</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $trx)
                        <tr>
                            <td>{{ $trx->nomor_order }}</td>
                            <td>{{ $trx->tenant->nama ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total_harga) }}</td>
                            <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($trx->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
