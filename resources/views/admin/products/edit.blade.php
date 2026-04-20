@extends('layouts.admin')

@section('page-title', 'Cập nhật Sản phẩm')

@section('content')
<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <h4 style="margin: 0; font-weight: bold; color: #333; display: flex; align-items: center;">
        <i class="bi bi-arrow-left-short" style="cursor:pointer; color: #6c757d; font-size: 24px; margin-right: 5px;" onclick="history.back()"></i>
        Cập nhật sản phẩm
    </h4>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        
        <div style="flex: 1 1 60%; min-width: 300px;">
            
            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 12px; font-size: 16px; font-weight: bold; color: #ffc107; display: flex; align-items: center;">
                    <i class="bi bi-pencil-square" style="margin-right: 8px;"></i> Thông tin cơ bản
                </h5>
                
                <div style="margin-bottom: 20px; margin-top: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Tên sản phẩm <span style="color: #dc3545;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width: 100%; padding: 10px 15px; border: 1px solid {{ $errors->has('name') ? '#dc3545' : '#ccc' }}; border-radius: 6px; font-size: 15px; outline: none;">
                    @error('name') 
                        <div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div> 
                    @enderror
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Mô tả chi tiết</label>
                    <textarea name="description" rows="6" style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; outline: none;">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 12px; font-size: 16px; font-weight: bold; color: #333;">Giá & Kho hàng</h5>
                
                <div style="display: flex; gap: 20px; margin-top: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Giá bán (VNĐ) <span style="color: #dc3545;">*</span></label>
                        <div style="display: flex;">
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-right: none; border-radius: 6px 0 0 6px; outline: none; font-size: 15px;">
                            <span style="background: #f8f9fa; border: 1px solid #ccc; padding: 10px 15px; border-radius: 0 6px 6px 0; color: #6c757d; font-weight: bold;">₫</span>
                        </div>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Số lượng trong kho <span style="color: #dc3545;">*</span></label>
                        <div style="display: flex;">
                            <span style="background: #f8f9fa; border: 1px solid #ccc; padding: 10px 15px; border-radius: 6px 0 0 6px; color: #6c757d;"><i class="bi bi-box"></i></span>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-left: none; border-radius: 0 6px 6px 0; outline: none; font-size: 15px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div style="flex: 1 1 35%; min-width: 300px;">
            
            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 12px; font-size: 16px; font-weight: bold; color: #333;">Phân loại</h5>
                <div style="margin-top: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Danh mục <span style="color: #dc3545;">*</span></label>
                    <select name="category_id" required style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 6px; outline: none; font-size: 15px; background: #fff;">
                        <option value="" disabled>-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <h5 style="margin: 0; padding: 15px 20px; background: #fdfdfd; border-bottom: 1px solid #eee; font-size: 16px; font-weight: bold; color: #333;">Hình ảnh</h5>
                
                <div style="padding: 15px; border-bottom: 1px solid #eee; text-align: center; background: #fafafa;">
                    <label style="display: block; font-size: 13px; color: #666; margin-bottom: 10px; font-weight: 600;">Ảnh hiện tại đang dùng</label>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" style="width: 120px; height: 120px; object-fit: contain; border: 1px solid #ccc; border-radius: 8px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" alt="Current Image">
                    @else
                        <div style="width: 120px; height: 120px; margin: 0 auto; background: #eee; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; color: #999; border-radius: 8px;">
                            Chưa có ảnh
                        </div>
                    @endif
                </div>

                <div style="display: flex; background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <div id="btn-tab-upload" onclick="switchTab('upload')" style="flex: 1; text-align: center; padding: 10px; cursor: pointer; background: #fff; border-bottom: 2px solid #0d6efd; font-weight: bold; color: #0d6efd; font-size: 13px; user-select: none;">
                        <i class="bi bi-cloud-arrow-up"></i> Tải mới
                    </div>
                    <div id="btn-tab-library" onclick="switchTab('library')" style="flex: 1; text-align: center; padding: 10px; cursor: pointer; color: #6c757d; font-weight: bold; font-size: 13px; user-select: none;">
                        <i class="bi bi-images"></i> Thư viện
                    </div>
                </div>

                <div style="padding: 15px;">
                    <div id="content-upload" style="display: block;">
                        <input type="radio" name="image_selector" id="radioUpload" value="upload" style="display: none;" checked>
                        
                        <div style="border: 2px dashed #ccc; border-radius: 8px; padding: 15px; text-align: center; background: #f8f9fa; cursor: pointer;" onclick="document.getElementById('fileUpload').click()">
                            <p style="color: #6c757d; margin: 0; font-size: 14px;"><i class="bi bi-cloud-arrow-up me-1"></i> Bấm để chọn ảnh khác</p>
                            <input type="file" name="image" id="fileUpload" accept="image/*" onchange="previewUploadImage(this)" style="display: none;">
                        </div>
                        
                        <div id="imagePreviewContainer" style="display: none; text-align: center; margin-top: 15px;">
                            <img id="imagePreview" src="" alt="Preview" style="max-height: 150px; max-width: 100%; border-radius: 6px; object-fit: contain; border: 1px solid #eee;">
                        </div>
                    </div>

                    <div id="content-library" style="display: none;">
                        @if(isset($existingImages) && count($existingImages) > 0)
                            <div style="max-height: 200px; overflow-y: auto; border: 1px solid #eee; border-radius: 6px; background: #fff;">
                                @foreach($existingImages as $img)
                                    <label style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-bottom: 1px solid #f1f1f1; cursor: pointer; margin: 0; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='transparent'">
                                        <div><input type="radio" name="image_selector" value="{{ $img }}" style="transform: scale(1.2); cursor: pointer; margin: 0;"></div>
                                        <div><img src="{{ asset('storage/' . $img) }}" style="width: 40px; height: 40px; object-fit: contain; border: 1px solid #e0e0e0; border-radius: 4px; background: #fff;" alt="Img"></div>
                                        <div style="flex-grow: 1; font-size: 12px; color: #333; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                            {{ basename($img) }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 20px; border: 1px dashed #ccc; border-radius: 6px; color: #777; font-size: 13px;">
                                Thư viện trống.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <h5 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 12px; font-size: 16px; font-weight: bold; color: #333;">Trạng thái</h5>
                <div style="margin-top: 15px;">
                    <label style="display: flex; align-items: center; cursor: pointer; font-size: 15px; font-weight: 500; color: #333;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} style="width: 20px; height: 20px; margin-right: 10px; cursor: pointer;">
                        Hiển thị trên web
                    </label>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <button type="submit" style="width: 100%; padding: 14px; background: #ffc107; color: #000; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 2px 4px rgba(255, 193, 7, 0.2);">
                    <i class="bi bi-check2-circle"></i> Lưu thay đổi
                </button>
                <a href="{{ route('admin.products.index') }}" style="display: block; width: 100%; padding: 14px; background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 8px; font-size: 16px; font-weight: 600; text-align: center; text-decoration: none; box-sizing: border-box;">
                    Hủy bỏ
                </a>
            </div>

        </div>
    </div>
</form>

<script>
    function switchTab(tabName) {
        var contentUpload = document.getElementById('content-upload');
        var contentLibrary = document.getElementById('content-library');
        var btnUpload = document.getElementById('btn-tab-upload');
        var btnLibrary = document.getElementById('btn-tab-library');
        var radioUpload = document.getElementById('radioUpload');

        if (tabName === 'upload') {
            contentUpload.style.display = 'block';
            contentLibrary.style.display = 'none';
            btnUpload.style.background = '#fff';
            btnUpload.style.borderBottom = '2px solid #0d6efd';
            btnUpload.style.color = '#0d6efd';
            btnLibrary.style.background = 'transparent';
            btnLibrary.style.borderBottom = 'none';
            btnLibrary.style.color = '#6c757d';
            radioUpload.checked = true;
        } else {
            contentUpload.style.display = 'none';
            contentLibrary.style.display = 'block';
            btnLibrary.style.background = '#fff';
            btnLibrary.style.borderBottom = '2px solid #0d6efd';
            btnLibrary.style.color = '#0d6efd';
            btnUpload.style.background = 'transparent';
            btnUpload.style.borderBottom = 'none';
            btnUpload.style.color = '#6c757d';
        }
    }

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