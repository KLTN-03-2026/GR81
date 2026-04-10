@extends('layouts.admin')
@section('title', 'Thêm nghề nghiệp')

@section('content')
<div class="page-header">
    <h1 class="page-title">Thêm nghề nghiệp</h1>
    <a href="/admin/nghe-nghiep" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="/admin/nghe-nghiep">
            @csrf
            <div style="margin-bottom:14px;">
                <label class="form-label">Tên nghề</label>
                <input type="text" class="form-control" name="ten_nghe" required placeholder="VD: Lập trình viên">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label class="form-label">Lĩnh vực</label>
                    <select class="form-select" name="linh_vuc_id">
                        <option value="">-- Chọn --</option>
                        @foreach($linhVuc as $lv)
                        <option value="{{ $lv->id }}">{{ $lv->ten_linh_vuc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Triển vọng</label>
                    <input type="text" class="form-control" name="trien_vong" placeholder="VD: Rất cao">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label class="form-label">Lương min (VND)</label>
                    <input type="number" class="form-control" name="muc_luong_min" placeholder="15000000">
                </div>
                <div>
                    <label class="form-label">Lương max (VND)</label>
                    <input type="number" class="form-control" name="muc_luong_max" placeholder="45000000">
                </div>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="mo_ta" rows="3" placeholder="Mô tả công việc..."></textarea>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-label">Kỹ năng cần thiết</label>
                <textarea class="form-control" name="ky_nang_can_thiet" rows="2" placeholder="VD: Lập trình, tư duy logic..."></textarea>
            </div>
            <div style="margin-bottom:20px;">
                <label class="form-label">Môi trường làm việc</label>
                <input type="text" class="form-control" name="moi_truong_lam_viec" placeholder="VD: Văn phòng, remote">
            </div>
            <button class="btn btn-primary"><i class="bi bi-check2"></i> Thêm nghề</button>
        </form>
    </div>
</div>
@endsection
