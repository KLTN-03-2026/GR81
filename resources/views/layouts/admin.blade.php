<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MBTI-CRS Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; color: #333; display: flex; min-height: 100vh; }

        /* === SIDEBAR === */
        .sidebar { width: 220px; background: #fff; border-right: 1px solid #e8ecf1; display: flex; flex-direction: column; position: fixed; height: 100vh; }
        .sidebar-header { padding: 20px 16px 16px; }
        .sidebar-header .brand { display: flex; align-items: center; gap: 10px; }
        .sidebar-header .brand-icon { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #34d399, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; }
        .sidebar-header .brand-name { font-weight: 700; font-size: 15px; color: #1a1a2e; }
        .sidebar-header .brand-desc { font-size: 11px; color: #999; }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 8px 0; }
        .nav-section { padding: 12px 16px 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; color: #bbb; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 16px; font-size: 13px; color: #666; text-decoration: none; transition: 0.2s; border-left: 3px solid transparent; }
        .nav-item:hover { background: #f0fdf4; color: #059669; }
        .nav-item.active { background: #f0fdf4; color: #059669; border-left-color: #34d399; font-weight: 600; }
        .nav-item i { font-size: 15px; width: 18px; text-align: center; }

        .sidebar-divider { border: none; border-top: 1px solid #e8ecf1; margin: 8px 16px; }
        .nav-section-title { padding: 6px 16px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #bbb; margin-top: 4px; }

        .sidebar-footer { padding: 12px 16px; border-top: 1px solid #e8ecf1; display: flex; gap: 4px; }
        .sidebar-footer a, .sidebar-footer button { flex: 1; display: flex; align-items: center; justify-content: center; gap: 4px; padding: 7px; border: none; border-radius: 6px; font-size: 12px; cursor: pointer; text-decoration: none; transition: 0.2s; background: #f8f9fb; color: #666; font-family: 'Inter', sans-serif; }
        .sidebar-footer a:hover { background: #e8ecf1; }
        .sidebar-footer .btn-logout { color: #059669; }
        .sidebar-footer .btn-logout:hover { background: #f0fdf4; }

        /* === MAIN CONTENT === */
        .main-content { margin-left: 220px; flex: 1; padding: 24px 28px; min-height: 100vh; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-title { font-size: 20px; font-weight: 700; color: #1a1a2e; }

        /* === CARDS & TABLES === */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf1; }
        .card-body { padding: 20px; }
        .card-header-custom { padding: 16px 20px; border-bottom: 1px solid #e8ecf1; font-size: 14px; font-weight: 600; color: #1a1a2e; }

        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #999; border-bottom: 1px solid #e8ecf1; }
        .table td { padding: 13px 16px; font-size: 13px; border-bottom: 1px solid #f1f3f5; color: #444; }
        .table tr:hover td { background: #fafbfc; }
        .table tr:last-child td { border-bottom: none; }

        /* === BUTTONS === */
        .btn { padding: 8px 16px; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-family: 'Inter', sans-serif; }
        .btn-primary { background: #34d399; color: #fff; }
        .btn-primary:hover { background: #059669; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-edit { background: #f1f3f5; color: #555; border-radius: 6px; }
        .btn-edit:hover { background: #e2e8f0; }
        .btn-delete { background: #fee2e2; color: #ef4444; border-radius: 6px; }
        .btn-delete:hover { background: #fca5a5; color: #fff; }
        .btn-secondary { background: #f1f3f5; color: #555; }
        .btn-secondary:hover { background: #e8ecf1; }

        /* MBTI Badges */
        .mbti-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; margin-right: 2px; }
        .mbti-green { background: #dcfce7; color: #166534; }
        .mbti-blue { background: #dbeafe; color: #1e40af; }
        .mbti-purple { background: #f3e8ff; color: #6b21a8; }
        .mbti-red { background: #fee2e2; color: #991b1b; }
        .mbti-orange { background: #ffedd5; color: #9a3412; }
        .mbti-teal { background: #ccfbf1; color: #115e59; }
        .mbti-pink { background: #fce7f3; color: #9d174d; }
        .mbti-yellow { background: #fef9c3; color: #854d0e; }

        /* Status */
        .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-active { background: #f0fdf4; color: #059669; }
        .badge-inactive { background: #fef2f2; color: #ef4444; }

        /* Stat cards */
        .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf1; padding: 20px; }
        .stat-card .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 10px; }
        .stat-card .stat-icon.green { background: #f0fdf4; color: #059669; }
        .stat-card .stat-icon.blue { background: #eff6ff; color: #2563eb; }
        .stat-card .stat-icon.orange { background: #fff7ed; color: #ea580c; }
        .stat-card .stat-icon.red { background: #fef2f2; color: #ef4444; }
        .stat-card .stat-label { font-size: 12px; color: #888; }
        .stat-card .stat-value { font-size: 28px; font-weight: 700; color: #1a1a2e; }

        /* Forms */
        .form-label { font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; display: block; }
        .form-control, .form-select { width: 100%; padding: 10px 14px; border: 1px solid #e8ecf1; border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; background: #fff; }
        .form-control:focus, .form-select:focus { border-color: #34d399; box-shadow: 0 0 0 3px rgba(52,211,153,0.1); }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* Grid */
        .grid { display: grid; gap: 16px; }
        .grid-2 { grid-template-columns: 1fr 1fr; }
        .grid-3 { grid-template-columns: 1fr 1fr 1fr; }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        /* Pagination */
        .pagination { display: flex; gap: 4px; margin-top: 16px; justify-content: center; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #e8ecf1; border-radius: 6px; font-size: 12px; text-decoration: none; color: #555; }
        .pagination .active span { background: #34d399; color: #fff; border-color: #34d399; }

        @yield('css')
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="brand">
                <div class="brand-icon">M</div>
                <div>
                    <div class="brand-name">Admin Panel</div>
                    <div class="brand-desc">Quản trị hệ thống</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Quản trị</div>
            <a href="/admin" class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="/admin/cau-hoi" class="nav-item {{ request()->is('admin/cau-hoi*') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i> Câu hỏi MBTI
            </a>
            <a href="/admin/nghe-nghiep" class="nav-item {{ request()->is('admin/nghe-nghiep*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Nghề nghiệp
            </a>
            <a href="/admin/nguoi-dung" class="nav-item {{ request()->is('admin/nguoi-dung*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Người dùng
            </a>
            <a href="/admin/thong-ke" class="nav-item {{ request()->is('admin/thong-ke') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Thống kê
            </a>

            <hr class="sidebar-divider">
            <div class="nav-section">Điều hướng</div>
            <a href="/" class="nav-item"><i class="bi bi-house"></i> Trang chính</a>
        </nav>

        <div class="sidebar-footer">
            <a href="/"><i class="bi bi-house"></i> Trang chính</a>
            <form action="/dang-xuat" method="POST" style="flex:1;display:flex;">
                @csrf
                <button type="submit" class="btn-logout" style="width:100%;"><i class="bi bi-box-arrow-left"></i> Thoát</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i class="bi bi-x-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    @yield('js')
</body>
</html>
