<x-app-layout>
    <div class="container mx-auto mt-8 p-4 bg-white rounded shadow">
        <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session('cart') && count(session('cart')) > 0)
            @php
                $totalQuantity = 0;
                $totalPrice = 0;
            @endphp

            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-center">Quantity</th>
                        <th class="px-4 py-2 text-right">Price</th>
                        <th class="px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('cart') as $id => $details)
                        @php
                            $totalQuantity += $details['quantity'];
                            $totalPrice += $details['price'] * $details['quantity'];
                        @endphp

                        <tr>
                            <td class="border px-4 py-2">{{ $details['name'] }}</td>
                            <td class="border px-4 py-2 text-center">{{ $details['quantity'] }}</td>
                            <td class="border px-4 py-2 text-right">Rp. {{ number_format($details['price'], 2) }}</td>
                            <td class="border px-4 py-2 text-right">Rp. {{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 text-right">
                <p class="text-xl font-semibold mb-2">Total Quantity: {{ $totalQuantity }}</p>
                <p class="text-xl font-semibold mb-4">Total Price: Rp. {{ number_format($totalPrice, 2) }}</p>

                <a href="{{ route('customer.checkout') }}" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                    Proceed to Checkout
                </a>
            </div>
        @else
            <p class="text-gray-600">Your cart is empty.</p>
        @endif
    </div>
</x-app-layout>
