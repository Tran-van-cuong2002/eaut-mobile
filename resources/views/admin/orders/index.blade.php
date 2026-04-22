@extends('layouts.admin')

@section('page-title', 'Quản lý Đơn hàng')

@section('content')

@if(session('success'))
    <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #badbcc; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.style.display='none'" style="background: transparent; border: none; font-size: 20px; cursor: pointer; color: #0f5132;">&times;</button>
    </div>
@endif

<div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
    
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-receipt" style="color: #0d6efd; font-size: 18px;"></i> Danh sách Đơn hàng
        </h5>
        
        {{-- NÚT XUẤT EXCEL ĐƯỢC THÊM VÀO ĐÂY --}}
        <a href="{{ route('admin.orders.export') }}" style="background: #198754; color: #fff; border: 1px solid #198754; padding: 8px 16px; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(25,135,84,0.2);" onmouseover="this.style.background='#157347'; this.style.borderColor='#146c43'" onmouseout="this.style.background='#198754'; this.style.borderColor='#198754'">
            <i class="bi bi-file-earmark-excel" style="font-size: 16px;"></i> Xuất Excel
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #ddd; color: #555;">
                    <th style="padding: 12px 20px; width: 100px; font-weight: 600;">Mã Đơn</th>
                    <th style="padding: 12px; font-weight: 600;">Khách hàng</th>
                    <th style="padding: 12px; font-weight: 600;">Ngày đặt</th>
                    <th style="padding: 12px; font-weight: 600; text-align: right;">Tổng tiền</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600;">Trạng thái</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    
                    {{-- Mã Đơn --}}
                    <td style="padding: 15px 20px; color: #0d6efd; font-weight: bold;">
                        #{{ $order->id }}
                    </td>
                    
                    {{-- Khách hàng --}}
                    <td style="padding: 15px 12px;">
                        <div style="font-weight: bold; color: #333; font-size: 14px;">{{ $order->customer_name ?? 'Khách lẻ' }}</div>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 4px;"><i class="bi bi-telephone"></i> {{ $order->customer_phone ?? 'N/A' }}</div>
                    </td>

                    {{-- Ngày đặt --}}
                    <td style="padding: 15px 12px; color: #555;">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>

                    {{-- Tổng tiền & Phương thức thanh toán --}}
                    <td style="padding: 15px 12px; text-align: right;">
                        <div style="font-weight: bold; color: #dc3545; font-size: 15px;">{{ number_format($order->total_price, 0, ',', '.') }} ₫</div>
                        @if($order->payment_method == 'BANK')
                            <span style="background: #cff4fc; color: #055160; border: 1px solid #b6effb; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; margin-top: 6px;">
                                <i class="bi bi-bank"></i> Chuyển khoản
                            </span>
                        @else
                            <span style="background: #e2e3e5; color: #41464b; border: 1px solid #d3d6d8; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; margin-top: 6px;">
                                <i class="bi bi-cash"></i> COD
                            </span>
                        @endif
                    </td>

                    {{-- Trạng thái --}}
                    <td style="padding: 15px 12px; text-align: center;">
                        @php
                            $badges = [
                                'pending' => ['bg' => '#fff3cd', 'color' => '#856404', 'border' => '#ffeeba', 'text' => 'Chờ xử lý', 'icon' => 'bi-hourglass-split'],
                                'paid' => ['bg' => '#d1e7dd', 'color' => '#0f5132', 'border' => '#badbcc', 'text' => 'Đã thanh toán', 'icon' => 'bi-check-circle-fill'],
                                'processing' => ['bg' => '#cff4fc', 'color' => '#055160', 'border' => '#b6effb', 'text' => 'Đang đóng gói', 'icon' => 'bi-box-seam'],
                                'shipped' => ['bg' => '#cfe2ff', 'color' => '#084298', 'border' => '#b6d4fe', 'text' => 'Đang giao hàng', 'icon' => 'bi-truck'],
                                'completed' => ['bg' => '#d1e7dd', 'color' => '#0f5132', 'border' => '#badbcc', 'text' => 'Đã giao thành công', 'icon' => 'bi-check-circle'],
                                'cancelled' => ['bg' => '#f8d7da', 'color' => '#842029', 'border' => '#f5c2c7', 'text' => 'Đã hủy', 'icon' => 'bi-x-circle']
                            ];
                            $status = $badges[$order->status ?? 'pending'] ?? $badges['pending'];
                        @endphp
                        
                        <span style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border: 1px solid {{ $status['border'] }}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="bi {{ $status['icon'] }}"></i> {{ $status['text'] }}
                        </span>
                    </td>

                    {{-- Thao tác --}}
                    <td style="padding: 15px 12px; text-align: center;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="background: #fff; border: 1px solid #0d6efd; color: #0d6efd; padding: 6px 12px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; font-size: 13px; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#0d6efd'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='#0d6efd'">
                                <i class="bi bi-eye"></i> Xem
                            </a>
                            
                            @if($order->payment_method == 'BANK' && $order->status == 'pending')
                                <form action="{{ route('admin.orders.confirmPayment', $order->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: #198754; border: 1px solid #198754; color: #fff; padding: 6px 12px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; font-size: 13px; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#157347'; this.style.borderColor='#146c43'" onmouseout="this.style.background='#198754'; this.style.borderColor='#198754'" onclick="return confirm('Bạn xác nhận đã nhận đủ tiền cho đơn hàng này?')">
                                        <i class="bi bi-check2-circle"></i> Nhận tiền
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px 20px;">
                        <div style="color: #adb5bd; font-size: 60px; margin-bottom: 15px;">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5 style="margin: 0 0 10px 0; color: #333; font-weight: bold;">Chưa có đơn hàng nào</h5>
                        <p style="color: #6c757d; font-size: 14px; margin: 0;">Khi khách hàng đặt mua, đơn hàng sẽ hiển thị tại đây.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #eee; background: #fff; display: flex; justify-content: flex-end;">
        {{ $orders->links() }}
    </div>
    @endif

</div>

@endsection