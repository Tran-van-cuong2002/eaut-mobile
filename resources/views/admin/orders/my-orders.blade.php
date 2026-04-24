@extends('layouts.client')

@section('content')
<div class="container mt-4 mb-5" style="min-height: 50vh;">
    <h3 class="mb-4">Đơn hàng của tôi</h3>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            Bạn chưa có đơn hàng nào. <a href="/">Mua sắm ngay</a>
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Người nhận</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>
                                    {{ $order->customer_name }} <br>
                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-danger fw-bold">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                                <td>
                                    {{-- Đã sửa phần này: Kiểm tra theo tiếng Anh, in ra tiếng Việt --}}
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    @elseif($order->status == 'processing' || $order->status == 'shipping')
                                        <span class="badge bg-primary">Đang giao</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($order->status == 'cancelled' || $order->status == 'canceled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info">Xem chi tiết</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection