<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - NebulaBooks</title>
    <link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
      integrity="sha512-..." 
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    
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

        

        .main-content {
            margin-left: 250px;
            padding: 20px;
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

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .logout-btn {
            padding: 8px 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: #333;
            font-size: 24px;
        }

        .btn-back {
            padding: 8px 16px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        label span {
            color: #e74c3c;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            padding: 12px 30px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
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


   

    <div class="main-content">
        <div class="header">
            <h1>Edit Category</h1>
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <strong>{{ Auth::user()->name }}</strong>
                    <p style="font-size: 12px; color: #666;">{{ Auth::user()->role }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <div class="form-section">
            <div class="form-header">
                <h2>Edit Category Information</h2>
                <a href="{{ route('admin.categories.index') }}" class="btn-back">← Back to List</a>
            </div>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Category Name <span>*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0;">Active</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script>
    // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function isMobile() {
        return window.innerWidth <= 768;
    }

    sidebarToggle.addEventListener('click', function () {
        const icon = this.querySelector('i');

        if (isMobile()) {
            // Mobile Mode
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');

            icon.className = sidebar.classList.contains('show') 
                ? 'fas fa-times' 
                : 'fas fa-bars';

        } else {
            // Desktop Mode
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));

            icon.className = sidebar.classList.contains('collapsed') 
                ? 'fas fa-bars' 
                : 'fas fa-times';
        }
    });

    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
        sidebarToggle.querySelector('i').className = 'fas fa-bars';
    });

    // On Load
    window.addEventListener('DOMContentLoaded', function () {
        if (!isMobile()) {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const icon = sidebarToggle.querySelector('i');

            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                icon.className = 'fas fa-bars';
            } else {
                icon.className = 'fas fa-times';
            }
        }
    });

    // On Resize
    window.addEventListener('resize', () => {
        if (!isMobile()) {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            sidebarToggle.querySelector('i').className = sidebar.classList.contains('collapsed')
                ? 'fas fa-bars'
                : 'fas fa-times';
        }
    });
</script>

</body>
</html>