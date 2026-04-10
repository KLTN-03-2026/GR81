@extends('layouts.admin')
@section('title', 'Quản lý câu hỏi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý câu hỏi MBTI</h1>
    <div style="display:flex;gap:8px;">
        <form method="GET" style="display:inline;">
            <select name="nhom_chieu" class="form-select" style="width:auto;padding:8px 12px;font-size:12px;" onchange="this.form.submit()">
                <option value="">Tất cả nhóm</option>
                @foreach(['EI','SN','TF','JP'] as $nc)
                <option value="{{ $nc }}" {{ request('nhom_chieu') == $nc ? 'selected' : '' }}>{{ $nc }}</option>
                @endforeach
            </select>
        </form>
        <a href="/admin/cau-hoi/them" class="btn btn-primary"><i class="bi bi-plus"></i> Thêm câu hỏi</a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr><th style="width:60px;">TT</th><th>Nội dung</th><th style="width:80px;">Nhóm</th><th style="width:100px;">Trạng thái</th><th style="width:120px;text-align:right;">Thao tác</th></tr>
            </thead>
            <tbody>
                @foreach($cauHoi as $cau)
                <tr>
                    <td>{{ $cau->thu_tu }}</td>
                    <td style="font-weight:500;">{{ Str::limit($cau->noi_dung, 70) }}</td>
                    <td><span class="mbti-badge mbti-teal">{{ $cau->nhom_chieu }}</span></td>
                    <td>
                        <span class="badge-status {{ $cau->trang_thai == 'hoat_dong' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $cau->trang_thai == 'hoat_dong' ? 'Active' : 'Ngừng' }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <a href="/admin/cau-hoi/{{ $cau->id }}/sua" class="btn btn-sm btn-edit">Sửa</a>
                        <form method="POST" action="/admin/cau-hoi/{{ $cau->id }}" style="display:inline;" onsubmit="return confirm('Xóa?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination">{{ $cauHoi->links() }}</div>
@endsection
