@extends('layouts.app')
@section('title', 'So sánh kết quả test')

@section('content')
<div class="page-header">
    <h1 class="page-title">So sánh kết quả test MBTI</h1>
    <p style="color:#64748b;font-size:14px;">Theo dõi sự thay đổi tính cách qua các lần làm test</p>
</div>

@if($danhSach->count() < 2)
<div class="card">
    <div class="card-body" style="text-align:center;padding:60px;">
        <i class="bi bi-arrow-left-right" style="font-size:48px;color:#ddd;"></i>
        <p style="margin-top:12px;color:#888;font-size:14px;">Bạn cần làm ít nhất 2 lần test để có thể so sánh kết quả.</p>
        <a href="/bai-test" class="btn btn-primary" style="margin-top:16px;"><i class="bi bi-pencil-square"></i> Làm test ngay</a>
    </div>
</div>
@else
<!-- Chọn 2 lần test -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px;">
        <form method="GET" action="/so-sanh-test" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <span style="font-size:13px;font-weight:600;">Chọn 2 lần test:</span>
            <select name="id1" style="padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;">
                @foreach($danhSach as $item)
                <option value="{{ $item->id }}" {{ ($ketQua1 && $ketQua1->id == $item->id) ? 'selected' : '' }}>
                    {{ $item->kieu_mbti }} — {{ $item->tao_luc->format('d/m/Y H:i') }}
                </option>
                @endforeach
            </select>
            <span style="color:#94a3b8;">so với</span>
            <select name="id2" style="padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;">
                @foreach($danhSach as $idx => $item)
                <option value="{{ $item->id }}" {{ ($ketQua2 && $ketQua2->id == $item->id) ? 'selected' : (($idx == 1 && !$ketQua2) ? 'selected' : '') }}>
                    {{ $item->kieu_mbti }} — {{ $item->tao_luc->format('d/m/Y H:i') }}
                </option>
                @endforeach
            </select>
            <button class="btn btn-primary" style="padding:8px 20px;"><i class="bi bi-arrow-left-right"></i> So sánh</button>
        </form>
    </div>
</div>

