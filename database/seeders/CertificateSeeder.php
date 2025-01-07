<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $certificates = [
            [
                'name' => 'Chứng nhận HACCP',
                'description' => 'Chứng nhận Hệ thống phân tích mối nguy và điểm kiểm soát tới hạn',
                'image' => 'images/certificates/haccp.png',
            ],
            [
                'name' => 'Chứng nhận ISO 22000',
                'description' => 'Chứng nhận Hệ thống quản lý an toàn thực phẩm',
                'image' => 'images/certificates/iso-22000.png',
            ],
            [
                'name' => 'Chứng nhận GMP',
                'description' => 'Chứng nhận Thực hành sản xuất tốt',
                'image' => 'images/certificates/gmp.png',
            ],
            [
                'name' => 'Chứng nhận HALAL',
                'description' => 'Chứng nhận sản phẩm phù hợp với quy định của đạo Hồi',
                'image' => 'images/certificates/halal.png',
            ],
            [
                'name' => 'Giải thưởng Thương hiệu Vàng',
                'description' => 'Top 10 thương hiệu vàng Việt Nam 2024',
                'image' => 'images/certificates/gold-brand.png',
            ],
            [
                'name' => 'Chứng nhận Organic',
                'description' => 'Chứng nhận sản phẩm hữu cơ',
                'image' => 'images/certificates/organic.png',
            ],
        ];

        foreach ($certificates as $certificate) {
            Certificate::create([
                'name' => $certificate['name'],
                'description' => $certificate['description'],
                'image' => $certificate['image'],
                'status' => 'published',
            ]);
        }
    }
}
