@extends('layouts.customer')
@section('title', 'My Cart')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Cart</h2>

    @if($cart && $cart->items->count())
    <div class="bg-white shadow-md rounded-lg overflow-hidden">

        <table class="w-full text-left table-auto border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-gray-600">Product</th>
                    <th class="p-3 text-gray-600">Name</th>
                    <th class="p-3 text-gray-600">Quantity</th>
                    <th class="p-3 text-gray-600">Price</th>
                    <th class="p-3 text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                <tr class="border-b hover:bg-gray-50 transition duration-200">
                    <td class="p-3">
                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                            alt="{{ $item->product->name }}" 
                            class="h-14 w-14 object-cover rounded-md">
                    </td>
                    <td class="p-3 font-medium text-gray-700">{{ $item->product->name }}</td>
                    <td class="p-3">
                        <div class="flex items-center space-x-2">
                            <button class="decrement bg-gray-200 px-2 rounded text-gray-700" data-id="{{ $item->product_id }}">-</button>
                            <input type="number" value="{{ $item->quantity }}" min="1" 
                                class="quantity border rounded px-2 py-1 w-16 text-center" 
                                data-id="{{ $item->product_id }}">
                            <button class="increment bg-gray-200 px-2 rounded text-gray-700" data-id="{{ $item->product_id }}">+</button>
                        </div>
                    </td>
                    <td class="p-3 font-semibold text-gray-800" id="price-{{ $item->product_id }}">
                        ${{ $item->price * $item->quantity }}
                    </td>
                    <td class="p-3">
                        <button class="remove-cart bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                data-id="{{ $item->product_id }}">
                            Remove
                        </button>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center p-4 bg-gray-50">
            <div class="text-lg font-semibold text-gray-800">
                Total: ${{ $cart->items->sum(fn($i) => $i->price * $i->quantity) }}
            </div>
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <button class="bg-green-600 px-6 py-2 rounded shadow hover:bg-green-600 transition font-semibold">
                    Checkout
                </button>
            </form>
        </div>

    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-600 text-lg">Your cart is empty.</p>
        <a href="{{ route('customer.dashboard') }}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
            Continue Shopping
        </a>
    </div>
    @endif

</div>


@endsection
@push('scripts')
<script type="text/javascript">
document.querySelectorAll('.increment').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            let input = document.querySelector('.quantity[data-id="'+id+'"]');
            input.value = parseInt(input.value) + 1;
            updateCart(id, input.value);
        });
    });

document.querySelectorAll('.decrement').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let input = document.querySelector('.quantity[data-id="'+id+'"]');
        if(parseInt(input.value) > 1){
            input.value = parseInt(input.value) - 1;
            updateCart(id, input.value);
        }
    });
});

document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('change', function() {
        let id = this.dataset.id;
        if(this.value < 1) this.value = 1;
        updateCart(id, this.value);
    });
});

function updateCart(id, quantity){
    fetch(`/customer/cart/update/${id}`, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
    body: JSON.stringify({quantity: newQuantity})
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById('price-' + id).textContent = '$' + data.item_total;
            document.getElementById('cart-total').textContent = '$' + data.cart_total;
        }
    });
}

// Remove item
document.querySelectorAll('.remove-cart').forEach(button => {
    button.addEventListener('click', function() {
        let id = this.dataset.id;
        fetch(`/customer/cart/remove/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    });
});

</script>
@endpush

