<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng nguoi_dung - lưu thông tin tài khoản
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 100);
            $table->string('email', 255)->unique();
            $table->string('mat_khau', 255);
            $table->date('ngay_sinh')->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->string('so_dien_thoai', 15)->nullable();
            $table->string('anh_dai_dien', 255)->nullable();
            $table->enum('vai_tro', ['user', 'admin'])->default('user');
            $table->enum('trang_thai', ['hoat_dong', 'bi_khoa'])->default('hoat_dong');
            $table->rememberToken();
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung');
    }
};
