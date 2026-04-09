@extends('layouts.app')
@section('title', 'Gợi ý nghề nghiệp AI')

@section('content')
<div class="page-header">
    <h1 class="page-title">Gợi ý nghề nghiệp AI</h1>
</div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">
    <!-- Sidebar info -->
    <div>
        <div class="card" style="margin-bottom:16px;">
            <div class="card-body" style="text-align:center;">
                <div style="background:linear-gradient(135deg,#34d399,#059669);border-radius:12px;padding:20px;margin-bottom:12px;">
                    <div style="font-size:28px;font-weight:800;color:#fff;">{{ $ketQua->kieu_mbti }}</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);">Kiểu tính cách</div>
                </div>
                <div style="font-size:12px;color:#888;">Ngày test: {{ $ketQua->tao_luc->format('d/m/Y') }}</div>
            </div>
        </div>

        @if($soThich)
        <div class="card" style="margin-bottom:16px;">
            <div class="card-body">
                <div style="font-weight:600;font-size:13px;margin-bottom:8px;"><i class="bi bi-heart" style="color:#059669;"></i> Sở thích</div>
                <p style="font-size:12px;color:#666;">{{ $soThich->so_thich ?: 'Chưa cập nhật' }}</p>
                <div style="font-weight:600;font-size:13px;margin:12px 0 8px;"><i class="bi bi-tools" style="color:#059669;"></i> Kỹ năng</div>
                <p style="font-size:12px;color:#666;">{{ $soThich->ky_nang ?: 'Chưa cập nhật' }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="/goi-y-nghe-nghiep/phan-tich">
            @csrf
            <button class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="bi bi-stars"></i> Yêu cầu AI phân tích
            </button>
        </form>
        <a href="/ho-so" class="btn btn-outline" style="width:100%;justify-content:center;margin-top:8px;">
            <i class="bi bi-person-gear"></i> Cập nhật sở thích
        </a>
    </div>

    <!-- AI Result -->
    <div>
        @if($goiYDaLuu)
        <div class="card">
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <div style="font-weight:600;font-size:14px;"><i class="bi bi-stars" style="color:#059669;"></i> Kết quả phân tích AI</div>
                    <span style="font-size:11px;color:#999;">{{ $goiYDaLuu->tao_luc->format('d/m/Y H:i') }}</span>
                </div>
                <div style="font-size:14px;color:#444;line-height:1.8;white-space:pre-line;">{{ $goiYDaLuu->noi_dung_goi_y }}</div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body" style="text-align:center;padding:60px;">
                <i class="bi bi-robot" style="font-size:48px;color:#ddd;"></i>
                <p style="margin-top:12px;color:#888;font-size:14px;">Chưa có gợi ý AI. Nhấn nút "Yêu cầu AI phân tích" để bắt đầu.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
