@extends('layouts.admin')
@section('title', 'Quản lý người dùng')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý người dùng</h1>
</div>

<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="padding:12px 16px;">
        <form method="GET" style="display:flex;gap:8px;">
            <input type="text" class="form-control" name="tim_kiem" value="{{ request('tim_kiem') }}" placeholder="Tìm theo tên, email..." style="max-width:300px;">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Tìm</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr><th>#</th><th>Họ tên</th><th>Email</th><th>Trạng thái</th><th>Ngày ĐK</th><th style="text-align:right;">Thao tác</th></tr>
            </thead>
            <tbody>
                @foreach($nguoiDung as $index => $nd)
                <tr>
                    <td>{{ $nguoiDung->firstItem() + $index }}</td>
                    <td style="font-weight:500;">{{ $nd->ho_ten }}</td>
                    <td style="color:#888;">{{ $nd->email }}</td>
                    <td>
                        <span class="badge-status {{ $nd->trang_thai == 'hoat_dong' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $nd->trang_thai == 'hoat_dong' ? 'Active' : 'Bị khóa' }}
                        </span>
                    </td>
                    <td style="color:#888;">{{ $nd->tao_luc->format('d/m/Y') }}</td>
                    <td style="text-align:right;">
                        <form method="POST" action="/admin/nguoi-dung/{{ $nd->id }}/khoa" style="display:inline;">
                            @csrf @method('PUT')
                            <button class="btn btn-sm {{ $nd->trang_thai == 'hoat_dong' ? 'btn-edit' : 'btn-primary' }}">
                                {{ $nd->trang_thai == 'hoat_dong' ? 'Khóa' : 'Mở' }}
                            </button>
                        </form>
                        <form method="POST" action="/admin/nguoi-dung/{{ $nd->id }}" style="display:inline;" onsubmit="return confirm('Xóa?')">
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
<div class="pagination">{{ $nguoiDung->links() }}</div>
@endsection
