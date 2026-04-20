@extends('layouts.admin')

@section('page-title', 'Tổng quan Hệ thống')

@section('content')

{{-- Lời chào --}}
<div style="margin-bottom: 25px;">
    <h4 style="margin: 0 0 5px 0; color: #333; font-weight: bold; font-size: 22px;">Xin chào, {{ Auth::user()->name ?? 'Admin' }}! 👋</h4>
    <p style="margin: 0; color: #6c757d; font-size: 14px;">Dưới đây là tình hình hoạt động kinh doanh của cửa hàng.</p>
</div>

{{-- Các thẻ Thống kê (Cards) --}}
<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
    
    {{-- Tổng doanh thu --}}
    <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.02)'">
        <div style="background: #d1e7dd; color: #0f5132; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px;">
            <i class="bi bi-currency-dollar"></i>
        </div>
        <div>
            <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px; font-weight: 600;">Tổng doanh thu</p>
            <h4 style="margin: 0; color: #333; font-weight: bold; font-size: 20px;">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} ₫</h4>
        </div>
    </div>

    {{-- Tổng đơn hàng --}}
    <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.02)'">
        <div style="background: #cfe2ff; color: #084298; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="bi bi-cart-check"></i>
        </div>
        <div>
            <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px; font-weight: 600;">Tổng đơn hàng</p>
            <h4 style="margin: 0; color: #333; font-weight: bold; font-size: 20px;">{{ $totalOrders ?? 0 }}</h4>
        </div>
    </div>

    {{-- Số sản phẩm --}}
    <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.02)'">
        <div style="background: #fff3cd; color: #856404; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="bi bi-box-seam"></i>
        </div>
        <div>
            <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px; font-weight: 600;">Số sản phẩm</p>
            <h4 style="margin: 0; color: #333; font-weight: bold; font-size: 20px;">{{ $totalProducts ?? 0 }}</h4>
        </div>
    </div>

    {{-- Khách hàng --}}
    <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.02)'">
        <div style="background: #cff4fc; color: #055160; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px; font-weight: 600;">Khách hàng</p>
            <h4 style="margin: 0; color: #333; font-weight: bold; font-size: 20px;">{{ $totalCustomers ?? 0 }}</h4>
        </div>
    </div>
</div>

{{-- Biểu đồ Thống kê Doanh thu --}}
<div style="background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
    <h6 style="margin: 0 0 20px 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="bi bi-bar-chart-line" style="color: #0d6efd; font-size: 18px;"></i> Biểu đồ doanh thu năm nay
    </h6>
    <div style="position: relative; height: 350px; width: 100%;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

{{-- Bảng Đơn hàng gần đây --}}
<div style="background: #fff; border: 1px solid #ddd; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
    
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fff; display: flex; justify-content: space-between; align-items: center;">
        <h6 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-clock-history" style="color: #0d6efd; font-size: 18px;"></i> Đơn hàng gần đây
        </h6>
        <a href="{{ route('admin.orders.index') }}" style="background: #f8f9fa; border: 1px solid #ddd; color: #0d6efd; padding: 5px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f8f9fa'">Xem tất cả</a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #ddd; color: #555;">
                    <th style="padding: 14px 20px; font-weight: 600;">Mã Đơn</th>
                    <th style="padding: 14px 12px; font-weight: 600;">Khách hàng</th>
                    <th style="padding: 14px 12px; font-weight: 600; text-align: right;">Tổng tiền</th>
                    <th style="padding: 14px 12px; text-align: center; font-weight: 600;">Trạng thái</th>
                    <th style="padding: 14px 12px; text-align: center; font-weight: 600;">Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($recentOrders) && count($recentOrders) > 0)
                    @foreach($recentOrders as $order)
                    <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 14px 20px; font-weight: bold;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="color: #0d6efd; text-decoration: none;">#{{ $order->id }}</a>
                        </td>
                        <td style="padding: 14px 12px; color: #333; font-weight: 500;">{{ $order->customer_name ?? 'Khách lẻ' }}</td>
                        <td style="padding: 14px 12px; text-align: right; font-weight: bold; color: #dc3545;">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                        <td style="padding: 14px 12px; text-align: center;">
                            @php
                                $badges = [
                                    'pending' => ['bg' => '#fff3cd', 'color' => '#856404', 'border' => '#ffeeba', 'text' => 'Chờ xử lý'],
                                    'processing' => ['bg' => '#cff4fc', 'color' => '#055160', 'border' => '#b6effb', 'text' => 'Đang đóng gói'],
                                    'shipped' => ['bg' => '#cfe2ff', 'color' => '#084298', 'border' => '#b6d4fe', 'text' => 'Đang giao'],
                                    'completed' => ['bg' => '#d1e7dd', 'color' => '#0f5132', 'border' => '#badbcc', 'text' => 'Hoàn thành'],
                                    'cancelled' => ['bg' => '#f8d7da', 'color' => '#842029', 'border' => '#f5c2c7', 'text' => 'Đã hủy']
                                ];
                                $status = $badges[$order->status ?? 'pending'] ?? $badges['pending'];
                            @endphp
                            <span style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border: 1px solid {{ $status['border'] }}; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;">
                                {{ $status['text'] }}
                            </span>
                        </td>
                        <td style="padding: 14px 12px; text-align: center; color: #6c757d; font-size: 13px;">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 20px; color: #6c757d;">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                            Chưa có đơn hàng nào phát sinh.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- Thư viện Chart.js & Script khởi tạo biểu đồ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Tạo gradient màu cho vùng dưới đường biểu đồ
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(13, 110, 253, 0.4)');
        gradient.addColorStop(1, 'rgba(13, 110, 253, 0.05)');

        new Chart(ctx, {
            type: 'line', // Chuyển thành 'bar' nếu muốn dùng biểu đồ cột
            data: {
                // Nhận mảng Label (Tháng 1 -> Tháng 12) từ Controller
                labels: {!! json_encode($revenueLabels ?? ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']) !!},
                datasets: [{
                    label: 'Doanh thu',
                    // ĐÃ SỬA THÀNH $chartData ĐỂ KHỚP VỚI CONTROLLER
                    data: {!! json_encode($chartData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0d6efd',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3 // Độ cong của đường
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Ẩn label do chỉ có 1 line
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Cập nhật lại định dạng hiển thị cho trục Y
                            callback: function(value) {
                                if (value === 0) return '0 ₫';
                                if (value >= 1000000) {
                                    return (value / 1000000).toLocaleString('vi-VN') + ' Tr';
                                }
                                return value.toLocaleString('vi-VN') + ' ₫';
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection