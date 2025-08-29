@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-4">Welcome {{ auth()->user()->name }}</h1>
<p class="text-gray-700">This is your admin dashboard.</p>
@endsection
