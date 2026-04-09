<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetQuaTest extends Model
{
    protected $table = 'ket_qua_test';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = null;

    protected $fillable = [
        'nguoi_dung_id', 'kieu_mbti',
        'diem_e', 'diem_i', 'diem_s', 'diem_n',
        'diem_t', 'diem_f', 'diem_j', 'diem_p',
        'phan_tram_e', 'phan_tram_i', 'phan_tram_s', 'phan_tram_n',
        'phan_tram_t', 'phan_tram_f', 'phan_tram_j', 'phan_tram_p',
    ];

    protected $casts = ['tao_luc' => 'datetime'];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function chiTietTraLoi()
    {
        return $this->hasMany(ChiTietTraLoi::class, 'ket_qua_test_id');
    }

    // Lấy thông tin kiểu MBTI chi tiết
    public function layKieuMbti()
    {
        return KieuMbti::where('ma_kieu', $this->kieu_mbti)->first();
    }
}
