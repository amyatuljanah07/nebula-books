@extends('layouts.admin')

@section('title', 'Detail Order')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4 flex-column flex-md-row gap-2">
        <div>
            <h2 class="mb-1"><i class="fas fa-receipt me-2" style="color: #5B4B9F;"></i>Detail Order</h2>
            <p class="text-muted mb-0">Order <span class="badge bg-purple" style="background: #5B4B9F !important;">{{ $order->order_number }}</span></p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row g-4">
        <!-- Main Content (Left) -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Daftar Barang</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40%;">Buku</th>
                                    <th>Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($item->book->image)
                                                <img src="{{ asset('storage/' . $item->book->image) }}" 
                                                     alt="{{ $item->book->title }}"
                                                     style="width: 45px; height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                            @else
                                                <div style="width: 45px; height: 60px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-book" style="color: #ccc;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-600">{{ $item->book->title }}</div>
                                                <small class="text-muted">{{ $item->book->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold" style="color: #5B4B9F;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold">Total Order:</span>
                        <span class="fs-5 fw-bold" style="color: #5B4B9F;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-2 d-block">Nama Penerima</label>
                            <div class="fw-600">{{ $order->user->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-2 d-block">Nomor Telepon</label>
                            <div class="fw-600">
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->phone) }}" target="_blank" class="text-decoration-none">
                                    {{ $order->phone }} <i class="fas fa-external-link-alt ms-1" style="font-size: 0.8em;"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small mb-2 d-block">Alamat Pengiriman</label>
                            <div class="fw-600 text-dark">{{ $order->shipping_address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Management (Moved to Left) -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Status Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline w-100">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Status Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST" class="d-inline w-100">
                                @csrf
                                @method('PATCH')
                                <select name="payment_status" class="form-select" onchange="this.form.submit()">
                                    <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                                    <option value="pending_verification" {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>Verifikasi</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (Right) -->
        <div class="col-lg-4">
            <!-- Order Status Card -->
            <div class="card mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Order</h5>
                </div>
                <div class="card-body">
                    <!-- Info Items -->
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small d-block mb-2">Order Number</label>
                        <div class="badge bg-secondary" style="padding: 8px 12px; font-size: 12px;">
                            #{{ $order->order_number }}
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small d-block mb-2">Email</label>
                        <a href="mailto:{{ $order->user->email }}" class="text-decoration-none" style="color: #5B4B9F; font-weight: 500;">
                            {{ $order->user->email }}
                        </a>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small d-block mb-2">Tanggal Order</label>
                        <div class="fw-600">{{ $order->created_at->format('d M Y') }}</div>
                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small d-block mb-2">Metode Pembayaran</label>
                        <span class="badge bg-info">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>

                    @if($order->payment_proof)
                    <div class="mb-3 pb-3">
                        <label class="text-muted small d-block mb-2">Bukti Pembayaran</label>
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                             alt="Payment Proof" 
                             style="width: 100%; max-width: 200px; border-radius: 8px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
                             onclick="window.open(this.src, '_blank')"
                             title="Klik untuk zoom">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ in_array($order->status, ['pending', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <strong>Order Dibuat</strong>
                                <small class="text-muted d-block">{{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <strong>Diproses</strong>
                            </div>
                        </div>
                        <div class="timeline-item {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <strong>Dikirim</strong>
                            </div>
                        </div>
                        <div class="timeline-item {{ $order->status === 'completed' ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <strong>Selesai</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Action -->
            <div class="d-grid mt-4">
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->phone) }}?text=Halo%20{{ urlencode($order->user->name) }},%20pesanan%20{{ $order->order_number }}%20Anda%20sedang%20kami%20proses." 
                   target="_blank" class="btn btn-success btn-md">
                    <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.fw-600 {
    font-weight: 600;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 5px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -31px;
    top: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e9ecef;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-item.active .timeline-marker {
    background: #5B4B9F;
    box-shadow: 0 0 0 4px rgba(91, 75, 159, 0.2);
}

.timeline-content {
    font-size: 13px;
}

.timeline-item.active .timeline-content strong {
    color: #5B4B9F;
}

.form-select-sm {
    font-size: 13px;
    padding: 0.5rem 0.75rem;
}
</style>

@endsection