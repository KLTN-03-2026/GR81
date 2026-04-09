<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoiYNgheNghiep extends Model
{
    protected $table = 'goi_y_nghe_nghiep';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';

    protected $fillable = [
        'nguoi_dung_id', 'ket_qua_test_id',
        'noi_dung_goi_y', 'prompt_da_gui', 'phan_hoi_ai',
    ];

    protected $casts = ['noi_dung_goi_y' => 'array'];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
