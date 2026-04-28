<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoThichKyNang extends Model
{
    protected $table = 'so_thich_ky_nang';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';

    protected $fillable = [
        'nguoi_dung_id', 'so_thich', 'ky_nang',
        'trinh_do_hoc_van', 'linh_vuc_quan_tam',
        'kinh_nghiem', 'muc_tieu',
    ];
}
