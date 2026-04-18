<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng dat_lai_mat_khau - lưu token khôi phục mật khẩu
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dat_lai_mat_khau', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('token', 255);
            $table->timestamp('tao_luc')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dat_lai_mat_khau');
    }
};
