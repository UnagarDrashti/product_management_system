@extends('layouts.customer')
@section('title', 'Login')

@section('content')
<h2 class="text-2xl font-bold mb-4">Customer Login</h2>
<form method="POST" action="{{ route('customer.login') }}" class="space-y-4">
    @csrf
    <input type="email" name="email" placeholder="Email" required
        class="w-full border p-2 rounded">
    <input type="password" name="password" placeholder="Password" required
        class="w-full border p-2 rounded">
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Login</button>
</form>
<a href="{{ route('customer.register') }}" class="block mt-4 text-blue-600 hover:underline">Register</a>
@endsection
