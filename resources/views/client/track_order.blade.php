@extends('layouts.client')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 60px; max-width: 800px; margin-left: auto; margin-right: auto;">
    
    {{-- Form nhập số điện thoại --}}
    <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; text-align: center;">
        <h3 style="margin-bottom: 20px; font-weight: bold;">Tra Cứu Đơn Hàng</h3>
        <p style="color: #6c757d; margin-bottom: 20px;">Vui lòng nhập số điện thoại bạn đã sử dụng để đặt hàng.</p>
        
        <form action="{{ route('track.order') }}" method="GET" style="display: flex; max-width: 400px; margin: 0 auto; gap: 10px;">
            <input type="text" name="phone" value="{{ request('phone') }}" placeholder="Nhập số điện thoại..." required style="flex: 1; padding: 10px 15px; border: 1px solid #ccc; border-radius: 4px; outline: none;">
            <button type="submit" style="background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                Tìm kiếm
            </button>
        </form>
    </div>

    {{-- Kết quả tra cứu --}}
    @if(isset($orders))
        @if($orders->count() > 0)
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <h5 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    Tìm thấy <b>{{ $orders->count() }}</b> đơn hàng cho số điện thoại: <span style="color: #0d6efd;">{{ $phone }}</span>
                </h5>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; text-align: left; border-bottom: 2px solid #ddd;">
                            <th style="padding: 12px;">Mã đơn</th>
                            <th style="padding: 12px;">Ngày đặt</th>
                            <th style="padding: 12px;">Tổng tiền</th>
                            <th style="padding: 12px;">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px; font-weight: bold;">#{{ $order->id }}</td>
                                <td style="padding: 12px;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td style="padding: 12px; color: #dc3545; font-weight: bold;">
                                    {{ number_format($order->total_price, 0, ',', '.') }} ₫
                                </td>
                                <td style="padding: 12px;">
                                    <span style="background: #e2e3e5; color: #383d41; padding: 5px 10px; border-radius: 4px; font-size: 13px;">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 4px; border: 1px solid #f5c2c7;">
                Không tìm thấy đơn hàng nào với số điện thoại <b>{{ $phone }}</b>. Vui lòng kiểm tra lại!
            </div>
        @endif
    @endif

</div>
@endsection