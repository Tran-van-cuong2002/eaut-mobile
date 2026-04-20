<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Danh sách người dùng
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // 2. Giao diện chỉnh sửa quyền
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 3. Cập nhật quyền (Role)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:0,1' // 0: Khách hàng, 1: Admin
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Đã cập nhật quyền cho tài khoản: ' . $user->name);
    }

    // 4. Xóa tài khoản
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Tránh việc Admin tự xóa chính mình
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công!');
    }
}