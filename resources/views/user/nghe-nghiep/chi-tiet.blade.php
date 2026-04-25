@extends('layouts.app')
@section('title', $nghe->ten_nghe)

@section('content')
<!-- Breadcrumb -->
<div style="margin-bottom:24px;">
    <a href="/nghe-nghiep" style="font-size:13px;color:#059669;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#f0fdf4;border-radius:8px;transition:all 0.2s;" onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<!-- Hero Header -->
<div class="card" style="margin-bottom:24px;overflow:hidden;">
    <div style="background:linear-gradient(135deg,#059669,#0d9488);padding:32px;position:relative;">
        <div style="position:absolute;top:0;right:0;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%;transform:translate(40%,-40%);"></div>
        <div style="position:absolute;bottom:0;left:50%;width:120px;height:120px;background:rgba(255,255,255,0.03);border-radius:50%;transform:translate(-50%,50%);"></div>

        <div style="display:flex;align-items:center;gap:20px;position:relative;z-index:1;">
            <div style="width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:16px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(10px);flex-shrink:0;">
                <i class="bi bi-briefcase-fill" style="font-size:28px;color:#fff;"></i>
            </div>
            <div>
                <h1 style="font-size:26px;font-weight:800;color:#fff;margin:0 0 8px;">{{ $nghe->ten_nghe }}</h1>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    @if($nghe->linhVuc)
                    <span style="background:rgba(255,255,255,0.2);color:#fff;padding:4px 14px;border-radius:20px;font-size:12px;font-weight:600;backdrop-filter:blur(10px);">
                        <i class="bi bi-tag"></i> {{ $nghe->linhVuc->ten_linh_vuc }}
                    </span>
                    @endif
                    @if($nghe->muc_luong_min || $nghe->muc_luong_max)
                    <span style="background:rgba(255,255,255,0.2);color:#fff;padding:4px 14px;border-radius:20px;font-size:12px;font-weight:600;backdrop-filter:blur(10px);">
                        <i class="bi bi-cash-stack"></i> {{ number_format($nghe->muc_luong_min/1000000) }} - {{ number_format($nghe->muc_luong_max/1000000) }} triệu/tháng
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
    <!-- Nội dung chính -->
    <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- Mô tả -->
        @if($nghe->mo_ta)
        <div class="card">
            <div class="card-body" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:36px;height:36px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-info-circle" style="font-size:16px;color:#475569;"></i>
                    </div>
                    <h3 style="font-size:15px;font-weight:700;margin:0;color:#0f172a;">Mô tả chi tiết</h3>
                </div>
                <p style="font-size:14px;color:#475569;line-height:1.9;margin:0;">{{ $nghe->mo_ta }}</p>
            </div>
        </div>
        @endif

        <!-- Kỹ năng cần thiết -->
        @if($nghe->ky_nang_can_thiet)
        <div class="card">
            <div class="card-body" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:36px;height:36px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-tools" style="font-size:16px;color:#475569;"></i>
                    </div>
                    <h3 style="font-size:15px;font-weight:700;margin:0;color:#0f172a;">Kỹ năng cần thiết</h3>
                </div>
                <div style="font-size:14px;color:#475569;line-height:1.9;">
                    @foreach(explode("\n", $nghe->ky_nang_can_thiet) as $line)
                        @if(trim($line))
                        <div style="display:flex;align-items:flex-start;gap:10px;padding:6px 0;">
                            <i class="bi bi-check2" style="color:#059669;font-size:14px;margin-top:3px;flex-shrink:0;"></i>
                            <span>{{ ltrim(trim($line), '•- ') }}</span>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Môi trường làm việc -->
        @if($nghe->moi_truong_lam_viec)
        <div class="card">
            <div class="card-body" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:36px;height:36px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-building" style="font-size:16px;color:#475569;"></i>
                    </div>
                    <h3 style="font-size:15px;font-weight:700;margin:0;color:#0f172a;">Môi trường làm việc</h3>
                </div>
                <p style="font-size:14px;color:#475569;line-height:1.9;margin:0;">{{ $nghe->moi_truong_lam_viec }}</p>
            </div>
        </div>
        @endif

        <!-- Triển vọng -->
        @if($nghe->trien_vong)
        <div class="card">
            <div class="card-body" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:36px;height:36px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-graph-up-arrow" style="font-size:16px;color:#475569;"></i>
                    </div>
                    <h3 style="font-size:15px;font-weight:700;margin:0;color:#0f172a;">Triển vọng phát triển</h3>
                </div>
                <p style="font-size:14px;color:#475569;line-height:1.9;margin:0;">{{ $nghe->trien_vong }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- Mức lương -->
        @if($nghe->muc_luong_min || $nghe->muc_luong_max)
        <div class="card" style="overflow:hidden;">
            <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);padding:24px;text-align:center;">
                <div style="font-weight:600;font-size:13px;color:#064e3b;margin-bottom:12px;">
                    <i class="bi bi-cash-stack"></i> Mức lương tham khảo
                </div>
                <div style="font-size:28px;font-weight:800;color:#059669;line-height:1.2;">
                    {{ number_format($nghe->muc_luong_min/1000000) }} - {{ number_format($nghe->muc_luong_max/1000000) }}
                </div>
                <div style="font-size:13px;color:#059669;font-weight:500;margin-top:4px;">triệu VNĐ / tháng</div>
                <div style="margin-top:12px;height:4px;background:rgba(5,150,105,0.15);border-radius:2px;overflow:hidden;">
                    <div style="height:100%;width:{{ min(100, ($nghe->muc_luong_max / 80000000) * 100) }}%;background:linear-gradient(90deg,#34d399,#059669);border-radius:2px;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:10px;color:#6ee7b7;margin-top:4px;">
                    <span>Thấp</span><span>Cao</span>
                </div>
            </div>
        </div>
        @endif

        <!-- MBTI phù hợp -->
        @if($mbtiPhuHop->count() > 0)
        <div class="card">
            <div class="card-body" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:32px;height:32px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-person-badge" style="font-size:14px;color:#475569;"></i>
                    </div>
                    <div style="font-weight:700;font-size:14px;color:#0f172a;">Kiểu MBTI phù hợp</div>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach($mbtiPhuHop as $mbti)
                    <span style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);color:#059669;padding:6px 16px;border-radius:10px;font-size:13px;font-weight:700;border:1px solid #bbf7d0;transition:all 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform=''">{{ $mbti->ma_kieu }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Nghề liên quan -->
        @if($ngheLienQuan->count() > 0)
        <div class="card">
            <div class="card-body" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:32px;height:32px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-link-45deg" style="font-size:14px;color:#475569;"></i>
                    </div>
                    <div style="font-weight:700;font-size:14px;color:#0f172a;">Nghề liên quan</div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($ngheLienQuan as $nglq)
                    <a href="/nghe-nghiep/{{ $nglq->id }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f8fafc;border-radius:10px;font-size:13px;color:#334155;font-weight:500;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='#f0fdf4';this.style.color='#059669'" onmouseout="this.style.background='#f8fafc';this.style.color='#334155'">
                        <i class="bi bi-briefcase" style="font-size:14px;"></i>
                        <span>{{ $nglq->ten_nghe }}</span>
                        <i class="bi bi-chevron-right" style="margin-left:auto;font-size:12px;"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- CTA -->
        <div class="card" style="overflow:hidden;">
            <div style="background:#f8fafc;padding:24px;text-align:center;">
                <i class="bi bi-stars" style="font-size:24px;color:#059669;"></i>
                <p style="font-size:13px;color:#64748b;margin:10px 0;line-height:1.6;">Muốn biết nghề này có phù hợp với bạn không?</p>
                <a href="/goi-y-nghe-nghiep" class="btn btn-primary" style="width:100%;justify-content:center;border-radius:10px;padding:10px;">
                    <i class="bi bi-robot"></i> Phân tích AI
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
