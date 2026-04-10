@extends('layouts.admin')
@section('title', 'Sửa câu hỏi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Sửa câu hỏi #{{ $cauHoi->thu_tu }}</h1>
    <a href="/admin/cau-hoi" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="/admin/cau-hoi/{{ $cauHoi->id }}">
            @csrf @method('PUT')
            <div style="margin-bottom:16px;">
                <label class="form-label">Nội dung câu hỏi</label>
                <input type="text" class="form-control" name="noi_dung" value="{{ $cauHoi->noi_dung }}" required>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                <div>
                    <label class="form-label">Lựa chọn A ({{ $cauHoi->chieu_a }})</label>
                    <input type="text" class="form-control" name="lua_chon_a" value="{{ $cauHoi->lua_chon_a }}" required>
                </div>
                <div>
                    <label class="form-label">Lựa chọn B ({{ $cauHoi->chieu_b }})</label>
                    <input type="text" class="form-control" name="lua_chon_b" value="{{ $cauHoi->lua_chon_b }}" required>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:20px;">
                <div>
                    <label class="form-label">Nhóm chiều</label>
                    <select class="form-select" name="nhom_chieu" required>
                        @foreach(['EI','SN','TF','JP'] as $nc)
                        <option value="{{ $nc }}" {{ $cauHoi->nhom_chieu == $nc ? 'selected' : '' }}>{{ $nc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Thứ tự</label>
                    <input type="number" class="form-control" name="thu_tu" value="{{ $cauHoi->thu_tu }}">
                </div>
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="trang_thai">
                        <option value="hoat_dong" {{ $cauHoi->trang_thai == 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="ngung" {{ $cauHoi->trang_thai == 'ngung' ? 'selected' : '' }}>Ngừng</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check2"></i> Cập nhật</button>
        </form>
    </div>
</div>
@endsection
