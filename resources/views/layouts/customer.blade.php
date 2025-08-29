<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer - @yield('title')</title>
    @vite('resources/css/app.css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-blue-50 font-sans min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Customer Portal</h2>
        @auth
            <nav class="flex items-center gap-4">
                <a href="{{ route('customer.dashboard') }}" class="px-3 text-white">Dashboard</a>
                <div class="flex items-center space-x-4">
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13l-1.5 7M17 13l1.5 7M6 21h12"/>
                        </svg>

                        <!-- Badge for total items -->
                        <span id="cart-count"
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 transition">Logout</button>
                </form>
            </nav>
        @endauth
    </header>

    {{-- Main Content --}}
    <main>
        <div class="w-full px-4">
            @yield('content')
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')

    </main>

    {{-- Footer --}}
    <footer class="bg-blue-100 text-center p-4 mt-6">
        <p>&copy; {{ date('Y') }} Customer Portal</p>
    </footer>

</body>
</html>
