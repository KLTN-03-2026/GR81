<?php
// app/Models/NguoiDung.php
// Model người dùng - kế thừa Authenticatable để dùng Auth của Laravel

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class NguoiDung extends Authenticatable
{
    // Tên bảng trong database
    protected $table = 'nguoi_dung';

    // Tên cột thời gian tùy chỉnh
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';

    // Cho Laravel biết cột password tên khác
    public function getAuthPasswordName()
    {
        return 'mat_khau';
    }

    // Các cột được phép gán hàng loạt
    protected $fillable = [
        'ho_ten', 'email', 'mat_khau',
        'ngay_sinh', 'gioi_tinh', 'so_dien_thoai',
        'anh_dai_dien', 'vai_tro', 'trang_thai',
    ];

    // Ẩn cột khi chuyển JSON
    protected $hidden = ['mat_khau', 'remember_token'];

    // === QUAN HỆ ===

    // 1 người dùng có nhiều lần test
    public function ketQuaTests()
    {
        return $this->hasMany(KetQuaTest::class, 'nguoi_dung_id');
    }

    // 1 người dùng có 1 bộ sở thích/kỹ năng
    public function soThichKyNang()
    {
        return $this->hasOne(SoThichKyNang::class, 'nguoi_dung_id');
    }

    // === HELPER ===

    // Kiểm tra admin
    public function laAdmin()
    {
        return $this->vai_tro === 'admin';
    }

    // Lấy kết quả test mới nhất
    public function ketQuaMoiNhat()
    {
        return $this->ketQuaTests()->orderBy('tao_luc', 'desc')->first();
    }
}
