@extends('layouts.admin')

@section('page-title', 'Thêm Sản phẩm Mới')

@section('content')
<div style="margin-bottom: 20px;">
    <h4 style="margin: 0; font-weight: bold; color: #333;">
        <span style="cursor:pointer; color: #666; margin-right: 5px;" onclick="history.back()">←</span> 
        Thêm sản phẩm mới
    </h4>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        
        <div style="flex: 1 1 60%; min-width: 300px;">
            
            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 16px;">Thông tin cơ bản</h5>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Tên sản phẩm <span style="color: red;">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Màn hình iPhone 13 Pro Max..." required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    @error('name') <span style="color: red; font-size: 13px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Mô tả chi tiết</label>
                    <textarea name="description" rows="5" placeholder="Nhập mô tả cho sản phẩm này..." style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">{{ old('description') }}</textarea>
                </div>
            </div>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px;">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 16px;">Giá & Kho hàng</h5>
                
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Giá bán (VNĐ) <span style="color: red;">*</span></label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" required min="0" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Số lượng trong kho <span style="color: red;">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
            </div>

        </div>

        <div style="flex: 1 1 35%; min-width: 300px;">
            
            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 16px;">Phân loại</h5>
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Danh mục <span style="color: red;">*</span></label>
                <select name="category_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="" disabled selected>-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                <h5 style="margin: 0; padding: 15px 20px; background: #fdfdfd; border-bottom: 1px solid #eee; font-size: 16px;">Hình ảnh</h5>
                
                <div style="display: flex; background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <div id="btn-tab-upload" onclick="switchTab('upload')" style="flex: 1; text-align: center; padding: 10px; cursor: pointer; background: #fff; border-bottom: 2px solid #0d6efd; font-weight: bold; color: #0d6efd; font-size: 14px; user-select: none;">
                        📤 Tải mới
                    </div>
                    <div id="btn-tab-library" onclick="switchTab('library')" style="flex: 1; text-align: center; padding: 10px; cursor: pointer; color: #6c757d; font-weight: bold; font-size: 14px; user-select: none;">
                        🖼️ Thư viện
                    </div>
                </div>

                <div style="padding: 15px;">
                    
                    <div id="content-upload" style="display: block;">
                        <input type="radio" name="image_selector" id="radioUpload" value="upload" style="display: none;" checked>
                        
                        <input type="file" name="image_upload" accept="image/*" onchange="previewUploadImage(this)" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px;">
                        
                        <div id="imagePreviewContainer" style="display: none; text-align: center; padding: 10px; background: #f9f9f9; border: 1px dashed #ccc; border-radius: 6px;">
                            <img id="imagePreview" src="" alt="Preview" style="max-height: 150px; max-width: 100%; border-radius: 4px; object-fit: contain;">
                        </div>
                    </div>

                    <div id="content-library" style="display: none;">
                        @if(isset($existingImages) && $existingImages->count() > 0)
                            <div style="max-height: 250px; overflow-y: auto; border: 1px solid #eee; border-radius: 4px; background: #fff;">
                                @foreach($existingImages as $img)
                                    <label style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-bottom: 1px solid #f1f1f1; cursor: pointer; margin: 0; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='transparent'">
                                        
                                        <div>
                                            <input type="radio" name="image_selector" value="{{ $img }}" style="transform: scale(1.2); cursor: pointer; margin: 0;">
                                        </div>
                                        
                                        <div>
                                            <img src="{{ asset('storage/' . $img) }}" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid #e0e0e0; border-radius: 4px; background: #fff;" alt="Img">
                                        </div>
                                        
                                        <div style="flex-grow: 1; font-size: 13px; color: #333; line-height: 1.4; overflow: hidden;">
                                            <div style="word-break: break-all; font-weight: 600;">
                                                {{ basename($img) }}
                                            </div>
                                            <div style="font-size: 11px; color: #888;">
                                                Thư mục: {{ dirname($img) }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 20px; border: 1px dashed #ccc; border-radius: 6px; color: #777; font-size: 14px;">
                                Chưa có ảnh nào trong thư viện.
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 16px;">Trạng thái</h5>
                <label style="display: flex; align-items: center; cursor: pointer; font-size: 15px;">
                    <input type="checkbox" name="is_active" value="1" checked style="transform: scale(1.2); margin-right: 10px;">
                    Hiển thị trên web
                </label>
            </div>

            <div>
                <button type="submit" style="width: 100%; padding: 12px; background: #0d6efd; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; margin-bottom: 10px;">
                    Hoàn tất lưu
                </button>
                <a href="{{ route('admin.products.index') }}" style="display: block; width: 100%; padding: 12px; background: #f8f9fa; color: #333; border: 1px solid #ccc; border-radius: 6px; font-size: 16px; text-align: center; text-decoration: none; box-sizing: border-box;">
                    Hủy bỏ
                </a>
            </div>

        </div>
    </div>
</form>

<script>
    // Hàm xử lý chuyển đổi qua lại giữa Tab Upload và Tab Thư viện
    function switchTab(tabName) {
        var contentUpload = document.getElementById('content-upload');
        var contentLibrary = document.getElementById('content-library');
        var btnUpload = document.getElementById('btn-tab-upload');
        var btnLibrary = document.getElementById('btn-tab-library');
        var radioUpload = document.getElementById('radioUpload');

        if (tabName === 'upload') {
            // Hiển thị nội dung upload
            contentUpload.style.display = 'block';
            contentLibrary.style.display = 'none';
            
            // Đổi màu nút Upload
            btnUpload.style.background = '#fff';
            btnUpload.style.borderBottom = '2px solid #0d6efd';
            btnUpload.style.color = '#0d6efd';
            
            // Đổi màu nút Library
            btnLibrary.style.background = 'transparent';
            btnLibrary.style.borderBottom = 'none';
            btnLibrary.style.color = '#6c757d';

            // Tự động tick vào input radio ẩn của Upload
            radioUpload.checked = true;
        } else {
            // Hiển thị nội dung thư viện
            contentUpload.style.display = 'none';
            contentLibrary.style.display = 'block';
            
            // Đổi màu nút Library
            btnLibrary.style.background = '#fff';
            btnLibrary.style.borderBottom = '2px solid #0d6efd';
            btnLibrary.style.color = '#0d6efd';
            
            // Đổi màu nút Upload
            btnUpload.style.background = 'transparent';
            btnUpload.style.borderBottom = 'none';
            btnUpload.style.color = '#6c757d';
        }
    }

    // Hàm xử lý hiển thị ảnh xem trước khi người dùng tải file từ máy tính
    function previewUploadImage(input) {
        var previewContainer = document.getElementById('imagePreviewContainer');
        var previewImg = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
            previewImg.src = '';
        }
    }
</script>
@endsection