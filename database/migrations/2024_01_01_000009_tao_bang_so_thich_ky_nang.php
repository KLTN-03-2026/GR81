<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng so_thich_ky_nang
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('so_thich_ky_nang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->cascadeOnDelete();
            $table->text('so_thich')->nullable();
            $table->text('ky_nang')->nullable();
            $table->string('trinh_do_hoc_van', 50)->nullable();
            $table->text('linh_vuc_quan_tam')->nullable();
            $table->text('kinh_nghiem')->nullable();
            $table->text('muc_tieu')->nullable();
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('so_thich_ky_nang');
    }
};
