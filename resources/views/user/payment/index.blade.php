@extends('layouts1.user')

@section('title', 'Pembayaran - NebulaBooks')
@section('page-title', 'Pembayaran')
@section('page-subtitle', 'Selesaikan pembayaran Anda')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="payment-card mb-4">
                <div class="payment-header">
                    <div class="status-badge pending">
                        <i class="fas fa-clock me-2"></i>Menunggu Pembayaran
                    </div>
                    <h4 class="mb-0">Order #{{ $order->order_number }}</h4>
                    <p class="text-muted mb-0">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    @if($order->isPaymentExpired())
                        <div class="alert alert-danger mt-3 mb-0" style="width: 100%;">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Waktu pembayaran telah berakhir!</strong> Order ini tidak lagi dapat diperbarui.
                        </div>
                    @else
                        <div class="countdown-wrapper mt-3">
                            <p class="text-muted mb-2">Batas waktu pembayaran:</p>
                            <div class="countdown-timer" id="countdown">
                                <span id="hours">24</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="payment-card mb-4">
                <h5 class="card-title">
                    <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                </h5>
                
                @php
                    $paymentInfo = [
                        'bca' => [
                            'name' => 'BCA',
                            'account' => '1234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Bank_Central_Asia.svg?width=200'
                        ],
                        'mandiri' => [
                            'name' => 'Bank Mandiri',
                            'account' => '0987654321',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Bank_Mandiri_logo_2016.svg?width=200'
                        ],
                        'bni' => [
                            'name' => 'BNI',
                            'account' => '1122334455',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/Bank_Negara_Indonesia_logo_%282004%29.svg/1280px-Bank_Negara_Indonesia_logo_%282004%29.svg.png'
                        ],
                        'bri' => [
                            'name' => 'BRI',
                            'account' => '5544332211',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/BRI_2020.svg?width=200'
                        ],
                        'gopay' => [
                            'name' => 'GoPay',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Gopay_logo.svg?width=200'
                        ],
                        'ovo' => [
                            'name' => 'OVO',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Logo_ovo_purple.svg?width=200'
                        ],
                        'dana' => [
                            'name' => 'DANA',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Logo_dana_blue.svg?width=200'
                        ],
                        'shopeepay' => [
                            'name' => 'ShopeePay',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Shopee.svg?width=200'
                        ]
                    ];
                    
                    $payment = $paymentInfo[$order->payment_method];
                @endphp

                <div class="bank-info">
                    <div class="bank-logo-wrapper">
                        <img src="{{ $payment['logo'] }}" alt="{{ $payment['name'] }}" class="bank-logo" id="bank-logo-image" onerror="showBankFallback()">
                        <div class="bank-logo-fallback" id="bank-logo-fallback" style="display: none;">
                            <i class="fas fa-landmark"></i>
                        </div>
                    </div>
                    <div class="bank-details">
                        <h6>{{ $payment['name'] }}</h6>
                        <div class="account-number">
                            <span>{{ $payment['account'] }}</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('{{ $payment['account'] }}')">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                        </div>
                        <p class="text-muted mb-0">a.n. {{ $payment['holder'] }}</p>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Transfer sesuai dengan nominal yang tertera. Pembayaran akan diverifikasi dalam 1x24 jam.
                </div>
            </div>

            <div class="payment-card mb-4">
                <h5 class="card-title">
                    <i class="fas fa-receipt me-2"></i>Total Pembayaran
                </h5>
                <div class="total-amount">
                    <span>Total yang harus dibayar:</span>
                    <h3 class="text-primary mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="payment-card mb-4">
                <h5 class="card-title">
                    <i class="fas fa-box me-2"></i>Detail Pesanan
                </h5>
                <div class="order-items">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-info">
                            <h6>{{ $item->book->title }}</h6>
                            <p class="text-muted mb-0">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="item-price">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_amount - 5000, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Admin</span>
                            <span>Rp 5.000</span>
                        </div>
                        <div class="summary-row total">
                            <strong>Total</strong>
                            <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-card mb-4">
                <h5 class="card-title">
                    <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                </h5>
                @if($order->isPaymentExpired())
                    <div class="alert alert-danger m-4">
                        <i class="fas fa-times-circle me-2"></i>
                        <strong>Waktu pembayaran telah berakhir.</strong> Anda tidak dapat mengunggah bukti pembayaran lagi. Silakan hubungi customer service untuk membuat order baru.
                    </div>
                @else
                    <form action="{{ route('user.payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-area">
                            <input type="file" name="payment_proof" id="payment_proof" class="d-none" accept="image/*" required>
                            <label for="payment_proof" class="upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik untuk upload bukti pembayaran</p>
                                <small>Format: JPG, PNG (Max 2MB)</small>
                            </label>
                            <div id="preview" class="preview-image"></div>
                        </div>
                        @error('payment_proof')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                        </button>
                    </form>
                @endif
            </div>

            <div class="text-center">
                @if(!$order->isPaymentExpired() && !$order->payment_proof)
                    <button type="button" class="btn btn-outline-secondary" disabled title="Silakan upload bukti pembayaran terlebih dahulu">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </button>
                    <p class="text-muted mt-3" style="font-size: 0.9rem;">
                        <i class="fas fa-info-circle me-1"></i>Anda harus mengunggah bukti pembayaran sebelum meninggalkan halaman ini.
                    </p>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.payment-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
    border: 1px solid #fafafa;
    margin-bottom: 24px;
    overflow: hidden;
}

