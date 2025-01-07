<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('youtube_url');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Bảng pivot để liên kết videos với các model khác
        Schema::create('videoables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->morphs('videoable');
            $table->string('collection')->default('default');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videoables');
        Schema::dropIfExists('videos');
    }
};
