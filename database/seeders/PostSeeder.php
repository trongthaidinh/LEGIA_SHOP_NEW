<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            // Vietnamese posts
            [
                'title' => 'Tổ yến - Món quà quý từ thiên nhiên',
                'slug' => 'to-yen-mon-qua-quy-tu-thien-nhien',
                'excerpt' => 'Tổ yến là một trong những thực phẩm quý giá bậc nhất trong ẩm thực Á Đông...',
                'content' => 'Nội dung chi tiết về tổ yến và giá trị dinh dưỡng của nó...',
                'featured_image' => 'posts/post-1.jpg',
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => true,
                'language' => 'vi',
                'admin_id' => 1,
            ],
            [
                'title' => 'Cách chưng yến sào đúng cách',
                'slug' => 'cach-chung-yen-sao-dung-cach',
                'excerpt' => 'Hướng dẫn chi tiết cách chưng yến sào để giữ được tối đa dưỡng chất...',
                'content' => 'Các bước chi tiết để chưng yến sào...',
                'featured_image' => 'posts/post-2.jpg',
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => false,
                'language' => 'vi',
                'admin_id' => 1,
            ],
            // Chinese posts
            [
                'title' => '燕窝 - 来自大自然的珍贵礼物',
                'slug' => 'birds-nest-precious-gift-from-nature',
                'excerpt' => '燕窝是东方美食中最珍贵的食材之一...',
                'content' => '关于燕窝及其营养价值的详细内容...',
                'featured_image' => 'posts/post-1.jpg',
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => true,
                'language' => 'zh',
                'admin_id' => 1,
            ],
            [
                'title' => '正确炖燕窝的方法',
                'slug' => 'correct-way-to-cook-birds-nest',
                'excerpt' => '详细指导如何炖燕窝以最大程度保留营养...',
                'content' => '炖燕窝的详细步骤...',
                'featured_image' => 'posts/post-2.jpg',
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => false,
                'language' => 'zh',
                'admin_id' => 1,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
