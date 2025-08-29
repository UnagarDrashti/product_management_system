@extends('layouts.admin')
@section('title', 'Login')

@section('content')
<h2 class="text-2xl font-bold mb-4">Admin Login</h2>

<form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
    @csrf
   @if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <input type="email" name="email" placeholder="Email" required
        class="w-full border p-2 rounded" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="Password" required
        class="w-full border p-2 rounded">
    <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded">Login</button>
</form>
@endsection
