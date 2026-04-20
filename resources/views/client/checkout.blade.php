@extends('layouts.client')

@section('content')

@php 
    // Tính tổng tiền ngay từ đầu để truyền vào mã QR tự động
    $cartTotal = 0; 
    if(session('cart')) {
        foreach(session('cart') as $id => $details) {
            $cartTotal += $details['price'] * $details['quantity'];
        }
    }
@endphp

<div class="container">
    <h3 class="fw-bold mb-4 text-danger"><i class="bi bi-wallet2"></i> Thanh toán đơn hàng</h3>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm p-4 mb-4 rounded-3">
                    <h5 class="fw-bold mb-3"><i class="bi bi-person-lines-fill text-primary"></i> Thông tin giao hàng</h5>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="fullname" class="form-control" required placeholder="Nhập họ và tên người nhận">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" required placeholder="Nhập số điện thoại liên hệ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" required placeholder="Nhập địa chỉ chi tiết (Số nhà, tên đường, phường/xã...)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ghi chú đơn hàng (Tùy chọn)</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Ghi chú thêm về đơn hàng (ví dụ: giao giờ hành chính)..."></textarea>
                    </div>
                    
                    <h5 class="fw-bold mt-4 mb-3"><i class="bi bi-credit-card-2-front text-primary"></i> Phương thức thanh toán</h5>
                    
                    <div class="form-check border p-3 rounded mb-2 bg-light">
                        <input class="form-check-input ms-1" type="radio" name="payment_method" id="cod" value="COD" checked onchange="toggleQR()">
                        <label class="form-check-label fw-bold text-dark ms-2" for="cod" style="cursor: pointer;">
                            <i class="bi bi-cash-coin text-success"></i> Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    
                    <div class="form-check border p-3 rounded mb-3">
                        <input class="form-check-input ms-1" type="radio" name="payment_method" id="bank" value="BANK" onchange="toggleQR()">
                        <label class="form-check-label fw-bold text-dark ms-2" for="bank" style="cursor: pointer;">
                            <i class="bi bi-bank text-primary"></i> Chuyển khoản ngân hàng
                        </label>
                    </div>

                    <div id="qr_section" class="text-center p-4 mb-2 border border-primary-subtle rounded-3 bg-light" style="display: none;">
                        <p class="fw-bold text-primary mb-2 fs-5">Quét mã QR để thanh toán</p>
                        
                        <img src="https://img.vietqr.io/image/MB-0123456789-compact2.png?amount={{ $cartTotal }}&addInfo=Thanh toan mua hang&accountName=TEN CHU TAI KHOAN" 
                             alt="Mã QR Thanh Toán" 
                             class="img-fluid rounded-3 shadow-sm bg-white p-2 mb-3" 
                             style="max-width: 220px;">
                             
                        <div class="small text-dark text-start mx-auto" style="max-width: 250px;">
                            <p class="mb-1 d-flex justify-content-between">Ngân hàng: <strong>MB Bank</strong></p>
                            <p class="mb-1 d-flex justify-content-between">Số tài khoản: <strong>0123456789</strong></p>
                            <p class="mb-1 d-flex justify-content-between">Chủ tài khoản: <strong>TÊN CHỦ TÀI KHOẢN</strong></p>
                            <p class="mb-1 d-flex justify-content-between text-danger fs-6 mt-2">Tổng tiền: <strong>{{ number_format($cartTotal) }}đ</strong></p>
                        </div>
                        <div class="alert alert-warning mt-3 py-2 small mb-0 text-start">
                            <i class="bi bi-info-circle-fill"></i> Vui lòng không thay đổi nội dung chuyển khoản để hệ thống xác nhận tự động.
                        </div>
                    </div>
                    </div>
            </div>

            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4 bg-light rounded-3 sticky-top" style="top: 80px;">
                    <h5 class="fw-bold mb-3"><i class="bi bi-bag-check text-primary"></i> Đơn hàng của bạn</h5>
                    
                    <ul class="list-group list-group-flush mb-3">
                        @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                                @php 
                                    $subtotal = $details['price'] * $details['quantity']; 
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/'.($details['image'] ?? 'default.jpg')) }}" alt="" width="50" height="50" style="object-fit: cover;" class="me-3 border rounded bg-white">
                                        <div>
                                            <div class="fw-bold small">{{ $details['name'] }}</div>
                                            <small class="text-muted">SL: {{ $details['quantity'] }} x {{ number_format($details['price']) }}đ</small>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-danger">{{ number_format($subtotal) }}đ</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    
                    <hr>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($cartTotal) }} đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success fw-bold">Miễn phí</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <span class="fs-5 fw-bold">Tổng cộng:</span>
                        <span class="fs-3 fw-bold text-danger">{{ number_format($cartTotal) }} đ</span>
                    </div>
                    
                    <button type="submit" class="btn btn-danger w-100 py-3 mt-4 fw-bold fs-5 shadow-sm rounded-3">
                        ĐẶT HÀNG NGAY
                    </button>
                    <a href="{{ route('cart') }}" class="btn btn-outline-secondary w-100 py-2 mt-2 rounded-3">
                        <i class="bi bi-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleQR() {
        var isBanking = document.getElementById('bank').checked;
        var qrSection = document.getElementById('qr_section');
        
        if (isBanking) {
            qrSection.style.display = 'block';
        } else {
            qrSection.style.display = 'none';
        }
    }
</script>

@endsection