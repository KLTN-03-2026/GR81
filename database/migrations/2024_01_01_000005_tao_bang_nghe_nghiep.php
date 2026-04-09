<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng nghe_nghiep - danh mục nghề nghiệp
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nghe_nghiep', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nghe', 200);
            $table->text('mo_ta')->nullable();
            $table->text('ky_nang_can_thiet')->nullable();
            $table->integer('muc_luong_min')->nullable();
            $table->integer('muc_luong_max')->nullable();
            $table->text('trien_vong')->nullable();
            $table->text('moi_truong_lam_viec')->nullable();
            $table->foreignId('linh_vuc_id')->nullable()->constrained('linh_vuc')->nullOnDelete();
            $table->string('hinh_anh', 255)->nullable();
            $table->enum('trang_thai', ['hien', 'an'])->default('hien');
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nghe_nghiep');
    }
};
