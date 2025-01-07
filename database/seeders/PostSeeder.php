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
            [
                'title' => 'Công dụng của yến sào đối với sức khỏe',
                'excerpt' => 'Khám phá những lợi ích tuyệt vời của yến sào đối với sức khỏe con người',
                'content' => '
                    <p>Yến sào từ lâu đã được biết đến như một thực phẩm bổ dưỡng, có nhiều công dụng tốt cho sức khỏe. Bài viết này sẽ giúp bạn hiểu rõ hơn về những lợi ích tuyệt vời của yến sào.</p>
                    
                    <h2>1. Tăng cường hệ miễn dịch</h2>
                    <p>Yến sào chứa nhiều protein và các axit amin thiết yếu, giúp tăng cường hệ miễn dịch, bảo vệ cơ thể khỏi các bệnh tật.</p>
                    
                    <h2>2. Cải thiện sức khỏe đường hô hấp</h2>
                    <p>Các nghiên cứu cho thấy yến sào có tác dụng tốt trong việc cải thiện các vấn đề về đường hô hấp, đặc biệt là ho và cảm cúm.</p>
                    
                    <h2>3. Làm đẹp da</h2>
                    <p>Yến sào giàu collagen tự nhiên, giúp da săn chắc, mịn màng và chống lão hóa hiệu quả.</p>
                ',
            ],
            [
                'title' => 'Cách chưng yến sào đúng cách',
                'excerpt' => 'Hướng dẫn chi tiết cách chưng yến sào để giữ nguyên dưỡng chất',
                'content' => '
                    <p>Chưng yến đúng cách sẽ giúp giữ được tối đa dưỡng chất có trong yến sào. Hãy cùng tìm hiểu cách chưng yến sào chuẩn nhất.</p>
                    
                    <h2>1. Chuẩn bị nguyên liệu</h2>
                    <ul>
                        <li>Tổ yến</li>
                        <li>Nước tinh khiết</li>
                        <li>Đường phèn (tùy khẩu vị)</li>
                    </ul>
                    
                    <h2>2. Các bước thực hiện</h2>
                    <ol>
                        <li>Ngâm tổ yến trong nước ấm</li>
                        <li>Làm sạch tổ yến</li>
                        <li>Chưng cách thủy</li>
                    </ol>
                ',
            ],
            [
                'title' => 'Phân biệt yến sào thật - giả',
                'excerpt' => 'Những dấu hiệu để nhận biết yến sào thật và yến sào giả',
                'content' => '
                    <p>Trên thị trường hiện nay có rất nhiều loại yến sào giả, kém chất lượng. Bài viết này sẽ giúp bạn phân biệt được yến thật và yến giả.</p>
                    
                    <h2>1. Quan sát hình dáng</h2>
                    <p>Yến thật có cấu trúc sợi đều đặn, xếp lớp tự nhiên. Yến giả thường có sợi không đều, dễ đứt gãy.</p>
                    
                    <h2>2. Kiểm tra độ đàn hồi</h2>
                    <p>Yến thật có độ đàn hồi tốt, khi ngâm nước sẽ nở đều. Yến giả thường bị tan rã nhanh.</p>
                    
                    <h2>3. Thử mùi vị</h2>
                    <p>Yến thật có mùi tanh nhẹ đặc trưng. Yến giả thường có mùi lạ hoặc không mùi.</p>
                ',
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'featured_image' => 'images/posts/' . Str::slug($post['title']) . '.jpg',
                'status' => 'published',
                'published_at' => now(),
                'admin_id' => 1,
            ]);
        }
    }
}
