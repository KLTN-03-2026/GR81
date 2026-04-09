<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng ket_qua_test - kết quả từng lần test
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ket_qua_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->cascadeOnDelete();
            $table->char('kieu_mbti', 4);
            // Điểm số (số câu chọn)
            $table->integer('diem_e')->default(0);
            $table->integer('diem_i')->default(0);
            $table->integer('diem_s')->default(0);
            $table->integer('diem_n')->default(0);
            $table->integer('diem_t')->default(0);
            $table->integer('diem_f')->default(0);
            $table->integer('diem_j')->default(0);
            $table->integer('diem_p')->default(0);
            // Phần trăm
            $table->decimal('phan_tram_e', 5, 2)->default(0);
            $table->decimal('phan_tram_i', 5, 2)->default(0);
            $table->decimal('phan_tram_s', 5, 2)->default(0);
            $table->decimal('phan_tram_n', 5, 2)->default(0);
            $table->decimal('phan_tram_t', 5, 2)->default(0);
            $table->decimal('phan_tram_f', 5, 2)->default(0);
            $table->decimal('phan_tram_j', 5, 2)->default(0);
            $table->decimal('phan_tram_p', 5, 2)->default(0);
            $table->timestamp('tao_luc')->useCurrent();

            $table->index('nguoi_dung_id');
            $table->index('kieu_mbti');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ket_qua_test');
    }
};
