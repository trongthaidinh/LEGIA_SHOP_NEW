<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general'); // general, contact, social, seo
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, image, boolean
            $table->string('label');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Thêm dữ liệu mặc định
        $defaultSettings = [
            // Thông tin chung
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Yến Sào LeGia\'Nest', 'type' => 'text', 'label' => 'Tên Website'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'Chuyên cung cấp các sản phẩm yến sào chất lượng cao', 'type' => 'textarea', 'label' => 'Mô tả Website'],
            ['group' => 'general', 'key' => 'logo', 'value' => null, 'type' => 'image', 'label' => 'Logo Website'],
            ['group' => 'general', 'key' => 'favicon', 'value' => null, 'type' => 'image', 'label' => 'Favicon'],
            
            // Thông tin liên hệ
            ['group' => 'contact', 'key' => 'company_name', 'value' => 'Công ty TNHH Yến Sào LeGia\'Nest', 'type' => 'text', 'label' => 'Tên Công ty'],
            ['group' => 'contact', 'key' => 'address', 'value' => 'Địa chỉ công ty', 'type' => 'textarea', 'label' => 'Địa chỉ'],
            ['group' => 'contact', 'key' => 'phone', 'value' => '0123456789', 'type' => 'text', 'label' => 'Số điện thoại'],
            ['group' => 'contact', 'key' => 'email', 'value' => 'contact@legianest.com', 'type' => 'text', 'label' => 'Email'],
            ['group' => 'contact', 'key' => 'working_hours', 'value' => '8:00 - 17:00', 'type' => 'text', 'label' => 'Giờ làm việc'],
            
            // Mạng xã hội
            ['group' => 'social', 'key' => 'facebook', 'value' => null, 'type' => 'text', 'label' => 'Facebook URL'],
            ['group' => 'social', 'key' => 'instagram', 'value' => null, 'type' => 'text', 'label' => 'Instagram URL'],
            ['group' => 'social', 'key' => 'youtube', 'value' => null, 'type' => 'text', 'label' => 'Youtube URL'],
            ['group' => 'social', 'key' => 'tiktok', 'value' => null, 'type' => 'text', 'label' => 'Tiktok URL'],
            
            // SEO
            ['group' => 'seo', 'key' => 'meta_title', 'value' => 'Yến Sào LeGia\'Nest - Chất Lượng Làm Nên Thương Hiệu', 'type' => 'text', 'label' => 'Meta Title'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'Yến Sào LeGia\'Nest - Chuyên cung cấp các sản phẩm yến sào chất lượng cao, uy tín, đảm bảo', 'type' => 'textarea', 'label' => 'Meta Description'],
            ['group' => 'seo', 'key' => 'meta_keywords', 'value' => 'yến sào, yến sào chất lượng cao, yến sào LeGia\'Nest', 'type' => 'textarea', 'label' => 'Meta Keywords']
        ];

        DB::table('settings')->insert($defaultSettings);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
