<h2>Struk Pemesanan</h2>
<p>Tanggal: {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
<p>No. Order: {{ $transaction->nomor_order }}</p>
<p>Tenant: {{ $transaction->tenant->nama }}</p>

<hr>

<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction->details as $item)
            <tr>
                <td>{{ $item->produk->nama }}</td>
                <td>{{ number_format($item->harga_satuan) }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ number_format($item->subtotal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>
<p><strong>Total: Rp {{ number_format($transaction->total_harga) }}</strong></p>
<p>Status: {{ ucfirst($transaction->status) }}</p>
