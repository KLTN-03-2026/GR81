<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng nghe_nghiep_mbti - bảng trung gian N-N
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nghe_nghiep_mbti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nghe_nghiep_id')->constrained('nghe_nghiep')->cascadeOnDelete();
            $table->foreignId('kieu_mbti_id')->constrained('kieu_mbti')->cascadeOnDelete();
            $table->enum('muc_do_phu_hop', ['rat_cao', 'cao', 'trung_binh'])->default('cao');
            $table->unique(['nghe_nghiep_id', 'kieu_mbti_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nghe_nghiep_mbti');
    }
};
