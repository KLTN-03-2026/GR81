<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng phan_tich_cv - kết quả phân tích CV
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phan_tich_cv', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->cascadeOnDelete();
            $table->string('ten_file', 255)->nullable();
            $table->text('noi_dung_cv')->nullable();
            $table->json('ket_qua_phan_tich')->nullable();
            $table->text('phan_hoi_ai')->nullable();
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phan_tich_cv');
    }
};
