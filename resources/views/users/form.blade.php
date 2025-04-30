@extends('layouts.app') <!-- Ganti dengan layout kamu jika berbeda -->

@section('content')
    <div class="container">
        <div class="card p-3">

            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <!-- Nama -->
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}"
                        required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}"
                        required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" onchange="toggleTenantSelect()">
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="kasir" {{ old('role', $user->role ?? '') == 'kasir' ? 'selected' : '' }}>Kasir
                        </option>
                        <option value="tenant" {{ old('role', $user->role ?? '') == 'tenant' ? 'selected' : '' }}>Tenant
                        </option>
                    </select>
                </div>

                <!-- Tenant (hanya untuk role tenant) -->
                @php
                    $tenants = \App\Models\Tenant::all();
                @endphp
                <div class="mb-3">
                    <label for="tenant_id">Tenant (Hanya untuk role tenant)</label>
                    <select name="tenant_id" id="tenant_id" class="form-control">
                        <option value="">-- Pilih Tenant --</option>
                        @foreach ($tenants as $tenant)
                            <option value="{{ $tenant->id }}"
                                {{ old('tenant_id', $user->tenant_id ?? '') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label>Password {{ isset($user) ? '(Biarkan kosong jika tidak diubah)' : '' }}</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleTenantSelect() {
            const role = document.getElementById('role').value;
            const tenantSelect = document.getElementById('tenant_id');

            if (role === 'tenant') {
                tenantSelect.disabled = false;
            } else {
                tenantSelect.disabled = true;
                tenantSelect.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleTenantSelect();
        });
    </script>
@endsection
