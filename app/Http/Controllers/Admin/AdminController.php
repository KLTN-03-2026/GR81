<?php
// Controller Admin Dashboard + Quản lý
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use App\Models\KetQuaTest;
use App\Models\CauHoi;
use App\Models\NgheNghiep;
use App\Models\LinhVuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // === DASHBOARD ===
    public function dashboard()
    {
        $tongNguoiDung = NguoiDung::where('vai_tro', 'user')->count();
        $tongTest = KetQuaTest::count();
        $tongCauHoi = CauHoi::count();
        $tongNghe = NgheNghiep::count();

        // Phân bố MBTI (biểu đồ)
        $phanBoMbti = KetQuaTest::select('kieu_mbti', DB::raw('count(*) as so_luong'))
            ->groupBy('kieu_mbti')
            ->orderBy('so_luong', 'desc')
            ->get();

        // Người dùng mới nhất
        $nguoiDungMoi = NguoiDung::where('vai_tro', 'user')
            ->orderBy('tao_luc', 'desc')
            ->limit(5)->get();

        return view('admin.dashboard', compact(
            'tongNguoiDung', 'tongTest', 'tongCauHoi', 'tongNghe',
            'phanBoMbti', 'nguoiDungMoi'
        ));
    }

    // === QUẢN LÝ NGƯỜI DÙNG ===
    public function danhSachNguoiDung(Request $request)
    {
        $query = NguoiDung::where('vai_tro', 'user');
        if ($request->filled('tim_kiem')) {
            $query->where(function($q) use ($request) {
                $q->where('ho_ten', 'like', '%'.$request->tim_kiem.'%')
                  ->orWhere('email', 'like', '%'.$request->tim_kiem.'%');
            });
        }
        $nguoiDung = $query->orderBy('tao_luc', 'desc')->paginate(15);
        return view('admin.nguoi-dung', compact('nguoiDung'));
    }

    public function khoaTaiKhoan($id)
    {
        $user = NguoiDung::findOrFail($id);
        $user->trang_thai = ($user->trang_thai === 'hoat_dong') ? 'bi_khoa' : 'hoat_dong';
        $user->save();
        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function xoaNguoiDung($id)
    {
        NguoiDung::findOrFail($id)->delete();
        return back()->with('success', 'Xóa người dùng thành công!');
    }

    // === QUẢN LÝ CÂU HỎI ===
    public function danhSachCauHoi(Request $request)
    {
        $query = CauHoi::query();
        if ($request->filled('nhom_chieu')) {
            $query->where('nhom_chieu', $request->nhom_chieu);
        }
        $cauHoi = $query->orderBy('thu_tu')->paginate(15);
        return view('admin.cau-hoi.danh-sach', compact('cauHoi'));
    }

    public function themCauHoiForm()
    {
        return view('admin.cau-hoi.them');
    }

    public function themCauHoi(Request $request)
    {
        $request->validate([
            'noi_dung' => 'required',
            'lua_chon_a' => 'required',
            'lua_chon_b' => 'required',
            'nhom_chieu' => 'required|in:EI,SN,TF,JP',
        ]);

        // Tự động xác định chiều A và B
        $chieuMap = ['EI' => ['E','I'], 'SN' => ['S','N'], 'TF' => ['T','F'], 'JP' => ['J','P']];
        $chieu = $chieuMap[$request->nhom_chieu];

        CauHoi::create([
            'noi_dung' => $request->noi_dung,
            'lua_chon_a' => $request->lua_chon_a,
            'lua_chon_b' => $request->lua_chon_b,
            'chieu_a' => $chieu[0],
            'chieu_b' => $chieu[1],
            'nhom_chieu' => $request->nhom_chieu,
            'thu_tu' => $request->thu_tu ?? CauHoi::max('thu_tu') + 1,
            'trang_thai' => $request->trang_thai ?? 'hoat_dong',
        ]);

        return redirect('/admin/cau-hoi')->with('success', 'Thêm câu hỏi thành công!');
    }

    public function suaCauHoiForm($id)
    {
        $cauHoi = CauHoi::findOrFail($id);
        return view('admin.cau-hoi.sua', compact('cauHoi'));
    }

    public function suaCauHoi(Request $request, $id)
    {
        $cauHoi = CauHoi::findOrFail($id);
        $chieuMap = ['EI' => ['E','I'], 'SN' => ['S','N'], 'TF' => ['T','F'], 'JP' => ['J','P']];
        $chieu = $chieuMap[$request->nhom_chieu];

        $cauHoi->update([
            'noi_dung' => $request->noi_dung,
            'lua_chon_a' => $request->lua_chon_a,
            'lua_chon_b' => $request->lua_chon_b,
            'chieu_a' => $chieu[0],
            'chieu_b' => $chieu[1],
            'nhom_chieu' => $request->nhom_chieu,
            'thu_tu' => $request->thu_tu,
            'trang_thai' => $request->trang_thai,
        ]);

        return redirect('/admin/cau-hoi')->with('success', 'Cập nhật câu hỏi thành công!');
    }

    public function xoaCauHoi($id)
    {
        CauHoi::findOrFail($id)->delete();
        return back()->with('success', 'Xóa câu hỏi thành công!');
    }

    // === QUẢN LÝ NGHỀ NGHIỆP ===
    public function danhSachNgheNghiep()
    {
        $ngheNghiep = NgheNghiep::with('linhVuc')->orderBy('ten_nghe')->paginate(15);
        return view('admin.nghe-nghiep.danh-sach', compact('ngheNghiep'));
    }

    public function themNgheNghiepForm()
    {
        $linhVuc = LinhVuc::all();
        return view('admin.nghe-nghiep.them', compact('linhVuc'));
    }

    public function themNgheNghiep(Request $request)
    {
        $request->validate(['ten_nghe' => 'required|max:200']);

        NgheNghiep::create($request->only(
            'ten_nghe', 'mo_ta', 'ky_nang_can_thiet', 'muc_luong_min',
            'muc_luong_max', 'trien_vong', 'moi_truong_lam_viec', 'linh_vuc_id'
        ));

        return redirect('/admin/nghe-nghiep')->with('success', 'Thêm nghề nghiệp thành công!');
    }

    public function suaNgheNghiepForm($id)
    {
        $ngheNghiep = NgheNghiep::findOrFail($id);
        $linhVuc = LinhVuc::all();
        return view('admin.nghe-nghiep.sua', compact('ngheNghiep', 'linhVuc'));
    }

    public function suaNgheNghiep(Request $request, $id)
    {
        NgheNghiep::findOrFail($id)->update($request->only(
            'ten_nghe', 'mo_ta', 'ky_nang_can_thiet', 'muc_luong_min',
            'muc_luong_max', 'trien_vong', 'moi_truong_lam_viec', 'linh_vuc_id', 'trang_thai'
        ));
        return redirect('/admin/nghe-nghiep')->with('success', 'Cập nhật thành công!');
    }

    public function xoaNgheNghiep($id)
    {
        NgheNghiep::findOrFail($id)->delete();
        return back()->with('success', 'Xóa nghề nghiệp thành công!');
    }

    // === THỐNG KÊ ===
    public function thongKe()
    {
        $phanBoMbti = KetQuaTest::select('kieu_mbti', DB::raw('count(*) as so_luong'))
            ->groupBy('kieu_mbti')->orderBy('so_luong', 'desc')->get();

        $testTheoThang = KetQuaTest::select(
            DB::raw('MONTH(tao_luc) as thang'),
            DB::raw('YEAR(tao_luc) as nam'),
            DB::raw('count(*) as so_luong')
        )->groupBy('thang', 'nam')->orderBy('nam')->orderBy('thang')->limit(12)->get();

        return view('admin.thong-ke', compact('phanBoMbti', 'testTheoThang'));
    }
}
