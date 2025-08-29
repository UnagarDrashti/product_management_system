<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Admin Panel</h2>
        @auth
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="px-6">Dashboard</a>
                <a href="{{ route('products.index') }}" class="px-6">Products</a>
                <a href="{{ route('admin.orders.index') }}" class="px-6">Orders</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded">Logout</button>
                </form>
            </nav>
        @endauth
    </header>

    <main class="p-6">
        <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
            @yield('content')

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            @stack('scripts')
        </div>
    </main>

    <footer class="bg-gray-200 text-center p-4 mt-6">
        <p>&copy; {{ date('Y') }} Admin Panel</p>
    </footer>
</body>
</html>
