<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - EAUT MOBILE')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        .sidebar { width: 260px; height: 100vh; background: #1a1d20; color: white; position: fixed; left: 0; top: 0; z-index: 1000; transition: all 0.3s; }
        .sidebar .nav-link { color: #adb5bd; padding: 12px 20px; display: flex; align-items: center; text-decoration: none; border-left: 4px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #2c3034; color: #fff; border-left-color: #0d6efd; }
        .sidebar .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        
        .main-content { margin-left: 260px; min-height: 100vh; background: #f4f7f6; transition: all 0.3s; }
        .top-navbar { background: white; padding: 15px 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 999; }
        
        /* Làm đẹp các bảng và khung */
        .card { border: none; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .table thead { background-color: #f8f9fa; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column shadow">
    <div class="p-4 text-center border-bottom border-secondary mb-2">
        <h5 class="text-white fw-bold m-0">EAUT ADMIN</h5>
    </div>
    <nav class="nav flex-column mt-2">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Tổng quan
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Quản lý Danh mục
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Quản lý Sản phẩm
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i> Quản lý Đơn hàng
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Quản lý Người dùng
        </a>

        <div class="mt-auto border-top border-secondary p-3">
            {{-- ĐÃ SỬA TẠI ĐÂY: Thêm sự kiện onclick và thẻ form ẩn --}}
            <a href="{{ route('logout') }}" class="nav-link text-danger fw-bold p-0"
               onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                <i class="bi bi-box-arrow-left"></i> Đăng xuất
            </a>
            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</div>

<div class="main-content">
    <header class="top-navbar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark">@yield('page-title', 'Trang Quản Trị')</h5>
        <div class="d-flex align-items-center">
            <div class="bg-light px-3 py-1 border rounded-pill small fw-bold">Admin</div>
        </div>
    </header>

    <main class="p-4">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/bootstrap.bundle.min.js"></script>
</body>
</html>