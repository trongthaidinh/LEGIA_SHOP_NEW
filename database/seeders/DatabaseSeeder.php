<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SliderSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\TestimonialSeeder;
use Database\Seeders\CertificateSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\StaticPagesSeeder;
use Database\Seeders\ProductReviewSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            SliderSeeder::class,
            PostSeeder::class,
            TestimonialSeeder::class,
            CertificateSeeder::class,
            MenuSeeder::class,
            StaticPagesSeeder::class,
            ProductReviewSeeder::class,
        ]);
    }
}
