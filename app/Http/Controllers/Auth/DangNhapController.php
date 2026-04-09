<?php
// Controller đăng nhập / đăng xuất
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DangNhapController extends Controller
{
    public function showForm()
    {
        return view('auth.dang-nhap');
    }

    public function dangNhap(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mat_khau' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu',
        ]);

        // Laravel dùng key 'password' rồi tự map qua getAuthPasswordName()
        $credentials = [
            'email' => $request->email,
            'password' => $request->mat_khau,
        ];

        if (Auth::attempt($credentials, $request->filled('ghi_nho'))) {
            $request->session()->regenerate();

            // Kiểm tra tài khoản bị khóa
            if (Auth::user()->trang_thai === 'bi_khoa') {
                Auth::logout();
                return back()->with('error', 'Tài khoản đã bị khóa!');
            }

            // Phân quyền: admin → dashboard, user → trang chủ
            if (Auth::user()->vai_tro === 'admin') {
                return redirect('/admin');
            }
            return redirect('/');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function dangXuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/dang-nhap');
    }
}
