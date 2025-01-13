<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run()
    {
        // Vietnamese sliders
        $viSliders = [
            [
                'title' => 'Yến sào cao cấp',
                'description' => 'Sản phẩm yến sào chất lượng cao, nguồn gốc tự nhiên',
                'image' => 'sliders/slider-1.jpg',
                'button_text' => 'Xem sản phẩm',
                'button_url' => '/vi/products',
                'order' => 1,
                'is_active' => true,
                'language' => 'vi'
            ],
            [
                'title' => 'Yến chưng sẵn',
                'description' => 'Yến chưng sẵn tiện lợi, bổ dưỡng',
                'image' => 'sliders/slider-2.jpg',
                'button_text' => 'Xem chi tiết',
                'button_url' => '/vi/products/yen-chung',
                'order' => 2,
                'is_active' => true,
                'language' => 'vi'
            ]
        ];

        // Chinese sliders
        $zhSliders = [
            [
                'title' => '高级燕窝',
                'description' => '优质天然燕窝产品',
                'image' => 'sliders/slider-1.jpg',
                'button_text' => '查看产品',
                'button_url' => '/zh/products',
                'order' => 1,
                'is_active' => true,
                'language' => 'zh'
            ],
            [
                'title' => '即食燕窝',
                'description' => '便利营养的即食燕窝',
                'image' => 'sliders/slider-2.jpg',
                'button_text' => '了解更多',
                'button_url' => '/zh/products/birds-nest',
                'order' => 2,
                'is_active' => true,
                'language' => 'zh'
            ]
        ];

        foreach (array_merge($viSliders, $zhSliders) as $slider) {
            Slider::create($slider);
        }
    }
}
