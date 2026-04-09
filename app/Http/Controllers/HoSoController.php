<?php
// Controller hồ sơ & sở thích kỹ năng
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoThichKyNang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HoSoController extends Controller
{
    // Xem hồ sơ
    public function index()
    {
        $nguoiDung = Auth::user();
        $soThich = SoThichKyNang::where('nguoi_dung_id', $nguoiDung->id)->first();
        return view('user.ho-so', compact('nguoiDung', 'soThich'));
    }

    // Cập nhật hồ sơ
    public function capNhat(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|min:2|max:100',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'nullable|in:nam,nu,khac',
            'so_dien_thoai' => 'nullable|max:15',
        ]);

        $nguoiDung = Auth::user();
        $nguoiDung->update($request->only('ho_ten', 'ngay_sinh', 'gioi_tinh', 'so_dien_thoai'));

        return back()->with('success', 'Cập nhật hồ sơ thành công!');
    }

    // Đổi mật khẩu
    public function doiMatKhau(Request $request)
    {
        $request->validate([
            'mat_khau_cu' => 'required',
            'mat_khau' => 'required|min:8|confirmed',
        ], [
            'mat_khau_cu.required' => 'Nhập mật khẩu hiện tại',
            'mat_khau.min' => 'Mật khẩu mới tối thiểu 8 ký tự',
            'mat_khau.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        $nguoiDung = Auth::user();
        if (!Hash::check($request->mat_khau_cu, $nguoiDung->mat_khau)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        $nguoiDung->update(['mat_khau' => Hash::make($request->mat_khau)]);
        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Lưu sở thích kỹ năng
    public function luuSoThich(Request $request)
    {
        $nguoiDung = Auth::user();

        SoThichKyNang::updateOrCreate(
            ['nguoi_dung_id' => $nguoiDung->id],
            $request->only('so_thich', 'ky_nang', 'trinh_do_hoc_van', 'linh_vuc_quan_tam', 'kinh_nghiem', 'muc_tieu')
        );

        return back()->with('success', 'Lưu thông tin thành công!');
    }
}
