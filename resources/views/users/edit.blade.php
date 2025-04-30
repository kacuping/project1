@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Edit User</h4>
        <div class="card p-3">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf @method('PUT')

                @include('users.form')

                {{-- <button class="btn btn-primary">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a> --}}
            </form>
        </div>
    </div>
@endsection
