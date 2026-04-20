@extends('layouts.admin')

@section('page-title', 'Cập nhật Người dùng')

@section('content')

<div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02); max-width: 600px;">
    
    {{-- Tiêu đề --}}
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-person-lines-fill" style="color: #0d6efd; font-size: 18px;"></i> Cập nhật thông tin: {{ $user->name }}
        </h5>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="margin: 0; padding: 20px;">
        @csrf
        @method('PUT')
        
        {{-- Tên người dùng --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px;">
                Tên người dùng <span style="color: #dc3545;">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; color: #333; outline: none; transition: all 0.2s;"
                   onfocus="this.style.borderColor='#86b7fe'; this.style.boxShadow='0 0 0 0.25rem rgba(13,110,253,.25)'"
                   onblur="this.style.borderColor='#ccc'; this.style.boxShadow='none'">
            @error('name')
                <span style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px;">
                Email <span style="color: #dc3545;">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; color: #333; outline: none; transition: all 0.2s;"
                   onfocus="this.style.borderColor='#86b7fe'; this.style.boxShadow='0 0 0 0.25rem rgba(13,110,253,.25)'"
                   onblur="this.style.borderColor='#ccc'; this.style.boxShadow='none'">
            @error('email')
                <span style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Mật khẩu --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px;">
                Mật khẩu mới <span style="color: #6c757d; font-weight: normal; font-size: 12px;">(Để trống nếu không muốn đổi)</span>
            </label>
            <input type="password" name="password" placeholder="Nhập mật khẩu mới..."
                   style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; color: #333; outline: none; transition: all 0.2s;"
                   onfocus="this.style.borderColor='#86b7fe'; this.style.boxShadow='0 0 0 0.25rem rgba(13,110,253,.25)'"
                   onblur="this.style.borderColor='#ccc'; this.style.boxShadow='none'">
            @error('password')
                <span style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Phân quyền --}}
        <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px;">
                Vai trò hệ thống <span style="color: #dc3545;">*</span>
            </label>
            
            <select name="role" 
                    style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; color: #333; background-color: #fff; outline: none; cursor: pointer; appearance: auto;"
                    onfocus="this.style.borderColor='#86b7fe'; this.style.boxShadow='0 0 0 0.25rem rgba(13,110,253,.25)'"
                    onblur="this.style.borderColor='#ccc'; this.style.boxShadow='none'"
                    {{ Auth::id() == $user->id ? 'disabled' : '' }}>
                <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Khách hàng (Chỉ mua sắm)</option>
                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Quản trị viên (Toàn quyền Admin)</option>
            </select>

            @if(Auth::id() == $user->id)
                <div style="color: #dc3545; font-size: 13px; margin-top: 8px; display: flex; align-items: center; gap: 5px;">
                    <i class="bi bi-exclamation-circle"></i> Bạn không thể tự thay đổi quyền hạn của chính mình.
                </div>
                <input type="hidden" name="role" value="{{ $user->role }}">
            @endif
        </div>

        {{-- Nút bấm --}}
        <div style="border-top: 1px solid #eee; padding-top: 20px; display: flex; gap: 10px;">
            <button type="submit" 
                    style="background: #0d6efd; color: #fff; border: 1px solid #0d6efd; padding: 8px 20px; border-radius: 4px; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;"
                    onmouseover="this.style.background='#0b5ed7'; this.style.borderColor='#0a58ca'" 
                    onmouseout="this.style.background='#0d6efd'; this.style.borderColor='#0d6efd'">
                <i class="bi bi-save"></i> Lưu cập nhật
            </button>
            
            <a href="{{ route('admin.users.index') }}" 
               style="background: #fff; color: #6c757d; border: 1px solid #ccc; padding: 8px 20px; border-radius: 4px; font-weight: 500; font-size: 14px; text-decoration: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;"
               onmouseover="this.style.background='#f8f9fa'; this.style.color='#5c636a'" 
               onmouseout="this.style.background='#fff'; this.style.color='#6c757d'">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>

@endsection