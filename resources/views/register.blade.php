@extends('layouts.customer')
@section('title', 'Register')

@section('content')
<h2 class="text-2xl font-bold mb-4">Customer Register</h2>

@if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('customer.register') }}" class="space-y-4">
    @csrf
    <input type="text" name="name" placeholder="Full Name" required
        class="w-full border p-2 rounded" value="{{ old('name') }}">
    <input type="email" name="email" placeholder="Email" required
        class="w-full border p-2 rounded" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="Password" required
        class="w-full border p-2 rounded">
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required
        class="w-full border p-2 rounded">
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Register</button>
</form>
@endsection
