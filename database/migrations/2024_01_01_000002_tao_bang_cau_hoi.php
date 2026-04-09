<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng cau_hoi - lưu câu hỏi MBTI
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cau_hoi', function (Blueprint $table) {
            $table->id();
            $table->text('noi_dung');
            $table->string('lua_chon_a', 500);
            $table->string('lua_chon_b', 500);
            $table->char('chieu_a', 1);         // E, S, T, J
            $table->char('chieu_b', 1);         // I, N, F, P
            $table->enum('nhom_chieu', ['EI', 'SN', 'TF', 'JP']);
            $table->integer('thu_tu')->default(0);
            $table->enum('trang_thai', ['hoat_dong', 'ngung'])->default('hoat_dong');
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cau_hoi');
    }
};
