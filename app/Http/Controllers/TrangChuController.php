<?php
// Controller trang chủ
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\KieuMbti;

class TrangChuController extends Controller
{
    public function index()
    {
        $nguoiDung = Auth::user();
        $ketQuaMoiNhat = $nguoiDung->ketQuaMoiNhat();
        $kieuMbti = null;

        if ($ketQuaMoiNhat) {
            $kieuMbti = KieuMbti::where('ma_kieu', $ketQuaMoiNhat->kieu_mbti)->first();
        }

        $danhSachKieu = KieuMbti::all();

        return view('user.trang-chu', compact('nguoiDung', 'ketQuaMoiNhat', 'kieuMbti', 'danhSachKieu'));
    }
}
