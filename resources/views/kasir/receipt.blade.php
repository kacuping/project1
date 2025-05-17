<div class="modal-header">
    <h5 class="modal-title">Struk Pembayaran - Order #{{ $order->nomor_order }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <p><strong>Tenant:</strong> {{ $order->tenant->nama }}</p>
    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->transactionDetails as $item)
                <tr>
                    <td>{{ $item->produk->nama }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end mt-3">
        <strong>Total: Rp{{ number_format($order->total_harga, 0, ',', '.') }}</strong>
    </div>
</div>
<div class="modal-footer">
    <form action="{{ route('kasir.confirm', $order->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Konfirmasi & Cetak</button>
    </form>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
