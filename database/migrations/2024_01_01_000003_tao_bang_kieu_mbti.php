<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng kieu_mbti - lưu 16 kiểu MBTI
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kieu_mbti', function (Blueprint $table) {
            $table->id();
            $table->char('ma_kieu', 4)->unique();
            $table->string('ten_goi', 100);
            $table->text('mo_ta_chung');
            $table->text('diem_manh')->nullable();
            $table->text('diem_yeu')->nullable();
            $table->text('phong_cach_lam_viec')->nullable();
            $table->text('moi_truong_phu_hop')->nullable();
            $table->text('nguoi_noi_tieng')->nullable();
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kieu_mbti');
    }
};
