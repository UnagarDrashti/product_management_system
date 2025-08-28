@extends('layouts.customer')
@section('title', 'Register')

@section('content')
<h2 class="text-2xl font-bold mb-4">Customer Register</h2>
<form method="POST" action="{{ route('customer.register') }}" class="space-y-4">
    @csrf
    <input type="text" name="name" placeholder="Full Name" required
        class="w-full border p-2 rounded">
    <input type="email" name="email" placeholder="Email" required
        class="w-full border p-2 rounded">
    <input type="password" name="password" placeholder="Password" required
        class="w-full border p-2 rounded">
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Register</button>
</form>
@endsection
