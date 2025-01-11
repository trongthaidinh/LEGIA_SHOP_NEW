<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncating
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        \DB::table('category_product')->truncate();
        Product::query()->delete();
        Category::query()->delete();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Recreate categories if needed
        $categories = [
            ['name' => 'Yến Sào Nguyên Chất', 'slug' => 'yen-sao-nguyen-chat'],
            ['name' => 'Yến Sào Chế Biến', 'slug' => 'yen-sao-che-bien'],
            ['name' => 'Yến Hũ', 'slug' => 'yen-hu'],
            ['name' => 'Yến Tinh Chế', 'slug' => 'yen-tinh-che']
        ];

        $createdCategories = [];
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'is_active' => true,
                'status' => 'published',
                'language' => 'vi'
            ]);
            $createdCategories[] = $category;
        }

        // Create products for each category
        foreach ($createdCategories as $category) {
            for ($i = 1; $i <= 4; $i++) {
                $name = $category->name . ' ' . $i;
                $slug = Str::slug($name);

                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => $slug,
                    'description' => 'Sản phẩm yến sào chất lượng cao, 100% từ thiên nhiên',
                    'content' => 'Chi tiết sản phẩm yến sào',
                    'featured_image' => 'images/products/' . $slug . '.webp',
                    'gallery' => json_encode([
                        'images/products/' . $slug . '-1.webp',
                        'images/products/' . $slug . '-2.webp',
                    ]),
                    'price' => rand(1000000, 5000000),
                    'sale_price' => rand(800000, 4000000),
                    'stock' => rand(10, 100),
                    'sku' => 'YS' . str_pad($category->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'is_featured' => rand(0, 1),
                    'status' => 'published',
                    'is_active' => true,
                    'language' => 'vi'
                ]);

                // Attach category to product in pivot table
                \DB::table('category_product')->insert([
                    'category_id' => $category->id,
                    'product_id' => $product->id
                ]);
            }
        }

        $this->command->info('Products and categories seeded successfully.');
    }
}
