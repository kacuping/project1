@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Status Order</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nomor Order</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->nomor_order }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-success">Dibayar</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                @if ($order->status == 'pending')
                                    <form method="POST" action="{{ route('tenant.orders.cancel', $order->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                        <a href="{{ route('tenant.transactions.print', $order->id) }}" target="_blank"
                                            class="btn btn-sm btn-secondary">
                                            <i class="menu-icon bx bx-bxs-printer"></i> Cetak Ulang
                                        </a>
                                    </form>
                                @elseif ($order->status == 'completed')
                                    <a href="{{ route('tenant.transactions.print', $order->id) }}" target="_blank"
                                        class="btn btn-sm btn-secondary">
                                        <i class="menu-icon bx bx-bxs-printer"></i> Cetak Struk
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Tidak tersedia</button>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
