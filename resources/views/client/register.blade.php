@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Đăng Ký Tài Khoản</h3>
                        <p class="text-muted">Gia nhập cộng đồng EAUT-MOBILE ngay hôm nay</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small fw-semibold">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ và tên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên..." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email hoặc Số điện thoại</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope-at"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" name="contact_info" value="{{ old('contact_info') }}" placeholder="Nhập email hoặc số điện thoại..." required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 border-end-0 bg-light" name="password" placeholder="Mật khẩu" required>
                                    <span class="input-group-text bg-light toggle-password" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-check-circle"></i></span>
                                    <input type="password" class="form-control border-start-0 border-end-0 bg-light" name="password_confirmation" placeholder="Nhập lại" required>
                                    <span class="input-group-text bg-light toggle-password" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold text-uppercase rounded-3 shadow-sm mb-3">
                            Tạo Tài Khoản
                        </button>
                        
                        <p class="small text-muted text-center">Bằng việc đăng ký, bạn đã đồng ý với các <a href="#" class="text-decoration-none">Điều khoản dịch vụ</a> của chúng tôi.</p>
                    </form>

                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="small text-muted mb-0">Đã có tài khoản? 
                            <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Đăng nhập ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function() {
            let input = this.previousElementSibling;
            let icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye', 'text-success'); 
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye', 'text-success');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
@endsection