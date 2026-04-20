@extends('layouts.admin')

@section('page-title', 'Quản lý Sản phẩm')

@section('content')

@if(session('success'))
    <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #badbcc; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.style.display='none'" style="background: transparent; border: none; font-size: 20px; cursor: pointer; color: #0f5132;">&times;</button>
    </div>
@endif

<div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
    
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-box-seam" style="color: #0d6efd;"></i> Tất cả sản phẩm
        </h5>
        <a href="{{ route('admin.products.create') }}" style="background: #0d6efd; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; box-shadow: 0 2px 4px rgba(13,110,253,0.2);">
            <i class="bi bi-plus-lg"></i> Thêm sản phẩm
        </a>
    </div>

    {{-- KHU VỰC TÌM KIẾM & LỌC ĐÃ ĐƯỢC CHUYỂN THÀNH FORM --}}
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #f8f9fa;">
        <form action="{{ url()->current() }}" method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap; margin: 0;">
            
            {{-- Ô tìm kiếm theo tên, mã --}}
            <div style="flex: 1; min-width: 250px; display: flex;">
                <span style="padding: 8px 12px; background: #fff; border: 1px solid #ccc; border-right: none; border-radius: 4px 0 0 4px; color: #6c757d;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, mã sản phẩm..." style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-left: none; border-radius: 0 4px 4px 0; outline: none; font-size: 14px;">
            </div>

            {{-- Ô chọn danh mục (Đã sửa ở đây) --}}
            <div style="flex: 0 0 200px;">
                <select name="category_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; outline: none; color: #555; font-size: 14px; background: #fff;">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach 
                </select>
            </div>

            {{-- Các nút thao tác --}}
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #0d6efd; border: 1px solid #0d6efd; padding: 8px 16px; border-radius: 4px; cursor: pointer; color: #fff; font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 5px; transition: 0.2s;" onmouseover="this.style.background='#0b5ed7'" onmouseout="this.style.background='#0d6efd'">
                    <i class="bi bi-funnel"></i> Lọc
                </button>

                {{-- Nút xóa lọc chỉ hiện khi có bất kỳ query nào trên URL --}}
                @if(request('search') || request('category_id'))
                    <a href="{{ url()->current() }}" style="background: #fff; border: 1px solid #6c757d; padding: 8px 16px; border-radius: 4px; cursor: pointer; color: #495057; text-decoration: none; font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 5px; transition: 0.2s;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-x-circle"></i> Xóa lọc
                    </a>
                @endif
            </div>

        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #ddd; color: #555;">
                    <th style="padding: 12px 20px; width: 60px; font-weight: 600;">ID</th>
                    <th style="padding: 12px; width: 80px; font-weight: 600;">Ảnh</th>
                    <th style="padding: 12px; font-weight: 600;">Thông tin sản phẩm</th>
                    <th style="padding: 12px; font-weight: 600;">Giá bán</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600;">Tồn kho</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600;">Trạng thái</th>
                    <th style="padding: 12px; text-align: center; width: 120px; font-weight: 600;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px 20px; color: #6c757d; font-weight: 500;">#{{ $product->id }}</td>
                    
                    <td style="padding: 15px 12px;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" alt="Img">
                        @else
                            <div style="width: 48px; height: 48px; background: #f1f3f5; border-radius: 6px; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image" style="color: #adb5bd; font-size: 20px;"></i>
                            </div>
                        @endif
                    </td>

                    <td style="padding: 15px 12px;">
                        <div style="font-weight: bold; color: #333; font-size: 15px; margin-bottom: 4px;">{{ $product->name }}</div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="background: #f8f9fa; border: 1px solid #ddd; padding: 2px 8px; border-radius: 4px; font-size: 12px; color: #495057;">
                                <i class="bi bi-folder2" style="margin-right: 3px;"></i> {{ $product->category->name ?? 'Chưa phân loại' }}
                            </span>
                            <span style="font-size: 12px; color: #6c757d;">Lượt xem: {{ rand(10, 500) }}</span>
                        </div>
                    </td>

                    <td style="padding: 15px 12px; font-weight: bold; color: #dc3545; font-size: 15px;">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    </td>

                    <td style="padding: 15px 12px; text-align: center;">
                        <span style="background: {{ ($product->stock ?? 0) > 0 ? '#cff4fc' : '#f8d7da' }}; color: {{ ($product->stock ?? 0) > 0 ? '#055160' : '#842029' }}; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 600;">
                            {{ $product->stock ?? 0 }}
                        </span>
                    </td>

                    <td style="padding: 15px 12px; text-align: center;">
                        @if($product->is_active)
                            <span style="background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                <i class="bi bi-circle-fill" style="font-size: 8px; margin-right: 4px; vertical-align: middle;"></i> Đang bán
                            </span>
                        @else
                            <span style="background: #e2e3e5; color: #41464c; border: 1px solid #d3d6d8; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                <i class="bi bi-pause-circle-fill" style="margin-right: 4px;"></i> Tạm ẩn
                            </span>
                        @endif
                    </td>

                    <td style="padding: 15px 12px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('admin.products.edit', $product->id) }}" style="background: #fff; border: 1px solid #ccc; color: #0d6efd; padding: 6px 10px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('⚠️ BẠN CÓ CHẮC MUỐN XÓA?\n\nSản phẩm: {{ $product->name }}\n\nLưu ý: Hành động này không thể hoàn tác!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #fff; border: 1px solid #ccc; color: #dc3545; padding: 6px 10px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" title="Xóa">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 50px 20px;">
                        <div style="color: #adb5bd; font-size: 60px; margin-bottom: 15px;">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        {{-- Hiển thị lỗi thông minh khi không tìm thấy dữ liệu --}}
                        @if(request('search') || request('category_id'))
                            <h5 style="margin: 0 0 10px 0; color: #333; font-weight: bold;">Không tìm thấy sản phẩm nào</h5>
                            <p style="color: #6c757d; font-size: 14px; margin-bottom: 20px;">Không có sản phẩm nào khớp với điều kiện lọc của bạn.</p>
                            <a href="{{ url()->current() }}" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 14px;">
                                Quay lại danh sách
                            </a>
                        @else
                            <h5 style="margin: 0 0 10px 0; color: #333; font-weight: bold;">Chưa có sản phẩm nào</h5>
                            <p style="color: #6c757d; font-size: 14px; margin-bottom: 20px;">Bắt đầu bằng cách thêm sản phẩm đầu tiên của bạn.</p>
                            <a href="{{ route('admin.products.create') }}" style="background: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 14px;">
                                Thêm sản phẩm ngay
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #eee; background: #fff; display: flex; justify-content: flex-end;">
        {{ $products->links() }}
    </div>
    @endif

</div>

@endsection