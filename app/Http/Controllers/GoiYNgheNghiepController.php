<?php
// Controller gợi ý nghề nghiệp bằng AI
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KetQuaTest;
use App\Models\SoThichKyNang;
use App\Models\GoiYNgheNghiep;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Auth;

class GoiYNgheNghiepController extends Controller
{
    public function index()
    {
        $nguoiDung = Auth::user();
        $ketQua = $nguoiDung->ketQuaMoiNhat();

        if (!$ketQua) {
            return redirect('/bai-test')->with('warning', 'Hãy làm bài test MBTI trước!');
        }

        $soThich = SoThichKyNang::where('nguoi_dung_id', $nguoiDung->id)->first();

        // Lấy gợi ý đã lưu (nếu có)
        $goiYDaLuu = GoiYNgheNghiep::where('nguoi_dung_id', $nguoiDung->id)
            ->where('ket_qua_test_id', $ketQua->id)
            ->orderBy('tao_luc', 'desc')
            ->first();

        return view('user.goi-y-nghe-nghiep', compact('ketQua', 'soThich', 'goiYDaLuu'));
    }

    // Gọi AI phân tích
    public function phanTich(Request $request)
    {
        $nguoiDung = Auth::user();
        $ketQua = $nguoiDung->ketQuaMoiNhat();

        if (!$ketQua) {
            return back()->with('error', 'Chưa có kết quả MBTI!');
        }

        $phanTram = [
            'e' => $ketQua->phan_tram_e, 'i' => $ketQua->phan_tram_i,
            's' => $ketQua->phan_tram_s, 'n' => $ketQua->phan_tram_n,
            't' => $ketQua->phan_tram_t, 'f' => $ketQua->phan_tram_f,
            'j' => $ketQua->phan_tram_j, 'p' => $ketQua->phan_tram_p,
        ];

        $soThich = SoThichKyNang::where('nguoi_dung_id', $nguoiDung->id)->first();
        $thongTin = $soThich ? $soThich->toArray() : [];

        $gemini = new GeminiService();
        $ketQuaAI = $gemini->goiYNgheNghiep($ketQua->kieu_mbti, $phanTram, $thongTin);

        if (!$ketQuaAI) {
            return back()->with('error', 'Không thể kết nối AI. Vui lòng thử lại!');
        }

        GoiYNgheNghiep::create([
            'nguoi_dung_id' => $nguoiDung->id,
            'ket_qua_test_id' => $ketQua->id,
            'noi_dung_goi_y' => $ketQuaAI,
            'prompt_da_gui' => 'Gợi ý nghề nghiệp MBTI: ' . $ketQua->kieu_mbti,
            'phan_hoi_ai' => json_encode($ketQuaAI),
        ]);

        return redirect('/goi-y-nghe-nghiep')->with('success', 'AI đã phân tích xong!');
    }
}
