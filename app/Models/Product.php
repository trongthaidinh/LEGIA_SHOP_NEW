<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_YEN_CHUNG = 'yen_chung';
    const TYPE_YEN_TO = 'yen_to';
    const TYPE_GIFT_SET = 'gift_set';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'type',
        'description',
        'content',
        'featured_image',
        'gallery',
        'price',
        'sale_price',
        'stock',
        'sku',
        'is_featured',
        'is_active',
        'status'
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'type' => 'string'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_YEN_CHUNG => 'Yến chưng',
            self::TYPE_YEN_TO => 'Yến tổ',
            self::TYPE_GIFT_SET => 'Set quà tặng'
        ];
    }

    public function getTypeLabel(): string
    {
        return self::getTypes()[$this->type] ?? 'Unknown';
    }
}
