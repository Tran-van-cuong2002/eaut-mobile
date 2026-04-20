<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status', 'customer_address', 'phone', 'customer_name', 'customer_phone', 'notes', 'payment_method'];

    // THÊM HÀM NÀY VÀO ĐỂ LẤY DANH SÁCH SẢN PHẨM
    public function items()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}