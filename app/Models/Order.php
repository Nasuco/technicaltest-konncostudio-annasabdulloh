<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'order_id',
        'total_price', 
        'transaction_status',
        'snap_token',
        'transaction_status',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // In your Order model
    public function updatePaymentStatus($transactionStatus)
    {
        $this->transaction_status = $transactionStatus; // Ensure this attribute exists in your database
        $this->is_paid = ($transactionStatus === 'settlement'); // Example logic to set is_paid
        $this->save();

        Log::info('Payment status updated for Order ID: ' . $this->order_id . ' to ' . $transactionStatus);
    }
}
