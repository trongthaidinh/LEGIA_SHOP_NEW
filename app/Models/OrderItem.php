<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' đ';
    }

    public function getTotalFormattedAttribute()
    {
        return number_format($this->total, 0, ',', '.') . ' đ';
    }
}