@if($ketQua1 && $ketQua2)
<!-- Bảng so sánh -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    @foreach([$ketQua1, $ketQua2] as $idx => $kq)
    <div class="card">
        <div class="card-body" style="text-align:center;">
            <div style="font-size:11px;color:#94a3b8;margin-bottom:8px;">Lần {{ $idx + 1 }} — {{ $kq->tao_luc->format('d/m/Y') }}</div>
            <div style="background:linear-gradient(135deg,{{ $idx == 0 ? '#34d399,#059669' : '#60a5fa,#2563eb' }});border-radius:12px;padding:16px;margin-bottom:12px;">
                <div style="font-size:32px;font-weight:900;color:#fff;">{{ $kq->kieu_mbti }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Chi tiết so sánh từng chiều -->
<div class="card">
    <div class="card-body">
        <div style="font-weight:600;font-size:14px;margin-bottom:20px;"><i class="bi bi-bar-chart" style="color:#059669;"></i> So sánh chi tiết từng chiều</div>

        @php
        $chieu = [
            ['E', 'I', 'Hướng ngoại', 'Hướng nội', 'phan_tram_e', 'phan_tram_i'],
            ['S', 'N', 'Cảm nhận', 'Trực giác', 'phan_tram_s', 'phan_tram_n'],
            ['T', 'F', 'Lý trí', 'Cảm xúc', 'phan_tram_t', 'phan_tram_f'],
            ['J', 'P', 'Nguyên tắc', 'Linh hoạt', 'phan_tram_j', 'phan_tram_p'],
        ];
        @endphp

        @foreach($chieu as $c)
        <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #f1f5f9;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <span style="font-weight:700;font-size:13px;">{{ $c[0] }} ({{ $c[2] }}) / {{ $c[1] }} ({{ $c[3] }})</span>
            </div>

            <!-- Lần 1 -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span style="font-size:11px;color:#059669;font-weight:600;width:50px;">Lần 1</span>
                <div style="flex:1;display:flex;height:20px;background:#f1f5f9;border-radius:4px;overflow:hidden;">
                    <div style="width:{{ $ketQua1->{$c[4]} }}%;background:#34d399;display:flex;align-items:center;justify-content:center;font-size:10px;color:#fff;font-weight:700;">{{ $c[0] }} {{ round($ketQua1->{$c[4]}) }}%</div>
                    <div style="flex:1;display:flex;align-items:center;justify-content:center;font-size:10px;color:#64748b;font-weight:600;">{{ $c[1] }} {{ round($ketQua1->{$c[5]}) }}%</div>
                </div>
            </div>

            <!-- Lần 2 -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span style="font-size:11px;color:#2563eb;font-weight:600;width:50px;">Lần 2</span>
                <div style="flex:1;display:flex;height:20px;background:#f1f5f9;border-radius:4px;overflow:hidden;">
                    <div style="width:{{ $ketQua2->{$c[4]} }}%;background:#60a5fa;display:flex;align-items:center;justify-content:center;font-size:10px;color:#fff;font-weight:700;">{{ $c[0] }} {{ round($ketQua2->{$c[4]}) }}%</div>
                    <div style="flex:1;display:flex;align-items:center;justify-content:center;font-size:10px;color:#64748b;font-weight:600;">{{ $c[1] }} {{ round($ketQua2->{$c[5]}) }}%</div>
                </div>
            </div>

            <!-- Sự thay đổi -->
            @php $change = round($ketQua2->{$c[4]} - $ketQua1->{$c[4]}, 1); @endphp
            <div style="font-size:11px;padding-left:60px;{{ $change > 0 ? 'color:#059669' : ($change < 0 ? 'color:#ef4444' : 'color:#94a3b8') }};">
                @if($change > 0) <i class="bi bi-arrow-up"></i> {{ $c[0] }} tăng {{ $change }}%
                @elseif($change < 0) <i class="bi bi-arrow-down"></i> {{ $c[0] }} giảm {{ abs($change) }}%
                @else <i class="bi bi-dash"></i> Không thay đổi
                @endif
            </div>
        </div>
        @endforeach

        <!-- Nhận xét tổng -->
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:16px;">
            <div style="font-weight:600;font-size:13px;color:#059669;margin-bottom:6px;"><i class="bi bi-lightbulb"></i> Nhận xét</div>
            <p style="font-size:13px;color:#475569;margin:0;line-height:1.7;">
                @if($ketQua1->kieu_mbti === $ketQua2->kieu_mbti)
                Kiểu tính cách của bạn vẫn là <strong>{{ $ketQua1->kieu_mbti }}</strong> qua cả 2 lần test. Điều này cho thấy tính cách cốt lõi khá ổn định, chỉ có sự dao động nhẹ ở một số chiều.
                @else
                Kiểu tính cách đã thay đổi từ <strong>{{ $ketQua1->kieu_mbti }}</strong> sang <strong>{{ $ketQua2->kieu_mbti }}</strong>. Sự thay đổi này có thể do trải nghiệm sống, môi trường hoặc sự phát triển cá nhân.
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Biểu đồ Radar so sánh -->
<div class="card" style="margin-top:20px;">
    <div class="card-body">
        <div style="font-weight:600;font-size:14px;margin-bottom:16px;"><i class="bi bi-diagram-3" style="color:#7c3aed;"></i> Biểu đồ so sánh</div>
        <canvas id="radarCompare" height="300"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('radarCompare'), {
    type: 'radar',
    data: {
        labels: ['E (Hướng ngoại)', 'S (Cảm nhận)', 'T (Lý trí)', 'J (Nguyên tắc)', 'I (Hướng nội)', 'N (Trực giác)', 'F (Cảm xúc)', 'P (Linh hoạt)'],
        datasets: [{
            label: 'Lần 1 — {{ $ketQua1->kieu_mbti }}',
            data: [{{ $ketQua1->phan_tram_e }},{{ $ketQua1->phan_tram_s }},{{ $ketQua1->phan_tram_t }},{{ $ketQua1->phan_tram_j }},{{ $ketQua1->phan_tram_i }},{{ $ketQua1->phan_tram_n }},{{ $ketQua1->phan_tram_f }},{{ $ketQua1->phan_tram_p }}],
            backgroundColor: 'rgba(52,211,153,0.2)', borderColor: '#059669', pointBackgroundColor: '#059669', borderWidth: 2
        },{
            label: 'Lần 2 — {{ $ketQua2->kieu_mbti }}',
            data: [{{ $ketQua2->phan_tram_e }},{{ $ketQua2->phan_tram_s }},{{ $ketQua2->phan_tram_t }},{{ $ketQua2->phan_tram_j }},{{ $ketQua2->phan_tram_i }},{{ $ketQua2->phan_tram_n }},{{ $ketQua2->phan_tram_f }},{{ $ketQua2->phan_tram_p }}],
            backgroundColor: 'rgba(96,165,250,0.2)', borderColor: '#2563eb', pointBackgroundColor: '#2563eb', borderWidth: 2
        }]
    },
    options: { scales: { r: { min: 0, max: 100, ticks: { stepSize: 20 } } }, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endif
@endif
@endsection
