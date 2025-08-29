@extends('layouts.admin')
@section('title', 'Orders Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Orders</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-left table-auto border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-gray-600">Order ID</th>
                    <th class="p-3 text-gray-600">Customer</th>
                    <th class="p-3 text-gray-600">Total</th>
                    <th class="p-3 text-gray-600">Status</th>
                    <th class="p-3 text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-50 transition duration-200">
                    <td class="p-3 font-medium text-gray-700">{{ $order->id }}</td>
                    <td class="p-3">{{ $order->user->name }}</td>
                    <td class="p-3 font-semibold text-gray-800">${{ $order->total_price }}</td>
                    <td class="p-3">
                        <span id="status-{{ $order->id }}" class="px-2 py-1 rounded 
                            {{ $order->status == 'Pending' ? 'bg-yellow-200 text-yellow-800' : ($order->status == 'Shipped' ? 'bg-blue-200 text-blue-800' : 'bg-green-200 text-green-800') }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-3">
                        <select class="status-dropdown border rounded px-2 py-1" data-id="{{ $order->id }}">
                            <option value="Pending" {{ $order->status=='Pending'?'selected':'' }}>Pending</option>
                            <option value="Shipped" {{ $order->status=='Shipped'?'selected':'' }}>Shipped</option>
                            <option value="Delivered" {{ $order->status=='Delivered'?'selected':'' }}>Delivered</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.status-dropdown').forEach(select => {
    select.addEventListener('change', function() {
        let orderId = this.dataset.id;
        let status = this.value;

        fetch(`/admin/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                let statusEl = document.getElementById('status-' + orderId);
                statusEl.textContent = data.status;

                statusEl.className = 'px-2 py-1 rounded ' +
                    (data.status == 'Pending' ? 'bg-yellow-200 text-yellow-800' : 
                    (data.status == 'Shipped' ? 'bg-blue-200 text-blue-800' : 'bg-green-200 text-green-800'));
            }
        });
    });
});
</script>
@endpush
