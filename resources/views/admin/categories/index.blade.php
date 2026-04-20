@extends('layouts.admin')

@section('page-title', 'Quản lý Danh mục')

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
            <i class="bi bi-tags" style="color: #0d6efd;"></i> Tất cả danh mục
        </h5>
        <a href="{{ route('admin.categories.create') }}" style="background: #0d6efd; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; box-shadow: 0 2px 4px rgba(13,110,253,0.2);">
            <i class="bi bi-plus-lg"></i> Thêm danh mục
        </a>
    </div>

    {{-- KHU VỰC TÌM KIẾM ĐÃ ĐƯỢC SỬA THÀNH FORM --}}
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #f8f9fa;">
        <form action="{{ url()->current() }}" method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap; margin: 0;">
            <div style="flex: 1; min-width: 250px; display: flex;">
                <span style="padding: 8px 12px; background: #fff; border: 1px solid #ccc; border-right: none; border-radius: 4px 0 0 4px; color: #6c757d;">
                    <i class="bi bi-search"></i>
                </span>
                {{-- Thêm name="search" và value để giữ lại từ khóa --}}
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên danh mục..." style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-left: none; border-radius: 0 4px 4px 0; outline: none; font-size: 14px;">
            </div>
            <div style="display: flex; gap: 10px;">
                {{-- Nút Tìm kiếm --}}
                <button type="submit" style="background: #0d6efd; border: 1px solid #0d6efd; padding: 8px 16px; border-radius: 4px; cursor: pointer; color: #fff; font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 5px; transition: 0.2s;" onmouseover="this.style.background='#0b5ed7'" onmouseout="this.style.background='#0d6efd'">
                    <i class="bi bi-search"></i> Tìm
                </button>

                {{-- Nút Hủy (Chỉ hiện khi có tìm kiếm) --}}
                @if(request('search'))
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
                    <th style="padding: 12px; font-weight: 600;">Tên danh mục</th>
                    <th style="padding: 12px; font-weight: 600;">Đường dẫn (Slug)</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600;">Trạng thái</th>
                    <th style="padding: 12px; text-align: center; width: 120px; font-weight: 600;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px 20px; color: #6c757d; font-weight: 500;">#{{ $category->id }}</td>
                    
                    <td style="padding: 15px 12px;">
                        <div style="font-weight: bold; color: #333; font-size: 15px;">{{ $category->name }}</div>
                    </td>

                    <td style="padding: 15px 12px;">
                        <span style="background: #f8f9fa; border: 1px solid #ddd; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-size: 13px; color: #d63384;">
                            {{ $category->slug }}
                        </span>
                    </td>

                    <td style="padding: 15px 12px; text-align: center;">
                        @if($category->status == 1)
                            <span style="background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                <i class="bi bi-circle-fill" style="font-size: 8px; margin-right: 4px; vertical-align: middle;"></i> Đang hiện
                            </span>
                        @else
                            <span style="background: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                <i class="bi bi-pause-circle-fill" style="margin-right: 4px;"></i> Đã ẩn
                            </span>
                        @endif
                    </td>

                    <td style="padding: 15px 12px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" style="background: #fff; border: 1px solid #ccc; color: #0d6efd; padding: 6px 10px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA?\n\nDanh mục: {{ $category->name }}\n\nHành động này không thể hoàn tác!');">
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
                    <td colspan="5" style="text-align: center; padding: 50px 20px;">
                        <div style="color: #adb5bd; font-size: 60px; margin-bottom: 15px;">
                            <i class="bi bi-tags"></i>
                        </div>
                        {{-- Bổ sung thông báo nếu tìm kiếm không ra kết quả --}}
                        @if(request('search'))
                            <h5 style="margin: 0 0 10px 0; color: #333; font-weight: bold;">Không tìm thấy kết quả nào</h5>
                            <p style="color: #6c757d; font-size: 14px; margin-bottom: 20px;">Không có danh mục nào khớp với từ khóa "<b>{{ request('search') }}</b>".</p>
                            <a href="{{ url()->current() }}" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 14px;">
                                Quay lại danh sách
                            </a>
                        @else
                            <h5 style="margin: 0 0 10px 0; color: #333; font-weight: bold;">Chưa có danh mục nào</h5>
                            <p style="color: #6c757d; font-size: 14px; margin-bottom: 20px;">Tạo danh mục để phân loại sản phẩm của bạn dễ dàng hơn.</p>
                            <a href="{{ route('admin.categories.create') }}" style="background: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 14px;">
                                Thêm danh mục ngay
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #eee; background: #fff; display: flex; justify-content: flex-end;">
        {{ $categories->links() }}
    </div>
    @endif

</div>

@endsection