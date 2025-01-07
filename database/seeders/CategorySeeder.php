<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Yến sào nguyên tổ',
                'description' => 'Tổ yến nguyên chất 100% từ thiên nhiên',
                'image' => 'images/categories/yen-nguyen-to.jpg',
            ],
            [
                'name' => 'Yến chưng sẵn',
                'description' => 'Yến chưng sẵn tiện lợi, bổ dưỡng',
                'image' => 'images/categories/yen-chung-san.jpg',
            ],
            [
                'name' => 'Yến dạng nước',
                'description' => 'Nước yến tinh khiết, giàu dinh dưỡng',
                'image' => 'images/categories/yen-dang-nuoc.jpg',
            ],
            [
                'name' => 'Yến collagen',
                'description' => 'Kết hợp yến sào và collagen tự nhiên',
                'image' => 'images/categories/yen-collagen.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
                'is_featured' => true,
                'status' => 'published',
            ]);
        }
    }
}
