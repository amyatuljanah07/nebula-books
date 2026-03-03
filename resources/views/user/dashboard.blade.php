
@extends('layouts1.user')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Dashboard</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Buku</h5>
                <h2>{{ $totalBooks }}</h2>
                <p class="card-text">Buku tersedia</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Pesanan Saya</h5>
                <h2>{{ $totalOrders }}</h2>
                <p class="card-text">Total pesanan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Keranjang</h5>
                <h2>{{ $cartItems }}</h2>
                <p class="card-text">Item di keranjang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Belanja</h5>
                <h2>Rp {{ number_format($totalSpent, 0, ',', '.') }}</h2>
                <p class="card-text">Total pembelian</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($order->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-primary">
    Detail
</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pesanan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('books.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-book"></i> Cari Buku
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('user.cart.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-info w-100">
                            <i class="fas fa-list"></i> Pesanan Saya
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-warning w-100">
                            <i class="fas fa-user"></i> Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection