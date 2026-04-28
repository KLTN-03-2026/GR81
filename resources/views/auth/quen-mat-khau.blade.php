<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - MBTI-CRS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-container { display: flex; width: 900px; max-width: 95vw; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .auth-left { flex: 1; background: linear-gradient(135deg, #059669, #34d399); padding: 48px; display: flex; flex-direction: column; justify-content: center; color: #fff; }
        .auth-left h1 { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        .auth-left p { font-size: 14px; opacity: 0.9; line-height: 1.6; }
        .auth-left .icon-wrap { margin-bottom: 24px; }
        .auth-left .icon-wrap i { font-size: 64px; opacity: 0.9; }
        .auth-left .steps { margin-top: 28px; }
        .auth-left .step-item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; font-size: 13px; }
        .auth-left .step-num { width: 24px; height: 24px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }
        .auth-right { flex: 1; padding: 48px; display: flex; flex-direction: column; justify-content: center; }
        .auth-right h2 { font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
        .auth-right .subtitle { font-size: 13px; color: #888; margin-bottom: 28px; line-height: 1.6; }
        .form-group { margin-bottom: 16px; }
        .form-label { font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; display: block; }
        .form-control { width: 100%; padding: 11px 14px; border: 1px solid #e8ecf1; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #34d399; box-shadow: 0 0 0 3px rgba(52,211,153,0.1); }
        .btn-submit { width: 100%; padding: 12px; background: #34d399; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-submit:hover { background: #059669; }
        .btn-submit:active { transform: scale(0.98); }
        .auth-link { text-align: center; margin-top: 20px; font-size: 13px; color: #888; }
        .auth-link a { color: #059669; text-decoration: none; font-weight: 500; }
        .auth-link a:hover { text-decoration: underline; }
        .alert { padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: flex-start; gap: 10px; line-height: 1.5; }
        .alert i { font-size: 16px; margin-top: 1px; flex-shrink: 0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        @media (max-width: 768px) { .auth-left { display: none; } .auth-container { max-width: 420px; } }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <div class="icon-wrap">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h1>Quên mật khẩu?</h1>
            <p>Đừng lo, chúng tôi sẽ giúp bạn lấy lại quyền truy cập tài khoản một cách nhanh chóng.</p>
            <div class="steps">
                <div class="step-item">
                    <span class="step-num">1</span>
                    <span>Nhập email đã đăng ký tài khoản</span>
                </div>
                <div class="step-item">
                    <span class="step-num">2</span>
                    <span>Kiểm tra hộp thư và nhấn vào link</span>
                </div>
                <div class="step-item">
                    <span class="step-num">3</span>
                    <span>Tạo mật khẩu mới và đăng nhập</span>
                </div>
            </div>
        </div>
        <div class="auth-right">
            <h2>Khôi phục mật khẩu</h2>
            <p class="subtitle">Nhập email đã đăng ký để nhận link đặt lại mật khẩu. Link sẽ có hiệu lực trong 60 phút.</p>

            @if(session('error'))
            <div class="alert alert-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @if(session('success'))
            <div class="alert alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error"><i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/quen-mat-khau">
                @csrf
                <div class="form-group">
                    <label class="form-label">Địa chỉ email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-envelope"></i> Gửi link đặt lại mật khẩu
                </button>
            </form>
            <div class="auth-link">
                <i class="bi bi-arrow-left"></i> <a href="/dang-nhap">Quay lại đăng nhập</a>
            </div>
        </div>
    </div>
</body>
</html>
