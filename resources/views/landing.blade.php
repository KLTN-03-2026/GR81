<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBTI-CRS — Hệ thống đánh giá tính cách & Đợi xuất nghề nghiệp</title>
    <meta name="description" content="Khám phá kiểu tính cách MBTI của bạn và nhận gợi ý nghề nghiệp phù hợp từ AI. Miễn phí, chính xác, bảo mật.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, sans-serif; color: #0f172a; background: #fff; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; }

        /* === NAVBAR === */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 0 24px; transition: all 0.35s ease; }
        .navbar.scrolled { background: rgba(255,255,255,0.92); backdrop-filter: blur(16px) saturate(180%); border-bottom: 1px solid rgba(0,0,0,0.06); }
        .navbar-inner { max-width: 1120px; margin: 0 auto; height: 64px; display: flex; align-items: center; justify-content: space-between; }
        .logo { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
        .logo em { font-style: normal; color: #059669; }
        .nav-menu { display: flex; align-items: center; gap: 36px; }
        .nav-menu a { font-size: 14px; font-weight: 500; color: #64748b; transition: color 0.2s; }
        .nav-menu a:hover { color: #0f172a; }
        .nav-cta { padding: 9px 22px; background: #0f172a; color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .nav-cta:hover { background: #059669; transform: translateY(-1px); }

        /* === HERO === */
        .hero { padding: 140px 24px 100px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(ellipse 50% 80% at 50% -20%, rgba(5,150,105,0.06) 0%, transparent 100%); pointer-events: none; }
        .hero-inner { max-width: 1120px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; position: relative; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 100px; font-size: 12px; font-weight: 600; color: #059669; margin-bottom: 24px; }
        .hero-badge i { font-size: 14px; }
        .hero h1 { font-size: 48px; font-weight: 900; line-height: 1.12; letter-spacing: -1.5px; margin-bottom: 20px; }
        .hero h1 .highlight { background: linear-gradient(135deg, #059669, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-subtitle { font-size: 17px; color: #64748b; line-height: 1.7; margin-bottom: 36px; max-width: 460px; }
        .hero-actions { display: flex; gap: 12px; margin-bottom: 40px; }
        .btn-primary { padding: 14px 32px; background: #059669; color: #fff; border-radius: 10px; font-size: 15px; font-weight: 600; transition: all 0.25s; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(5,150,105,0.2); }
        .btn-primary:hover { background: #047857; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(5,150,105,0.25); }
        .btn-secondary { padding: 14px 32px; background: #fff; color: #0f172a; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; font-weight: 600; transition: all 0.25s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { border-color: #059669; color: #059669; }
        .hero-trust { display: flex; align-items: center; gap: 16px; font-size: 13px; color: #94a3b8; }
        .hero-trust .divider { width: 1px; height: 16px; background: #e2e8f0; }
        .hero-trust strong { color: #0f172a; font-weight: 600; }

        /* HERO VISUAL — MBTI Grid */
        .mbti-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; perspective: 800px; }
        .mbti-cell { background: #fff; border: 1px solid #f1f5f9; border-radius: 10px; padding: 14px 6px; text-align: center; transition: all 0.3s ease; cursor: default; }
        .mbti-cell:hover { transform: translateY(-4px) rotateX(2deg); box-shadow: 0 12px 32px rgba(0,0,0,0.08); border-color: transparent; }
        .mbti-cell .code { font-size: 18px; font-weight: 800; letter-spacing: -0.3px; margin-bottom: 2px; }
        .mbti-cell .name { font-size: 8.5px; color: #94a3b8; font-weight: 500; letter-spacing: 0.2px; }
        .mbti-cell.green .code { color: #059669; } .mbti-cell.green:hover { background: #f0fdf4; }
        .mbti-cell.blue .code { color: #2563eb; } .mbti-cell.blue:hover { background: #eff6ff; }
        .mbti-cell.purple .code { color: #7c3aed; } .mbti-cell.purple:hover { background: #faf5ff; }
        .mbti-cell.amber .code { color: #d97706; } .mbti-cell.amber:hover { background: #fffbeb; }

        /* === LOGOS / TRUST === */
        .trust-bar { padding: 48px 24px; border-top: 1px solid #f1f5f9; }
        .trust-inner { max-width: 1120px; margin: 0 auto; text-align: center; }
        .trust-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; margin-bottom: 24px; }
        .trust-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; }
        .trust-stat .num { font-size: 36px; font-weight: 900; letter-spacing: -1px; }
        .trust-stat .num.green { color: #059669; }
        .trust-stat .label { font-size: 13px; color: #94a3b8; margin-top: 4px; font-weight: 500; }

        /* === SECTION COMMON === */
        .section { padding: 96px 24px; }
        .section-inner { max-width: 1120px; margin: 0 auto; }
        .section-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #059669; margin-bottom: 12px; }
        .section-title { font-size: 32px; font-weight: 800; letter-spacing: -0.8px; margin-bottom: 8px; line-height: 1.2; }
        .section-desc { font-size: 16px; color: #64748b; line-height: 1.6; max-width: 520px; }
        .section-header { margin-bottom: 56px; }
        .section-header.center { text-align: center; }
        .section-header.center .section-desc { margin: 0 auto; }
        .section-alt { background: #fafbfc; }

        /* === FEATURES === */
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feature { background: #fff; border: 1px solid #f1f5f9; border-radius: 14px; padding: 32px 28px; transition: all 0.3s ease; }
        .feature:hover { border-color: #e2e8f0; box-shadow: 0 12px 32px rgba(0,0,0,0.04); transform: translateY(-2px); }
        .feature-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 20px; }
        .feature h3 { font-size: 16px; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.2px; }
        .feature p { font-size: 14px; color: #64748b; line-height: 1.6; }

        /* === HOW IT WORKS === */
        .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; position: relative; }
        .steps-grid::before { content: ''; position: absolute; top: 28px; left: 15%; right: 15%; height: 2px; background: linear-gradient(90deg, #dcfce7 0%, #34d399 50%, #dcfce7 100%); z-index: 0; }
        .step { text-align: center; position: relative; z-index: 1; }
        .step-number { width: 56px; height: 56px; border-radius: 50%; background: #fff; border: 3px solid #dcfce7; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 20px; font-weight: 800; color: #059669; transition: all 0.3s; }
        .step:hover .step-number { background: #059669; color: #fff; border-color: #059669; transform: scale(1.1); }
        .step h3 { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
        .step p { font-size: 13px; color: #94a3b8; line-height: 1.5; padding: 0 8px; }

        /* === MBTI DIMENSIONS === */
        .dims-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .dim-card { background: #fff; border: 1px solid #f1f5f9; border-radius: 14px; padding: 28px; display: flex; gap: 20px; align-items: center; transition: all 0.3s; }
        .dim-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.04); transform: translateY(-2px); }
        .dim-visual { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 900; flex-shrink: 0; }
        .dim-info h3 { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .dim-info p { font-size: 13px; color: #64748b; line-height: 1.5; }
        .dim-tags { display: flex; gap: 6px; margin-top: 8px; }
        .dim-tag { padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }

        /* === FAQ === */
        .faq-list { max-width: 680px; margin: 0 auto; }
        .faq-item { border-bottom: 1px solid #f1f5f9; }
        .faq-q { padding: 20px 0; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: color 0.2s; }
        .faq-q:hover { color: #059669; }
        .faq-q i { font-size: 14px; color: #94a3b8; transition: transform 0.3s; }
        .faq-a { max-height: 0; overflow: hidden; transition: max-height 0.35s ease, padding 0.35s; }
        .faq-a p { font-size: 14px; color: #64748b; line-height: 1.7; padding-bottom: 20px; }
        .faq-item.open .faq-a { max-height: 200px; }
        .faq-item.open .faq-q i { transform: rotate(45deg); }

        /* === CTA === */
        .cta { padding: 96px 24px; background: #0f172a; text-align: center; position: relative; overflow: hidden; }
        .cta::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 50% at 50% 120%, rgba(5,150,105,0.15) 0%, transparent 100%); }
        .cta-inner { max-width: 560px; margin: 0 auto; position: relative; }
        .cta h2 { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -0.8px; margin-bottom: 12px; line-height: 1.2; }
        .cta p { font-size: 16px; color: #94a3b8; margin-bottom: 36px; line-height: 1.6; }
        .cta .btn-cta { padding: 16px 40px; background: #059669; color: #fff; border-radius: 12px; font-size: 16px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px; transition: all 0.25s; box-shadow: 0 4px 16px rgba(5,150,105,0.3); }
        .cta .btn-cta:hover { background: #34d399; transform: translateY(-2px); box-shadow: 0 8px 32px rgba(5,150,105,0.35); }
        .cta-note { font-size: 12px; color: #475569; margin-top: 16px; }

        /* === FOOTER === */
        .footer { padding: 32px 24px; border-top: 1px solid #f1f5f9; background: #fafbfc; }
        .footer-inner { max-width: 1120px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .footer-brand { font-size: 13px; color: #94a3b8; }
        .footer-brand strong { color: #0f172a; font-weight: 700; }
        .footer-links { display: flex; gap: 24px; }
        .footer-links a { font-size: 13px; color: #94a3b8; font-weight: 500; transition: color 0.2s; }
        .footer-links a:hover { color: #059669; }

        /* === ANIMATIONS === */
        .fade-up { opacity: 0; transform: translateY(24px); transition: all 0.6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .hero-inner { grid-template-columns: 1fr; gap: 48px; text-align: center; }
            .hero h1 { font-size: 32px; }
            .hero-subtitle { max-width: 100%; }
            .hero-actions { justify-content: center; }
            .hero-trust { justify-content: center; }
            .hero-visual { order: -1; }
            .features-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr 1fr; }
            .steps-grid::before { display: none; }
            .dims-grid { grid-template-columns: 1fr; }
            .trust-stats { grid-template-columns: repeat(2, 1fr); }
            .nav-menu a:not(.nav-cta) { display: none; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="navbar-inner">
        <a href="/" class="logo">MBTI<em>-CRS</em></a>
        <div class="nav-menu">
            <a href="#tinh-nang">Tính năng</a>
            <a href="#quy-trinh">Cách hoạt động</a>
            <a href="#mbti">Về MBTI</a>
            <a href="#faq">FAQ</a>
            <a href="/dang-nhap" class="nav-cta">Đăng nhập</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-inner">
        <div class="fade-up">
            <div class="hero-badge"><i class="bi bi-lightning-charge-fill"></i> Kết hợp AI Gemini — Hoàn toàn miễn phí</div>
            <h1>Hiểu rõ bản thân,<br><span class="highlight">định hướng tương lai</span></h1>
            <p class="hero-subtitle">
                Hệ thống đánh giá tính cách MBTI kết hợp trí tuệ nhân tạo giúp bạn khám phá 
                thế mạnh, điểm yếu và nhận đề xuất nghề nghiệp được cá nhân hóa.
            </p>
            <div class="hero-actions">
                <a href="/dang-ky" class="btn-primary">Làm test miễn phí <i class="bi bi-arrow-right"></i></a>
                <a href="#quy-trinh" class="btn-secondary"><i class="bi bi-play-circle"></i> Xem cách hoạt động</a>
            </div>
            <div class="hero-trust">
                <span><strong>70</strong> câu hỏi trắc nghiệm</span>
                <span class="divider"></span>
                <span><strong>~15 phút</strong> hoàn thành</span>
                <span class="divider"></span>
                <span><strong>16</strong> kiểu tính cách</span>
            </div>
        </div>
        <div class="hero-visual fade-up">
            <div class="mbti-grid">
                @php $types = [
                    ['ISTJ','Nhà Hậu Cần','green'],['ISFJ','Người Bảo Vệ','blue'],['INFJ','Người Cố Vấn','purple'],['INTJ','Nhà Chiến Lược','amber'],
                    ['ISTP','Thợ Thủ Công','green'],['ISFP','Nghệ Sĩ','blue'],['INFP','Người Hòa Giải','purple'],['INTP','Nhà Tư Duy','amber'],
                    ['ESTP','Nhà Kinh Doanh','green'],['ESFP','Người Biểu Diễn','blue'],['ENFP','Người Truyền Lửa','purple'],['ENTP','Nhà Tranh Luận','amber'],
                    ['ESTJ','Người Điều Hành','green'],['ESFJ','Người Chăm Sóc','blue'],['ENFJ','Người Dẫn Dắt','purple'],['ENTJ','Nhà Chỉ Huy','amber'],
                ]; @endphp
                @foreach($types as $t)
                <div class="mbti-cell {{ $t[2] }}">
                    <div class="code">{{ $t[0] }}</div>
                    <div class="name">{{ $t[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- TRUST STATS -->
<div class="trust-bar">
    <div class="trust-inner">
        <div class="trust-label">Hệ thống đánh giá toàn diện</div>
        <div class="trust-stats">
            <div class="trust-stat fade-up"><div class="num green">70</div><div class="label">câu hỏi được thiết kế chuyên sâu</div></div>
            <div class="trust-stat fade-up"><div class="num green">4</div><div class="label">chiều đánh giá tính cách</div></div>
            <div class="trust-stat fade-up"><div class="num green">16</div><div class="label">kiểu tính cách MBTI</div></div>
            <div class="trust-stat fade-up"><div class="num green">AI</div><div class="label">gợi ý nghề nghiệp thông minh</div></div>
        </div>
    </div>
</div>

<!-- FEATURES -->
<section class="section" id="tinh-nang">
    <div class="section-inner">
        <div class="section-header center">
            <div class="section-label">Tính năng</div>
            <h2 class="section-title">Mọi thứ bạn cần để hiểu bản thân</h2>
            <p class="section-desc">Từ bài test chuẩn MBTI đến gợi ý nghề nghiệp bằng AI — tất cả trong một nền tảng duy nhất</p>
        </div>
        <div class="features-grid">
            <div class="feature fade-up">
                <div class="feature-icon" style="background:#f0fdf4;color:#059669;"><i class="bi bi-clipboard2-check"></i></div>
                <h3>Bài test MBTI chuẩn xác</h3>
                <p>70 câu hỏi trắc nghiệm A/B chia đều 4 nhóm chiều, được thiết kế dựa trên lý thuyết MBTI gốc của Myers-Briggs Foundation.</p>
            </div>
            <div class="feature fade-up">
                <div class="feature-icon" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-graph-up-arrow"></i></div>
                <h3>Phân tích trực quan</h3>
                <p>Kết quả trình bày qua biểu đồ radar, thanh phần trăm chi tiết cho từng chiều E/I, S/N, T/F, J/P — dễ hiểu, dễ chia sẻ.</p>
            </div>
            <div class="feature fade-up">
                <div class="feature-icon" style="background:#faf5ff;color:#7c3aed;"><i class="bi bi-robot"></i></div>
                <h3>AI đề xuất nghề nghiệp</h3>
                <p>Tích hợp Google Gemini AI phân tích tính cách kết hợp sở thích cá nhân để đề xuất nghề nghiệp phù hợp nhất với bạn.</p>
            </div>
            <div class="feature fade-up">
                <div class="feature-icon" style="background:#fef3c7;color:#d97706;"><i class="bi bi-clock-history"></i></div>
                <h3>Theo dõi sự thay đổi</h3>
                <p>Lưu trữ toàn bộ lịch sử các lần làm bài. So sánh kết quả theo thời gian để thấy sự phát triển tính cách của bạn.</p>
            </div>
            <div class="feature fade-up">
                <div class="feature-icon" style="background:#fce7f3;color:#db2777;"><i class="bi bi-person-badge"></i></div>
                <h3>Hồ sơ cá nhân hóa</h3>
                <p>Cập nhật sở thích, kỹ năng và mục tiêu nghề nghiệp để AI đưa ra gợi ý chính xác và phù hợp nhất.</p>
            </div>
            <div class="feature fade-up">
                <div class="feature-icon" style="background:#ecfdf5;color:#059669;"><i class="bi bi-shield-lock"></i></div>
                <h3>Bảo mật tuyệt đối</h3>
                <p>Mật khẩu được mã hóa bcrypt. Dữ liệu cá nhân chỉ hiển thị cho chính bạn, không chia sẻ với bên thứ ba.</p>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section section-alt" id="quy-trinh">
    <div class="section-inner">
        <div class="section-header center">
            <div class="section-label">Cách hoạt động</div>
            <h2 class="section-title">Bắt đầu chỉ trong 4 bước</h2>
            <p class="section-desc">Quy trình đơn giản, không cần kiến thức chuyên môn — ai cũng có thể self-discovery</p>
        </div>
        <div class="steps-grid">
            <div class="step fade-up">
                <div class="step-number">1</div>
                <h3>Tạo tài khoản</h3>
                <p>Đăng ký miễn phí chỉ với email và mật khẩu. Không yêu cầu thẻ tín dụng</p>
            </div>
            <div class="step fade-up">
                <div class="step-number">2</div>
                <h3>Làm bài trắc nghiệm</h3>
                <p>Trả lời 70 câu hỏi A/B trong khoảng 15 phút. Chọn theo bản năng, không suy nghĩ quá lâu</p>
            </div>
            <div class="step fade-up">
                <div class="step-number">3</div>
                <h3>Nhận phân tích</h3>
                <p>Xem kết quả MBTI kèm biểu đồ chi tiết, điểm mạnh, điểm yếu và đặc điểm tính cách</p>
            </div>
            <div class="step fade-up">
                <div class="step-number">4</div>
                <h3>Khám phá nghề nghiệp</h3>
                <p>AI phân tích tính cách + sở thích để gợi ý nghề nghiệp phù hợp nhất với bạn</p>
            </div>
        </div>
    </div>
</section>

<!-- MBTI DIMENSIONS -->
<section class="section" id="mbti">
    <div class="section-inner">
        <div class="section-header center">
            <div class="section-label">Về MBTI</div>
            <h2 class="section-title">4 chiều đánh giá tính cách</h2>
            <p class="section-desc">Mỗi chiều phản ánh cách bạn tiếp nhận thông tin, đưa ra quyết định và tương tác với thế giới</p>
        </div>
        <div class="dims-grid">
            <div class="dim-card fade-up">
                <div class="dim-visual" style="background:#f0fdf4;color:#059669;">E/I</div>
                <div class="dim-info">
                    <h3>Nguồn năng lượng</h3>
                    <p>Bạn lấy năng lượng từ việc giao tiếp xã hội hay từ thế giới nội tâm?</p>
                    <div class="dim-tags">
                        <span class="dim-tag" style="background:#f0fdf4;color:#059669;">Hướng ngoại (E)</span>
                        <span class="dim-tag" style="background:#f0fdf4;color:#059669;">Hướng nội (I)</span>
                    </div>
                </div>
            </div>
            <div class="dim-card fade-up">
                <div class="dim-visual" style="background:#eff6ff;color:#2563eb;">S/N</div>
                <div class="dim-info">
                    <h3>Tiếp nhận thông tin</h3>
                    <p>Bạn tin vào dữ kiện cụ thể hay thích suy luận từ trực giác và khả năng?</p>
                    <div class="dim-tags">
                        <span class="dim-tag" style="background:#eff6ff;color:#2563eb;">Cảm nhận (S)</span>
                        <span class="dim-tag" style="background:#eff6ff;color:#2563eb;">Trực giác (N)</span>
                    </div>
                </div>
            </div>
            <div class="dim-card fade-up">
                <div class="dim-visual" style="background:#faf5ff;color:#7c3aed;">T/F</div>
                <div class="dim-info">
                    <h3>Ra quyết định</h3>
                    <p>Bạn quyết định dựa trên logic khách quan hay cảm xúc và giá trị cá nhân?</p>
                    <div class="dim-tags">
                        <span class="dim-tag" style="background:#faf5ff;color:#7c3aed;">Lý trí (T)</span>
                        <span class="dim-tag" style="background:#faf5ff;color:#7c3aed;">Cảm xúc (F)</span>
                    </div>
                </div>
            </div>
            <div class="dim-card fade-up">
                <div class="dim-visual" style="background:#fffbeb;color:#d97706;">J/P</div>
                <div class="dim-info">
                    <h3>Phong cách sống</h3>
                    <p>Bạn thích lên kế hoạch có cấu trúc hay linh hoạt thích ứng theo tình huống?</p>
                    <div class="dim-tags">
                        <span class="dim-tag" style="background:#fffbeb;color:#d97706;">Nguyên tắc (J)</span>
                        <span class="dim-tag" style="background:#fffbeb;color:#d97706;">Linh hoạt (P)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="section section-alt" id="faq">
    <div class="section-inner">
        <div class="section-header center">
            <div class="section-label">FAQ</div>
            <h2 class="section-title">Câu hỏi thường gặp</h2>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">MBTI là gì? <i class="bi bi-plus"></i></div>
                <div class="faq-a"><p>MBTI (Myers-Briggs Type Indicator) là công cụ đánh giá tính cách dựa trên lý thuyết của Carl Jung. Nó phân loại con người vào 16 kiểu tính cách dựa trên 4 chiều: Hướng ngoại/Hướng nội, Cảm nhận/Trực giác, Lý trí/Cảm xúc, Nguyên tắc/Linh hoạt.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Bài test có miễn phí không? <i class="bi bi-plus"></i></div>
                <div class="faq-a"><p>Hoàn toàn miễn phí! Bạn chỉ cần đăng ký tài khoản và có thể làm bài test không giới hạn số lần. Tính năng gợi ý nghề nghiệp AI cũng miễn phí.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Kết quả có chính xác không? <i class="bi bi-plus"></i></div>
                <div class="faq-a"><p>Độ chính xác phụ thuộc vào sự trung thực của bạn. Hệ thống sử dụng 70 câu hỏi chia đều 4 chiều và tính phần trăm cho từng chiều, cung cấp kết quả chi tiết và đáng tin cậy.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">AI gợi ý nghề nghiệp hoạt động như thế nào? <i class="bi bi-plus"></i></div>
                <div class="faq-a"><p>Hệ thống sử dụng Google Gemini AI để phân tích kết quả MBTI kết hợp với sở thích, kỹ năng bạn đã cập nhật trong hồ sơ, từ đó đề xuất nghề nghiệp phù hợp nhất, bao gồm cả mức lương tham khảo và triển vọng ngành.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">Tôi có thể làm lại test không? <i class="bi bi-plus"></i></div>
                <div class="faq-a"><p>Có! Bạn có thể làm lại bất cứ lúc nào. Mỗi lần kết quả đều được lưu trong lịch sử để bạn theo dõi sự thay đổi tính cách theo thời gian.</p></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="cta-inner fade-up">
        <h2>Bắt đầu hành trình<br>khám phá bản thân</h2>
        <p>Chỉ mất 15 phút để hiểu rõ tính cách và tìm ra con đường sự nghiệp phù hợp nhất</p>
        <a href="/dang-ky" class="btn-cta">Tạo tài khoản miễn phí <i class="bi bi-arrow-right"></i></a>
        <div class="cta-note">Không yêu cầu thẻ tín dụng · Miễn phí mãi mãi</div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand"><strong>MBTI-CRS</strong> · Đồ án tốt nghiệp · © {{ date('Y') }}</div>
        <div class="footer-links">
            <a href="/dang-nhap">Đăng nhập</a>
            <a href="/dang-ky">Đăng ký</a>
            <a href="#tinh-nang">Tính năng</a>
            <a href="#faq">FAQ</a>
        </div>
    </div>
</footer>

<script>
// Navbar scroll effect
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
});

// Fade-up on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>
</body>
</html>
