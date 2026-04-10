@extends('layouts.admin')
@section('title', 'Thống kê')

@section('content')
<div class="page-header">
    <h1 class="page-title">Thống kê</h1>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;">📊 Phân bố kiểu MBTI</div>
            <canvas id="chartPhanBo" height="220"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;">📈 Lượt test theo tháng</div>
            <canvas id="chartThang" height="220"></canvas>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('chartPhanBo'), {
    type: 'doughnut',
    data: {
        labels: @json($phanBoMbti->pluck('kieu_mbti')),
        datasets: [{
            data: @json($phanBoMbti->pluck('so_luong')),
            backgroundColor: ['#34d399','#3b82f6','#8b5cf6','#ef4444','#f97316','#06b6d4','#ec4899','#eab308','#14b8a6','#6366f1','#f43f5e','#84cc16','#a855f7','#22d3ee','#fb923c','#a3e635']
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'right', labels: { font: { size: 11 } } } } }
});

new Chart(document.getElementById('chartThang'), {
    type: 'line',
    data: {
        labels: @json($testTheoThang->map(fn($t) => $t->thang.'/'.$t->nam)),
        datasets: [{
            label: 'Lượt test',
            data: @json($testTheoThang->pluck('so_luong')),
            borderColor: '#34d399',
            backgroundColor: 'rgba(52,211,153,0.1)',
            fill: true,
            tension: 0.3,
            borderWidth: 2
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
