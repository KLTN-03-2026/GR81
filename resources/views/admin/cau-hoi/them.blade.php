@extends('layouts.admin')
@section('title', 'Thêm câu hỏi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Thêm câu hỏi mới</h1>
    <a href="/admin/cau-hoi" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="/admin/cau-hoi">
            @csrf
            <div style="margin-bottom:16px;">
                <label class="form-label">Nội dung câu hỏi</label>
                <input type="text" class="form-control" name="noi_dung" value="{{ old('noi_dung') }}" required placeholder="VD: Khi gặp người mới, bạn thường:">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                <div>
                    <label class="form-label">Lựa chọn A</label>
                    <input type="text" class="form-control" name="lua_chon_a" value="{{ old('lua_chon_a') }}" required>
                </div>
                <div>
                    <label class="form-label">Lựa chọn B</label>
                    <input type="text" class="form-control" name="lua_chon_b" value="{{ old('lua_chon_b') }}" required>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:20px;">
                <div>
                    <label class="form-label">Nhóm chiều</label>
                    <select class="form-select" name="nhom_chieu" required>
                        <option value="EI">EI - Hướng ngoại/Hướng nội</option>
                        <option value="SN">SN - Cảm nhận/Trực giác</option>
                        <option value="TF">TF - Lý trí/Cảm xúc</option>
                        <option value="JP">JP - Nguyên tắc/Linh hoạt</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Thứ tự</label>
                    <input type="number" class="form-control" name="thu_tu" value="{{ old('thu_tu') }}" placeholder="Auto">
                </div>
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="trang_thai">
                        <option value="hoat_dong">Hoạt động</option>
                        <option value="ngung">Ngừng</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check2"></i> Thêm câu hỏi</button>
        </form>
    </div>
</div>
@endsection
