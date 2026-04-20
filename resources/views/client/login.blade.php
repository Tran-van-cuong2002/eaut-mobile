@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Đăng Nhập</h3>
                        <p class="text-muted">Chào mừng bạn quay lại EAUT-MOBILE</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small fw-semibold">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email hoặc Số điện thoại</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" name="login_info" value="{{ old('login_info') }}" placeholder="Nhập email hoặc số điện thoại..." required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control border-start-0 border-end-0 bg-light" name="password" placeholder="Nhập mật khẩu..." required>
                                <span class="input-group-text bg-light toggle-password" style="cursor: pointer;">
                                    <i class="bi bi-eye-slash text-muted"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label small" for="remember">Ghi nhớ tôi</label>
                            </div>
                            <a href="{{ route('forgot-password') }}" class="small text-decoration-none text-primary fw-semibold">Quên mật khẩu?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold text-uppercase rounded-3 shadow-sm">
                            Đăng nhập
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="small text-muted mb-0">Chưa có tài khoản? 
                            <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Đăng ký ngay</a>
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
                icon.classList.add('bi-eye', 'text-primary');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye', 'text-primary');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
@endsection