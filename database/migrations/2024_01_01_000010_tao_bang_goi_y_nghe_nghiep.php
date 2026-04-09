<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng goi_y_nghe_nghiep - kết quả gợi ý từ AI
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goi_y_nghe_nghiep', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->cascadeOnDelete();
            $table->foreignId('ket_qua_test_id')->constrained('ket_qua_test')->cascadeOnDelete();
            $table->json('noi_dung_goi_y');
            $table->text('prompt_da_gui')->nullable();
            $table->text('phan_hoi_ai')->nullable();
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goi_y_nghe_nghiep');
    }
};
