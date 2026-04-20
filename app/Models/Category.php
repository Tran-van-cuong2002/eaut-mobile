<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Gộp tất cả các trường vào MỘT dòng $fillable duy nhất
    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'status', 
        'is_active'
    ];

    // Thiết lập quan hệ: 1 Danh mục có nhiều Sản phẩm (Chương 4)
    public function products() {
        return $this->hasMany(Product::class);
    }
}