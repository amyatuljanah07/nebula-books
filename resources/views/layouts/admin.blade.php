<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - NebulaBooks</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-bg: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
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

        /* Sidebar Styles */
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

        /* Toggle Button - Always Visible */
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

        /* Main Content */
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

        /* Mobile Overlay */
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

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
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
        }

        /* Card Styles */
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

        /* Button Styles */
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

        /* Tooltip untuk collapsed sidebar */
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
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
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

    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Check if mobile
        function isMobile() {
            return window.innerWidth <= 768;
        }

        // Toggle sidebar
        sidebarToggle.addEventListener('click', function() {
            if (isMobile()) {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                // Change icon
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('show')) {
                    icon.className = 'fas fa-times';
                } else {
                    icon.className = 'fas fa-bars';
                }
            } else {
                sidebar.classList.toggle('collapsed');
                // Save state to localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                // Change icon
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'fas fa-bars';
                } else {
                    icon.className = 'fas fa-times';
                }
            }
        });

        // Close sidebar when overlay clicked (mobile)
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            const icon = sidebarToggle.querySelector('i');
            icon.className = 'fas fa-bars';
        });

        // Load saved state
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

        // Handle window resize
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