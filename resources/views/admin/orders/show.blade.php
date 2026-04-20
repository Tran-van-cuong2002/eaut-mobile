@extends('layouts.admin')

@section('page-title', 'Chi tiết Đơn hàng #' . $order->id)

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

{{-- Tiêu đề & Nút quay lại --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h4 style="margin: 0; font-weight: bold; color: #333; display: flex; align-items: center; gap: 8px;">
        <i class="bi bi-arrow-left-short" style="cursor:pointer; color: #6c757d; font-size: 24px;" onclick="history.back()" title="Quay lại"></i>
        Chi tiết Đơn hàng #{{ $order->id }}
    </h4>
</div>

{{-- Layout chia 2 cột --}}
<div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start;">
    
    {{-- CỘT TRÁI: THÔNG TIN KHÁCH HÀNG & SẢN PHẨM --}}
    <div style="flex: 1 1 60%; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
        
        {{-- Card Thông tin nhận hàng --}}
        <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
            <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd;">
                <h6 style="margin: 0; font-weight: bold; color: #333; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-person-lines-fill" style="color: #0d6efd;"></i> Thông tin nhận hàng
                </h6>
            </div>
            <div style="padding: 20px; display: flex; flex-wrap: wrap; gap: 20px;">
                <div style="flex: 1; min-width: 45%;">
                    <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;">Họ và tên</p>
                    <h6 style="margin: 0; font-weight: bold; color: #333; font-size: 15px;">{{ $order->customer_name ?? 'Không rõ' }}</h6>
                </div>
                <div style="flex: 1; min-width: 45%;">
                    <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;">Số điện thoại</p>
                    <h6 style="margin: 0; font-weight: bold; color: #333; font-size: 15px;">{{ $order->customer_phone ?? 'Không rõ' }}</h6>
                </div>
                <div style="width: 100%;">
                    <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;">Địa chỉ giao hàng</p>
                    <h6 style="margin: 0; font-weight: bold; color: #333; font-size: 15px; line-height: 1.4;">{{ $order->customer_address ?? 'Không rõ' }}</h6>
                </div>
                <div style="width: 100%;">
                    <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;">Ghi chú của khách</p>
                    <div style="padding: 12px 15px; background: #f8f9fa; border: 1px solid #eee; border-radius: 6px; color: #495057; font-size: 14px;">
                        {{ $order->notes ?? 'Không có ghi chú' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Danh sách sản phẩm --}}
        <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
            <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd;">
                <h6 style="margin: 0; font-weight: bold; color: #333; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-box-seam" style="color: #0d6efd;"></i> Danh sách sản phẩm
                </h6>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead style="background: #f8f9fa; color: #6c757d; font-size: 13px;">
                        <tr>
                            <th style="padding: 12px 20px; font-weight: 600;">Sản phẩm</th>
                            <th style="padding: 12px; font-weight: 600; text-align: center;">Đơn giá</th>
                            <th style="padding: 12px; font-weight: 600; text-align: center;">SL</th>
                            <th style="padding: 12px 20px; font-weight: 600; text-align: right;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($order->items) && $order->items->count() > 0)
                            @foreach($order->items as $item)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 15px 20px; color: #333; font-weight: 500;">{{ $item->product_name ?? 'Sản phẩm' }}</td>
                                <td style="padding: 15px 12px; text-align: center; color: #6c757d;">{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                <td style="padding: 15px 12px; text-align: center; font-weight: bold; color: #333;">{{ $item->quantity }}</td>
                                <td style="padding: 15px 20px; text-align: right; color: #dc3545; font-weight: bold;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 30px; color: #6c757d;">Chi tiết món hàng đang được cập nhật</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div style="padding: 15px 20px; background: #fff; text-align: right; border-top: 1px solid #eee;">
                <span style="color: #6c757d; margin-right: 15px; font-size: 15px;">Tổng cộng:</span>
                <span style="font-size: 20px; font-weight: bold; color: #dc3545;">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
            </div>
        </div>
    </div>

    {{-- CỘT PHẢI: TRẠNG THÁI & LỊCH SỬ --}}
    <div style="flex: 1 1 30%; min-width: 280px;">
        <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
            <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd;">
                <h6 style="margin: 0; font-weight: bold; color: #333; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-activity" style="color: #0d6efd;"></i> Trạng thái đơn
                </h6>
            </div>
            <div style="padding: 20px;">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; color: #6c757d; font-size: 13px; margin-bottom: 8px;">Tình trạng hiện tại</label>
                        <select name="status" style="width: 100%; padding: 12px 15px; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; outline: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); cursor: pointer; color: #333;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>💳 Đã thanh toán</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>📦 Đang đóng gói</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Đang giao hàng</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Đã giao thành công</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
                        </select>
                    </div>

                    <button type="submit" style="width: 100%; background: #0d6efd; color: #fff; padding: 12px; border: none; border-radius: 6px; font-weight: bold; font-size: 15px; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Cập nhật trạng thái
                    </button>
                </form>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">
                
                <div style="font-size: 13px; color: #6c757d; line-height: 1.8;">
                    <div style="display: flex; gap: 8px; margin-bottom: 5px;">
                        <i class="bi bi-clock"></i> 
                        <span>Ngày đặt: <strong style="color: #333;">{{ $order->created_at->format('d/m/Y H:i') }}</strong></span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <i class="bi bi-clock-history"></i> 
                        <span>Cập nhật: <strong style="color: #333;">{{ $order->updated_at->format('d/m/Y H:i') }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection