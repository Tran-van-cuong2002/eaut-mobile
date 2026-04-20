<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Đã thêm 'stock' vào mảng $fillable
    protected $fillable = ['category_id', 'name', 'slug', 'price', 'stock', 'description', 'image', 'is_active'];

    // Thiết lập quan hệ: 1 Sản phẩm thuộc về 1 Danh mục
    public function category() {
        return $this->belongsTo(Category::class);
    }
}