<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 
// 1. Thêm dòng này để sử dụng thư viện xuất Excel
use Rap2hpoutre\FastExcel\FastExcel;

class OrderController extends Controller
{
    // 1. Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        // Lấy danh sách đơn hàng, sắp xếp mới nhất
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // --- HÀM XUẤT FILE EXCEL MỚI THÊM ---
    public function export()
    {
        // Lấy toàn bộ đơn hàng (hoặc dùng Order::latest()->get())
        $orders = Order::latest()->get();

        // Xuất file và định dạng các cột
        return (new FastExcel($orders))->download('danh-sach-don-hang.xlsx', function ($order) {
            return [
                'Mã Đơn'         => $order->id,
                'Tên Khách Hàng' => $order->full_name, // Bạn kiểm tra cột này trong DB nhé (có thể là name hoặc customer_name)
                'Số Điện Thoại'  => $order->phone,
                'Tổng Tiền'      => number_format($order->total_price, 0, ',', '.') . ' đ',
                'Trạng Thái'     => $this->translateStatus($order->status),
                'Ngày Đặt'       => $order->created_at ? $order->created_at->format('d/m/Y H:i') : '',
            ];
        });
    }

    // Hàm phụ để dịch trạng thái sang tiếng Việt cho file Excel đẹp hơn
    private function translateStatus($status) {
        $list = [
            'pending'    => 'Chờ xử lý',
            'paid'       => 'Đã thanh toán',
            'processing' => 'Đang xử lý',
            'shipped'    => 'Đang giao hàng',
            'completed'  => 'Hoàn thành',
            'cancelled'  => 'Đã hủy',
        ];
        return $list[$status] ?? $status;
    }
    // ------------------------------------

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
        
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Đã cập nhật trạng thái đơn hàng #'.$order->id);
    }

    // 4. Xác nhận đã nhận tiền (Dành cho đơn chuyển khoản)
    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'processing'
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Đã xác nhận nhận đủ tiền và chuyển sang Đang xử lý cho đơn #'.$order->id);
    }
}