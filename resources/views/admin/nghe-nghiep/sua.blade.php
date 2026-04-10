@extends('layouts.admin')
@section('title', 'Sửa nghề nghiệp')

@section('content')
<div class="page-header">
    <h1 class="page-title">Sửa: {{ $ngheNghiep->ten_nghe }}</h1>
    <a href="/admin/nghe-nghiep" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="/admin/nghe-nghiep/{{ $ngheNghiep->id }}">
            @csrf @method('PUT')
            <div style="margin-bottom:14px;">
                <label class="form-label">Tên nghề</label>
                <input type="text" class="form-control" name="ten_nghe" value="{{ $ngheNghiep->ten_nghe }}" required>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label class="form-label">Lĩnh vực</label>
                    <select class="form-select" name="linh_vuc_id">
                        @foreach($linhVuc as $lv)
                        <option value="{{ $lv->id }}" {{ $ngheNghiep->linh_vuc_id == $lv->id ? 'selected' : '' }}>{{ $lv->ten_linh_vuc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="trang_thai">
                        <option value="hien" {{ $ngheNghiep->trang_thai == 'hien' ? 'selected' : '' }}>Hiện</option>
                        <option value="an" {{ $ngheNghiep->trang_thai == 'an' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label class="form-label">Lương min</label>
                    <input type="number" class="form-control" name="muc_luong_min" value="{{ $ngheNghiep->muc_luong_min }}">
                </div>
                <div>
                    <label class="form-label">Lương max</label>
                    <input type="number" class="form-control" name="muc_luong_max" value="{{ $ngheNghiep->muc_luong_max }}">
                </div>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="mo_ta" rows="3">{{ $ngheNghiep->mo_ta }}</textarea>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-label">Kỹ năng cần thiết</label>
                <textarea class="form-control" name="ky_nang_can_thiet" rows="2">{{ $ngheNghiep->ky_nang_can_thiet }}</textarea>
            </div>
            <div style="margin-bottom:20px;">
                <label class="form-label">Môi trường làm việc</label>
                <input type="text" class="form-control" name="moi_truong_lam_viec" value="{{ $ngheNghiep->moi_truong_lam_viec }}">
            </div>
            <button class="btn btn-primary"><i class="bi bi-check2"></i> Cập nhật</button>
        </form>
    </div>
</div>
@endsection
