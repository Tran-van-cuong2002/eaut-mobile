<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAUT-MOBILE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        #suggestionBox { z-index: 1050; top: 100%; border-radius: 0 0 10px 10px; overflow: hidden; }
        .suggestion-item img { width: 40px; height: 40px; object-fit: contain; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">EAUT-MOBILE</a>
            
            <div class="position-relative w-50 mx-auto">
                <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                    <input id="searchInput" class="form-control me-2" type="search" name="keyword" 
                           value="{{ request('keyword') }}" placeholder="Tìm kiếm linh kiện..." autocomplete="off" required>
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>
                <ul id="suggestionBox" class="list-group position-absolute w-100 shadow-lg" style="display: none;"></ul>
            </div>

            <div class="navbar-nav align-items-center">
                @auth
                    {{-- Khách đã đăng nhập: Chuyển thẳng đến trang tra cứu kèm SĐT của họ (nếu có) --}}
                    <a class="nav-link me-3" href="{{ route('track.order', ['phone' => Auth::user()->phone ?? '']) }}">
                        <i class="bi bi-box-seam"></i> Đơn hàng của tôi
                    </a>
                @else
                    {{-- Khách chưa đăng nhập: Mở trang tra cứu trống --}}
                    <a class="nav-link me-3" href="{{ route('track.order') }}">
                        <i class="bi bi-search"></i> Tra cứu đơn hàng
                    </a>
                @endauth
                
                <a class="nav-link position-relative me-3" href="{{ route('cart') }}">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>

                {{-- ĐÃ SỬA Ở ĐÂY: Tạo Menu Dropdown cho User đã đăng nhập --}}
                @auth
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-lines-fill me-2"></i>Hồ sơ cá nhân</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Thoát</a></li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4" style="min-height: 600px;">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer style="background-color: #212529; color: #f8f9fa; padding: 50px 0 20px 0; margin-top: 40px; width: 100%; font-family: sans-serif;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 style="color: #fff; font-weight: 800; margin-bottom: 20px; letter-spacing: 1px;">EAUT-MOBILE</h4>
                    <p style="font-size: 14px; color: #adb5bd; line-height: 1.6; padding-right: 20px;">Chuyên cung cấp linh kiện điện thoại chính hãng, uy tín và chất lượng. Cam kết mang đến trải nghiệm dịch vụ sửa chữa chuyên nghiệp nhất cho sinh viên EAUT.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3" style="transition: color 0.2s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#fff'"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white me-3" style="transition: color 0.2s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#fff'"><i class="fab fa-zalo fa-2x"></i></a>
                        <a href="#" class="text-white" style="transition: color 0.2s;" onmouseover="this.style.color='#ff0000'" onmouseout="this.style.color='#fff'"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px;">Thông tin liên hệ</h5>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: #adb5bd; line-height: 2.2;">
                        <li><i class="bi bi-geo-alt-fill" style="margin-right: 8px; color: #0d6efd;"></i> Tòa nhà EAUT, Nam Từ Liêm, Hà Nội</li>
                        <li><i class="bi bi-telephone-fill" style="margin-right: 8px; color: #0d6efd;"></i> Hotline: 0123 456 789</li>
                        <li><i class="bi bi-envelope-fill" style="margin-right: 8px; color: #0d6efd;"></i> contact@eaut.edu.vn</li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px;">Bản đồ</h5>
                    <div style="border-radius: 8px; overflow: hidden; height: 160px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                        <iframe src="https://maps.google.com/maps?q=Đại%20học%20Công%20nghệ%20Đông%20Á,%20Trịnh%20Văn%20Bô,%20Nam%20Từ%20Liêm,%20Hà%20Nội&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div style="text-align: center; border-top: 1px solid #343a40; margin-top: 20px; padding-top: 20px; font-size: 13px; color: #6c757d;">
                © {{ date('Y') }} Dự án Laravel - Nhóm Sinh Viên EAUT. Phát triển bởi Admin.
            </div>
        </div>
    </footer>

    <script>
        const searchInput = document.getElementById('searchInput');
        const suggestionBox = document.getElementById('suggestionBox');

        searchInput.addEventListener('input', function() {
            let keyword = this.value.trim();
            if(keyword.length >= 2) {
                fetch(`/search/suggest?keyword=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if(data.length > 0) {
                        data.forEach(item => {
                            suggestionBox.innerHTML += `
                                <a href="/san-pham/${item.id}" class="list-group-item list-group-item-action d-flex align-items-center suggestion-item">
                                    <img src="/images/${item.image || 'default.jpg'}" class="me-3">
                                    <div>
                                        <div class="fw-bold small text-dark">${item.name}</div>
                                        <div class="text-danger small">${new Intl.NumberFormat().format(item.price)}đ</div>
                                    </div>
                                </a>`;
                        });
                        suggestionBox.style.display = 'block';
                    } else {
                        suggestionBox.style.display = 'none';
                    }
                });
            } else { suggestionBox.style.display = 'none'; }
        });

        document.addEventListener('click', (e) => {
            if(!searchInput.contains(e.target)) suggestionBox.style.display = 'none';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>