<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | MyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">MyShop</h1>
            <div class="space-x-4">
                <a href="{{ route('customer.login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Login</a>
                <a href="{{ route('customer.register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Register</a>
            </div>
        </div>
    </header>

    <section class="relative bg-blue-600 text-white">
        <div class="container mx-auto px-6 py-20 text-center">
            <h2 class="text-5xl font-bold mb-4">Discover Amazing Products</h2>
            <p class="text-lg mb-8">Shop the latest trends, deals, and collections in one place.</p>
            <a href="{{ route('customer.register') }}" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-full hover:bg-gray-100 transition">
                Get Started
            </a>
        </div>
        
        <div class="absolute top-0 right-0 w-40 h-40 bg-blue-400 rounded-full opacity-50 -mt-20 -mr-20"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-blue-400 rounded-full opacity-50 -mb-20 -ml-20"></div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-gray-800 mb-12">Why Choose MyShop?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <img src="https://img.icons8.com/color/96/shipped.png" class="mx-auto mb-4" alt="Fast Delivery"/>
                    <h4 class="text-xl font-bold mb-2">Fast Delivery</h4>
                    <p class="text-gray-600">Get your orders delivered quickly and on time.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <img src="https://img.icons8.com/color/96/discount.png" class="mx-auto mb-4" alt="Best Deals"/>
                    <h4 class="text-xl font-bold mb-2">Best Deals</h4>
                    <p class="text-gray-600">Enjoy amazing discounts and offers every day.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <img src="https://img.icons8.com/color/96/customer-support.png" class="mx-auto mb-4" alt="24/7 Support"/>
                    <h4 class="text-xl font-bold mb-2">24/7 Support</h4>
                    <p class="text-gray-600">Our team is always here to help you with any issues.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold mb-4">Ready to Start Shopping?</h3>
            <p class="mb-6">Join thousands of happy customers today.</p>
            <a href="{{ route('customer.register') }}" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-full hover:bg-gray-100 transition">
                Register Now
            </a>
        </div>
    </section>

    <footer class="bg-white shadow py-6 mt-12">
        <div class="container mx-auto text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} MyShop. All rights reserved.
        </div>
    </footer>

</body>
</html>
