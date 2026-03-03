@extends('layouts1.user')

@section('page-title', 'Pembayaran')
@section('page-subtitle', 'Selesaikan pembayaran Anda')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Order Status -->
            <div class="payment-card mb-4">
                <div class="payment-header">
                    <div class="status-badge pending">
                        <i class="fas fa-clock me-2"></i>Menunggu Pembayaran
                    </div>
                    <h4 class="mb-0">Order #{{ $order->order_number }}</h4>
                    <p class="text-muted mb-0">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <!-- Payment Info -->
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
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/320px-Bank_Central_Asia.svg.png'
                        ],
                        'mandiri' => [
                            'name' => 'Bank Mandiri',
                            'account' => '0987654321',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/320px-Bank_Mandiri_logo_2016.svg.png'
                        ],
                        'bni' => [
                            'name' => 'BNI',
                            'account' => '1122334455',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/320px-BNI_logo.svg.png'
                        ],
                        'bri' => [
                            'name' => 'BRI',
                            'account' => '5544332211',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_2020.svg/320px-BRI_2020.svg.png'
                        ],
                        'gopay' => [
                            'name' => 'GoPay',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/320px-Gopay_logo.svg.png'
                        ],
                        'ovo' => [
                            'name' => 'OVO',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/320px-Logo_ovo_purple.svg.png'
                        ],
                        'dana' => [
                            'name' => 'DANA',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/320px-Logo_dana_blue.svg.png'
                        ],
                        'shopeepay' => [
                            'name' => 'ShopeePay',
                            'account' => '081234567890',
                            'holder' => 'PT Nebula Books Indonesia',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Shopee.svg/320px-Shopee.svg.png'
                        ]
                    ];
                    
                    $payment = $paymentInfo[$order->payment_method];
                @endphp

                <div class="bank-info">
                    <img src="{{ $payment['logo'] }}" alt="{{ $payment['name'] }}" class="bank-logo">
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

            <!-- Total Payment -->
            <div class="payment-card mb-4">
                <h5 class="card-title">
                    <i class="fas fa-receipt me-2"></i>Total Pembayaran
                </h5>
                <div class="total-amount">
                    <span>Total yang harus dibayar:</span>
                    <h3 class="text-primary mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Order Items -->
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

            <!-- Upload Payment Proof -->
            <div class="payment-card mb-4">
                <h5 class="card-title">
                    <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                </h5>
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
            </div>

            <div class="text-center">
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.payment-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 3px 15px rgba(0,0,0,.08);
}

.payment-header {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
    margin-bottom: 20px;
}

.status-badge {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 0.9rem;
}

.status-badge.pending {
    background: #fff3cd;
    color: #856404;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}

.bank-info {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.bank-logo {
    width: 100px;
    height: 60px;
    object-fit: contain;
}

.bank-details {
    flex: 1;
}

.bank-details h6 {
    font-weight: 700;
    margin-bottom: 10px;
    color: #333;
}

.account-number {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

.account-number span {
    font-size: 1.3rem;
    font-weight: 700;
    color: #667eea;
    font-family: 'Courier New', monospace;
}

.total-amount {
    text-align: center;
    padding: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    color: white;
}

.total-amount span {
    font-size: 1.1rem;
    opacity: 0.9;
}

.order-items {
    margin-top: 20px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
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
    color: #667eea;
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
    border: 3px dashed #ddd;
    border-radius: 10px;
    padding: 40px;
    text-align: center;
    transition: all 0.3s;
}

.upload-area:hover {
    border-color: #667eea;
    background: #f8f9ff;
}

.upload-label {
    cursor: pointer;
    display: block;
}

.upload-label i {
    font-size: 3rem;
    color: #667eea;
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
</style>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor rekening berhasil disalin!');
    });
}

document.getElementById('payment_proof').addEventListener('change', function(e) {
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
