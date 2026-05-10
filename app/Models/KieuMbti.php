<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KieuMbti extends Model
{
    protected $table = 'kieu_mbti';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';

    protected $fillable = [
        'ma_kieu', 'ten_goi', 'mo_ta_chung',
        'diem_manh', 'diem_yeu', 'phong_cach_lam_viec',
        'moi_truong_phu_hop', 'nguoi_noi_tieng',
    ];

    public function ngheNghiep()
    {
        return $this->belongsToMany(NgheNghiep::class, 'nghe_nghiep_mbti', 'kieu_mbti_id', 'nghe_nghiep_id')
            ->withPivot('muc_do_phu_hop');
    }
}
