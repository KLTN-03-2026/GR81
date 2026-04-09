@extends('layouts.app')
@section('title', 'Lịch sử test')

@section('content')
<div class="page-header">
    <h1 class="page-title">Lịch sử bài test</h1>
    <a href="/bai-test" class="btn btn-primary"><i class="bi bi-plus"></i> Làm test mới</a>
</div>

@if($danhSach->count() > 0)
<div class="card">
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr><th>#</th><th>Kiểu MBTI</th><th>E/I</th><th>S/N</th><th>T/F</th><th>J/P</th><th>Ngày</th><th style="text-align:right;">Thao tác</th></tr>
            </thead>
            <tbody>
                @foreach($danhSach as $index => $kq)
                <tr>
                    <td>{{ $danhSach->firstItem() + $index }}</td>
                    <td>
                        <span class="mbti-badge mbti-green" style="font-size:13px;padding:5px 12px;">{{ $kq->kieu_mbti }}</span>
                    </td>
                    <td style="font-size:12px;">{{ $kq->phan_tram_e }}%/{{ $kq->phan_tram_i }}%</td>
                    <td style="font-size:12px;">{{ $kq->phan_tram_s }}%/{{ $kq->phan_tram_n }}%</td>
                    <td style="font-size:12px;">{{ $kq->phan_tram_t }}%/{{ $kq->phan_tram_f }}%</td>
                    <td style="font-size:12px;">{{ $kq->phan_tram_j }}%/{{ $kq->phan_tram_p }}%</td>
                    <td style="font-size:13px;color:#888;">{{ $kq->tao_luc->format('d/m/Y') }}</td>
                    <td style="text-align:right;">
                        <a href="/ket-qua/{{ $kq->id }}" class="btn btn-sm btn-primary">Xem</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination">{{ $danhSach->links() }}</div>
@else
<div class="card">
    <div class="card-body" style="text-align:center;padding:60px;">
        <i class="bi bi-inbox" style="font-size:48px;color:#ddd;"></i>
        <p style="margin-top:12px;color:#888;font-size:14px;">Bạn chưa làm bài test nào.</p>
        <a href="/bai-test" class="btn btn-primary" style="margin-top:16px;"><i class="bi bi-play-circle"></i> Làm test ngay</a>
    </div>
</div>
@endif
@endsection
