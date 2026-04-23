@extends('layouts.client')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4 text-danger"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h3>
    
    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            <div class="col-md-8">
                <table class="table align-middle text-center bg-white shadow-sm rounded">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4">Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th style="width: 120px;">Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php 
                                $subtotal = $details['price'] * $details['quantity']; 
                                $total += $subtotal; 
                            @endphp
                            <tr>
                                <td class="text-start ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/'.$details['image']) }}" width="60" class="me-3 border rounded">
                                        <span class="fw-bold">{{ $details['name'] }}</span>
                                    </div>
                                </td>
                                <td>{{ number_format($details['price']) }} đ</td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                               class="form-control text-center bg-secondary text-white fw-bold" 
                                               onchange="this.form.submit()" min="1">
                                    </form>
                                </td>
                                <td class="text-danger fw-bold">{{ number_format($subtotal) }} đ</td>
                                <td>
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm bg-light rounded-3">
                    <h5 class="fw-bold mb-4">Tóm tắt đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($total) }} đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 text-muted">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between my-3">
                        <span class="fs-5 fw-bold">Tổng cộng:</span>
                        <span class="fs-4 fw-bold text-danger">{{ number_format($total) }} đ</span>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="btn btn-danger w-100 py-2 fw-bold text-white text-decoration-none shadow-sm mb-3">
                        TIẾN HÀNH THANH TOÁN
                    </a>
                    
                    <div class="text-center mt-2">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary small">
                            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white shadow-sm rounded">
            <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
            <p class="text-muted mt-3 fs-5">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-2 px-4 py-2">
                <i class="bi bi-cart-plus"></i> Mua sắm ngay
            </a>
        </div>
    @endif
</div>
@endsection