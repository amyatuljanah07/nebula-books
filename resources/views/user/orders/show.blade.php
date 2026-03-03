@extends('layouts1.user')

@section('page-title', 'Detail Pesanan')
@section('page-subtitle', 'Order #' . $order->order_number)

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Back Button -->
            <a href="{{ route('user.dashboard') }}" class="btn btn-back mb-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>

            <!-- Order Header -->
            <div class="order-header-card mb-4">
                <div class="header-gradient"></div>
                <div class="header-content">
                    <div class="header-left">
                        <div class="order-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">Order #{{ $order->order_number }}</h3>
                            <p class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>{{ $order->created_at->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    <div class="header-right">
                        @php
                            $statusBadges = [
                                'pending' => ['class' => 'status-pending', 'icon' => 'clock', 'text' => 'Menunggu'],
                                'processing' => ['class' => 'status-processing', 'icon' => 'cog fa-spin', 'text' => 'Diproses'],
                                'shipped' => ['class' => 'status-shipped', 'icon' => 'truck', 'text' => 'Dikirim'],
                                'completed' => ['class' => 'status-completed', 'icon' => 'check-circle', 'text' => 'Selesai'],
                                'cancelled' => ['class' => 'status-cancelled', 'icon' => 'times-circle', 'text' => 'Dibatalkan']
                            ];
                            
                            $paymentBadges = [
                                'unpaid' => ['class' => 'payment-unpaid', 'icon' => 'times-circle', 'text' => 'Belum Bayar'],
                                'pending_verification' => ['class' => 'payment-pending', 'icon' => 'hourglass-half', 'text' => 'Menunggu Verifikasi'],
                                'paid' => ['class' => 'payment-paid', 'icon' => 'check-circle', 'text' => 'Lunas']
                            ];
                            
                            $status = $statusBadges[$order->status] ?? ['class' => 'status-pending', 'icon' => 'question', 'text' => 'Unknown'];
                            $payment = $paymentBadges[$order->payment_status] ?? ['class' => 'payment-pending', 'icon' => 'question', 'text' => 'Unknown'];
                        @endphp
                        
                        <span class="status-badge {{ $status['class'] }}">
                            <i class="fas fa-{{ $status['icon'] }} me-2"></i>{{ $status['text'] }}
                        </span>
                        <span class="status-badge {{ $payment['class'] }}">
                            <i class="fas fa-{{ $payment['icon'] }} me-2"></i>{{ $payment['text'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Progress Timeline -->
            <div class="timeline-card mb-4">
                <div class="timeline">
                    @php
                        $steps = [
                            'pending' => ['icon' => 'clipboard-list', 'text' => 'Pesanan Dibuat', 'color' => '#667eea'],
                            'processing' => ['icon' => 'box-open', 'text' => 'Diproses', 'color' => '#f093fb'],
                            'shipped' => ['icon' => 'shipping-fast', 'text' => 'Dikirim', 'color' => '#4facfe'],
                            'completed' => ['icon' => 'check-double', 'text' => 'Selesai', 'color' => '#00f2fe']
                        ];
                        $statusOrder = ['pending', 'processing', 'shipped', 'completed'];
                        $currentIndex = array_search($order->status, $statusOrder);
                        if ($currentIndex === false) $currentIndex = -1;
                    @endphp
                    
                    @foreach($steps as $key => $step)
                        @php
                            $stepIndex = array_search($key, $statusOrder);
                            $isActive = $stepIndex <= $currentIndex && $order->status !== 'cancelled';
                            $isCurrent = $key === $order->status;
                        @endphp
                        <div class="timeline-step {{ $isActive ? 'active' : '' }} {{ $isCurrent ? 'current' : '' }}">
                            <div class="step-icon" style="{{ $isActive ? 'background: linear-gradient(135deg, ' . $step['color'] . ', ' . $steps[array_keys($steps)[min($stepIndex + 1, 3)]]['color'] . ')' : '' }}">
                                <i class="fas fa-{{ $step['icon'] }}"></i>
                            </div>
                            <span class="step-text">{{ $step['text'] }}</span>
                        </div>
                        @if(!$loop->last)
                            <div class="timeline-line {{ $isActive && !$isCurrent ? 'active' : '' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="row">
                <!-- Order Items -->
                <div class="col-md-8">
                    <div class="items-card mb-4">
                        <div class="card-header-custom">
                            <div class="header-icon bg-gradient-purple">
                                <i class="fas fa-book"></i>
                            </div>
                            <h5>Daftar Buku</h5>
                            <span class="item-count">{{ $order->items->count() }} item</span>
                        </div>
                        
                        <div class="items-list">
                            @foreach($order->items as $index => $item)
                            <div class="book-item" style="animation-delay: {{ $index * 0.1 }}s">
                                <div class="book-number">{{ $index + 1 }}</div>
                                <div class="book-image">
                                    @if($item->book->image)
                                        <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}">
                                    @else
                                        <div class="book-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="book-details">
                                    <h6>{{ $item->book->title }}</h6>
                                    <p class="book-author"><i class="fas fa-user-edit me-1"></i>{{ $item->book->author }}</p>
                                    <div class="book-meta">
                                        <span class="quantity-badge">
                                            <i class="fas fa-times"></i>{{ $item->quantity }}
                                        </span>
                                        <span class="price-per">@ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="book-subtotal">
                                    <small>Subtotal</small>
                                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="order-total-section">
                            <div class="total-row">
                                <span><i class="fas fa-shopping-basket me-2"></i>Subtotal</span>
                                <span>Rp {{ number_format($order->total_amount - 5000, 0, ',', '.') }}</span>
                            </div>
                            <div class="total-row">
                                <span><i class="fas fa-hand-holding-usd me-2"></i>Biaya Admin</span>
                                <span>Rp 5.000</span>
                            </div>
                            <div class="total-row grand-total">
                                <span><i class="fas fa-receipt me-2"></i>Total Pembayaran</span>
                                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="col-md-4">
                    <!-- Shipping Info -->
                    <div class="info-card shipping-card mb-4">
                        <div class="info-card-header">
                            <div class="info-icon bg-gradient-blue">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5>Pengiriman</h5>
                        </div>
                        <div class="info-content">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone-alt"></i>Telepon
                                </div>
                                <div class="info-value">{{ $order->phone }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-home"></i>Alamat
                                </div>
                                <div class="info-value">{{ $order->shipping_address }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="info-card payment-card mb-4">
                        <div class="info-card-header">
                            <div class="info-icon bg-gradient-green">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <h5>Pembayaran</h5>
                        </div>
                        <div class="info-content">
                            @php
                                $paymentMethods = [
                                    'bca' => ['name' => 'BCA', 'color' => '#0060af'],
                                    'mandiri' => ['name' => 'Mandiri', 'color' => '#003d79'],
                                    'bni' => ['name' => 'BNI', 'color' => '#f15a22'],
                                    'bri' => ['name' => 'BRI', 'color' => '#00529c'],
                                    'gopay' => ['name' => 'GoPay', 'color' => '#00aed6'],
                                    'ovo' => ['name' => 'OVO', 'color' => '#4c3494'],
                                    'dana' => ['name' => 'DANA', 'color' => '#108ee9'],
                                    'shopeepay' => ['name' => 'ShopeePay', 'color' => '#ee4d2d']
                                ];
                                $method = $paymentMethods[$order->payment_method] ?? ['name' => $order->payment_method, 'color' => '#667eea'];
                            @endphp
                            <div class="payment-method-badge" style="background: {{ $method['color'] }}">
                                <i class="fas fa-university me-2"></i>{{ $method['name'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof -->
                    @if($order->payment_proof)
                    <div class="info-card proof-card mb-4">
                        <div class="info-card-header">
                            <div class="info-icon bg-gradient-orange">
                                <i class="fas fa-image"></i>
                            </div>
                            <h5>Bukti Pembayaran</h5>
                        </div>
                        <div class="info-content text-center">
                            <div class="proof-image-wrapper">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="proof-image"
                                     onclick="window.open(this.src, '_blank')">
                                <div class="proof-overlay">
                                    <i class="fas fa-search-plus"></i>
                                    <span>Klik untuk zoom</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    @if($order->payment_status === 'unpaid')
                    <a href="{{ route('user.payment', $order) }}" class="btn-pay-now">
                        <div class="btn-content">
                            <i class="fas fa-credit-card"></i>
                            <span>Bayar Sekarang</span>
                        </div>
                        <div class="btn-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                    @endif

                    <!-- Help Card -->
                    <div class="help-card">
                        <div class="help-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="help-content">
                            <h6>Butuh Bantuan?</h6>
                            <p>Hubungi customer service kami</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="help-link">
                                <i class="fab fa-whatsapp me-2"></i>Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Back Button */
.btn-back {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    color: white;
}

/* Order Header Card */
.order-header-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    position: relative;
}

.header-gradient {
    height: 8px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
    background-size: 200% 200%;
    animation: gradientMove 3s ease infinite;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.header-content {
    padding: 25px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.order-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.header-left h3 {
    font-weight: 800;
    color: #1a1a2e;
    margin: 0;
}

.header-left p {
    color: #6c757d;
    font-size: 14px;
}

.header-right {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: flex-end;
}

/* Status Badges */
.status-badge {
    padding: 10px 20px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.status-pending {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #8b5a2b;
}

.status-processing {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #5a5a8b;
}

.status-shipped {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.status-completed {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
}

.status-cancelled {
    background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    color: white;
}

.payment-unpaid {
    background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    color: white;
}

.payment-pending {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.payment-paid {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
}

/* Timeline Card */
.timeline-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.timeline {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

.timeline-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    z-index: 2;
}

.step-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 18px;
    transition: all 0.3s ease;
}

.timeline-step.active .step-icon {
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    transform: scale(1.1);
}

.timeline-step.current .step-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
    70% { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
    100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
}

.step-text {
    font-size: 12px;
    font-weight: 600;
    color: #adb5bd;
    text-align: center;
}

.timeline-step.active .step-text {
    color: #1a1a2e;
}

.timeline-line {
    flex: 1;
    height: 4px;
    background: #e9ecef;
    border-radius: 2px;
    margin: 0 -10px;
    margin-bottom: 30px;
}

.timeline-line.active {
    background: linear-gradient(90deg, #667eea, #764ba2);
}

/* Items Card */
.items-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.card-header-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.bg-gradient-purple {
    background: rgba(255,255,255,0.2);
}

.card-header-custom h5 {
    margin: 0;
    color: white;
    font-weight: 700;
    flex: 1;
}

.item-count {
    background: rgba(255,255,255,0.2);
    padding: 6px 14px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
    font-weight: 600;
}

.items-list {
    padding: 20px;
}

.book-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%);
    border-radius: 16px;
    margin-bottom: 15px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.book-item:hover {
    border-color: #667eea;
    transform: translateX(5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.book-number {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
}

.book-image {
    width: 70px;
    height: 90px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.book-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.book-details {
    flex: 1;
}

.book-details h6 {
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 5px;
    font-size: 15px;
}

.book-author {
    color: #6c757d;
    font-size: 13px;
    margin-bottom: 8px !important;
}

.book-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-badge {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.price-per {
    color: #6c757d;
    font-size: 13px;
}

.book-subtotal {
    text-align: right;
}

.book-subtotal small {
    display: block;
    color: #adb5bd;
    font-size: 11px;
    margin-bottom: 4px;
}

.book-subtotal span {
    font-size: 18px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Order Total Section */
.order-total-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    padding: 25px;
    border-top: 2px dashed #e9ecef;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    color: #6c757d;
    font-size: 15px;
}

.total-row.grand-total {
    margin-top: 15px;
    padding-top: 20px;
    border-top: 2px solid #667eea;
    font-size: 20px;
    color: #1a1a2e;
}

.total-row.grand-total span:last-child {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.info-card-header {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.info-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.bg-gradient-blue {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-green {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-gradient-orange {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.info-card-header h5 {
    margin: 0;
    font-weight: 700;
    color: #1a1a2e;
}

.info-content {
    padding: 20px;
}

.info-item {
    margin-bottom: 18px;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 12px;
    color: #adb5bd;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-label i {
    color: #667eea;
}

.info-value {
    font-size: 15px;
    color: #1a1a2e;
    font-weight: 500;
    line-height: 1.6;
}

/* Payment Method Badge */
.payment-method-badge {
    padding: 15px 25px;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    font-size: 16px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Proof Image */
.proof-image-wrapper {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
}

.proof-image {
    max-width: 100%;
    display: block;
    transition: transform 0.3s ease;
}

.proof-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.proof-overlay i {
    font-size: 30px;
}

.proof-overlay span {
    font-size: 13px;
    font-weight: 600;
}

.proof-image-wrapper:hover .proof-overlay {
    opacity: 1;
}

.proof-image-wrapper:hover .proof-image {
    transform: scale(1.05);
}

/* Pay Now Button */
.btn-pay-now {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
    padding: 18px 25px;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 700;
    box-shadow: 0 10px 30px rgba(17, 153, 142, 0.4);
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.btn-pay-now:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(17, 153, 142, 0.5);
    color: white;
}

.btn-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-content i {
    font-size: 20px;
}

.btn-arrow {
    width: 35px;
    height: 35px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.btn-pay-now:hover .btn-arrow {
    transform: translateX(5px);
}

/* Help Card */
.help-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    color: white;
}

.help-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.help-content h6 {
    margin: 0 0 5px 0;
    font-weight: 700;
}

.help-content p {
    margin: 0 0 12px 0;
    font-size: 13px;
    opacity: 0.9;
}

.help-link {
    display: inline-flex;
    align-items: center;
    background: #25D366;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.help-link:hover {
    background: #128C7E;
    color: white;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
    }
    
    .header-right {
        align-items: center;
    }
    
    .timeline {
        flex-direction: column;
        gap: 20px;
    }
    
    .timeline-line {
        width: 4px;
        height: 30px;
        margin: 0;
    }
    
    .book-item {
        flex-wrap: wrap;
    }
    
    .book-subtotal {
        width: 100%;
        text-align: left;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #e9ecef;
    }
}
</style>
@endsection