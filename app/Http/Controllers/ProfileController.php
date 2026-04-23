<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Hiển thị trang form hồ sơ
    public function edit()
    {
        $user = Auth::user();
        return view('client.profile', compact('user'));
    }

    // Xử lý khi khách hàng bấm nút "Lưu thay đổi"
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // 1. Cập nhật tên ở bảng users
        $user->update(['name' => $request->name]);

        // 2. Cập nhật (hoặc tạo mới nếu chưa có) dữ liệu ở bảng profiles
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Tìm xem user này đã có profile chưa
            [
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]
        );

        return redirect('/')->with('success', 'Cập nhật hồ sơ thành công!');
    }
}

