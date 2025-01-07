<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_avatar')->nullable();
            $table->string('position')->nullable();
            $table->string('customer_position')->nullable(); // Chức danh/Nghề nghiệp của khách hàng
            $table->text('content');
            $table->integer('rating')->default(5); // Đánh giá sao (1-5)
            $table->string('company')->nullable(); // Công ty/Tổ chức của khách hàng (nếu có)
            $table->string('location')->nullable(); // Địa điểm của khách hàng
            $table->boolean('is_featured')->default(false); // Đánh giá nổi bật
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};
