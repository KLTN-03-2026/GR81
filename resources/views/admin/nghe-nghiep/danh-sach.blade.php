@extends('layouts.admin')
@section('title', 'Quản lý nghề nghiệp')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý nghề nghiệp</h1>
    <a href="/admin/nghe-nghiep/them" class="btn btn-primary"><i class="bi bi-plus"></i> Thêm nghề nghiệp</a>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Danh mục</th>
                    <th>MBTI</th>
                    <th>Trạng thái</th>
                    <th style="text-align:right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ngheNghiep as $nn)
                <tr>
                    <td>{{ $nn->id }}</td>
                    <td style="font-weight:500;">{{ $nn->ten_nghe }}</td>
                    <td>{{ $nn->linhVuc->ten_linh_vuc ?? '-' }}</td>
                    <td>
                        @php
                            $colors = ['mbti-red','mbti-blue','mbti-green','mbti-purple','mbti-orange','mbti-teal','mbti-pink','mbti-yellow'];
                            $kieuList = $nn->kieuMbti ?? collect();
                        @endphp
                        @foreach($kieuList->take(5) as $i => $kieu)
                        <span class="mbti-badge {{ $colors[$i % count($colors)] }}">{{ $kieu->ma_kieu }}</span>
                        @endforeach
                    </td>
                    <td>
                        <span class="badge-status {{ $nn->trang_thai == 'hien' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $nn->trang_thai == 'hien' ? 'Active' : 'Ẩn' }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <a href="/admin/nghe-nghiep/{{ $nn->id }}/sua" class="btn btn-sm btn-edit">Sửa</a>
                        <form method="POST" action="/admin/nghe-nghiep/{{ $nn->id }}" style="display:inline;" onsubmit="return confirm('Xóa?')">
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
<div class="pagination">{{ $ngheNghiep->links() }}</div>
@endsection
