<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo User Admin (Xóa hoặc comment dòng User::factory() mặc định nếu có để tránh lỗi trùng mail)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Linh Kien',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Tạo Danh mục mẫu
        $cat = Category::create([
            'name' => 'Màn hình iPhone',
            'slug' => 'man-hinh-iphone',
            'is_active' => true
        ]);

        // 3. Tạo Sản phẩm mẫu
        Product::create([
            'category_id' => $cat->id,
            'name' => 'Màn hình iPhone 13 Pro Max',
            'slug' => 'man-hinh-13-pm',
            'price' => 2500000,
            'description' => 'Linh kiện zin chính hãng',
            'image' => 'iphone13.jpg',
            'is_active' => true
        ]);
    }
}