<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    protected $table = 'cau_hoi';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';

    protected $fillable = [
        'noi_dung', 'lua_chon_a', 'lua_chon_b',
        'chieu_a', 'chieu_b', 'nhom_chieu', 'thu_tu', 'trang_thai',
    ];

    // Scope: chỉ lấy câu hỏi đang hoạt động
    public function scopeHoatDong($query)
    {
        return $query->where('trang_thai', 'hoat_dong');
    }
}
