@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="fw-bold py-3 mb-4">Tambah Produk</h4>
        <div class="card p-3">
            <form action="{{ route('products.store') }}" method="POST">
                @include('products.form')
            </form>
        </div>
    </div>
@endsection
