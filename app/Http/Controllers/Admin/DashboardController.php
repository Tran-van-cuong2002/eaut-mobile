<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon; // BỔ SUNG: Khai báo thư viện xử lý thời gian

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê các con số tổng quan
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 0)->count(); // Chỉ đếm khách hàng
        
        // Tính tổng doanh thu (chỉ tính những đơn đã giao thành công)
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');

        // 2. BỔ SUNG: Lấy dữ liệu doanh thu 12 tháng cho biểu đồ
        $chartData = [];
        $currentYear = Carbon::now()->year; // Lấy năm hiện tại

        for ($month = 1; $month <= 12; $month++) {
            $revenue = Order::where('status', 'completed') // Lọc đơn 'completed'
                ->whereYear('created_at', $currentYear)    // Trong năm nay
                ->whereMonth('created_at', $month)         // Theo từng tháng
                ->sum('total_price');                      // Cộng tổng tiền
            
            $chartData[] = (int) $revenue; // Ép kiểu số nguyên và đưa vào mảng
        }

        // 3. Lấy 5 đơn hàng mới nhất để hiển thị nhanh
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalProducts', 
            'totalCustomers', 
            'totalRevenue',
            'recentOrders',
            'chartData' // BỔ SUNG: Truyền mảng dữ liệu ra giao diện
        ));
    }

    // THÊM MỚI: Hàm xử lý xuất file CSV
    public function export()
    {
        $currentYear = Carbon::now()->year;
        $fileName = "bao-cao-doanh-thu-$currentYear.csv";

        $headers = array(
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use ($currentYear) {
            $file = fopen('php://output', 'w');
            
            // Thêm BOM để hiển thị được tiếng Việt trong Excel không bị lỗi font
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Tiêu đề của file
            fputcsv($file, ["BÁO CÁO DOANH THU NĂM $currentYear"]);
            fputcsv($file, ["Tháng", "Doanh thu (VNĐ)"]);

            // Lặp 12 tháng để xuất dữ liệu
            for ($month = 1; $month <= 12; $month++) {
                $revenue = Order::where('status', 'completed')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->sum('total_price');
                
                fputcsv($file, ["Tháng $month", number_format($revenue, 0, ',', '.') . " ₫"]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}