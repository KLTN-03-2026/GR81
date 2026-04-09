<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration tạo bảng linh_vuc - danh mục lĩnh vực nghề
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('linh_vuc', function (Blueprint $table) {
            $table->id();
            $table->string('ten_linh_vuc', 100);
            $table->text('mo_ta')->nullable();
            $table->timestamp('tao_luc')->useCurrent();
            $table->timestamp('cap_nhat_luc')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('linh_vuc');
    }
};
