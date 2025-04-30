@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Tambah User</h4>
        <div class="card p-3">
            <form action="{{ route('users.store') }}" method="POST">
                @include('users.form')
            </form>
        </div>
    </div>
@endsection
