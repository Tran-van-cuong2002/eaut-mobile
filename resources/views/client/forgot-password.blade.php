@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Quên Mật Khẩu?</h3>
                        <p class="text-muted">Đừng lo lắng! Vui lòng nhập email hoặc số điện thoại, chúng tôi sẽ gửi mã khôi phục cho bạn.</p>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email hoặc Số điện thoại đã đăng ký</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope-exclamation"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" name="contact_info" placeholder="Nhập thông tin của bạn..." required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning text-dark w-100 py-2 fw-bold text-uppercase rounded-3 shadow-sm mb-3">
                            <i class="bi bi-send me-1"></i> Gửi Yêu Cầu
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="small text-muted mb-0">Nhớ ra mật khẩu rồi? 
                            <a href="{{ route('login') }}" class="text-dark fw-bold text-decoration-none text-warning-hover">
                                Quay lại đăng nhập
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-warning-hover:hover { color: #ffc107 !important; transition: 0.3s; }
</style>
@endsection