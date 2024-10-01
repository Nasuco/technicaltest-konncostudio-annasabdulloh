<x-app-layout>
    <div class="container mx-auto mt-8 p-4 bg-white rounded shadow">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>

        @foreach ($order->orderItems as $item)
            <p>{{ $item->quantity }} x {{ $item->product->name }} - ${{ number_format($item->price, 2) }}</p>
        @endforeach

        <div class="mt-6 text-right">
            <p class="text-xl font-semibold mb-2">Total Price: ${{ number_format($order->total_price, 2) }}</p>

            <button id="pay-button" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                Bayar Sekarang
            </button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '/payment-success/' + result.order_id;
                },
                onPending: function(result) {
                    alert('Your payment is pending.');
                },
                onError: function(result) {
                    alert('Payment failed: ' + result.status_message);
                },
                onClose: function() {
                    alert('Payment popup closed.');
                }
            });
        });
    </script>
</x-app-layout>
