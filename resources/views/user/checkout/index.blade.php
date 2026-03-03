@extends('layouts1.user')

@section('page-title', 'Checkout')
@section('page-subtitle', 'Proses pembayaran Anda')

@section('content')
<div class="container-fluid px-4">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('user.checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Left Side - Shipping & Payment -->
            <div class="col-lg-8 mb-4">
                <!-- Shipping Address -->
                <div class="card checkout-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Alamat Pengiriman
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="recipient_name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="shipping_address" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" name="postal_code" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Catatan untuk kurir"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card checkout-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>
                            Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Bank Transfer -->
                        <div class="payment-section mb-4">
                            <h6 class="payment-section-title">
                                <i class="fas fa-university me-2"></i>
                                Transfer Bank
                            </h6>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="bca" id="bca" required>
                                    <label for="bca">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/200px-Bank_Central_Asia.svg.png" alt="BCA">
                                        </div>
                                        <span>BCA</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="mandiri" id="mandiri">
                                    <label for="mandiri">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/200px-Bank_Mandiri_logo_2016.svg.png" alt="Mandiri">
                                        </div>
                                        <span>Mandiri</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="bni" id="bni">
                                    <label for="bni">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/200px-BNI_logo.svg.png" alt="BNI">
                                        </div>
                                        <span>BNI</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="bri" id="bri">
                                    <label for="bri">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_2020.svg/200px-BRI_2020.svg.png" alt="BRI">
                                        </div>
                                        <span>BRI</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- E-Wallet -->
                        <div class="payment-section">
                            <h6 class="payment-section-title">
                                <i class="fas fa-wallet me-2"></i>
                                E-Wallet
                            </h6>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="gopay" id="gopay">
                                    <label for="gopay">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/200px-Gopay_logo.svg.png" alt="GoPay">
                                        </div>
                                        <span>GoPay</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="ovo" id="ovo">
                                    <label for="ovo">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/200px-Logo_ovo_purple.svg.png" alt="OVO">
                                        </div>
                                        <span>OVO</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="dana" id="dana">
                                    <label for="dana">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/200px-Logo_dana_blue.svg.png" alt="DANA">
                                        </div>
                                        <span>DANA</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" value="shopeepay" id="shopeepay">
                                    <label for="shopeepay">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Shopee.svg/200px-Shopee.svg.png" alt="ShopeePay">
                                        </div>
                                        <span>ShopeePay</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="col-lg-4">
                <div class="card summary-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Items List -->
                        <div class="summary-items mb-3">
                            <h6 class="mb-3">Items ({{ $cartItems->count() }})</h6>
                            @foreach($cartItems as $item)
                            <div class="summary-item">
                                <div class="summary-item-image">
                                    @if($item->book->image)
                                        <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}">
                                    @else
                                        <img src="https://via.placeholder.com/60x80/667eea/ffffff?text=Book" alt="{{ $item->book->title }}">
                                    @endif
                                </div>
                                <div class="summary-item-details">
                                    <h6>{{ Str::limit($item->book->title, 30) }}</h6>
                                    <p>{{ $item->quantity }} x Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="summary-item-price">
                                    Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Details -->
                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Biaya Admin</span>
                                <span>Rp 5.000</span>
                            </div>
                            <div class="summary-row">
                                <span>Ongkos Kirim</span>
                                <span class="text-success">GRATIS</span>
                            </div>
                            <hr>
                            <div class="summary-row total">
                                <span class="fw-bold">Total Pembayaran</span>
                                <span class="fw-bold text-primary">Rp {{ number_format($subtotal + 5000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-checkout w-100 mt-3">
                            <i class="fas fa-check-circle me-2"></i>
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('user.cart.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Keranjang
                        </a>

                        <!-- Security Info -->
                        <div class="security-info mt-3">
                            <i class="fas fa-lock"></i>
                            <span>Transaksi Anda aman dan terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.checkout-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,.08);
    margin-bottom: 1.5rem;
}

.checkout-card .card-header {
    background: white;
    border-bottom: 2px solid #f0f0f0;
    padding: 1.25rem 1.5rem;
    border-radius: 15px 15px 0 0;
}

.checkout-card .card-header h5 {
    font-weight: 700;
    color: #333;
    margin: 0;
}

.payment-section-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e9ecef;
}

.payment-options {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 1rem;
}

.payment-option {
    position: relative;
}

.payment-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.payment-option label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.payment-option input[type="radio"]:checked + label {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.payment-option label:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.payment-logo {
    width: 80px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.payment-option label span {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.summary-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,.08);
    position: sticky;
    top: 90px;
}

.summary-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    padding: 1.25rem 1.5rem;
}

.summary-items {
    max-height: 300px;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.summary-items::-webkit-scrollbar {
    width: 5px;
}

.summary-items::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 10px;
}

.summary-items h6 {
    font-weight: 600;
    color: #333;
}

.summary-item {
    display: flex;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-item-image {
    width: 50px;
    height: 70px;
    border-radius: 6px;
    overflow: hidden;
    flex-shrink: 0;
}

.summary-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.summary-item-details {
    flex: 1;
}

.summary-item-details h6 {
    font-size: 0.85rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 0.25rem 0;
    line-height: 1.3;
}

.summary-item-details p {
    font-size: 0.75rem;
    color: #666;
    margin: 0;
}

.summary-item-price {
    font-size: 0.85rem;
    font-weight: 600;
    color: #667eea;
    align-self: center;
}

.summary-details {
    margin-top: 1rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    font-size: 0.9rem;
    color: #666;
}

.summary-row.total {
    font-size: 1.1rem;
    padding-top: 0.75rem;
}

.summary-row.total .text-primary {
    font-size: 1.3rem;
}

.btn-checkout {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.875rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-back {
    display: block;
    text-align: center;
    color: #667eea;
    text-decoration: none;
    margin-top: 1rem;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.btn-back:hover {
    color: #764ba2;
}

.security-info {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #666;
}

.security-info i {
    color: #28a745;
}

@media (max-width: 992px) {
    .summary-card {
        position: relative !important;
        top: 0 !important;
    }
    
    .payment-options {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection
