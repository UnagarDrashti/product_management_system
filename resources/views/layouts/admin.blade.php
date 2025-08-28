<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Admin Panel</h2>
        @auth
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="px-3">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded">Logout</button>
                </form>
            </nav>
        @endauth
    </header>

    <main class="p-6">
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-200 text-center p-4 mt-6">
        <p>&copy; {{ date('Y') }} Admin Panel</p>
    </footer>
</body>
</html>
