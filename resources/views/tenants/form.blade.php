@csrf

<div class="mb-3">
    <label class="form-label">Nama Tenant</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $tenant->nama ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Pemilik</label>
    <input type="text" name="pemilik" class="form-control" value="{{ old('pemilik', $tenant->pemilik ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">No HP</label>
    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $tenant->no_hp ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control">{{ old('alamat', $tenant->alamat ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ route('tenants.index') }}" class="btn btn-secondary">Kembali</a>
