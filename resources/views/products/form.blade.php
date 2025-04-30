@csrf

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $product->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Tenant</label>
    <select name="tenant_id" class="form-control" required>
        <option value="">-- Pilih Tenant --</option>
        @foreach ($tenants as $tenant)
            <option value="{{ $tenant->id }}"
                {{ old('tenant_id', $product->tenant_id ?? '') == $tenant->id ? 'selected' : '' }}>
                {{ $tenant->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number" name="harga" class="form-control" value="{{ old('harga', $product->harga ?? '') }}"
        required>
</div>

<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
