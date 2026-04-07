@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-column flex-md-row gap-2">
        <div>
            <h2 class="mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
        <div class="text-muted text-nowrap">
            <i class="fas fa-calendar-alt me-2"></i><span class="d-none d-md-inline">{{ date('l, d F Y') }}</span><span class="d-md-none">{{ date('d/m/Y') }}</span>
        </div>
    </div>
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $totalBooks }}</h3>
                    <p>Total Books</p>
                </div>
            </div>
        </div>   
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stats-content">
                    <h3 class="text-truncate">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon bg-danger">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $unreadChats }}<span style="font-size: 0.7em; color: #6c757d;">/ {{ $totalChats }}</span></h3>
                    <p>Unread Chats</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-column flex-md-row gap-2">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary w-100 w-md-auto">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th class="d-none d-sm-table-cell">Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="d-none d-md-table-cell">Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->order_number }}</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                {{ substr($order->user->name, 0, 1) }}
                                            </div>
                                            <div class="d-none d-md-block">
                                                <strong>{{ $order->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $order->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger'
                                            ];
                                            $color = $statusColors[$order->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $order->created_at->format('d M Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No orders yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Order Status</h5>
                </div>
                <div class="card-body">
                    @php
                        $orderStats = [
                            'pending' => \App\Models\Order::where('status', 'pending')->count(),
                            'processing' => \App\Models\Order::where('status', 'processing')->count(),
                            'shipped' => \App\Models\Order::where('status', 'shipped')->count(),
                            'completed' => \App\Models\Order::where('status', 'completed')->count(),
                            'cancelled' => \App\Models\Order::where('status', 'cancelled')->count(),
                        ];
                    @endphp

                    <div class="status-list">
                        <div class="status-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-circle text-warning me-2"></i>Pending</span>
                                <strong>{{ $orderStats['pending'] }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ $totalOrders > 0 ? ($orderStats['pending']/$totalOrders*100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="status-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-circle text-info me-2"></i>Processing</span>
                                <strong>{{ $orderStats['processing'] }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: {{ $totalOrders > 0 ? ($orderStats['processing']/$totalOrders*100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="status-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-circle text-primary me-2"></i>Shipped</span>
                                <strong>{{ $orderStats['shipped'] }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: {{ $totalOrders > 0 ? ($orderStats['shipped']/$totalOrders*100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="status-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-circle text-success me-2"></i>Completed</span>
                                <strong>{{ $orderStats['completed'] }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: {{ $totalOrders > 0 ? ($orderStats['completed']/$totalOrders*100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="status-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-circle text-danger me-2"></i>Cancelled</span>
                                <strong>{{ $orderStats['cancelled'] }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger" style="width: {{ $totalOrders > 0 ? ($orderStats['cancelled']/$totalOrders*100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 gap-sm-3">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-outline-primary btn-sm d-md-block">
                            <i class="fas fa-plus-circle me-2"></i><span class="d-none d-sm-inline">Add New Book</span><span class="d-sm-none">Add Book</span>
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success btn-sm d-md-block">
                            <i class="fas fa-folder-plus me-2"></i><span class="d-none d-sm-inline">Add Category</span><span class="d-sm-none">Category</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info btn-sm d-md-block">
                            <i class="fas fa-list me-2"></i><span class="d-none d-sm-inline">View All Orders</span><span class="d-sm-none">Orders</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 3px 15px rgba(0,0,0,.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,.15);
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
    flex-shrink: 0;
}

.stats-content h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    color: #333;
}

.stats-content p {
    margin: 0;
    color: #666;
    font-size: 0.875rem;
}

.status-item {
    margin-bottom: 1.5rem;
}

.avatar-sm {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #5B4B9F;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.status-item {
    padding-bottom: 0.5rem;
}

.progress {
    border-radius: 10px;
    background: #f0f0f0;
}

.progress-bar {
    border-radius: 10px;
}

.table tbody tr {
    transition: background 0.2s ease;
}

.table tbody tr:hover {
    background: #f8f9ff;
}


@media (max-width: 768px) {
    .stats-card {
        padding: 1rem;
        gap: 0.75rem;
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }

    .stats-content h3 {
        font-size: 1.25rem;
    }

    .stats-content p {
        font-size: 0.75rem;
    }

    .card {
        border-radius: 10px;
    }

    .table {
        font-size: 0.8rem;
    }

    .badge {
        font-size: 0.65rem;
        padding: 0.35rem 0.5rem;
    }
}

@media (max-width: 576px) {
    .stats-card {
        padding: 0.75rem;
    }

    .stats-icon {
        width: 45px;
        height: 45px;
        font-size: 1rem;
    }

    .stats-content h3 {
        font-size: 1.1rem;
    }

    .stats-content p {
        font-size: 0.7rem;
    }

    .d-grid.gap-2 {
        gap: 0.5rem;
    }

    .btn {
        padding: 0.35rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection
