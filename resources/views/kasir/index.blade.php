@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Pesanan</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Tenant</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->tenant->nama }}</td>
                        <td>
                            <ul>
                                @foreach (json_decode($order->items) as $item)
                                    <li>{{ $item->nama }} x{{ $item->jumlah }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <form action="{{ route('kasir.orders.complete', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Selesaikan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
