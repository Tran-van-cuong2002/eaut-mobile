@extends('layouts.admin')

@section('page-title', 'Thêm Danh mục Mới')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
        
        <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-plus-circle-fill" style="color: #0d6efd; font-size: 18px;"></i> Thêm Danh mục Mới
            </h5>
        </div>

        <div style="padding: 25px 30px;">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px; font-size: 14px;">
                        Tên danh mục <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="name" 
                           style="width: 100%; padding: 10px 15px; border: 1px solid @error('name') #dc3545 @else #ccc @enderror; border-radius: 6px; font-size: 14px; outline: none; box-sizing: border-box; transition: border-color 0.2s;" 
                           value="{{ old('name') }}" placeholder="Ví dụ: Linh kiện iPhone">
                    @error('name') 
                        <div style="color: #dc3545; font-size: 13px; margin-top: 6px; font-weight: 500;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div> 
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px; font-size: 14px;">
                        Mô tả
                    </label>
                    <textarea name="description" rows="4" 
                              style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; outline: none; box-sizing: border-box; resize: vertical;" 
                              placeholder="Nhập mô tả danh mục...">{{ old('description') }}</textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 12px; font-size: 14px;">
                        Trạng thái hiển thị
                    </label>
                    <div style="display: flex; gap: 25px;">
                        <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px; color: #495057;">
                            <input type="radio" name="status" value="1" style="width: 16px; height: 16px; cursor: pointer;" checked>
                            🟢 Hiển thị ngay
                        </label>
                        <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px; color: #495057;">
                            <input type="radio" name="status" value="0" style="width: 16px; height: 16px; cursor: pointer;">
                            🔴 Tạm ẩn
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 35px; padding-top: 20px; border-top: 1px solid #eee;">
                    <button type="submit" style="background: #0d6efd; color: #fff; padding: 10px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; box-shadow: 0 2px 4px rgba(13,110,253,0.2); display: flex; align-items: center; gap: 6px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i class="bi bi-plus-lg"></i> Lưu danh mục
                    </button>
                    <a href="{{ route('admin.categories.index') }}" style="background: #fff; color: #495057; border: 1px solid #ccc; padding: 10px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; text-align: center; display: flex; align-items: center; gap: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-arrow-left-circle"></i> Hủy bỏ
                    </a>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection