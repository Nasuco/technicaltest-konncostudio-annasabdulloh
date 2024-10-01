<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('status', 1)->where('stock', '>', 0)->get();

        return view('customer.index', compact('products'));
    }

    public function addToCart(Product $product) {
        if ($product->stock > 0) {
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1
                ];
            }
    
            session()->put('cart', $cart);
    
            return redirect()->route('customer.products.index')->with('success', 'Product added to cart.');
        }
    
        return redirect()->route('customer.products.index')->with('error', 'Product is out of stock.');
    }

    public function cart() {
        $cart = session()->get('cart', []);
    
        return view('customer.cart', compact('cart'));
    }

    public function checkout(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('customer.products.index')->with('error', 'You must be logged in to proceed to checkout.');
        }
    
        // Validate that the cart is not empty
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('customer.products.index')->with('error', 'Keranjang belanja kosong.');
        }
    
        // Validate each item in the cart
        foreach ($cart as $product_id => $details) {
            $product = Product::find($product_id);
            if (!$product) {
                return redirect()->route('customer.cart')->with('error', 'One or more products are no longer available.');
            }
    
            // Ensure the product stock is sufficient
            if ($details['quantity'] > $product->stock) {
                return redirect()->route('customer.cart')->with('error', 'Insufficient stock for ' . $product->name . '.');
            }
        }
    
        // Calculate total price and create order items
        $totalPrice = 0;
        $items = [];
        
        foreach ($cart as $product_id => $details) {
            // Calculate total price
            if (!is_numeric($details['price']) || !is_numeric($details['quantity'])) {
                return redirect()->route('customer.cart')->with('error', 'Invalid item details.');
            }
    
            $totalPrice += $details['price'] * $details['quantity'];
    
            $items[] = [
                'id' => uniqid(),
                'price' => (int) $details['price'],
                'quantity' => (int) $details['quantity'],
                'name' => substr($details['name'], 0, 50)
            ];
        }
    
        // Validate that total price is greater than zero
        if ($totalPrice <= 0) {
            return redirect()->route('customer.cart')->with('error', 'Total price must be greater than zero.');
        }
    
        // Create the order
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'order_id' => 'ORDER-' . Str::uuid(),
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
        ]);
    
        // Create order items
        foreach ($cart as $product_id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product_id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }
    
        // Setup Midtrans configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_id,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'item_details' => $items
        ];
    
        // Handle payment initiation
        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return redirect()->route('customer.cart')->with('error', 'Failed to initiate payment: ' . $e->getMessage());
        }
    
        return view('customer.checkout', compact('order', 'snapToken'));
    }
    

}
