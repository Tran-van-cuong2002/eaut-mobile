<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Kiểm tra dữ liệu với thông báo lỗi tiếng Việt
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email của bạn!',
            'email.email'    => 'Định dạng email không hợp lệ (ví dụ: abc@gmail.com).',
            'email.exists'   => 'Email này chưa được đăng ký trong hệ thống!'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        return back()->with('success', 'Yêu cầu đã được gửi! Vui lòng kiểm tra hộp thư email của bạn để đặt lại mật khẩu.');
    }
}