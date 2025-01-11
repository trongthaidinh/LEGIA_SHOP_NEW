<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasLanguage;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasLanguage;

    const TYPE_YEN_CHUNG = 'yen_chung';
    const TYPE_YEN_TO = 'yen_to';
    const TYPE_GIFT_SET = 'gift_set';
    const TYPE_YEN_CHUNG_LABEL = 'Yến chưng';
    const TYPE_YEN_TO_LABEL = 'Yến tổ';
    const TYPE_GIFT_SET_LABEL = 'Set quà tặng';

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
        'status',
        'language'
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'type' => 'string'
    ];

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('status', 'published');
    }

    // Scope for language-specific products
    public function scopeByLanguage($query, $language = null)
    {
        $language = $language ?? app()->getLocale();
        return $query->where('language', $language);
    }

    // Relationship with single category (backward compatibility)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many-to-Many relationship with categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    // Mutator for gallery to ensure JSON
    public function setGalleryAttribute($value)
    {
        $this->attributes['gallery'] = is_array($value) 
            ? json_encode($value) 
            : $value;
    }

    // Accessor for gallery to ensure array
    public function getGalleryAttribute($value)
    {
        return is_string($value) 
            ? json_decode($value, true) 
            : $value;
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for published products
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_YEN_CHUNG => self::TYPE_YEN_CHUNG_LABEL,
            self::TYPE_YEN_TO => self::TYPE_YEN_TO_LABEL,
            self::TYPE_GIFT_SET => self::TYPE_GIFT_SET_LABEL
        ];
    }

    public function getTypeLabel(): string
    {
        return self::getTypes()[$this->type] ?? 'Unknown';
    }

    // Helper method to attach categories
    public function attachCategories(array $categoryIds)
    {
        $this->categories()->sync($categoryIds);
    }
}
