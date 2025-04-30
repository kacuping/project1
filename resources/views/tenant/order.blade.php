<form action="{{ route('tenant.transaksi.store') }}" method="POST">
    @csrf

    <input type="hidden" name="total_harga" id="total_harga" value="">

    <div id="produk-wrapper">
        <!-- Loop produk di sini -->
        @foreach ($produk as $p)
            <div>
                <label>{{ $p->nama }}</label>
                <input type="hidden" name="items[{{ $loop->index }}][produk_id]" value="{{ $p->id }}">
                <input type="number" name="items[{{ $loop->index }}][jumlah]" value="1">
                <input type="hidden" name="items[{{ $loop->index }}][harga_satuan]" value="{{ $p->harga }}">
            </div>
        @endforeach
    </div>

    <button type="submit">Pesan</button>
</form>
