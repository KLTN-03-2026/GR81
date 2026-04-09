<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgheNghiep extends Model
{
    protected $table = 'nghe_nghiep';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';

    protected $fillable = [
        'ten_nghe', 'mo_ta', 'ky_nang_can_thiet',
        'muc_luong_min', 'muc_luong_max', 'trien_vong',
        'moi_truong_lam_viec', 'linh_vuc_id', 'hinh_anh', 'trang_thai',
    ];

    public function linhVuc()
    {
        return $this->belongsTo(LinhVuc::class, 'linh_vuc_id');
    }

    public function kieuMbti()
    {
        return $this->belongsToMany(KieuMbti::class, 'nghe_nghiep_mbti', 'nghe_nghiep_id', 'kieu_mbti_id')
            ->withPivot('muc_do_phu_hop');
    }

    public function scopeHienThi($query)
    {
        return $query->where('trang_thai', 'hien');
    }
}
