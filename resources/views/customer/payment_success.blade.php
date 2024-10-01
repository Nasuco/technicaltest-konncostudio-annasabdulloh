<x-app-layout>
    <div class="container mx-auto mt-8 p-4 bg-white rounded shadow">
        <h1 class="text-3xl font-bold mb-6 text-green-600">Payment Successful!</h1>

        <div class="mb-4">
            <p class="text-lg">Thank you for your purchase. Your payment was successfully processed.</p>
            <p class="text-lg">Order ID: <strong>{{ $order->order_id }}</strong></p>
            <p class="text-lg">Transaction ID: <strong>{{ $order->transaction_id ?? 'N/A' }}</strong></p>
            <p class="text-lg">Amount Paid: <strong>${{ number_format($order->total_price, 2) }}</strong></p>
        </div>

        <a href="{{ route('customer.orders') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            View My Orders
        </a>
    </div>
</x-app-layout>
