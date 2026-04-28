<?php
// Controller quên mật khẩu / đặt lại mật khẩu
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\DatLaiMatKhauMail;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QuenMatKhauController extends Controller
{
    // Hiển thị form nhập email
    public function showForm()
    {
        return view('auth.quen-mat-khau');
    }

    // Gửi email chứa link đặt lại mật khẩu
    public function guiEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
        ]);

        $nguoiDung = NguoiDung::where('email', $request->email)->first();

        if (!$nguoiDung) {
            return back()->with('error', 'Email không tồn tại trong hệ thống!');
        }

        // Xóa token cũ nếu có
        DB::table('dat_lai_mat_khau')->where('email', $request->email)->delete();

        // Tạo token mới
        $token = Str::random(64);

        DB::table('dat_lai_mat_khau')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'tao_luc' => Carbon::now(),
        ]);

        // Tạo link đặt lại mật khẩu
        $resetUrl = url('/dat-lai-mat-khau/' . $token . '?email=' . urlencode($request->email));

        // Gửi email
        Mail::to($request->email)->send(new DatLaiMatKhauMail($resetUrl, $nguoiDung->ho_ten));

        return back()->with('success', 'Đã gửi link đặt lại mật khẩu đến email của bạn! Vui lòng kiểm tra hộp thư.');
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetForm(Request $request, $token)
    {
        return view('auth.dat-lai-mat-khau', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // Xử lý đặt lại mật khẩu
    public function datLai(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'mat_khau' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email là bắt buộc',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu mới',
            'mat_khau.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'mat_khau.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        // Tìm token trong database
        $record = DB::table('dat_lai_mat_khau')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->with('error', 'Link đặt lại mật khẩu không hợp lệ!');
        }

        // Kiểm tra token hợp lệ
        if (!Hash::check($request->token, $record->token)) {
            return back()->with('error', 'Link đặt lại mật khẩu không hợp lệ!');
        }

        // Kiểm tra token hết hạn (60 phút)
        if (Carbon::parse($record->tao_luc)->addMinutes(60)->isPast()) {
            DB::table('dat_lai_mat_khau')->where('email', $request->email)->delete();
            return back()->with('error', 'Link đặt lại mật khẩu đã hết hạn! Vui lòng yêu cầu lại.');
        }

        // Cập nhật mật khẩu
        NguoiDung::where('email', $request->email)->update([
            'mat_khau' => Hash::make($request->mat_khau),
        ]);

        // Xóa token đã sử dụng
        DB::table('dat_lai_mat_khau')->where('email', $request->email)->delete();

        return redirect('/dang-nhap')->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập.');
    }
}
