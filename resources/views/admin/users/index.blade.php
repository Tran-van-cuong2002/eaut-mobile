@extends('layouts.admin')

@section('page-title', 'Quản lý Người dùng')

@section('content')

{{-- Thông báo Thành công --}}
@if(session('success'))
    <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #badbcc; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.style.display='none'" style="background: transparent; border: none; font-size: 20px; cursor: pointer; color: #0f5132;">&times;</button>
    </div>
@endif

{{-- Thông báo Lỗi (Thêm vào cho đồng bộ) --}}
@if(session('error'))
    <div style="background-color: #f8d7da; color: #842029; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c2c7; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
            <span style="font-weight: 500;">{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.style.display='none'" style="background: transparent; border: none; font-size: 20px; cursor: pointer; color: #842029;">&times;</button>
    </div>
@endif

<div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
    
    <div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: bold; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-people" style="color: #0d6efd; font-size: 18px;"></i> Danh sách tài khoản
        </h5>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #ddd; color: #555;">
                    <th style="padding: 12px 20px; width: 80px; font-weight: 600; text-align: center;">ID</th>
                    <th style="padding: 12px; font-weight: 600;">Người dùng</th>
                    <th style="padding: 12px; font-weight: 600;">Email</th>
                    <th style="padding: 12px; font-weight: 600; text-align: center;">Vai trò</th>
                    <th style="padding: 12px; font-weight: 600; text-align: center;">Ngày tham gia</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    
                    {{-- ID --}}
                    <td style="padding: 15px 20px; text-align: center; color: #0d6efd; font-weight: bold;">
                        #{{ $user->id }}
                    </td>
                    
                    {{-- Tên --}}
                    <td style="padding: 15px 12px;">
                        <div style="font-weight: bold; color: #333; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            {{ $user->name }}
                            @if(Auth::id() == $user->id)
                                <span style="background: #d1e7dd; color: #0f5132; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold;">Bạn</span>
                            @endif
                        </div>
                    </td>

                    {{-- Email --}}
                    <td style="padding: 15px 12px; color: #555;">
                        {{ $user->email }}
                    </td>

                    {{-- Vai trò (Style theo kiểu status đơn hàng) --}}
                    <td style="padding: 15px 12px; text-align: center;">
                        @if($user->role == 1)
                            <span style="background: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-shield-lock"></i> Quản trị viên
                            </span>
                        @else
                            <span style="background: #e2e3e5; color: #41464b; border: 1px solid #d3d6d8; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-person"></i> Khách hàng
                            </span>
                        @endif
                    </td>

                    {{-- Ngày tham gia --}}
                    <td style="padding: 15px 12px; text-align: center; color: #555;">
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                    </td>

                    {{-- Thao tác --}}
                    <td style="padding: 15px 12px; text-align: center;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" style="background: #fff; border: 1px solid #0d6efd; color: #0d6efd; padding: 6px 12px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; font-size: 13px; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#0d6efd'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='#0d6efd'">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                @if(Auth::id() == $user->id)
                                    <button type="button" disabled style="background: #f8f9fa; border: 1px solid #ddd; color: #adb5bd; padding: 6px 12px; border-radius: 4px; cursor: not-allowed; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; font-size: 13px; white-space: nowrap;" title="Không thể xóa chính mình">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                @else
                                    <button type="submit" style="background: #fff; border: 1px solid #dc3545; color: #dc3545; padding: 6px 12px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; font-size: 13px; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#dc3545'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='#dc3545'" onclick="return confirm('Xác nhận xóa tài khoản này?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                @endif
                            </form>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px 20px;">
                        <div style="color: #adb5bd; font-size: 60px; margin-bottom: 15px;">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5 style="margin: 0 0 10px 0; color: #333; font-weight: bold;">Chưa có người dùng nào</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #eee; background: #fff; display: flex; justify-content: flex-end;">
        {{ $users->links() }}
    </div>
    @endif

</div>

@endsection