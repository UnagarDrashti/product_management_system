@extends('layouts.admin')
@section('title', 'Login')

@section('content')
<h2 class="text-2xl font-bold mb-4">Admin Login</h2>
<form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
    @csrf
    <input type="email" name="email" placeholder="Email" required
        class="w-full border p-2 rounded">
    <input type="password" name="password" placeholder="Password" required
        class="w-full border p-2 rounded">
    <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded">Login</button>
</form>
@endsection
