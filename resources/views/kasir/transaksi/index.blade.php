@extends('layouts.app') {{-- ganti dengan layout Sneat kamu --}}

@section('content')
    <div class="container">
        <div class="card">
            <h5 class="card-header">POS System - Transaksi Pending</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Order</th>
                            <th>Tenant</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $index => $transaksi)
                            @php $rowspan = count($transaksi->transaction_details); @endphp
                            @foreach ($transaksi->transaction_details as $i => $detail)
                                <tr>
                                    @if ($i === 0)
                                        <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                        <td rowspan="{{ $rowspan }}"><strong>{{ $transaksi->nomor_order }}</strong></td>
                                        <td rowspan="{{ $rowspan }}">{{ $transaksi->tenant->nama }}</td>
                                    @endif
                                    <td>{{ $detail->produk->nama }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    @if ($i === 0)
                                        <td rowspan="{{ $rowspan }}">
                                            <strong>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                                        </td>
                                        <td rowspan="{{ $rowspan }}">
                                            <span class="badge bg-label-warning">{{ ucfirst($transaksi->status) }}</span>
                                        </td>
                                        <td rowspan="{{ $rowspan }}">
                                            <form method="POST"
                                                action="{{ route('kasir.transaksi.bayar', $transaksi->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('Yakin ingin memproses pembayaran?')">
                                                    <i class="bx bx-check-circle"></i> Bayar
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
