<?php

namespace App\Http\Controllers; // QUAN TRỌNG: Dòng này định danh Controller cho Laravel

use Illuminate\Http\Request;
use App\Models\Product;    // Để sử dụng được Model Product
use App\Models\Category;   // Để sử dụng được Model Category

class ProductController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu sản phẩm kèm danh mục (Eager Loading - Chương 4)
        $products = Product::with('category')->where('is_active', true)->latest()->paginate(8);
        
        // Lấy danh sách danh mục để hiện ở sidebar
        $categories = Category::all();

        // Trả về view và truyền biến (Chương 3)
        return view('client.index', compact('products', 'categories'));
    }
}