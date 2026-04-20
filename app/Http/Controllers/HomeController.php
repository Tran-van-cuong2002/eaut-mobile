<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order; // BỔ SUNG: Khai báo model Order để dùng cho chức năng tra cứu
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // --- GIAO DIỆN TRANG CHỦ & LỌC SẢN PHẨM ---
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('name', 'asc')->get();

        $query = Product::with('category')->where('is_active', true);

        // Lọc theo tên
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Lọc theo giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp
        $sort = $request->get('sort', 'new');
        switch ($sort) {
            case 'price_asc': $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            default: $query->latest(); break;
        }

        $products = $query->paginate(9)->withQueryString();

        return view('client.index', compact('categories', 'products'));
    }

    // --- BỔ SUNG: HÀM TRA CỨU ĐƠN HÀNG ---
    public function trackOrder(Request $request) 
    {
        $orders = null; // Mặc định là null khi chưa tìm kiếm
        $phone = $request->input('phone'); // Lấy số điện thoại từ ô input

        // Nếu người dùng có nhập số điện thoại và bấm tìm kiếm
        if ($phone) {
            // Tìm các đơn hàng khớp với số điện thoại trong cột customer_phone
            $orders = Order::where('customer_phone', $phone)
                           ->latest() // Sắp xếp đơn hàng mới nhất lên đầu
                           ->get();
        }

        // Trả về view track_order.blade.php kèm theo dữ liệu
        return view('client.track_order', compact('orders', 'phone'));
    }
}