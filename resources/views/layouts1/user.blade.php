<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NebulaBooks - User Dashboard')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #5B4B9F;
            --secondary-color: #5B4B9F;
            --sidebar-width: 280px;
            --navbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary-color);
            padding: 2rem 0;
            transition: transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 0 1.5rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 2rem;
        }

        .sidebar-header i {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 0.5rem;
        }

        .sidebar-header h3 {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
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
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .sidebar-menu a .badge {
            position: absolute;
            right: 10px;
            font-size: 0.7rem;
            padding: 3px 7px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu a i {
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }

        .top-navbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--navbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .menu-toggle:hover {
            color: var(--primary-color);
            background: #f8f9fa;
        }

        .navbar-title h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
        }

        .navbar-title p {
            margin: 0;
            font-size: 0.875rem;
            color: #666;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-icon {
            position: relative;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #666;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .notification-icon:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f5576c;
            color: white;
            font-size: 0.625rem;
            padding: 2px 5px;
            border-radius: 10px;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .user-profile:hover {
            background: #f8f9fa;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-info h6 {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 600;
            color: #333;
        }

        .user-info p {
            margin: 0;
            font-size: 0.75rem;
            color: #666;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 2rem 2.5rem;
            min-height: calc(100vh - var(--navbar-height));
            background: #f8f9fa;
            transition: margin-left 0.3s ease;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        body.sidebar-collapsed .top-navbar {
            left: 0;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .top-navbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem 1rem;
            }

            .navbar-title h2 {
                font-size: 1.2rem;
            }

            .user-info {
                display: none;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            :root {
                --sidebar-width: 240px;
            }

            .sidebar-header h3 {
                font-size: 1.3rem;
            }

            .sidebar-menu a {
                font-size: 0.9rem;
                padding: 0.75rem 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-book"></i>
            <h3>NebulaBooks</h3>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Katalog Buku</span>
                </a>
            </li>
           <li>
               <a href="{{ route('user.cart.index') }}" class="{{ request()->routeIs('user.cart.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Keranjang</span>
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                    @endphp
                    @if($cartCount > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $cartCount }}</span>
                    @endif
                </a>
            </li> 
           
          
            <li>
                <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="fas fa-user"></i>
        <span>Profile</span>
    </a>
            </li>
           
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

    <nav class="top-navbar" id="topNavbar">
        <div class="navbar-left">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-title">
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('page-subtitle', 'Selamat datang kembali!')</p>
            </div>
        </div>
        <div class="navbar-right">
            <a href="{{ route('user.cart.index') }}" class="notification-icon" style="text-decoration: none;">
                <i class="fas fa-shopping-cart"></i>
                @php
                    $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                @endphp
                @if($cartCount > 0)
                    <span class="notification-badge">{{ $cartCount }}</span>
                @endif
            </a>
            <div class="user-profile">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <h6>{{ Auth::user()->name }}</h6>
                    <p>User</p>
                </div>
                <i class="fas fa-chevron-down" style="color: #999; font-size: 0.75rem;"></i>
            </div>
        </div>
    </nav>

    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        let isMobile = window.innerWidth <= 768;

        window.addEventListener('resize', function() {
            isMobile = window.innerWidth <= 768;
            
            if (!isMobile) {
                sidebar.classList.remove('mobile-show');
                sidebarOverlay.classList.remove('show');
            } else {
                document.body.classList.remove('sidebar-collapsed');
            }
        });

        menuToggle.addEventListener('click', function() {
            if (isMobile) {
                sidebar.classList.toggle('mobile-show');
                sidebarOverlay.classList.toggle('show');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
                
                const icon = menuToggle.querySelector('i');
                if (document.body.classList.contains('sidebar-collapsed')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-show');
            sidebarOverlay.classList.remove('show');
        });

        const menuLinks = document.querySelectorAll('.sidebar-menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (isMobile) {
                    sidebar.classList.remove('mobile-show');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });
    </script>

    @yield('scripts')

    <!-- Chat Widget -->
    @include('components.chat-widget')
</body>
</html>