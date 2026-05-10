<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinhVuc extends Model
{
    protected $table = 'linh_vuc';
    const CREATED_AT = 'tao_luc';
    const UPDATED_AT = 'cap_nhat_luc';
    protected $fillable = ['ten_linh_vuc', 'mo_ta'];
}
