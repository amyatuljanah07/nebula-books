@extends('layouts.admin')

@section('title', 'Detail Order')

@push('styles')
<style>
    /* Hide sidebar */
    .sidebar-toggle, .sidebar-overlay, .sidebar {
        display: none !important;
    }
    
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    
    body {
        padding-left: 0 !important;
        background: #f0f2f5;
    }

    /* Custom sidebar toggle button */
    .custom-sidebar-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1050;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: white;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .custom-sidebar-toggle:hover {
        background: #6366f1;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .custom-sidebar-toggle span {
        width: 24px;
        height: 3px;
        background-color: #495057;
        border-radius: 2px;
        transition: all 0.3s;
    }

    .custom-sidebar-toggle:hover span {
        background-color: white;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px 40px;
        color: white;
        margin-left: 80px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .page-header .order-number {
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        display: inline-block;
        margin-top: 8px;
    }

    .btn-close-order {
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.5);
        color: white;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-close-order:hover {
        background: white;
        color: #667eea;
        border-color: white;
    }

    /* Scroll Container */
    .scroll-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 30px;
    }

    .scroll-content {
        min-width: 1200px;
        padding: 30px 40px;
        margin-left: 80px;
    }

    /* Cards */
    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        height: 100%;
    }

    .info-card .card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        padding: 18px 24px;
        border-bottom: 1px solid #e8ecf4;
    }

    .info-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1a1a2e;
        font-size: 16px;
    }

    .info-card .card-header h5 i {
        color: #6366f1;
        margin-right: 10px;
    }

    .info-card .card-body {
        padding: 24px;
    }

    /* Order Items Table */
    .order-table {
        width: 100%;
    }

    .order-table thead th {
        background: #f8f9fa;
        padding: 14px 16px;
        font-weight: 600;
        color: #495057;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e9ecef;
    }

    .order-table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-table tbody tr:hover {
        background: #f8f9ff;
    }

    .book-img {
        width: 50px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .book-title {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .book-author {
        color: #6c757d;
        font-size: 13px;
    }

    .order-table tfoot td {
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 700;
    }

    /* Info Rows */
    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 140px;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }

    .info-value {
        flex: 1;
        color: #1a1a2e;
        font-size: 14px;
    }

    .badge-order {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Status Selects */
    .status-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .status-label {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .status-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
        appearance: none;
        background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236366f1' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 16px center;
    }

    .status-select:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .status-select.status-pending { border-left: 4px solid #ffc107; }
    .status-select.status-processing { border-left: 4px solid #17a2b8; }
    .status-select.status-shipped { border-left: 4px solid #6f42c1; }
    .status-select.status-completed { border-left: 4px solid #28a745; }
    .status-select.status-cancelled { border-left: 4px solid #dc3545; }
    .status-select.status-unpaid { border-left: 4px solid #dc3545; }
    .status-select.status-pending_verification { border-left: 4px solid #ffc107; }
    .status-select.status-paid { border-left: 4px solid #28a745; }

    /* Payment Proof */
    .payment-proof-img {
        max-width: 100%;
        max-height: 350px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        cursor: pointer;
        transition: transform 0.3s;
    }

    .payment-proof-img:hover {
        transform: scale(1.02);
    }

    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .btn-action {
        flex: 1;
        padding: 12px 16px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-whatsapp {
        background: #25D366;
        color: white;
    }

    .btn-whatsapp:hover {
        background: #128C7E;
        color: white;
        transform: translateY(-2px);
    }

    .btn-print {
        background: #6366f1;
        color: white;
    }

    .btn-print:hover {
        background: #4f46e5;
        color: white;
        transform: translateY(-2px);
    }

    /* Timeline */
    .order-timeline {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e9ecef;
        margin-right: 15px;
    }

    .timeline-dot.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
    }

    .timeline-text {
        font-size: 13px;
        color: #6c757d;
    }

    .timeline-text.active {
        color: #1a1a2e;
        font-weight: 600;
    }

    /* Responsive scroll hint */
    .scroll-hint {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: white;
        padding: 10px 20px;
        border-radius: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        font-size: 13px;
        color: #6366f1;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }
</style>
@endpush

@section('content')
<!-- Custom Sidebar Toggle Button -->
<button class="custom-sidebar-toggle" onclick="window.location.href='{{ route('admin.orders.index') }}'">
    <span></span>
    <span></span>
    <span></span>
</button>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-receipt me-3"></i>Detail Order</h1>
            <span class="order-number">
                <i class="fas fa-hashtag me-1"></i>{{ $order->order_number }}
            </span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-close-order">
            <i class="fas fa-times me-2"></i>Tutup
        </a>
    </div>
</div>

<!-- Scroll Hint -->
<div class="scroll-hint">
    <i class="fas fa-arrows-alt-h"></i> Geser ke samping
</div>

<div class="scroll-wrapper">
    <div class="scroll-content">
        <div class="row g-4 align-items-start" style="flex-wrap: nowrap;">
            <!-- Order Items -->
<div class="col" style="min-width: 40px; max-width: 450px;">
    <div class="info-card">
        <div class="card-header" style="padding: 12px 16px;">
            <h5 style="font-size: 13px; margin: 0;"><i class="fas fa-shopping-bag"></i>Order Items</h5>
        </div>
        <div class="card-body p-0">
            <table class="order-table" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th style="width: 45%; padding: 8px 10px;">Buku</th>
                        <th style="padding: 8px 10px;">Harga</th>
                        <th class="text-center" style="padding: 8px 10px;">Qty</th>
                        <th class="text-end" style="padding: 8px 10px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="padding: 8px 10px;">
                            <div class="d-flex align-items-center gap-2">
                                @if($item->book->image)
                                    <img src="{{ asset('storage/' . $item->book->image) }}" 
                                         alt="{{ $item->book->title }}"
                                         style="width: 32px; height: 42px; object-fit: cover; border-radius: 4px;">
                                @endif
                                <div>
                                    <div style="font-size: 11px; font-weight: 600;">{{ Str::limit($item->book->title, 20) }}</div>
                                    <div style="font-size: 10px; color: #6c757d;">{{ Str::limit($item->book->author, 15) }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 8px 10px; font-size: 11px;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-center" style="padding: 8px 10px;">
                            <span class="badge bg-light text-dark" style="font-size: 10px; padding: 3px 8px;">{{ $item->quantity }}</span>
                        </td>
                        <td class="text-end fw-bold" style="padding: 8px 10px; font-size: 11px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end" style="padding: 10px; font-size: 12px;">Total</td>
                        <td class="text-end" style="padding: 10px; font-size: 13px;">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Payment Proof - Compact -->
    @if($order->payment_proof)
    <div class="info-card mt-2">
        <div class="card-header" style="padding: 10px 16px;">
            <h5 style="font-size: 13px; margin: 0;"><i class="fas fa-file-invoice"></i>Bukti Pembayaran</h5>
        </div>
        <div class="card-body text-center" style="padding: 12px;">
            <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                 alt="Payment Proof" 
                 style="max-width: 150px; max-height: 150px; border-radius: 8px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
                 onclick="window.open(this.src, '_blank')">
            <p class="text-muted mt-1 mb-0" style="font-size: 10px;">
                <i class="fas fa-search-plus"></i> Klik untuk zoom
            </p>
        </div>
    </div>
    @endif
</div>

            <!-- Order Information -->
            <div class="col" style="min-width: 380px;">
                <div class="info-card">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle"></i>Informasi Order</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <div class="info-label">Order Number</div>
                            <div class="info-value">
                                <span class="badge-order">{{ $order->order_number }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Customer</div>
                            <div class="info-value">
                                <strong>{{ $order->user->name }}</strong>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Email</div>
                            <div class="info-value">
                                <a href="mailto:{{ $order->user->email }}" style="color: #6366f1;">
                                    {{ $order->user->email }}
                                </a>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Telepon</div>
                            <div class="info-value">{{ $order->phone }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tanggal Order</div>
                            <div class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Metode Bayar</div>
                            <div class="info-value text-uppercase fw-bold">{{ $order->payment_method }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Alamat Kirim</div>
                            <div class="info-value">{{ $order->shipping_address }}</div>
                        </div>

                        <!-- Status Section -->
                        <div class="status-section">
                            <div class="status-label"><i class="fas fa-truck me-2"></i>Order Status</div>
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="status-select status-{{ $order->status }}" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>📦 Shipped</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                            </form>
                        </div>

                        <div class="status-section" style="border-top: none; margin-top: 15px; padding-top: 0;">
                            <div class="status-label"><i class="fas fa-credit-card me-2"></i>Payment Status</div>
                            <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="payment_status" class="status-select status-{{ $order->payment_status }}" onchange="this.form.submit()">
                                    <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>❌ Unpaid</option>
                                    <option value="pending_verification" {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>⏳ Pending Verification</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>✅ Paid</option>
                                </select>
                            </form>
                        </div>

                        <!-- Quick Actions -->
                        <div class="quick-actions">
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->phone) }}?text=Halo%20{{ urlencode($order->user->name) }},%20pesanan%20{{ $order->order_number }}%20Anda%20sedang%20kami%20proses." 
                               target="_blank" class="btn-action btn-whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button onclick="window.print()" class="btn-action btn-print">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>

                        <!-- Order Timeline -->
                        <div class="order-timeline">
                            <div class="status-label"><i class="fas fa-history me-2"></i>Order Timeline</div>
                            <div class="timeline-item">
                                <div class="timeline-dot {{ in_array($order->status, ['pending', 'processing', 'shipped', 'completed']) ? 'active' : '' }}"></div>
                                <div class="timeline-text {{ in_array($order->status, ['pending', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">Order Dibuat</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'active' : '' }}"></div>
                                <div class="timeline-text {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'active' : '' }}">Diproses</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }}"></div>
                                <div class="timeline-text {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }}">Dikirim</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $order->status === 'completed' ? 'active' : '' }}"></div>
                                <div class="timeline-text {{ $order->status === 'completed' ? 'active' : '' }}">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Hide scroll hint after 5 seconds
    setTimeout(() => {
        document.querySelector('.scroll-hint').style.display = 'none';
    }, 5000);
</script>
@endpush
@endsection