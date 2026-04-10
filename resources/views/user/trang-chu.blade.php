@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
</div>

<!-- Stat Cards + MBTI Result -->
<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
    <!-- Row 1: Stats -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; grid-column: span 2;">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-pencil-square"></i></div>
            <div class="stat-label">Lần làm test</div>
            <div class="stat-value">{{ $nguoiDung->ketQuaTests()->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-search"></i></div>
            <div class="stat-label">Kiểu MBTI</div>
            <div class="stat-value">{{ $ketQuaMoiNhat->kieu_mbti ?? '---' }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-briefcase"></i></div>
            <div class="stat-label">Gợi ý nghề nghiệp</div>
            <div class="stat-value">{{ $ketQuaMoiNhat && $kieuMbti ? $kieuMbti->ngheNghiep()->count() : 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-bar-chart"></i></div>
            <div class="stat-label">Độ phù hợp</div>
            <div class="stat-value">{{ $ketQuaMoiNhat ? max($ketQuaMoiNhat->phan_tram_e, $ketQuaMoiNhat->phan_tram_i, $ketQuaMoiNhat->phan_tram_s, $ketQuaMoiNhat->phan_tram_n, $ketQuaMoiNhat->phan_tram_t, $ketQuaMoiNhat->phan_tram_f, $ketQuaMoiNhat->phan_tram_j, $ketQuaMoiNhat->phan_tram_p) : 0 }}%</div>
        </div>
    </div>

    <!-- Radar Chart -->
    <div class="card" style="grid-row: span 1;">
        <div class="card-body" style="text-align:center;">
            @if($ketQuaMoiNhat)
            <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:8px;">
                <div style="text-align:left;">
                    <div style="font-size:11px;color:#999;">Kết quả MBTI</div>
                    <div style="font-size:24px;font-weight:700;">{{ $ketQuaMoiNhat->kieu_mbti }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:11px;color:#999;">Ngày test</div>
                    <div style="font-size:13px;font-weight:500;">{{ $ketQuaMoiNhat->tao_luc->format('d/m/Y') }}</div>
                </div>
            </div>
            <canvas id="radarChart" height="180"></canvas>
            <div style="margin-top:8px;">
                <span style="font-size:12px;color:#999;">Cập nhật {{ $ketQuaMoiNhat->tao_luc->diffForHumans() }}.</span>
                <a href="/ket-qua/{{ $ketQuaMoiNhat->id }}" style="font-size:12px;color:#059669;text-decoration:none;"> Xem chi tiết →</a>
            </div>
            @else
            <div style="padding:40px 0;color:#999;">
                <i class="bi bi-clipboard-x" style="font-size:48px;"></i>
                <p style="margin-top:12px;">Chưa có kết quả test</p>
                <a href="/bai-test" class="btn btn-primary" style="margin-top:12px;"><i class="bi bi-play-circle"></i> Làm test ngay</a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Row 2: History + MBTI bars + Quick actions -->
<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
    <!-- Lịch sử test -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div style="font-weight:600;font-size:14px;">Lịch sử test</div>
                <a href="/lich-su-test" style="font-size:12px;color:#059669;text-decoration:none;">Xem tất cả →</a>
            </div>
            @php $lichSu = $nguoiDung->ketQuaTests()->orderBy('tao_luc','desc')->limit(5)->get(); @endphp
            @if($lichSu->count() > 0)
            <table style="width:100%;">
                <thead><tr>
                    <th style="text-align:left;font-size:11px;color:#999;padding:6px 0;font-weight:500;">MBTI</th>
                    <th style="text-align:left;font-size:11px;color:#999;padding:6px 0;font-weight:500;">NGÀY</th>
                </tr></thead>
                <tbody>
                @foreach($lichSu as $ls)
                <tr>
                    <td style="padding:8px 0;">
                        <span class="mbti-badge mbti-green">{{ substr($ls->kieu_mbti,0,2) }}</span>
                        <span style="font-size:13px;font-weight:500;">{{ $ls->kieu_mbti }}</span>
                    </td>
                    <td style="padding:8px 0;font-size:13px;color:#888;">{{ $ls->tao_luc->format('d/m/Y') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <div style="text-align:center;padding:24px;color:#ccc;font-size:13px;">
                <i class="bi bi-inbox" style="font-size:32px;"></i><br>Chưa có lịch sử
            </div>
            @endif
        </div>
    </div>

    <!-- Phân bố chiều MBTI -->
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;">Phân bố chiều MBTI</div>
            @if($ketQuaMoiNhat)
            @php
            $bars = [
                ['E', $ketQuaMoiNhat->phan_tram_e, 'I', $ketQuaMoiNhat->phan_tram_i],
                ['S', $ketQuaMoiNhat->phan_tram_s, 'N', $ketQuaMoiNhat->phan_tram_n],
                ['T', $ketQuaMoiNhat->phan_tram_t, 'F', $ketQuaMoiNhat->phan_tram_f],
                ['J', $ketQuaMoiNhat->phan_tram_j, 'P', $ketQuaMoiNhat->phan_tram_p],
            ];
            @endphp
            @foreach($bars as $bar)
            <div style="margin-bottom:12px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                    <span style="font-size:12px;font-weight:500;">{{ $bar[0] }} {{ $bar[1] }}%</span>
                    <span style="font-size:12px;font-weight:500;">{{ $bar[3] }}% {{ $bar[2] }}</span>
                </div>
                <div class="progress-bar-custom">
                    <div class="progress-fill green" style="width:{{ $bar[1] }}%"></div>
                    <div class="progress-fill gray" style="width:{{ $bar[3] }}%"></div>
                </div>
            </div>
            @endforeach
            @else
            <div style="text-align:center;padding:24px;color:#ccc;font-size:13px;">Chưa có dữ liệu</div>
            @endif
        </div>
    </div>

    <!-- Hành động nhanh -->
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;">Hành động nhanh</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="/bai-test" class="quick-action"><i class="bi bi-pencil-square"></i> Làm bài test MBTI</a>
                <a href="/goi-y-nghe-nghiep" class="quick-action"><i class="bi bi-stars"></i> Gợi ý nghề nghiệp AI</a>
                <a href="/ho-so" class="quick-action"><i class="bi bi-person-gear"></i> Cập nhật hồ sơ</a>
                <a href="/lich-su-test" class="quick-action"><i class="bi bi-clock-history"></i> Xem lịch sử test</a>
            </div>
        </div>
    </div>
</div>

<!-- 16 kiểu MBTI -->
@if($danhSachKieu->count() > 0)
<div style="margin-top:20px;">
    <div style="font-weight:600;font-size:14px;margin-bottom:12px;">16 kiểu tính cách MBTI</div>
    <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:8px;">
        @foreach($danhSachKieu as $kieu)
        <div class="card" style="text-align:center;padding:12px 8px;cursor:pointer;transition:0.2s;" onmouseover="this.style.borderColor='#34d399'" onmouseout="this.style.borderColor='#e8ecf1'">
            <div style="font-size:16px;font-weight:700;color:#059669;">{{ $kieu->ma_kieu }}</div>
            <div style="font-size:10px;color:#888;margin-top:2px;">{{ $kieu->ten_goi }}</div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection

@section('js')
@if($ketQuaMoiNhat)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: ['E','N','T','J','I','S','F','P'],
        datasets: [{
            data: [{{ $ketQuaMoiNhat->phan_tram_e }},{{ $ketQuaMoiNhat->phan_tram_n }},{{ $ketQuaMoiNhat->phan_tram_t }},{{ $ketQuaMoiNhat->phan_tram_j }},{{ $ketQuaMoiNhat->phan_tram_i }},{{ $ketQuaMoiNhat->phan_tram_s }},{{ $ketQuaMoiNhat->phan_tram_f }},{{ $ketQuaMoiNhat->phan_tram_p }}],
            backgroundColor: 'rgba(52,211,153,0.2)',
            borderColor: '#34d399',
            borderWidth: 2,
            pointBackgroundColor: '#34d399',
            pointRadius: 3
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { r: { beginAtZero: true, max: 100, ticks: { stepSize: 20, font: { size: 9 } }, pointLabels: { font: { size: 11, weight: '600' } } } }
    }
});
</script>
@endif
@endsection
