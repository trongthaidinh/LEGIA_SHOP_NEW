<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Nguyễn Thị Hương',
                'customer_avatar' => 'images/testimonials/customer-1.jpg',
                'position' => 'Giám đốc công ty ABC',
                'content' => 'Tôi rất hài lòng với chất lượng yến sào của LeGia\'Nest. Sản phẩm thơm ngon, bổ dưỡng và đặc biệt là dịch vụ khách hàng rất tốt.',
                'rating' => 5,
            ],
            [
                'customer_name' => 'Trần Văn Nam',
                'customer_avatar' => 'images/testimonials/customer-2.jpg',
                'position' => 'Bác sĩ dinh dưỡng',
                'content' => 'Là một bác sĩ dinh dưỡng, tôi hoàn toàn tin tưởng vào chất lượng sản phẩm của LeGia\'Nest. Đây là một thương hiệu uy tín mà tôi thường xuyên giới thiệu cho bệnh nhân.',
                'rating' => 5,
            ],
            [
                'customer_name' => 'Lê Thị Thanh',
                'customer_avatar' => 'images/testimonials/customer-3.jpg',
                'position' => 'Khách hàng thân thiết',
                'content' => 'Đã sử dụng yến sào LeGia\'Nest được 2 năm và thấy sức khỏe cải thiện rõ rệt. Sẽ tiếp tục ủng hộ thương hiệu trong tương lai.',
                'rating' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create([
                'customer_name' => $testimonial['customer_name'],
                'customer_avatar' => $testimonial['customer_avatar'],
                'position' => $testimonial['position'],
                'content' => $testimonial['content'],
                'rating' => $testimonial['rating'],
                'status' => 'published',
            ]);
        }
    }
}
