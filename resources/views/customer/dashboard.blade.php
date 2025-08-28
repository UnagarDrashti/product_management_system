@extends('layouts.customer')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-4">Welcome, Customer {{ auth()->user()->name }}</h1>
<p class="text-gray-700">This is your customer dashboard.</p>
@endsection
