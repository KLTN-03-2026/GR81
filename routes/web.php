<?php
// routes/web.php - Định nghĩa tất cả routes

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DangKyController;
use App\Http\Controllers\Auth\DangNhapController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\BaiTestController;
use App\Http\Controllers\KetQuaController;
use App\Http\Controllers\HoSoController;
use App\Http\Controllers\GoiYNgheNghiepController;
use App\Http\Controllers\Admin\AdminController;

// ==============================
// TRANG CHỦ - Landing / Dashboard
// ==============================
Route::get('/', function () {
    if (auth()->check()) {
        return app(TrangChuController::class)->index();
    }
    return view('landing');
})->name('trang-chu');

// ==============================
// ROUTES KHÁCH (chưa đăng nhập)
// ==============================
Route::middleware('guest')->group(function () {
    Route::get('/dang-ky', [DangKyController::class, 'showForm'])->name('dang-ky');
    Route::post('/dang-ky', [DangKyController::class, 'dangKy']);

    Route::get('/dang-nhap', [DangNhapController::class, 'showForm'])->name('dang-nhap');
    Route::post('/dang-nhap', [DangNhapController::class, 'dangNhap']);
});

// ============================================
// ROUTES NGƯỜI DÙNG (cần đăng nhập)
// ============================================
Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [DangNhapController::class, 'dangXuat'])->name('dang-xuat');

    // Hồ sơ cá nhân
    Route::get('/ho-so', [HoSoController::class, 'index'])->name('ho-so');
    Route::put('/ho-so', [HoSoController::class, 'capNhat'])->name('ho-so.cap-nhat');
    Route::put('/doi-mat-khau', [HoSoController::class, 'doiMatKhau'])->name('doi-mat-khau');
    Route::post('/so-thich-ky-nang', [HoSoController::class, 'luuSoThich'])->name('so-thich.luu');

    // Bài test MBTI
    Route::get('/bai-test', [BaiTestController::class, 'gioiThieu'])->name('bai-test');
    Route::get('/bai-test/lam-bai', [BaiTestController::class, 'lamBai'])->name('bai-test.lam-bai');
    Route::post('/bai-test/nop-bai', [BaiTestController::class, 'nopBai'])->name('bai-test.nop-bai');

    // Kết quả test
    Route::get('/ket-qua/{id}', [KetQuaController::class, 'hienThi'])->name('ket-qua');
    Route::get('/lich-su-test', [KetQuaController::class, 'lichSu'])->name('lich-su-test');

    // Gợi ý nghề nghiệp (AI)
    Route::get('/goi-y-nghe-nghiep', [GoiYNgheNghiepController::class, 'index'])->name('goi-y');
    Route::post('/goi-y-nghe-nghiep/phan-tich', [GoiYNgheNghiepController::class, 'phanTich'])->name('goi-y.phan-tich');
});

// ============================================
// ROUTES ADMIN (cần đăng nhập + quyền admin)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Quản lý người dùng
    Route::get('/nguoi-dung', [AdminController::class, 'danhSachNguoiDung'])->name('admin.nguoi-dung');
    Route::put('/nguoi-dung/{id}/khoa', [AdminController::class, 'khoaTaiKhoan'])->name('admin.nguoi-dung.khoa');
    Route::delete('/nguoi-dung/{id}', [AdminController::class, 'xoaNguoiDung'])->name('admin.nguoi-dung.xoa');

    // Quản lý câu hỏi
    Route::get('/cau-hoi', [AdminController::class, 'danhSachCauHoi'])->name('admin.cau-hoi');
    Route::get('/cau-hoi/them', [AdminController::class, 'themCauHoiForm'])->name('admin.cau-hoi.them');
    Route::post('/cau-hoi', [AdminController::class, 'themCauHoi'])->name('admin.cau-hoi.luu');
    Route::get('/cau-hoi/{id}/sua', [AdminController::class, 'suaCauHoiForm'])->name('admin.cau-hoi.sua');
    Route::put('/cau-hoi/{id}', [AdminController::class, 'suaCauHoi'])->name('admin.cau-hoi.cap-nhat');
    Route::delete('/cau-hoi/{id}', [AdminController::class, 'xoaCauHoi'])->name('admin.cau-hoi.xoa');

    // Quản lý nghề nghiệp
    Route::get('/nghe-nghiep', [AdminController::class, 'danhSachNgheNghiep'])->name('admin.nghe-nghiep');
    Route::get('/nghe-nghiep/them', [AdminController::class, 'themNgheNghiepForm'])->name('admin.nghe-nghiep.them');
    Route::post('/nghe-nghiep', [AdminController::class, 'themNgheNghiep'])->name('admin.nghe-nghiep.luu');
    Route::get('/nghe-nghiep/{id}/sua', [AdminController::class, 'suaNgheNghiepForm'])->name('admin.nghe-nghiep.sua');
    Route::put('/nghe-nghiep/{id}', [AdminController::class, 'suaNgheNghiep'])->name('admin.nghe-nghiep.cap-nhat');
    Route::delete('/nghe-nghiep/{id}', [AdminController::class, 'xoaNgheNghiep'])->name('admin.nghe-nghiep.xoa');

    // Thống kê
    Route::get('/thong-ke', [AdminController::class, 'thongKe'])->name('admin.thong-ke');
});
