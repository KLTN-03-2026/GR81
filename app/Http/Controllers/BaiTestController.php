<?php
// Controller bài test MBTI
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CauHoi;
use App\Models\KetQuaTest;
use App\Models\ChiTietTraLoi;
use App\Services\MbtiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BaiTestController extends Controller
{
    public function gioiThieu()
    {
        $tongCauHoi = CauHoi::hoatDong()->count();
        return view('user.bai-test.gioi-thieu', compact('tongCauHoi'));
    }

    public function lamBai()
    {
        $cauHoi = CauHoi::hoatDong()->orderBy('thu_tu')->get();
        return view('user.bai-test.lam-bai', compact('cauHoi'));
    }

    public function nopBai(Request $request)
    {
        $request->validate([
            'tra_loi' => 'required|array',
            'tra_loi.*.cau_hoi_id' => 'required|exists:cau_hoi,id',
            'tra_loi.*.lua_chon' => 'required|in:A,B',
        ]);

        $mbtiService = new MbtiService();
        $ketQua = $mbtiService->tinhKetQua($request->tra_loi);

        DB::beginTransaction();
        try {
            // Lưu kết quả test
            $ketQuaTest = KetQuaTest::create([
                'nguoi_dung_id' => Auth::id(),
                'kieu_mbti' => $ketQua['kieu_mbti'],
                'diem_e' => $ketQua['diem']['E'], 'diem_i' => $ketQua['diem']['I'],
                'diem_s' => $ketQua['diem']['S'], 'diem_n' => $ketQua['diem']['N'],
                'diem_t' => $ketQua['diem']['T'], 'diem_f' => $ketQua['diem']['F'],
                'diem_j' => $ketQua['diem']['J'], 'diem_p' => $ketQua['diem']['P'],
                'phan_tram_e' => $ketQua['phan_tram']['e'], 'phan_tram_i' => $ketQua['phan_tram']['i'],
                'phan_tram_s' => $ketQua['phan_tram']['s'], 'phan_tram_n' => $ketQua['phan_tram']['n'],
                'phan_tram_t' => $ketQua['phan_tram']['t'], 'phan_tram_f' => $ketQua['phan_tram']['f'],
                'phan_tram_j' => $ketQua['phan_tram']['j'], 'phan_tram_p' => $ketQua['phan_tram']['p'],
            ]);

            // Lưu chi tiết từng câu trả lời
            foreach ($ketQua['chi_tiet'] as $ct) {
                ChiTietTraLoi::create([
                    'ket_qua_test_id' => $ketQuaTest->id,
                    'cau_hoi_id' => $ct['cau_hoi_id'],
                    'lua_chon' => $ct['lua_chon'],
                    'chieu_duoc_chon' => $ct['chieu_duoc_chon'],
                ]);
            }

            DB::commit();
            $url = route('ket-qua', $ketQuaTest->id);
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect' => $url]);
            }
            return redirect($url);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Có lỗi xảy ra!'], 500);
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }
}
