<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        try {
            Log::info('Raw Midtrans Notification Data:', $request->all());

            $request->validate([
                'order_id' => 'required|string|exists:orders,order_id',
                'transaction_status' => 'required|string',
            ]);

            $notif = new Notification($request->all());
            Log::info('Received Midtrans Notification: ', (array) $notif);

            Log::info('Transaction Status: ' . $notif->transaction_status);

            $order = Order::where('order_id', $notif->order_id)->firstOrFail();
            Log::info('Midtrans Notification received for order: ' . $notif->order_id);

            // Update the order based on the transaction status
            $order->updatePaymentStatus($notif->transaction_status); 

            Log::info('Updated Order: ', $order->fresh()->toArray());

            return response()->json(['status' => 'success', 'message' => 'Notification handled'], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage(), [
                'exception' => $e, 
                'request_data' => $request->all() 
            ]);
            return response()->json(['status' => 'error', 'message' => 'Notification handling failed'], 500);
        }
    }

    public function paymentSuccess($order_id)
    {
        Log::info('Payment Success Check for Order ID: ' . $order_id);

        $order = Order::where('order_id', $order_id)->firstOrFail();

        Log::info('Order details: ', $order->toArray());
        Log::info('Transaction Status: ' . $order->transaction_status);

        // Check the transaction status instead of is_paid
        if ($order->transaction_status === 'settlement') {
            return view('customer.payment_success', compact('order'));
        }

        Log::warning('Payment not completed for Order ID: ' . $order_id);
        return redirect()->route('customer.cart')->with('error', 'Payment not completed.');
    }
}
