{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    <p class="mb-4">Halo Admin, {{ auth()->user()->name }}!</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Logout
        </button>
    </form>
</div>
@endsection
