@extends('layouts.admin')

@section('page-title', 'Cập nhật Danh mục')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
        
        <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-pencil-square" style="color: #ffc107; font-size: 18px;"></i> Cập nhật danh mục: <span style="color: #0d6efd;">{{ $category->name }}</span>
            </h5>
        </div>

        <div style="padding: 25px 30px;">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px; font-size: 14px;">
                        Tên danh mục <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="name" 
                           style="width: 100%; padding: 10px 15px; border: 1px solid @error('name') #dc3545 @else #ccc @enderror; border-radius: 6px; font-size: 14px; outline: none; box-sizing: border-box; transition: border-color 0.2s;" 
                           value="{{ old('name', $category->name) }}" placeholder="Nhập tên danh mục...">
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
                              placeholder="Nhập mô tả danh mục (không bắt buộc)...">{{ old('description', $category->description) }}</textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px; font-size: 14px;">
                        Trạng thái
                    </label>
                    <select name="status" style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; outline: none; box-sizing: border-box; background-color: #fff; cursor: pointer;">
                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>🟢 Đang hiển thị</option>
                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>🔴 Tạm ẩn danh mục</option>
                    </select>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 35px; padding-top: 20px; border-top: 1px solid #eee;">
                    <button type="submit" style="background: #ffc107; color: #000; padding: 10px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; box-shadow: 0 2px 4px rgba(255,193,7,0.2); display: flex; align-items: center; gap: 6px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i class="bi bi-save"></i> Cập nhật ngay
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