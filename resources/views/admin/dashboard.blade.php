@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
        <div class="text-muted">
            <i class="fas fa-calendar-alt me-2"></i>{{ date('l, d F Y') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Books -->
        <div class="col-md-3">
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

        <!-- Total Orders -->
        <div class="col-md-3">
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

        <!-- Total Users -->
        <div class="col-md-3">
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

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stats-content">
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                {{ substr($order->user->name, 0, 1) }}
                                            </div>
                                            <div>
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

        <!-- Quick Stats -->
        <div class="col-lg-4">
            <!-- Order Status Chart -->
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

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus-circle me-2"></i>Add New Book
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-folder-plus me-2"></i>Add Category
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-list me-2"></i>View All Orders
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

.avatar-sm {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
</style>
@endsection
