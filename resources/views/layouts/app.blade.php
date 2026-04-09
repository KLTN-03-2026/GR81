<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MBTI-CRS')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; color: #333; display: flex; min-height: 100vh; }

        /* === SIDEBAR === */
        .sidebar { width: 250px; background: #fff; border-right: 1px solid #e8ecf1; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; }
        .sidebar-header { padding: 24px 20px 16px; border-bottom: 1px solid #e8ecf1; }
        .sidebar-header .user-info { display: flex; align-items: center; gap: 12px; }
        .sidebar-header .avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #34d399, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 16px; }
        .sidebar-header .user-name { font-weight: 600; font-size: 14px; color: #1a1a2e; }
        .sidebar-header .user-email { font-size: 12px; color: #888; margin-top: 2px; }
        .sidebar-search { padding: 12px 16px; }
        .sidebar-search input { width: 100%; padding: 8px 12px; border: 1px solid #e8ecf1; border-radius: 8px; font-size: 13px; background: #f8f9fb; outline: none; }
        .sidebar-search input:focus { border-color: #34d399; }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 8px 0; }
        .nav-section { padding: 8px 20px 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; color: #aaa; margin-top: 8px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; font-size: 14px; color: #555; text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent; cursor: pointer; }
        .nav-item:hover { background: #f0fdf4; color: #059669; }
        .nav-item.active { background: #f0fdf4; color: #059669; border-left-color: #34d399; font-weight: 600; }
        .nav-item i { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer { padding: 12px 16px; border-top: 1px solid #e8ecf1; display: flex; gap: 8px; }
        .sidebar-footer a, .sidebar-footer button { flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; text-decoration: none; transition: 0.2s; background: #f8f9fb; color: #666; font-family: 'Inter', sans-serif; }
        .sidebar-footer a:hover { background: #e8ecf1; }
        .sidebar-footer .btn-logout { color: #ef4444; }
        .sidebar-footer .btn-logout:hover { background: #fef2f2; }

        /* === MAIN CONTENT === */
        .main-content { margin-left: 250px; flex: 1; padding: 24px 32px; min-height: 100vh; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title { font-size: 22px; font-weight: 700; color: #1a1a2e; }

        /* === CARDS === */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf1; }
        .card-body { padding: 20px; }

        /* === STAT CARDS === */
        .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf1; padding: 20px; display: flex; flex-direction: column; gap: 8px; }
        .stat-card .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .stat-card .stat-icon.green { background: #f0fdf4; color: #059669; }
        .stat-card .stat-icon.blue { background: #eff6ff; color: #2563eb; }
        .stat-card .stat-icon.purple { background: #faf5ff; color: #7c3aed; }
        .stat-card .stat-icon.orange { background: #fff7ed; color: #ea580c; }
        .stat-card .stat-label { font-size: 12px; color: #888; }
        .stat-card .stat-value { font-size: 24px; font-weight: 700; color: #1a1a2e; }

        /* === MBTI BADGE === */
        .mbti-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .mbti-badge.green { background: #dcfce7; color: #166534; }
        .mbti-badge.blue { background: #dbeafe; color: #1e40af; }
        .mbti-badge.purple { background: #f3e8ff; color: #6b21a8; }
        .mbti-badge.red { background: #fee2e2; color: #991b1b; }
        .mbti-badge.orange { background: #ffedd5; color: #9a3412; }
        .mbti-badge.teal { background: #ccfbf1; color: #115e59; }

        /* === TABLE === */
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #888; border-bottom: 1px solid #e8ecf1; }
        .table td { padding: 14px 16px; font-size: 14px; border-bottom: 1px solid #f1f3f5; color: #333; }
        .table tr:hover td { background: #fafbfc; }

        /* === BUTTONS === */
        .btn { padding: 8px 16px; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-family: 'Inter', sans-serif; }
        .btn-primary { background: #34d399; color: #fff; }
        .btn-primary:hover { background: #059669; }
        .btn-secondary { background: #f1f3f5; color: #555; }
        .btn-secondary:hover { background: #e8ecf1; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-edit { background: #f1f3f5; color: #555; border-radius: 6px; }
        .btn-edit:hover { background: #e2e8f0; }
        .btn-delete { background: #fee2e2; color: #ef4444; border-radius: 6px; }
        .btn-delete:hover { background: #fca5a5; color: #fff; }
        .btn-outline { background: transparent; border: 1px solid #e8ecf1; color: #555; }
        .btn-outline:hover { background: #f8f9fb; }
        .btn-lg { padding: 12px 24px; font-size: 15px; border-radius: 10px; }

        /* === FORM ELEMENTS === */
        .form-label { font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; display: block; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #e8ecf1; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; outline: none; transition: 0.2s; background: #fff; }
        .form-control:focus { border-color: #34d399; box-shadow: 0 0 0 3px rgba(52,211,153,0.1); }
        .form-select { width: 100%; padding: 10px 14px; border: 1px solid #e8ecf1; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; outline: none; background: #fff; }
        .form-select:focus { border-color: #34d399; }
        textarea.form-control { resize: vertical; }

        /* === PROGRESS BARS === */
        .progress-bar-custom { height: 24px; background: #f1f3f5; border-radius: 12px; overflow: hidden; display: flex; }
        .progress-fill { height: 100%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #fff; transition: width 0.3s; }
        .progress-fill.green { background: #34d399; }
        .progress-fill.gray { background: #94a3b8; }

        /* === ALERTS === */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .alert-info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        /* === GRID UTILS === */
        .grid { display: grid; gap: 20px; }
        .grid-2 { grid-template-columns: 1fr 1fr; }
        .grid-3 { grid-template-columns: 1fr 1fr 1fr; }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }
        .grid-sidebar { grid-template-columns: 2fr 1fr; }

        /* === QUICK ACTION === */
        .quick-action { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 1px solid #e8ecf1; border-radius: 10px; text-decoration: none; color: #333; font-size: 14px; transition: 0.2s; background: #fff; cursor: pointer; }
        .quick-action:hover { border-color: #34d399; background: #f0fdf4; }
        .quick-action i { font-size: 16px; color: #888; }

        /* === STATUS BADGE === */
        .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-active { background: #f0fdf4; color: #059669; }
        .badge-inactive { background: #fef2f2; color: #ef4444; }

        /* === PAGINATION === */
        .pagination { display: flex; gap: 4px; margin-top: 16px; justify-content: center; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #e8ecf1; border-radius: 6px; font-size: 13px; text-decoration: none; color: #555; }
        .pagination .active span { background: #34d399; color: #fff; border-color: #34d399; }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 16px; }
            .grid-2, .grid-3, .grid-4, .grid-sidebar { grid-template-columns: 1fr; }
            .mobile-toggle { display: block !important; }
        }

        .mobile-toggle { display: none; position: fixed; top: 16px; left: 16px; z-index: 101; background: #fff; border: 1px solid #e8ecf1; border-radius: 8px; padding: 8px 10px; cursor: pointer; }

        @yield('css')
    </style>
</head>
<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')">
        <i class="bi bi-list"></i>
    </button>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="user-info">
                <div class="avatar">{{ mb_substr(Auth::user()->ho_ten, 0, 1) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->ho_ten }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Tổng quan</div>
            <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <div class="nav-section">Bài test</div>
            <a href="/bai-test" class="nav-item {{ request()->is('bai-test*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Làm bài test
            </a>
            <a href="/lich-su-test" class="nav-item {{ request()->is('lich-su-test') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Lịch sử
            </a>

            <div class="nav-section">Nghề nghiệp</div>
            <a href="/goi-y-nghe-nghiep" class="nav-item {{ request()->is('goi-y*') ? 'active' : '' }}">
                <i class="bi bi-stars"></i> Gợi ý AI
            </a>

            <div class="nav-section">Cá nhân</div>
            <a href="/ho-so" class="nav-item {{ request()->is('ho-so') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Hồ sơ
            </a>

            @if(Auth::user()->vai_tro === 'admin')
            <div class="nav-section">Quản trị</div>
            <a href="/admin" class="nav-item {{ request()->is('admin*') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i> Admin Panel
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <a href="/ho-so"><i class="bi bi-gear"></i> Cài đặt</a>
            <form action="/dang-xuat" method="POST" style="flex:1;display:flex;">
                @csrf
                <button type="submit" class="btn-logout" style="width:100%;"><i class="bi bi-box-arrow-left"></i> Thoát</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main-content">
        @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i class="bi bi-x-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('warning'))
        <div class="alert alert-warning"><i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-error"><i class="bi bi-x-circle"></i> {{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    @yield('js')
</body>
</html>
