@extends('layouts.app')
@section('title', 'Khám phá nghề nghiệp')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Khám phá nghề nghiệp</h1>
        <p style="color:#64748b;font-size:14px;margin-top:4px;">Tìm hiểu các nghề nghiệp phù hợp với tính cách MBTI của bạn</p>
    </div>
</div>

<!-- Thanh tìm kiếm & lọc -->
<div class="card" style="margin-bottom:24px;overflow:hidden;">
    <div style="padding:20px;background:linear-gradient(135deg,#f0fdf4,#eff6ff);">
        <form method="GET" action="/nghe-nghiep" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <div style="flex:1;min-width:220px;">
                <div style="position:relative;">
                    <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;"></i>
                    <input type="text" name="tim_kiem" value="{{ request('tim_kiem') }}" placeholder="Tìm kiếm nghề nghiệp..."
                        style="width:100%;padding:12px 14px 12px 40px;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;background:#fff;outline:none;transition:border 0.2s;" onfocus="this.style.borderColor='#34d399'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>
            <select name="linh_vuc_id" style="padding:12px 16px;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;min-width:180px;background:#fff;cursor:pointer;">
                <option value="">Tất cả lĩnh vực</option>
                @foreach($linhVuc as $lv)
                <option value="{{ $lv->id }}" {{ request('linh_vuc_id') == $lv->id ? 'selected' : '' }}>{{ $lv->ten_linh_vuc }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" style="padding:12px 24px;border-radius:10px;font-size:14px;">
                <i class="bi bi-funnel"></i> Lọc
            </button>
            @if(request('tim_kiem') || request('linh_vuc_id'))
            <a href="/nghe-nghiep" class="btn btn-outline" style="padding:12px 20px;border-radius:10px;font-size:14px;">
                <i class="bi bi-x-lg"></i> Xóa lọc
            </a>
            @endif
        </form>
    </div>
</div>

<!-- Số kết quả -->
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div style="font-size:14px;color:#64748b;">
        Hiển thị <strong style="color:#059669;">{{ $ngheNghiep->total() }}</strong> nghề nghiệp
    </div>
</div>

<!-- Grid nghề nghiệp -->
@if($ngheNghiep->count() > 0)
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
    @foreach($ngheNghiep as $nghe)
    <a href="/nghe-nghiep/{{ $nghe->id }}" style="text-decoration:none;display:block;">
        <div class="card" style="height:100%;transition:all 0.3s cubic-bezier(0.4,0,0.2,1);overflow:hidden;position:relative;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 32px rgba(5,150,105,0.12)';this.querySelector('.career-bar').style.width='100%'" onmouseout="this.style.transform='';this.style.boxShadow='';this.querySelector('.career-bar').style.width='0'">
            <!-- Top accent bar on hover -->
            <div class="career-bar" style="position:absolute;top:0;left:0;width:0;height:3px;background:linear-gradient(90deg,#34d399,#059669);transition:width 0.4s;"></div>

            <div class="card-body" style="padding:24px;">
                <!-- Header -->
                <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:16px;">
                    <div style="width:48px;height:48px;background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-briefcase-fill" style="font-size:20px;color:#059669;"></i>
                    </div>
                    <div style="min-width:0;">
                        <h3 style="font-size:16px;font-weight:700;margin:0 0 6px;color:#0f172a;">{{ $nghe->ten_nghe }}</h3>
                        @if($nghe->linhVuc)
                        <span style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#2563eb;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block;">{{ $nghe->linhVuc->ten_linh_vuc }}</span>
                        @endif
                    </div>
                </div>

                <!-- Mô tả -->
                @if($nghe->mo_ta)
                <p style="font-size:13px;color:#64748b;line-height:1.7;margin:0 0 16px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $nghe->mo_ta }}</p>
                @endif

                <!-- Footer -->
                <div style="display:flex;justify-content:space-between;align-items:center;padding-top:14px;border-top:1px solid #f1f5f9;">
                    @if($nghe->muc_luong_min || $nghe->muc_luong_max)
                    <div style="font-size:13px;color:#059669;font-weight:700;">
                        <i class="bi bi-cash-stack"></i>
                        {{ number_format($nghe->muc_luong_min/1000000) }} - {{ number_format($nghe->muc_luong_max/1000000) }} triệu
                    </div>
                    @else
                    <div></div>
                    @endif
                    <div style="font-size:12px;color:#94a3b8;font-weight:500;">
                        Xem chi tiết <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>

<div style="margin-top:24px;">{{ $ngheNghiep->withQueryString()->links() }}</div>
@else
<div class="card">
    <div class="card-body" style="text-align:center;padding:80px 40px;">
        <div style="width:80px;height:80px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="bi bi-search" style="font-size:32px;color:#cbd5e1;"></i>
        </div>
        <h3 style="font-size:16px;font-weight:600;color:#475569;margin-bottom:8px;">Không tìm thấy nghề nghiệp</h3>
        <p style="font-size:13px;color:#94a3b8;">Thử thay đổi từ khóa hoặc bộ lọc lĩnh vực để tìm nghề phù hợp.</p>
        <a href="/nghe-nghiep" class="btn btn-primary" style="margin-top:16px;"><i class="bi bi-arrow-counterclockwise"></i> Xem tất cả</a>
    </div>
</div>
@endif
@endsection
