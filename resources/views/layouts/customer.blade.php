<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer - @yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-50 font-sans">
    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Customer Portal</h2>
        @auth
            <nav>
                <a href="{{ route('customer.dashboard') }}" class="px-3">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded">Logout</button>
                </form>
            </nav>
        @endauth
    </header>

    <main class="p-6">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6">
            @yield('content')
        </div>
    </main>

    <footer class="bg-blue-100 text-center p-4 mt-6">
        <p>&copy; {{ date('Y') }} Customer Portal</p>
    </footer>
</body>
</html>
