<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - MBTI-CRS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-container { display: flex; width: 900px; max-width: 95vw; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .auth-left { flex: 1; background: linear-gradient(135deg, #059669, #34d399); padding: 48px; display: flex; flex-direction: column; justify-content: center; color: #fff; }
        .auth-left h1 { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        .auth-left p { font-size: 14px; opacity: 0.9; line-height: 1.6; }
        .auth-left .features { margin-top: 28px; }
        .auth-left .feature-item { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; font-size: 13px; }
        .auth-left .feature-item i { font-size: 16px; }
        .auth-right { flex: 1; padding: 48px; display: flex; flex-direction: column; justify-content: center; }
        .auth-right h2 { font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
        .auth-right .subtitle { font-size: 13px; color: #888; margin-bottom: 28px; }
        .form-group { margin-bottom: 16px; }
        .form-label { font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; display: block; }
        .form-control { width: 100%; padding: 11px 14px; border: 1px solid #e8ecf1; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; outline: none; }
        .form-control:focus { border-color: #34d399; box-shadow: 0 0 0 3px rgba(52,211,153,0.1); }
        .btn-submit { width: 100%; padding: 12px; background: #34d399; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; font-family: 'Inter', sans-serif; }
        .btn-submit:hover { background: #059669; }
        .auth-link { text-align: center; margin-top: 16px; font-size: 13px; color: #888; }
        .auth-link a { color: #059669; text-decoration: none; font-weight: 500; }
        .auth-link a:hover { text-decoration: underline; }
        .alert { padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .remember { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #666; margin-bottom: 16px; }
        @media (max-width: 768px) { .auth-left { display: none; } .auth-container { max-width: 420px; } }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <h1>MBTI-CRS</h1>
            <p>Hệ thống đánh giá tính cách và đề xuất nghề nghiệp theo mô hình MBTI kết hợp trí tuệ nhân tạo.</p>
            <div class="features">
                <div class="feature-item"><i class="bi bi-check-circle"></i> 70 câu hỏi trắc nghiệm MBTI</div>
                <div class="feature-item"><i class="bi bi-check-circle"></i> Phân tích 16 kiểu tính cách</div>
                <div class="feature-item"><i class="bi bi-check-circle"></i> Gợi ý nghề nghiệp bằng AI</div>
                <div class="feature-item"><i class="bi bi-check-circle"></i> Biểu đồ trực quan Chart.js</div>
            </div>
        </div>
        <div class="auth-right">
            <h2>Đăng nhập</h2>
            <p class="subtitle">Chào mừng bạn quay trở lại!</p>

            @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/dang-nhap">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="mat_khau" placeholder="••••••••" required>
                </div>
                <label class="remember">
                    <input type="checkbox" name="ghi_nho"> Ghi nhớ đăng nhập
                </label>
                <button type="submit" class="btn-submit">Đăng nhập</button>
            </form>
            <div class="auth-link">Chưa có tài khoản? <a href="/dang-ky">Đăng ký ngay</a></div>
        </div>
    </div>
</body>
</html>
