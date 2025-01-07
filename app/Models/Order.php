<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'status',
        'total_amount',
        'shipping_amount',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'shipping_city',
        'shipping_district',
        'shipping_ward',
        'notes'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getTotalAmountFormattedAttribute()
    {
        return number_format($this->total_amount, 0, ',', '.') . ' đ';
    }

    public function getShippingAmountFormattedAttribute()
    {
        return number_format($this->shipping_amount, 0, ',', '.') . ' đ';
    }

    // Boot method để tự động tạo order number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
        });
    }
}
