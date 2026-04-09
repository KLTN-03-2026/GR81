<?php
// Controller xem kết quả test
namespace App\Http\Controllers;

use App\Models\KetQuaTest;
use App\Models\KieuMbti;
use Illuminate\Support\Facades\Auth;

class KetQuaController extends Controller
{
    public function hienThi($id)
    {
        $ketQua = KetQuaTest::where('id', $id)
            ->where('nguoi_dung_id', Auth::id())
            ->firstOrFail();

        $kieuMbti = KieuMbti::where('ma_kieu', $ketQua->kieu_mbti)->first();

        // Lấy nghề phù hợp từ DB
        $ngheGoi = [];
        if ($kieuMbti) {
            $ngheGoi = $kieuMbti->ngheNghiep()->limit(5)->get();
        }

        return view('user.ket-qua.hien-thi', compact('ketQua', 'kieuMbti', 'ngheGoi'));
    }

    // Lịch sử test
    public function lichSu()
    {
        $danhSach = KetQuaTest::where('nguoi_dung_id', Auth::id())
            ->orderBy('tao_luc', 'desc')
            ->paginate(10);
        return view('user.ket-qua.lich-su', compact('danhSach'));
    }
}
