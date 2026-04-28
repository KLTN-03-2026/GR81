<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - MBTI-CRS</title>
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
        .auth-left .tips { margin-top: 28px; }
        .auth-left .tip-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 14px; font-size: 13px; line-height: 1.5; }
        .auth-left .tip-item i { font-size: 16px; margin-top: 2px; flex-shrink: 0; }
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
        .password-strength { margin-top: 6px; height: 4px; border-radius: 2px; background: #e8ecf1; overflow: hidden; }
        .password-strength .bar { height: 100%; width: 0; border-radius: 2px; transition: width 0.3s, background 0.3s; }
        @media (max-width: 768px) { .auth-left { display: none; } .auth-container { max-width: 420px; } }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <div class="icon-wrap">
                <i class="bi bi-key"></i>
            </div>
            <h1>Tạo mật khẩu mới</h1>
            <p>Hãy chọn mật khẩu mạnh để bảo vệ tài khoản của bạn.</p>
            <div class="tips">
                <div class="tip-item">
                    <i class="bi bi-check-circle"></i>
                    <span>Tối thiểu 8 ký tự</span>
                </div>
                <div class="tip-item">
                    <i class="bi bi-check-circle"></i>
                    <span>Kết hợp chữ hoa, chữ thường và số</span>
                </div>
                <div class="tip-item">
                    <i class="bi bi-check-circle"></i>
                    <span>Sử dụng ký tự đặc biệt (@, #, $...)</span>
                </div>
                <div class="tip-item">
                    <i class="bi bi-check-circle"></i>
                    <span>Không dùng thông tin cá nhân</span>
                </div>
            </div>
        </div>
        <div class="auth-right">
            <h2>Đặt lại mật khẩu</h2>
            <p class="subtitle">Nhập mật khẩu mới cho tài khoản <strong>{{ $email }}</strong></p>

            @if(session('error'))
            <div class="alert alert-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error"><i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/dat-lai-mat-khau">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" name="mat_khau" id="mat_khau" placeholder="Tối thiểu 8 ký tự" required autofocus>
                    <div class="password-strength"><div class="bar" id="strength-bar"></div></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="mat_khau_confirmation" placeholder="Nhập lại mật khẩu mới" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg"></i> Đặt lại mật khẩu
                </button>
            </form>
            <div class="auth-link">
                <i class="bi bi-arrow-left"></i> <a href="/dang-nhap">Quay lại đăng nhập</a>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('mat_khau');
        const strengthBar = document.getElementById('strength-bar');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            const widths = ['0%', '25%', '50%', '75%', '100%'];
            const colors = ['#e8ecf1', '#f87171', '#fbbf24', '#34d399', '#059669'];

            strengthBar.style.width = widths[strength];
            strengthBar.style.background = colors[strength];
        });
    </script>
</body>
</html>
