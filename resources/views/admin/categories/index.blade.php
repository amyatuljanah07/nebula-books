<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management - NebulaBooks</title>
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

        .logout-btn:hover {
            background: #c0392b;
        }

        .categories-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            color: #333;
            font-size: 24px;
        }

        .btn-add {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: #d4edda; color: #155724; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .category-description {
            color: #666;
            font-size: 13px;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            <h1>Categories Management</h1>
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

        <div class="categories-section">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="section-header">
                <h2>All Categories</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn-add">
                    <span>➕</span> Add New Category
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Books Count</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                <div class="category-description">
                                    {{ $category->description ?? '-' }}
                                </div>
                            </td>
                            <td>{{ $category->books_count }} books</td>
                            <td>
                                <span class="badge badge-{{ $category->is_active ? 'success' : 'secondary' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-action btn-edit">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px;">
                                <p style="color: #999;">No categories found. <a href="{{ route('admin.categories.create') }}">Add your first category</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                {{ $categories->links() }}
            </div>
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