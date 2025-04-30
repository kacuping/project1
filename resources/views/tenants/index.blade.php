@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="fw-bold py-3 mb-4">Manajemen Tenant</h4>
        <a href="{{ route('tenants.create') }}" class="btn btn-primary mb-3">+ Tambah Tenant</a>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Pemilik</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($tenants as $tenant)
                            <tr>
                                <td>{{ $tenant->nama }}</td>
                                <td>{{ $tenant->pemilik }}</td>
                                <td>{{ $tenant->no_hp }}</td>
                                <td>{{ $tenant->alamat }}</td>
                                <td>
                                    <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
