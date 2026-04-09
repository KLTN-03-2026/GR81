<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng chi_tiet_tra_loi - chi tiết từng câu trả lời
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_tra_loi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ket_qua_test_id')->constrained('ket_qua_test')->cascadeOnDelete();
            $table->foreignId('cau_hoi_id')->constrained('cau_hoi')->cascadeOnDelete();
            $table->enum('lua_chon', ['A', 'B']);
            $table->char('chieu_duoc_chon', 1);
            $table->timestamp('tao_luc')->useCurrent();
            $table->unique(['ket_qua_test_id', 'cau_hoi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_tra_loi');
    }
};
