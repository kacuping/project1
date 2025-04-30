@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="fw-bold py-3 mb-4">Edit Produk</h4>
        <div class="card p-3">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @method('PUT')
                @include('products.form')
            </form>
        </div>
    </div>
@endsection
