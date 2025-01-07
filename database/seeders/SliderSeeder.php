<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Yến sào thiên nhiên 100%',
                'description' => 'Tổ yến thiên nhiên nguyên chất, giàu dinh dưỡng, tốt cho sức khỏe',
                'image' => 'images/sliders/slider-1.jpg',
                'button_text' => 'Mua ngay',
                'button_url' => '/products',
            ],
            [
                'title' => 'Quà tặng sức khỏe',
                'description' => 'Món quà ý nghĩa cho người thân yêu',
                'image' => 'images/sliders/slider-2.jpg',
                'button_text' => 'Xem thêm',
                'button_url' => '/about',
            ],
            [
                'title' => 'Chứng nhận chất lượng',
                'description' => 'Đạt tiêu chuẩn vệ sinh an toàn thực phẩm',
                'image' => 'images/sliders/slider-3.jpg',
                'button_text' => 'Tìm hiểu',
                'button_url' => '/certificates',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create([
                'title' => $slider['title'],
                'description' => $slider['description'],
                'image' => $slider['image'],
                'button_text' => $slider['button_text'],
                'button_url' => $slider['button_url'],
                'status' => 'published',
            ]);
        }
    }
}
