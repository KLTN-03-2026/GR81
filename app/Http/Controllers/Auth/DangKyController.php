<?php
// Controller đăng ký tài khoản
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DangKyController extends Controller
{
    // Hiển thị form đăng ký
    public function showForm()
    {
        return view('auth.dang-ky');
    }

    // Xử lý đăng ký
    public function dangKy(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|min:2|max:100',
            'email' => 'required|email|unique:nguoi_dung,email',
            'mat_khau' => 'required|min:8|confirmed',
        ], [
            'ho_ten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã được sử dụng',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu',
            'mat_khau.min' => 'Mật khẩu tối thiểu 8 ký tự',
            'mat_khau.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        $nguoiDung = NguoiDung::create([
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'mat_khau' => Hash::make($request->mat_khau),
        ]);

        Auth::login($nguoiDung);
        return redirect('/')->with('success', 'Đăng ký thành công! Chào mừng bạn.');
    }
}
