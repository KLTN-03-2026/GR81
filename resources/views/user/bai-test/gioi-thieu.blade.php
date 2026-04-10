@extends('layouts.app')
@section('title', 'Bài Test MBTI')

@section('content')
<div class="page-header">
    <h1 class="page-title">Bài test MBTI</h1>
</div>

<!-- Thông tin bài test -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:20px;">
    <div class="card">
        <div class="card-body">
            <div style="font-weight:600;font-size:15px;color:#1a1a2e;margin-bottom:12px;">Đánh giá tính cách MBTI</div>
            <p style="font-size:13px;color:#666;line-height:1.8;margin-bottom:16px;">
                Bài test gồm <strong>{{ $tongCauHoi }} câu hỏi</strong> trắc nghiệm A/B, chia thành 4 nhóm chiều đánh giá.
                Kết quả sẽ xác định kiểu tính cách của bạn trong 16 nhóm MBTI và đề xuất nghề nghiệp phù hợp.
            </p>

            <table class="table" style="margin-bottom:0;">
                <thead>
                    <tr><th>Chiều</th><th>Mô tả</th><th style="text-align:center;">Số câu</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="mbti-badge mbti-green">E / I</span></td>
                        <td style="font-size:13px;">Hướng ngoại — Hướng nội</td>
                        <td style="text-align:center;font-size:13px;">18</td>
                    </tr>
                    <tr>
                        <td><span class="mbti-badge mbti-blue">S / N</span></td>
                        <td style="font-size:13px;">Cảm nhận — Trực giác</td>
                        <td style="text-align:center;font-size:13px;">17</td>
                    </tr>
                    <tr>
                        <td><span class="mbti-badge mbti-purple">T / F</span></td>
                        <td style="font-size:13px;">Lý trí — Cảm xúc</td>
                        <td style="text-align:center;font-size:13px;">17</td>
                    </tr>
                    <tr>
                        <td><span class="mbti-badge mbti-orange">J / P</span></td>
                        <td style="font-size:13px;">Nguyên tắc — Linh hoạt</td>
                        <td style="text-align:center;font-size:13px;">18</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="card">
            <div class="card-body">
                <div style="font-weight:600;font-size:14px;margin-bottom:12px;">Hướng dẫn</div>
                <ul style="font-size:13px;color:#555;line-height:2;padding-left:18px;margin:0;">
                    <li>Mỗi câu có 2 lựa chọn A hoặc B</li>
                    <li>Chọn phương án phù hợp nhất với bạn</li>
                    <li>Không có đáp án đúng hay sai</li>
                    <li>Trả lời trung thực để kết quả chính xác</li>
                    <li>Thời gian ước tính: ~15 phút</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align:center;">
                <div style="font-size:13px;color:#888;margin-bottom:4px;">Tổng câu hỏi</div>
                <div style="font-size:32px;font-weight:800;color:#1a1a2e;margin-bottom:16px;">{{ $tongCauHoi }}</div>
                <a href="/bai-test/lam-bai" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px;">
                    Bắt đầu làm bài
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