.payment-header {
    text-align: center;
    padding: 48px 32px;
    border: none;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
    background: #ffffff;
    border-bottom: 1px solid #f0f0f0;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 10px 24px;
    border-radius: 28px;
    font-weight: 600;
    font-size: 0.9rem;
    order: -1;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    backdrop-filter: brightness(1.05);
}

.status-badge.pending {
    background: #fffbeb;
    color: #b8860b;
    border: 1px solid rgba(184, 134, 11, 0.1);
}

.payment-header h4 {
    font-size: 2rem;
    font-weight: 800;
    color: #0a0a0a;
    margin: 0;
    line-height: 1.4;
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    max-width: 100%;
    letter-spacing: -0.8px;
    padding: 0 16px;
}

.payment-header p {
    font-size: 0.95rem;
    color: #a0a0a0;
    margin: 0;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.countdown-wrapper {
    text-align: center;
}

.countdown-wrapper p {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 8px;
}

.countdown-timer {
    font-size: 2.2rem;
    font-weight: 700;
    color: #5B4B9F;
    font-family: 'Courier New', monospace;
    letter-spacing: 3px;
    background: #f8f9ff;
    padding: 12px 24px;
    border-radius: 10px;
    display: inline-block;
    min-width: 200px;
}

.countdown-timer.warning {
    color: #ff9800;
}

.countdown-timer.danger {
    color: #f44336;
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.6;
    }
}

.card-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0;
    padding: 28px 32px;
    color: #1a1a1a;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
}

.bank-info {
    display: flex;
    align-items: center;
    gap: 28px;
    padding: 32px;
    margin: 0;
    background: #f8f9ff;
    border-bottom: 1px solid #f0f0f0;
    border-radius: 0;
}

