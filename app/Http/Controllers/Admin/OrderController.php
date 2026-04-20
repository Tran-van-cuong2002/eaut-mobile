<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 

class OrderController extends Controller
{
    // 1. Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        // Lấy danh sách đơn hàng, sắp xếp mới nhất
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết đơn hàng
    public function show($id)
    {
        // Lấy chi tiết đơn hàng
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Cập nhật trạng thái đơn hàng chung
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Thêm 'paid' vào danh sách trạng thái hợp lệ
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        // ĐÃ SỬA: Chuyển hướng ra danh sách đơn hàng
        return redirect()->route('admin.orders.index')->with('success', 'Đã cập nhật trạng thái đơn hàng #'.$order->id);
    }

    // 4. Xác nhận đã nhận tiền (Dành cho đơn chuyển khoản)
    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        // Đổi 'paid' thành 'processing' để khớp với Database cũ của bạn
        $order->update([
            'status' => 'processing'
        ]);

        // ĐÃ SỬA: Chuyển hướng ra danh sách đơn hàng
        return redirect()->route('admin.orders.index')->with('success', 'Đã xác nhận nhận đủ tiền và chuyển sang Đang xử lý cho đơn #'.$order->id);
    }
}