<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop Linh Kiện Điện Thoại')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; color: #0d6efd; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-mobile-alt me-2"></i>EAUT-MOBILE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Danh mục</a>
                    </li>
                </ul>
                <form class="d-flex me-3">
                    <input class="form-control me-2" type="search" placeholder="Tìm linh kiện...">
                    <button class="btn btn-outline-primary" type="submit">Tìm</button>
                </form>
                <div class="navbar-nav">
                    <a href="#" class="nav-link"><i class="fas fa-shopping-cart"></i> Giỏ hàng (0)</a>
                    <a href="#" class="nav-link">Đăng nhập</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4" style="min-height: 600px;">
        @yield('content')
    </div>

    <footer style="background-color: #212529; color: #f8f9fa; padding: 50px 0 20px 0; margin-top: 60px; width: 100%; font-family: sans-serif;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 style="color: #fff; font-weight: 800; margin-bottom: 20px; letter-spacing: 1px;">EAUT-MOBILE</h4>
                    <p style="font-size: 14px; color: #adb5bd; line-height: 1.6;">Chuyên cung cấp linh kiện điện thoại chính hãng, uy tín và chất lượng. Cam kết mang đến trải nghiệm dịch vụ sửa chữa chuyên nghiệp nhất cho sinh viên và khách hàng.</p>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px;">Thông tin liên hệ</h5>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: #adb5bd; line-height: 2.2;">
                        <li><i class="bi bi-geo-alt-fill" style="margin-right: 8px; color: #0d6efd;"></i> Tòa nhà EAUT, Hà Nội</li>
                        <li><i class="bi bi-telephone-fill" style="margin-right: 8px; color: #0d6efd;"></i> Hotline: 0123 456 789</li>
                        <li><i class="bi bi-envelope-fill" style="margin-right: 8px; color: #0d6efd;"></i> Email: contact@eaut.edu.vn</li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px;">Chính sách & Kết nối</h5>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; line-height: 2.2; margin-bottom: 15px;">
                        <li><a href="#" style="color: #adb5bd; text-decoration: none;">Chính sách bảo hành</a></li>
                        <li><a href="#" style="color: #adb5bd; text-decoration: none;">Chính sách đổi trả</a></li>
                    </ul>
                    <div>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-zalo fa-2x"></i></a>
                    </div>
                </div>
            </div>

            <div style="text-align: center; border-top: 1px solid #343a40; margin-top: 20px; padding-top: 20px; font-size: 13px; color: #6c757d;">
                &copy; {{ date('Y') }} Dự án Laravel - Nhóm Sinh Viên EAUT. Phát triển bởi Admin.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/bootstrap.bundle.min.js"></script>
</body>
</html>