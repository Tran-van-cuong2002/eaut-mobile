<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khôi phục mật khẩu - EAUT MOBILE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9; 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .card-custom {
            width: 100%;
            max-width: 450px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            background: #fff;
        }
        .btn-primary-custom {
            background-color: #0056b3;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-primary-custom:hover {
            background-color: #004494;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }
        .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
            padding: 12px 15px;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            background-color: #fff;
            border-color: #0056b3;
        }
        .input-group:focus-within .input-group-text {
            background-color: #fff;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="card card-custom">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: #0056b3; letter-spacing: 1px;">EAUT MOBILE</h2>
                <h5 class="fw-bold mt-4">KHÔI PHỤC MẬT KHẨU</h5>
                <p class="text-muted small mt-2">Vui lòng nhập email đăng ký để nhận liên kết đặt lại mật khẩu</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 text-center small mb-4" style="border-radius: 8px; background-color: #d1e7dd; color: #0f5132;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size: 14px;">Email của bạn <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="example@gmail.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger mt-2 small"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary-custom text-white w-100 mb-4">
                    GỬI YÊU CẦU KHÔI PHỤC
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: #0056b3; font-size: 14px;">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại trang Đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>