.bank-logo {
    flex-shrink: 0;
    width: 120px;
    height: 72px;
    padding: 8px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    object-fit: contain;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bank-details {
    flex: 1;
    min-width: 0;
}

.bank-details h6 {
    font-weight: 700;
    margin-bottom: 14px;
    color: #0a0a0a;
    font-size: 1.15rem;
}

.account-number {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.account-number span {
    font-size: 1.4rem;
    font-weight: 700;
    color: #5B4B9F;
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

.account-number button {
    padding: 8px 16px !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
    border: 2px solid #5B4B9F !important;
    color: #5B4B9F !important;
    background: transparent !important;
    border-radius: 8px !important;
    transition: all 0.3s ease !important;
    cursor: pointer;
    white-space: nowrap;
}

.account-number button:hover {
    background: #5B4B9F !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(91, 75, 159, 0.3) !important;
}

.account-number button i {
    margin-right: 6px;
}

.bank-details p {
    font-size: 0.95rem;
    color: #888;
    margin: 0;
    font-weight: 500;
}

.total-amount {
    text-align: center;
    padding: 40px 32px;
    margin: 0;
    background: #5B4B9F;
    border-radius: 0;
    color: white;
}

.total-amount span {
    font-size: 1rem;
    opacity: 0.92;
    display: block;
    margin-bottom: 12px;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.total-amount h3 {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: -0.5px;
}

.order-items {
    margin: 0;
    padding: 32px;
    border-bottom: 1px solid #f0f0f0;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    padding: 20px 0;
    border-bottom: 1px solid #f5f5f5;
}

.order-item:last-child {
    border-bottom: none;
}

.item-info h6 {
    font-size: 1rem;
    margin-bottom: 5px;
    color: #333;
}

.item-price {
    font-weight: 700;
    color: #5B4B9F;
}

.order-summary {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    color: #666;
}

.summary-row.total {
    font-size: 1.2rem;
    color: #333;
    padding-top: 15px;
    margin-top: 10px;
    border-top: 2px solid #f0f0f0;
}

.upload-area {
    border: 2px dashed #d0d0e0;
    border-radius: 12px;
    padding: 48px 32px;
    margin: 32px 32px 0;
    text-align: center;
    transition: all 0.3s ease;
    background: #f8f9ff;
}

.upload-area:hover {
    border-color: #5B4B9F;
    background: #f0f1ff;
    box-shadow: 0 4px 12px rgba(91, 75, 159, 0.15);
}

.alert {
    margin: 0 32px;
    padding: 24px 32px;
    border: none;
    border-radius: 0;
    border-left: 4px solid;
}

.alert-info {
    background: #e7f5ff;
    color: #0066b3;
    border-left-color: #0066cc;
    margin-bottom: 32px;
}

.upload-label {
    cursor: pointer;
    display: block;
}

.upload-label i {
    font-size: 3rem;
    color: #5B4B9F;
    margin-bottom: 15px;
}

.upload-label p {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.upload-label small {
    color: #666;
}

.preview-image {
    margin-top: 20px;
    display: none;
}

.preview-image img {
    max-width: 300px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,.1);
}

@media (max-width: 768px) {
    .payment-card {
        border-radius: 12px;
    }

    .payment-header {
        padding: 40px 24px;
        gap: 18px;
    }

    .payment-header h4 {
        font-size: 1.6rem;
        padding: 0 12px;
    }

    .payment-header p {
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 9px 20px;
        font-size: 0.88rem;
    }

    .card-title {
        font-size: 1.1rem;
        padding: 24px 24px 0;
    }

    .bank-info {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 20px;
        padding: 28px 24px;
    }

    .bank-logo {
        width: 100px;
        height: 60px;
    }

    .bank-details {
        width: 100%;
    }

    .account-number {
        justify-content: center;
        gap: 12px;
    }

    .total-amount {
        padding: 32px 24px;
    }

    .total-amount h3 {
        font-size: 1.6rem;
    }

    .order-items {
        padding: 24px;
    }

    .order-item {
        padding: 16px 0;
    }

    .upload-area {
        padding: 40px 24px;
        margin: 24px 24px 0;
    }

    .alert {
        margin: 0 24px;
        padding: 20px 24px;
        font-size: 0.95rem;
    }
}

@media (max-width: 480px) {
    .payment-card {
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .payment-header {
        padding: 32px 16px;
        gap: 16px;
    }

    .payment-header h4 {
        font-size: 1.35rem;
        padding: 0 8px;
    }

    .status-badge {
        padding: 8px 18px;
        font-size: 0.8rem;
    }

    .card-title {
        font-size: 1rem;
        padding: 20px 16px 0;
    }

    .bank-info {
        padding: 24px 16px;
        gap: 16px;
    }

    .bank-logo {
        width: 90px;
        height: 54px;
    }

    .account-number span {
        font-size: 1.1rem;
        letter-spacing: 0.5px;
    }

    .total-amount {
        padding: 28px 16px;
    }

    .total-amount span {
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .total-amount h3 {
        font-size: 1.45rem;
    }

    .order-items {
        padding: 20px 16px;
    }

    .order-item {
        padding: 14px 0;
    }

    .item-info h6 {
        font-size: 0.95rem;
    }

    .upload-area {
        padding: 32px 16px;
        margin: 20px 16px 0;
        border-radius: 10px;
    }

    .upload-label i {
        font-size: 2.5rem;
        margin-bottom: 12px;
    }

    .upload-label p {
        font-size: 1rem;
    }

    .alert {
        margin: 0 16px 20px;
        padding: 16px;
        font-size: 0.9rem;
    }
}
</style>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor rekening berhasil disalin!');
    });
}

// Countdown Timer
function initCountdown() {
    @if($order->payment_deadline && !$order->isPaymentExpired())
        const paymentDeadline = '{{ $order->payment_deadline->toIso8601String() }}';
        const countdownElement = document.getElementById('countdown');
        
        if (!countdownElement) return;

        function updateCountdown() {
            const now = new Date().getTime();
            const deadline = new Date(paymentDeadline).getTime();
            const difference = deadline - now;

            if (difference <= 0) {
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                countdownElement.classList.add('danger');
                // Refresh page to show expired message
                setTimeout(() => {
                    location.reload();
                }, 1000);
                return;
            }

            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            // Update display
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

            // Change color based on time remaining
            countdownElement.classList.remove('warning', 'danger');
            if (hours === 0 && minutes <= 10) {
                countdownElement.classList.add('danger');
            } else if (hours === 0 && minutes <= 30) {
                countdownElement.classList.add('warning');
            }
        }

        // Initial call
        updateCountdown();
        // Update every second
        setInterval(updateCountdown, 1000);
    @endif
}

// Initialize countdown on page load
document.addEventListener('DOMContentLoaded', initCountdown);

document.getElementById('payment_proof')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
