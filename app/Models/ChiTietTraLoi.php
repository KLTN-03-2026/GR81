<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietTraLoi extends Model
{
    protected $table = 'chi_tiet_tra_loi';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = null;

    protected $fillable = [
        'ket_qua_test_id', 'cau_hoi_id', 'lua_chon', 'chieu_duoc_chon',
    ];
}
