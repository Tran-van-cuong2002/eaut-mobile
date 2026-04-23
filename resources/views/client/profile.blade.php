@extends('layouts.client')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Hồ sơ cá nhân của tôi</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email đăng nhập</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email không thể thay đổi.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại liên hệ</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ $user->profile->phone_number ?? '' }}" placeholder="Nhập số điện thoại...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ giao hàng mặc định</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ nhận hàng của bạn...">{{ $user->profile->address ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection