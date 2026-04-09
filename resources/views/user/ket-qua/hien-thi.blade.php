@extends('layouts.app')
@section('title', 'Kết quả MBTI')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kết quả bài test MBTI</h1>
    <a href="/bai-test" class="btn btn-secondary"><i class="bi bi-arrow-repeat"></i> Làm lại test</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
    <!-- Main Result -->
    <div>
        <!-- MBTI Type Card -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body" style="display:flex;gap:24px;align-items:center;">
                <div style="background:linear-gradient(135deg,#34d399,#059669);border-radius:16px;padding:24px 32px;text-align:center;min-width:120px;">
                    <div style="font-size:32px;font-weight:800;color:#fff;">{{ $ketQua->kieu_mbti }}</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);margin-top:4px;">{{ $kieuMbti->ten_goi ?? '' }}</div>
                </div>
                <div>
                    <h3 style="font-size:16px;font-weight:600;margin-bottom:8px;">{{ $kieuMbti->ten_goi ?? '' }}</h3>
                    <p style="font-size:13px;color:#666;line-height:1.6;">{{ $kieuMbti->mo_ta_chung ?? '' }}</p>
                </div>
            </div>
        </div>

        <!-- Phân bố chiều MBTI -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body">
                <div style="font-weight:600;font-size:14px;margin-bottom:16px;">Phân bố chiều MBTI</div>
                @php $bars = [
                    ['E','Hướng ngoại',$ketQua->phan_tram_e,'I','Hướng nội',$ketQua->phan_tram_i],
                    ['S','Cảm nhận',$ketQua->phan_tram_s,'N','Trực giác',$ketQua->phan_tram_n],
                    ['T','Lý trí',$ketQua->phan_tram_t,'F','Cảm xúc',$ketQua->phan_tram_f],
                    ['J','Nguyên tắc',$ketQua->phan_tram_j,'P','Linh hoạt',$ketQua->phan_tram_p],
                ]; @endphp
                @foreach($bars as $b)
                <div style="margin-bottom:16px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                        <span style="font-size:12px;font-weight:600;">{{ $b[0] }} {{ $b[1] }} {{ $b[2] }}%</span>
                        <span style="font-size:12px;font-weight:600;">{{ $b[5] }}% {{ $b[4] }} {{ $b[3] }}</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill green" style="width:{{ $b[2] }}%"></div>
                        <div class="progress-fill gray" style="width:{{ $b[5] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Điểm mạnh / yếu -->
        @if($kieuMbti)
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="card">
                <div class="card-body">
                    <div style="font-weight:600;font-size:14px;margin-bottom:12px;color:#059669;"><i class="bi bi-hand-thumbs-up"></i> Điểm mạnh</div>
                    <div style="font-size:13px;color:#555;line-height:1.8;">{{ $kieuMbti->diem_manh }}</div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div style="font-weight:600;font-size:14px;margin-bottom:12px;color:#ef4444;"><i class="bi bi-hand-thumbs-down"></i> Điểm yếu</div>
                    <div style="font-size:13px;color:#555;line-height:1.8;">{{ $kieuMbti->diem_yeu }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Radar Chart -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body" style="text-align:center;">
                <div style="font-weight:600;font-size:14px;margin-bottom:12px;">Biểu đồ Radar</div>
                <canvas id="radarChart" height="220"></canvas>
            </div>
        </div>

        <!-- Nghề phù hợp -->
        @if(count($ngheGoi) > 0)
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body">
                <div style="font-weight:600;font-size:14px;margin-bottom:12px;"><i class="bi bi-briefcase"></i> Nghề phù hợp</div>
                @foreach($ngheGoi as $ng)
                <div style="padding:8px 0;border-bottom:1px solid #f1f3f5;font-size:13px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-weight:500;">{{ $ng->ten_nghe }}</span>
                    <span class="mbti-badge mbti-green">{{ $ng->pivot->muc_do_phu_hop ?? '' }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div style="display:flex;flex-direction:column;gap:8px;">
            <a href="/goi-y-nghe-nghiep" class="quick-action"><i class="bi bi-stars"></i> Gợi ý AI chi tiết</a>
            <a href="/lich-su-test" class="quick-action"><i class="bi bi-clock-history"></i> Xem lịch sử</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: ['E','N','T','J','I','S','F','P'],
        datasets: [{
            data: [{{ $ketQua->phan_tram_e }},{{ $ketQua->phan_tram_n }},{{ $ketQua->phan_tram_t }},{{ $ketQua->phan_tram_j }},{{ $ketQua->phan_tram_i }},{{ $ketQua->phan_tram_s }},{{ $ketQua->phan_tram_f }},{{ $ketQua->phan_tram_p }}],
            backgroundColor: 'rgba(52,211,153,0.2)',
            borderColor: '#34d399',
            borderWidth: 2,
            pointBackgroundColor: '#34d399',
            pointRadius: 3
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { r: { beginAtZero: true, max: 100, ticks: { stepSize: 20, font: { size: 9 } }, pointLabels: { font: { size: 11, weight: '600' } } } } }
});
</script>
@endsection
