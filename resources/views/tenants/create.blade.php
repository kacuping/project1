@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="fw-bold py-3 mb-4">Tambah Tenant</h4>
        <div class="card p-3">
            <form action="{{ route('tenants.store') }}" method="POST">
                @include('tenants.form')
            </form>
        </div>
    </div>
@endsection
