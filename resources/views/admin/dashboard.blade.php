@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
</div>

<!-- Stat Cards -->
<div class="grid grid-4" style="margin-bottom:20px;">
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-people"></i></div>
        <div class="stat-label">Người dùng</div>
        <div class="stat-value">{{ $tongNguoiDung }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-pencil-square"></i></div>
        <div class="stat-label">Lượt test</div>
        <div class="stat-value">{{ $tongTest }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="bi bi-question-circle"></i></div>
        <div class="stat-label">Câu hỏi</div>
        <div class="stat-value">{{ $tongCauHoi }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="bi bi-briefcase"></i></div>
        <div class="stat-label">Nghề nghiệp</div>
        <div class="stat-value">{{ $tongNghe }}</div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Biểu đồ phân bố MBTI -->
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;">📊 Phân bố kiểu MBTI</div>
            <canvas id="chartMbti" height="200"></canvas>
        </div>
    </div>

    <!-- Người dùng mới -->
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:14px;margin-bottom:16px;">👥 Người dùng mới</div>
            <table class="table">
                <thead><tr><th>Họ tên</th><th>Email</th><th>Ngày</th></tr></thead>
                <tbody>
                    @foreach($nguoiDungMoi as $nd)
                    <tr>
                        <td style="font-weight:500;">{{ $nd->ho_ten }}</td>
                        <td style="color:#888;">{{ $nd->email }}</td>
                        <td style="color:#888;">{{ $nd->tao_luc->format('d/m') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('chartMbti'), {
    type: 'bar',
    data: {
        labels: @json($phanBoMbti->pluck('kieu_mbti')),
        datasets: [{
            label: 'Số lượt',
            data: @json($phanBoMbti->pluck('so_luong')),
            backgroundColor: '#34d399',
            borderRadius: 6
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
