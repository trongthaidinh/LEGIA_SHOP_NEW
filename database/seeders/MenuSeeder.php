<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Create Vietnamese Main Menu
        $viMenu = Menu::create([
            'name' => 'Main Menu',
            'type' => 'main',
            'language' => 'vi',
            'is_active' => true
        ]);

        // Vietnamese Menu Items
        $this->createVietnameseMenuItems($viMenu);

        // Create Chinese Main Menu
        $zhMenu = Menu::create([
            'name' => '主菜单',  // Main Menu in Chinese
            'type' => 'main',
            'language' => 'zh',
            'is_active' => true
        ]);

        // Chinese Menu Items
        $this->createChineseMenuItems($zhMenu);
    }

    protected function createVietnameseMenuItems($menu)
    {
        // Home
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Trang chủ',
            'url' => '/',
            'target' => '_self',
            'icon_class' => 'fas fa-home',
            'order' => 1,
            'is_active' => true
        ]);

        // Products Parent
        $productsMenu = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Sản phẩm',
            'url' => '/products',
            'target' => '_self',
            'icon_class' => 'fas fa-box',
            'order' => 2,
            'is_active' => true
        ]);

        // Product Children
        MenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $productsMenu->id,
            'title' => 'Yến sào',
            'url' => '/products/yen-sao',
            'target' => '_self',
            'order' => 1,
            'is_active' => true
        ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $productsMenu->id,
            'title' => 'Yến chưng',
            'url' => '/products/yen-chung',
            'target' => '_self',
            'order' => 2,
            'is_active' => true
        ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $productsMenu->id,
            'title' => 'Set quà tặng',
            'url' => '/products/set-qua-tang',
            'target' => '_self',
            'order' => 3,
            'is_active' => true
        ]);

        // About
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Giới thiệu',
            'url' => '/about',
            'target' => '_self',
            'icon_class' => 'fas fa-info-circle',
            'order' => 3,
            'is_active' => true
        ]);

        // News
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Tin tức',
            'url' => '/posts',
            'target' => '_self',
            'icon_class' => 'fas fa-newspaper',
            'order' => 4,
            'is_active' => true
        ]);

        // Contact
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Liên hệ',
            'url' => '/contact',
            'target' => '_self',
            'icon_class' => 'fas fa-phone',
            'order' => 5,
            'is_active' => true
        ]);
    }

    protected function createChineseMenuItems($menu)
    {
        // Home
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => '主页',
            'url' => '/',
            'target' => '_self',
            'icon_class' => 'fas fa-home',
            'order' => 1,
            'is_active' => true
        ]);

        // Products Parent
        $productsMenu = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => '产品',
            'url' => '/products',
            'target' => '_self',
            'icon_class' => 'fas fa-box',
            'order' => 2,
            'is_active' => true
        ]);

        // Product Children
        MenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $productsMenu->id,
            'title' => '燕窝',
            'url' => '/products/yen-sao',
            'target' => '_self',
            'order' => 1,
            'is_active' => true
        ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $productsMenu->id,
            'title' => '炖燕窝',
            'url' => '/products/yen-chung',
            'target' => '_self',
            'order' => 2,
            'is_active' => true
        ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $productsMenu->id,
            'title' => '礼品套装',
            'url' => '/products/set-qua-tang',
            'target' => '_self',
            'order' => 3,
            'is_active' => true
        ]);

        // About
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => '关于我们',
            'url' => '/about',
            'target' => '_self',
            'icon_class' => 'fas fa-info-circle',
            'order' => 3,
            'is_active' => true
        ]);

        // News
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => '新闻',
            'url' => '/posts',
            'target' => '_self',
            'icon_class' => 'fas fa-newspaper',
            'order' => 4,
            'is_active' => true
        ]);

        // Contact
        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => '联系我们',
            'url' => '/contact',
            'target' => '_self',
            'icon_class' => 'fas fa-phone',
            'order' => 5,
            'is_active' => true
        ]);
    }
}
