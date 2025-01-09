<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Thêm cột language vào các bảng cần thiết
        $tables = [
            'products',
            'categories',
            'posts',
            'menus',
            'settings',
            'sliders',
            'testimonials',
            'certificates',
            'orders'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('language')->default('vi')->after('id');
                $table->index('language');
            });
        }
    }

    public function down()
    {
        $tables = [
            'products',
            'categories',
            'posts',
            'menus',
            'settings',
            'sliders',
            'testimonials',
            'certificates',
            'orders'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('language');
            });
        }
    }
};
