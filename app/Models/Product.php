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

    public function scopeByLanguage($query, $language = null)
    {
        $lang = $language ?? App::getLocale();
        return $query->where('language', $lang);
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
}
