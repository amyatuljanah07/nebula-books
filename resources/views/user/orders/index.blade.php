@extends('layouts1.user')

@section('title', 'Riwayat Pesanan - NebulaBooks')
@section('page-title', 'Riwayat Pesanan')
@section('page-subtitle', 'Semua pesanan Anda')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="{{ route('user.dashboard') }}" class="btn btn-back mb-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>

            <div class="orders-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-2"><i class="fas fa-history me-2"></i>Riwayat Pesanan</h2>
                        <p class="text-muted mb-0">Total pesanan: <strong>{{ $orders->total() }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="orders-card">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Total</th>
                                    <th>Status Pesanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <span class="order-number-badge">{{ $order->order_number }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'status-pending',
                                                'processing' => 'status-processing',
                                                'shipped' => 'status-shipped',
                                                'completed' => 'status-completed',
                                                'cancelled' => 'status-cancelled'
                                            ];
                                            $statusTexts = [
                                                'pending' => 'Menunggu',
                                                'processing' => 'Diproses',
                                                'shipped' => 'Dikirim',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan'
                                            ];
                                        @endphp
                                        <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                                            {{ $statusTexts[$order->status] ?? ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $paymentClasses = [
                                                'unpaid' => 'payment-unpaid',
                                                'pending_verification' => 'payment-pending',
                                                'paid' => 'payment-paid'
                                            ];
                                            $paymentTexts = [
                                                'unpaid' => 'Belum Bayar',
                                                'pending_verification' => 'Menunggu Verifikasi',
                                                'paid' => 'Dibayar'
                                            ];
                                        @endphp
                                        <span class="payment-badge {{ $paymentClasses[$order->payment_status] ?? 'payment-pending' }}">
                                            {{ $paymentTexts[$order->payment_status] ?? ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.orders.show', $order) }}" class="btn-view-detail">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                    <div class="pagination-wrapper">
                        {{ $orders->links() }}
                    </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>Belum ada pesanan</h5>
                        <p class="text-muted">Anda belum membuat pesanan apapun</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.btn-back {
    background: #5B4B9F;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(91, 75, 159, 0.4);
    text-decoration: none;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    color: white;
}

.orders-header {
    background: #5B4B9F;
    padding: 40px 30px;
    border-radius: 16px;
    color: white;
    box-shadow: 0 10px 40px rgba(91, 75, 159, 0.25);
    position: relative;
    overflow: hidden;
}

.orders-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 40px 40px;
    opacity: 0.5;
}

.orders-header h2 {
    font-weight: 800;
    margin: 0;
    font-size: 32px;
    position: relative;
    z-index: 1;
}

.orders-header p {
    font-size: 16px;
    opacity: 0.95;
    position: relative;
    z-index: 1;
    margin: 8px 0 0 0;
}

.orders-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.orders-table thead {
    background: #f8f9ff;
    position: sticky;
    top: 0;
}

.orders-table th {
    padding: 18px 16px;
    text-align: left;
    font-weight: 700;
    color: #1a1a2e;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-bottom: 2px solid #e9ecef;
}

.orders-table td {
    padding: 18px 16px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.orders-table tbody tr {
    transition: all 0.3s ease;
}

.orders-table tbody tr:hover {
    background: #f8f9ff;
    box-shadow: inset 0 2px 8px rgba(91, 75, 159, 0.1);
}

.orders-table tbody tr:last-child td {
    border-bottom: none;
}

.order-number-badge {
    background: #5B4B9F;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    display: inline-block;
    box-shadow: 0 4px 12px rgba(91, 75, 159, 0.25);
}

.status-badge {
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: #fcb69f;
    color: #8b5a2b;
    box-shadow: 0 4px 12px rgba(255, 172, 102, 0.3);
}

.status-processing {
    background: #fed6e3;
    color: #5a5a8b;
    box-shadow: 0 4px 12px rgba(168, 237, 234, 0.3);
}

.status-shipped {
    background: #5B4B9F;
    color: white;
    box-shadow: 0 4px 12px rgba(91, 75, 159, 0.3);
}

.status-completed {
    background: #38ef7d;
    color: white;
    box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
}

.status-cancelled {
    background: #ff4b2b;
    color: white;
    box-shadow: 0 4px 12px rgba(255, 65, 108, 0.3);
}

.payment-badge {
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.payment-unpaid {
    background: #ff4b2b;
    color: white;
    box-shadow: 0 4px 12px rgba(255, 65, 108, 0.3);
}

.payment-pending {
    background: #f5576c;
    color: white;
    box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
}

.payment-paid {
    background: #38ef7d;
    color: white;
    box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
}

.btn-view-detail {
    background: #5B4B9F;
    color: white;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.btn-view-detail:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    color: white;
}

.pagination-wrapper {
    padding: 24px 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-top: 2px solid #f0f0f0;
    background: #f0f4ff;
}

.pagination-wrapper .pagination {
    gap: 8px;
    margin: 0;
}

.pagination-wrapper .page-item {
    display: inline-block;
}

.pagination-wrapper .page-link {
    color: #667eea;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 14px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
    text-decoration: none;
}

.pagination-wrapper .page-link:hover:not(.disabled) {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.pagination-wrapper .page-item.active .page-link {
    background: #5B4B9F;
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #ccc;
    border-color: #e9ecef;
    cursor: not-allowed;
    background: #f8f9fa;
}

.pagination-wrapper .pagination {
    list-style: none;
    display: flex;
    gap: 8px;
}

.empty-state {
    padding: 80px 30px;
    text-align: center;
    background: #f0f4ff;
}

.empty-state i {
    font-size: 80px;
    color: #ccc;
    margin-bottom: 25px;
    display: block;
    opacity: 0.7;
}

.empty-state h5 {
    color: #1a1a2e;
    font-weight: 700;
    margin-bottom: 12px;
    font-size: 22px;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 15px;
}

.empty-state .btn-primary {
    background: #5B4B9F;
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.empty-state .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
    .orders-header {
        padding: 25px 20px;
    }

    .orders-header h2 {
        font-size: 24px;
    }

    .orders-header p {
        font-size: 14px;
    }

    .orders-table th,
    .orders-table td {
        padding: 12px 10px;
        font-size: 12px;
    }

    .orders-table th {
        font-size: 11px;
    }

    .btn-view-detail {
        padding: 6px 12px;
        font-size: 12px;
    }

    .order-number-badge {
        padding: 4px 10px;
        font-size: 11px;
    }

    .status-badge,
    .payment-badge {
        padding: 6px 12px;
        font-size: 12px;
    }

    .pagination-wrapper {
        padding: 16px 12px;
    }

    .pagination-wrapper .page-link {
        padding: 8px 10px;
        font-size: 13px;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}
</style>
@endsection
