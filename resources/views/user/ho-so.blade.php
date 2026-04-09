@extends('layouts.app')
@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="page-header">
    <h1 class="page-title">Hồ sơ cá nhân</h1>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <!-- Thông tin cá nhân -->
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;"><i class="bi bi-person" style="color:#059669;"></i> Thông tin cá nhân</div>
            <form method="POST" action="/ho-so">
                @csrf @method('PUT')
                <div style="margin-bottom:14px;">
                    <label class="form-label">Họ tên</label>
                    <input type="text" class="form-control" name="ho_ten" value="{{ $nguoiDung->ho_ten }}" required>
                </div>
                <div style="margin-bottom:14px;">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $nguoiDung->email }}" disabled style="background:#f8f9fb;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                    <div>
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngay_sinh" value="{{ $nguoiDung->ngay_sinh }}">
                    </div>
                    <div>
                        <label class="form-label">Giới tính</label>
                        <select class="form-select" name="gioi_tinh">
                            <option value="">-- Chọn --</option>
                            <option value="nam" {{ $nguoiDung->gioi_tinh == 'nam' ? 'selected' : '' }}>Nam</option>
                            <option value="nu" {{ $nguoiDung->gioi_tinh == 'nu' ? 'selected' : '' }}>Nữ</option>
                            <option value="khac" {{ $nguoiDung->gioi_tinh == 'khac' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="so_dien_thoai" value="{{ $nguoiDung->so_dien_thoai }}">
                </div>
                <button class="btn btn-primary"><i class="bi bi-check2"></i> Cập nhật</button>
            </form>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:20px;">
        <!-- Đổi mật khẩu -->
        <div class="card">
            <div class="card-body">
                <div style="font-weight:600;font-size:14px;margin-bottom:16px;"><i class="bi bi-key" style="color:#059669;"></i> Đổi mật khẩu</div>
                <form method="POST" action="/doi-mat-khau">
                    @csrf @method('PUT')
                    <div style="margin-bottom:14px;">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" name="mat_khau_cu" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="mat_khau" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" name="mat_khau_confirmation" required>
                    </div>
                    <button class="btn btn-primary"><i class="bi bi-key"></i> Đổi mật khẩu</button>
                </form>
            </div>
        </div>

        <!-- Sở thích & Kỹ năng -->
        <div class="card">
            <div class="card-body">
                <div style="font-weight:600;font-size:14px;margin-bottom:16px;"><i class="bi bi-heart" style="color:#059669;"></i> Sở thích & Kỹ năng</div>
                <form method="POST" action="/so-thich-ky-nang">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label class="form-label">Sở thích</label>
                        <textarea class="form-control" name="so_thich" rows="2" placeholder="VD: Đọc sách, lập trình, vẽ tranh...">{{ $soThich->so_thich ?? '' }}</textarea>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label class="form-label">Kỹ năng</label>
                        <textarea class="form-control" name="ky_nang" rows="2" placeholder="VD: Giao tiếp, teamwork, lập trình PHP...">{{ $soThich->ky_nang ?? '' }}</textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                        <div>
                            <label class="form-label">Trình độ học vấn</label>
                            <select class="form-select" name="trinh_do_hoc_van">
                                <option value="">-- Chọn --</option>
                                @foreach(['thpt','trung_cap','cao_dang','dai_hoc','thac_si','tien_si'] as $td)
                                <option value="{{ $td }}" {{ ($soThich->trinh_do_hoc_van ?? '') == $td ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$td)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Lĩnh vực quan tâm</label>
                            <input type="text" class="form-control" name="linh_vuc_quan_tam" value="{{ $soThich->linh_vuc_quan_tam ?? '' }}" placeholder="VD: Công nghệ, y tế...">
                        </div>
                    </div>
                    <button class="btn btn-primary"><i class="bi bi-check2"></i> Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
