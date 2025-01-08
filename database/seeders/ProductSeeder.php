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
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 4; $i++) {
                $name = $category->name . ' ' . $i;
                Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => 'Sản phẩm yến sào chất lượng cao, 100% từ thiên nhiên',
                    'content' => '
                        <h2>Giới thiệu sản phẩm</h2>
                        <p>Yến sào LeGia\'Nest tự hào mang đến cho bạn sản phẩm yến sào chất lượng cao, được thu hoạch và chế biến theo quy trình nghiêm ngặt, đảm bảo giữ nguyên dưỡng chất.</p>
                        
                        <h2>Thành phần</h2>
                        <ul>
                            <li>100% tổ yến thiên nhiên</li>
                            <li>Không chất bảo quản</li>
                            <li>Không chất phụ gia</li>
                        </ul>
                        
                        <h2>Công dụng</h2>
                        <ul>
                            <li>Tăng cường sức khỏe</li>
                            <li>Bổ sung dinh dưỡng</li>
                            <li>Làm đẹp da</li>
                            <li>Tăng cường miễn dịch</li>
                        </ul>
                        
                        <h2>Hướng dẫn sử dụng</h2>
                        <p>Sử dụng 1-2 lần/ngày, mỗi lần 1 phần. Có thể dùng trực tiếp hoặc chế biến theo khẩu vị.</p>
                        
                        <h2>Bảo quản</h2>
                        <p>Bảo quản nơi khô ráo, thoáng mát. Tránh ánh nắng trực tiếp.</p>
                    ',
                    'featured_image' => 'images/products/' . Str::slug($name) . '.webp',
                    'gallery' => json_encode([
                        'images/products/' . Str::slug($name) . '-1.webp',
                        'images/products/' . Str::slug($name) . '-2.webp',
                        'images/products/' . Str::slug($name) . '-3.webp',
                    ]),
                    'price' => rand(1000000, 5000000),
                    'sale_price' => rand(800000, 4000000),
                    'stock' => rand(10, 100),
                    'sku' => 'YS' . str_pad($category->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'is_featured' => rand(0, 1),
                    'status' => 'published',
                ]);
            }
        }
    }
}
