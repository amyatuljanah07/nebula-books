<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - NebulaBooks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --primary-color: #5B4B9F;
            --secondary-color: #5B4B9F;
            --sidebar-bg: #5B4B9F;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            padding: 2rem 0;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
            white-space: nowrap;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-header h3 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            transition: opacity 0.3s;
        }

        .sidebar-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .sidebar-header p {
            opacity: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
        }

        .sidebar-menu a i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .sidebar-menu a span {
            transition: opacity 0.3s, width 0.3s;
        }

        .sidebar.collapsed .sidebar-menu a span {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 0.875rem;
        }

        .sidebar.collapsed .sidebar-menu a i {
            margin-right: 0;
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: calc(var(--sidebar-width) + 10px);
            width: 45px;
            height: 45px;
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,.15);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            transition: all 0.3s ease;
            color: var(--primary-color);
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0,0,0,.25);
        }

        .sidebar-toggle i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed ~ .sidebar-toggle {
            left: calc(var(--sidebar-collapsed-width) + 10px);
        }

        .sidebar.collapsed ~ .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            padding-top: 5rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-width: 260px;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-toggle {
                left: 20px;
                background: var(--sidebar-bg);
                color: white;
            }

            .sidebar.show ~ .sidebar-toggle {
                left: calc(var(--sidebar-width) - 25px);
                background: white;
                color: var(--primary-color);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
                padding-top: 5rem;
            }

            .sidebar.collapsed ~ .main-content {
                margin-left: 0;
            }

            .card {
                margin-bottom: 1.5rem;
                border-radius: 10px;
            }

            .card-header {
                padding: 1rem !important;
            }

            .card-body {
                padding: 1rem !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .table thead th {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }

            .table td {
                padding: 0.75rem 0.5rem;
                vertical-align: middle;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
            }

            .btn-group {
                flex-wrap: wrap;
            }

            .btn-group .btn {
                margin-bottom: 0.25rem;
            }

            .form-label {
                font-size: 0.875rem;
                margin-bottom: 0.4rem;
            }

            .form-control, .form-select {
                font-size: 0.875rem;
                padding: 0.5rem;
            }

            .row {
                margin-right: -0.5rem;
                margin-left: -0.5rem;
            }

            .col-md-3, .col-md-4, .col-md-6, .col-lg-8 {
                padding-right: 0.5rem;
                padding-left: 0.5rem;
            }

            .stats-card {
                display: flex;
                gap: 1rem;
                padding: 1rem;
            }

            .stats-icon {
                width: 50px;
                height: 50px;
                min-width: 50px;
            }

            .stats-content h3 {
                font-size: 1.25rem;
            }

            .stats-content p {
                font-size: 0.8rem;
            }

            .breadcrumb {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }

            .modal-body {
                padding: 1rem;
            }

            .badge {
                font-size: 0.75rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            h3 {
                font-size: 1.2rem;
            }

            h4 {
                font-size: 1rem;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .mb-3 {
                margin-bottom: 0.8rem !important;
            }

            .p-4 {
                padding: 1rem !important;
            }

            .p-3 {
                padding: 0.8rem !important;
            }

            .alert {
                padding: 0.75rem;
                font-size: 0.875rem;
                margin-bottom: 1rem;
            }

            .avatar-lg {
                width: 50px;
                height: 50px;
            }

            .d-md-none {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
                padding-top: 5rem;
            }

            .card {
                border-radius: 8px;
            }

            .btn {
                padding: 0.35rem 0.75rem;
                font-size: 0.8rem;
            }

            .col-md-3, .col-md-4, .col-md-6, .col-lg-8 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .form-control, .form-select {
                font-size: 0.8rem;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                font-size: 0.75rem;
                white-space: nowrap;
            }

            .table thead th {
                padding: 0.5rem 0.4rem;
            }

            .table td {
                padding: 0.5rem 0.4rem;
            }

            h2 {
                font-size: 1.25rem;
            }

            h3 {
                font-size: 1rem;
            }

            .d-flex.justify-content-between {
                display: block !important;
            }

            .text-muted small {
                display: block;
                font-size: 0.75rem;
                margin-top: 0.5rem;
            }
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,.08);
            margin-bottom: 2rem;
        }

        .card-header {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            border-radius: 15px 15px 0 0 !important;
        }

        .container-fluid {
            padding-right: 2rem;
            padding-left: 2rem;
        }

        .btn {
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 3px 15px rgba(0,0,0,.08);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stats-content h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #222;
        }

        .stats-content p {
            margin: 0.25rem 0 0;
            color: #999;
            font-size: 0.9rem;
        }

        .sidebar.collapsed .sidebar-menu a {
            position: relative;
        }

        .sidebar.collapsed .sidebar-menu a::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s, left 0.3s;
            margin-left: 10px;
            font-size: 0.875rem;
        }

        .sidebar.collapsed .sidebar-menu a:hover::after {
            opacity: 1;
            left: calc(100% + 5px);
        }

        .w-md-auto {
            width: auto !important;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 1rem;
        }

        .avatar-sm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #5B4B9F;
            border-radius: 50%;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .text-truncate-2 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .flex-column {
            flex-direction: column;
        }

        @supports (display: grid) {
            .g-3 {
                --bs-gutter-x: 1rem;
                --bs-gutter-y: 1rem;
            }

            .g-md-4 {
                --bs-gutter-x: 1.5rem;
                --bs-gutter-y: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>NebulaBooks</h3>
            <p>Admin Panel</p>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   data-title="Dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.books.index') }}" 
                   class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}"
                   data-title="Books">
                    <i class="fas fa-book"></i>
                    <span>Books</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" 
                   class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                   data-title="Categories">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" 
                   class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                   data-title="Orders">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.chats.index') }}" 
                   class="{{ request()->routeIs('admin.chats.*') ? 'active' : '' }}"
                   data-title="Chats">
                    <i class="fas fa-comments"></i>
                    <span>Chats</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" 
                   class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   data-title="Users">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="#" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   data-title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function isMobile() {
            return window.innerWidth <= 768;
        }

        sidebarToggle.addEventListener('click', function() {
            if (isMobile()) {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('show')) {
                    icon.className = 'fas fa-times';
                } else {
                    icon.className = 'fas fa-bars';
                }
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'fas fa-bars';
                } else {
                    icon.className = 'fas fa-times';
                }
            }
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            const icon = sidebarToggle.querySelector('i');
            icon.className = 'fas fa-bars';
        });

        window.addEventListener('DOMContentLoaded', function() {
            if (!isMobile()) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    const icon = sidebarToggle.querySelector('i');
                    icon.className = 'fas fa-bars';
                } else {
                    const icon = sidebarToggle.querySelector('i');
                    icon.className = 'fas fa-times';
                }
            }
        });

        window.addEventListener('resize', function() {
            if (!isMobile()) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>