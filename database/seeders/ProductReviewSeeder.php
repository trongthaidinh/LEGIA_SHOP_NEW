<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        // Debug database connection
        $dbName = DB::connection()->getDatabaseName();
        Log::info("Connected to database: " . $dbName);

        // Debug raw SQL query
        $rawProducts = DB::table('products')->get();
        Log::info("Raw products count: " . $rawProducts->count());
        foreach ($rawProducts as $product) {
            Log::info("Raw product - ID: {$product->id}, Name: {$product->name}, Language: " . ($product->language ?? 'null'));
        }

        // First, let's debug what products we have using the model
        $allProducts = Product::all();
        Log::info('Total products from model: ' . $allProducts->count());
        
        foreach ($allProducts as $product) {
            Log::info("Product from model - ID: {$product->id}, Name: {$product->name}, Language: {$product->language}");
        }

        // Vietnamese reviews
        $viReviews = [
            [
                'reviewer_name' => 'Nguyễn Văn An',
                'reviewer_email' => 'nguyenvanan@gmail.com',
                'rating' => 5,
                'comment' => 'Sản phẩm rất tốt, yến sào chất lượng cao. Đóng gói cẩn thận, giao hàng nhanh. Sẽ ủng hộ shop dài dài.',
                'is_approved' => true,
            ],
            [
                'reviewer_name' => 'Trần Thị Bình',
                'reviewer_email' => 'tranthib@yahoo.com',
                'rating' => 4,
                'comment' => 'Yến chưng ngon, vị thanh nhẹ dễ uống. Giá hơi cao nhưng xứng đáng với chất lượng.',
                'is_approved' => true,
            ],
            [
                'reviewer_name' => 'Lê Hoàng Nam',
                'reviewer_email' => 'lehoangnam@outlook.com',
                'rating' => 5,
                'comment' => 'Mua tặng bố mẹ, các cụ rất thích. Yến sạch, không tạp chất. Sẽ mua lại.',
                'is_approved' => true,
            ],
            [
                'reviewer_name' => 'Phạm Thị Hương',
                'reviewer_email' => 'phamhuong@gmail.com',
                'rating' => 4,
                'comment' => 'Yến chất lượng tốt, shop tư vấn nhiệt tình. Đóng gói kỹ càng.',
                'is_approved' => true,
            ],
            [
                'reviewer_name' => 'Hoàng Minh Tuấn',
                'reviewer_email' => 'hmtuan@gmail.com',
                'rating' => 3,
                'comment' => 'Sản phẩm tạm được, giao hàng hơi chậm. Mong shop cải thiện dịch vụ vận chuyển.',
                'is_approved' => true,
            ]
        ];

        // Get Vietnamese products - try different approach
        $viProducts = DB::table('products')
            ->where('language', 'vi')
            ->orWhereNull('language')
            ->get();

        Log::info('Found Vietnamese Products (raw query): ' . $viProducts->count());
        foreach ($viProducts as $product) {
            Log::info("Vietnamese Product (raw) - ID: {$product->id}, Name: {$product->name}");
        }

        // If we found products, let's add reviews
        if ($viProducts->count() > 0) {
            foreach ($viProducts as $product) {
                $reviewsCount = rand(3, 5);
                $selectedReviews = array_rand($viReviews, $reviewsCount);
                
                if (!is_array($selectedReviews)) {
                    $selectedReviews = [$selectedReviews];
                }

                foreach ($selectedReviews as $index) {
                    $review = $viReviews[$index];
                    ProductReview::create([
                        'product_id' => $product->id,
                        'reviewer_name' => $review['reviewer_name'],
                        'reviewer_email' => $review['reviewer_email'],
                        'rating' => $review['rating'],
                        'comment' => $review['comment'],
                        'is_approved' => $review['is_approved'],
                        'created_at' => now()->subDays(rand(1, 180)),
                    ]);
                }
                
                Log::info("Added reviews for product ID: {$product->id}");
            }
        }

        Log::info('Product Review Seeder completed');
    }
}
