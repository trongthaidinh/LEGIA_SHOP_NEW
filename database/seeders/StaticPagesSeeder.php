<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            // Vietnamese Pages
            [
                'title' => 'Chính Sách Chung',
                'slug' => 'chinh-sach-chung',
                'content' => $this->getGeneralPolicyContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Chính sách chung của LeGia Shop',
                'meta_keywords' => 'chính sách, quy định, LeGia Shop'
            ],
            [
                'title' => 'Chính Sách Bảo Mật',
                'slug' => 'chinh-sach-bao-mat',
                'content' => $this->getPrivacyPolicyContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Chính sách bảo mật thông tin khách hàng của LeGia Shop',
                'meta_keywords' => 'bảo mật, quyền riêng tư, thông tin cá nhân'
            ],
            [
                'title' => 'Chính Sách Bảo Hành',
                'slug' => 'chinh-sach-bao-hanh',
                'content' => $this->getWarrantyPolicyContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Chính sách bảo hành sản phẩm của LeGia Shop',
                'meta_keywords' => 'bảo hành, sản phẩm, chất lượng'
            ],
            [
                'title' => 'Chính Sách Đổi Trả',
                'slug' => 'chinh-sach-doi-tra',
                'content' => $this->getReturnPolicyContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Chính sách đổi trả sản phẩm của LeGia Shop',
                'meta_keywords' => 'đổi trả, hoàn tiền, sản phẩm'
            ],
            [
                'title' => 'Chính Sách Đặt Hàng & Thanh Toán',
                'slug' => 'chinh-sach-dat-hang-thanh-toan',
                'content' => $this->getOrderPaymentPolicyContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Hướng dẫn đặt hàng và thanh toán tại LeGia Shop',
                'meta_keywords' => 'đặt hàng, thanh toán, phương thức'
            ],
            [
                'title' => 'Chính Sách Vận Chuyển',
                'slug' => 'chinh-sach-van-chuyen',
                'content' => $this->getShippingPolicyContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Chính sách vận chuyển của LeGia Shop',
                'meta_keywords' => 'vận chuyển, giao hàng, phí ship'
            ],
            [
                'title' => 'Câu Hỏi Thường Gặp',
                'slug' => 'cau-hoi-thuong-gap',
                'content' => $this->getFAQContentVi(),
                'locale' => 'vi',
                'meta_description' => 'Các câu hỏi thường gặp tại LeGia Shop',
                'meta_keywords' => 'FAQ, hỗ trợ, câu hỏi'
            ],

            // Chinese Pages (Similar structure)
            [
                'title' => '一般政策',
                'slug' => 'yi-ban-zheng-ce',
                'content' => $this->getGeneralPolicyContentZh(),
                'locale' => 'zh',
                'meta_description' => 'LeGia Shop的一般政策',
                'meta_keywords' => '政策, 规定, LeGia Shop'
            ],
            // Add other Chinese pages similarly...
        ];

        foreach ($pages as $pageData) {
            StaticPage::updateOrCreate(
                [
                    'slug' => $pageData['slug'],
                    'locale' => $pageData['locale']
                ],
                $pageData
            );
        }
    }

    // Vietnamese Content Methods
    private function getGeneralPolicyContentVi()
    {
        return '<h2>Chính Sách Chung của LeGia Shop</h2>
        <p>LeGia Shop cam kết cung cấp dịch vụ chất lượng và sản phẩm đáng tin cậy cho khách hàng. Chúng tôi luôn nỗ lực mang đến trải nghiệm mua sắm tốt nhất.</p>
        
        <h3>Nguyên Tắc Hoạt Động</h3>
        <ul>
            <li>Tôn trọng quyền lợi của khách hàng</li>
            <li>Minh bạch trong các giao dịch</li>
            <li>Bảo vệ thông tin cá nhân</li>
            <li>Cam kết chất lượng sản phẩm</li>
        </ul>';
    }

    private function getPrivacyPolicyContentVi()
    {
        return '<h2>Chính Sách Bảo Mật Thông Tin</h2>
        <p>Tại LeGia Shop, chúng tôi coi trọng việc bảo vệ thông tin cá nhân của khách hàng. Mọi thông tin được thu thập sẽ được bảo mật tuyệt đối.</p>
        
        <h3>Phạm Vi Thu Thập Thông Tin</h3>
        <ul>
            <li>Thông tin cá nhân khi đăng ký</li>
            <li>Thông tin giao dịch</li>
            <li>Thông tin liên hệ</li>
        </ul>';
    }

    // Add other content methods for Vietnamese and Chinese pages...

    private function getWarrantyPolicyContentVi()
    {
        return '<h2>Chính Sách Bảo Hành</h2>
        <p>LeGia Shop cam kết bảo hành sản phẩm với chất lượng cao nhất.</p>
        
        <h3>Điều Kiện Bảo Hành</h3>
        <ul>
            <li>Sản phẩm còn trong thời gian bảo hành</li>
            <li>Không áp dụng cho các hư hỏng do sử dụng sai</li>
            <li>Có hóa đơn mua hàng</li>
        </ul>';
    }

    private function getReturnPolicyContentVi()
    {
        return '<h2>Chính Sách Đổi Trả</h2>
        <p>Chúng tôi luôn muốn khách hàng hài lòng với sản phẩm.</p>
        
        <h3>Quy Trình Đổi Trả</h3>
        <ul>
            <li>Trong vòng 7 ngày kể từ ngày nhận hàng</li>
            <li>Sản phẩm nguyên vẹn, chưa qua sử dụng</li>
            <li>Có hóa đơn mua hàng</li>
        </ul>';
    }

    private function getOrderPaymentPolicyContentVi()
    {
        return '<h2>Chính Sách Đặt Hàng & Thanh Toán</h2>
        <p>Chúng tôi cung cấp nhiều phương thức thanh toán để thuận tiện cho khách hàng.</p>
        
        <h3>Phương Thức Thanh Toán</h3>
        <ul>
            <li>Thanh toán khi nhận hàng (COD)</li>
            <li>Chuyển khoản ngân hàng</li>
            <li>Thanh toán qua ví điện tử</li>
        </ul>';
    }

    private function getShippingPolicyContentVi()
    {
        return '<h2>Chính Sách Vận Chuyển</h2>
        <p>LeGia Shop cam kết giao hàng nhanh chóng và an toàn.</p>
        
        <h3>Thông Tin Vận Chuyển</h3>
        <ul>
            <li>Miễn phí vận chuyển cho đơn hàng trên 500,000 VND</li>
            <li>Thời gian giao hàng: 2-3 ngày</li>
            <li>Hỗ trợ giao hàng toàn quốc</li>
        </ul>';
    }

    private function getFAQContentVi()
    {
        return '<h2>Câu Hỏi Thường Gặp</h2>
        <h3>1. Làm thế nào để đặt hàng?</h3>
        <p>Bạn có thể đặt hàng trực tiếp trên website hoặc liên hệ qua hotline.</p>
        
        <h3>2. Chính sách bảo hành như thế nào?</h3>
        <p>Sản phẩm được bảo hành trong vòng 12 tháng kể từ ngày mua.</p>';
    }

    // Chinese Content Methods (simplified examples)
    private function getGeneralPolicyContentZh()
    {
        return '<h2>LeGia Shop的一般政策</h2>
        <p>LeGia Shop致力于提供高质量的服务和可靠的产品。我们始终努力为客户提供最佳购物体验。</p>
        
        <h3>运营原则</h3>
        <ul>
            <li>尊重客户权益</li>
            <li>交易透明</li>
            <li>保护个人信息</li>
            <li>承诺产品质量</li>
        </ul>';
    }
}
