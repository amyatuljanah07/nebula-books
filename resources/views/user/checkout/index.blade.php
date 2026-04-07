@extends('layouts1.user')

@section('title', 'Checkout - NebulaBooks')
@section('page-title', 'Checkout')
@section('page-subtitle', 'Proses pembayaran Anda')

@section('content')
    <div class="container-fluid px-4 checkout-page">
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

        <form action="{{ route('user.checkout.process') }}" method="POST" id="checkout-form">
            @csrf

            <div class="checkout-card address-card" id="address-display">
                <div class="address-header">
                    <div class="address-pin">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h6 class="address-title">Alamat Pengiriman</h6>
                    <button type="button" class="btn-edit-address" onclick="toggleAddressForm()">
                        <i class="fas fa-pen"></i> Ubah
                    </button>
                </div>
                <div class="address-body">
                    <div class="address-name-phone">
                        <span class="address-name">{{ $user->name }}</span>
                        <span class="address-divider">|</span>
                        <span class="address-phone">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <p class="address-text" id="address-preview">
                        {{ $user->address ?? ($lastOrder->shipping_address ?? 'Belum ada alamat tersimpan. Klik "Ubah" untuk mengisi.') }}
                        @if($user->city || ($lastOrder && $lastOrder->city))
                            <br><strong>{{ $user->city ?? ($lastOrder->city ?? '') }}</strong> {{ $user->postal_code ?? ($lastOrder->postal_code ?? '') }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="checkout-card address-form-card" id="address-form" style="display: none;">
                <div class="address-header">
                    <div class="address-pin">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h6 class="address-title">Edit Alamat Pengiriman</h6>
                    <button type="button" class="btn-edit-address" onclick="toggleAddressForm()">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
                <div class="address-form-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control" id="input-name"
                                value="{{ old('recipient_name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="phone" class="form-control" id="input-phone"
                                value="{{ old('phone', $user->phone ?? ($lastOrder->phone ?? '')) }}"
                                placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="shipping_address" class="form-control" id="input-address" rows="2"
                                placeholder="Nama jalan, nomor rumah, RT/RW"
                                required>{{ old('shipping_address', $user->address ?? ($lastOrder->shipping_address ?? '')) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-control" id="input-city"
                                value="{{ old('city', $user->city ?? ($lastOrder->city ?? '')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-control" id="input-postal"
                                value="{{ old('postal_code', $user->postal_code ?? ($lastOrder->postal_code ?? '')) }}" required>
                        </div>
                    </div>
                    <button type="button" class="btn-save-address" onclick="saveAddress()">
                        <i class="fas fa-check me-2"></i>Simpan Alamat
                    </button>
                </div>
            </div>

            <input type="hidden" name="recipient_name" id="hidden-name" value="{{ old('recipient_name', $user->name) }}">
            <input type="hidden" name="phone" id="hidden-phone"
                value="{{ old('phone', $user->phone ?? ($lastOrder->phone ?? '')) }}">
            <input type="hidden" name="shipping_address" id="hidden-address"
                value="{{ old('shipping_address', $user->address ?? ($lastOrder->shipping_address ?? '')) }}">
            <input type="hidden" name="city" id="hidden-city" value="{{ old('city', $user->city ?? ($lastOrder->city ?? '')) }}">
            <input type="hidden" name="postal_code" id="hidden-postal"
                value="{{ old('postal_code', $user->postal_code ?? ($lastOrder->postal_code ?? '')) }}">

            <div class="checkout-card">
                <div class="products-header">
                    <i class="fas fa-shopping-bag me-2 text-primary"></i>
                    <h6>Pesanan Kamu</h6>
                    <span class="product-count-badge">{{ $cartItems->count() }} item</span>
                </div>
                @foreach($cartItems as $item)
                    <div class="product-row">
                        <div class="product-image">
                            @if($item->book->image)
                                <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}">
                            @else
                                <img src="https://via.placeholder.com/60x80/667eea/ffffff?text=Book" alt="{{ $item->book->title }}">
                            @endif
                        </div>
                        <div class="product-info">
                            <h6 class="product-title">{{ $item->book->title }}</h6>
                            <p class="product-author">{{ $item->book->author }}</p>
                            <div class="product-price-row">
                                <span class="product-price">Rp {{ number_format($item->book->price, 0, ',', '.') }}</span>
                                <span class="product-qty">x{{ $item->quantity }}</span>
                            </div>
                        </div>
                        <div class="product-subtotal">
                            Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="checkout-card">
                <div class="section-row">
                    <div class="section-row-left">
                        <i class="fas fa-comment-dots me-2 text-muted"></i>
                        <span>Catatan untuk Penjual</span>
                    </div>
                    <input type="text" name="notes" class="notes-input" placeholder="Tinggalkan pesan..."
                        value="{{ old('notes') }}">
                </div>
            </div>

            <div class="checkout-card">
                <div class="section-row">
                    <div class="section-row-left">
                        <i class="fas fa-truck me-2 text-success"></i>
                        <span>Opsi Pengiriman</span>
                    </div>
                </div>
                <div class="shipping-option selected">
                    <div class="shipping-detail">
                        <span class="shipping-name">Reguler</span>
                        <span class="shipping-est">Estimasi tiba 2-3 hari kerja</span>
                    </div>
                    <div class="shipping-price-tag">
                        <span class="shipping-price-free">GRATIS</span>
                    </div>
                </div>
            </div>

            <div class="checkout-card">
                <div class="section-row" style="margin-bottom: 12px;">
                    <div class="section-row-left">
                        <i class="fas fa-credit-card me-2 text-primary"></i>
                        <span class="fw-600">Metode Pembayaran</span>
                    </div>
                    <span class="payment-selected-label" id="selected-payment-label">Pilih metode</span>
                </div>

                <div class="payment-dropdown">
                    <div class="payment-dropdown-header" onclick="togglePaymentGroup(this)">
                        <div class="payment-dropdown-left">
                            <i class="fas fa-university"></i>
                            <span>Transfer Bank</span>
                        </div>
                        <i class="fas fa-chevron-down payment-dropdown-arrow"></i>
                    </div>
                    <div class="payment-dropdown-body">
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="bca" required>
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/200px-Bank_Central_Asia.svg.png"
                                    alt="BCA">
                                <span>BCA</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="mandiri">
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/200px-Bank_Mandiri_logo_2016.svg.png"
                                    alt="Mandiri">
                                <span>Mandiri</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="bni">
                            <div class="payment-item-content">
                                <img src="{{ asset('images/logo.jpg') }}" alt="BNI">
                                <span>BNI</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="bri">
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_2020.svg/200px-BRI_2020.svg.png"
                                    alt="BRI">
                                <span>BRI</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                    </div>
                </div>

                <div class="payment-dropdown">
                    <div class="payment-dropdown-header" onclick="togglePaymentGroup(this)">
                        <div class="payment-dropdown-left">
                            <i class="fas fa-wallet"></i>
                            <span>E-Wallet</span>
                        </div>
                        <i class="fas fa-chevron-down payment-dropdown-arrow"></i>
                    </div>
                    <div class="payment-dropdown-body">
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="gopay">
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/200px-Gopay_logo.svg.png"
                                    alt="GoPay">
                                <span>GoPay</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="ovo">
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/200px-Logo_ovo_purple.svg.png"
                                    alt="OVO">
                                <span>OVO</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="dana">
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/200px-Logo_dana_blue.svg.png"
                                    alt="DANA">
                                <span>DANA</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                        <label class="payment-item">
                            <input type="radio" name="payment_method" value="shopeepay">
                            <div class="payment-item-content">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Shopee.svg/200px-Shopee.svg.png"
                                    alt="ShopeePay">
                                <span>ShopeePay</span>
                            </div>
                            <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="checkout-card">
                <div class="section-row" style="margin-bottom: 16px;">
                    <div class="section-row-left">
                        <i class="fas fa-receipt me-2 text-primary"></i>
                        <span class="fw-600">Rincian Pembayaran</span>
                    </div>
                </div>
                <div class="payment-detail-row">
                    <span>Subtotal Pesanan</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="payment-detail-row">
                    <span>Subtotal Pengiriman</span>
                    <span>Rp 0</span>
                </div>
                <div class="payment-detail-row">
                    <span>Biaya Layanan</span>
                    <span>Rp 5.000</span>
                </div>
                <div class="payment-detail-row">
                    <span>Total Diskon Pengiriman</span>
                    <span class="text-success">-Rp 0</span>
                </div>
                <hr style="margin: 12px 0;">
                <div class="payment-detail-row total">
                    <span>Total Pembayaran</span>
                    <span class="total-price">Rp {{ number_format($subtotal + 5000, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="checkout-bottom-bar">
                <div class="bottom-bar-inner">
                    <div class="bottom-bar-left">
                        <span class="bottom-label">Total</span>
                        <span class="bottom-total">Rp {{ number_format($subtotal + 5000, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="btn-buat-pesanan">
                        Buat Pesanan
                    </button>
                </div>
            </div>

            <div style="height: 100px;"></div>
        </form>
    </div>

    <style>
        .checkout-page {
            max-width: 680px;
            margin: 0 auto;
            padding-bottom: 0 !important;
        }

        .checkout-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .06);
            padding: 20px;
            margin-bottom: 12px;
        }

        .address-card {
            border-left: 4px solid #667eea;
        }

        .address-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .address-pin {
            color: #667eea;
            font-size: 1.1rem;
        }

        .address-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #333;
            margin: 0;
            flex: 1;
        }

        .btn-edit-address {
            background: none;
            border: 1px solid #5B4B9F;
            color: #667eea;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-edit-address:hover {
            background: #5B4B9F;
            color: white;
        }

        .address-name-phone {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .address-name {
            font-weight: 700;
            color: #222;
            font-size: 0.95rem;
        }

        .address-divider {
            color: #ccc;
        }

        .address-phone {
            color: #666;
            font-size: 0.9rem;
        }

        .address-text {
            color: #555;
            font-size: 0.85rem;
            margin: 0;
            line-height: 1.5;
        }

        .address-form-card {
            border-left: 4px solid #667eea;
        }

        .address-form-body {
            padding-top: 4px;
        }

        .address-form-body .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 4px;
        }

        .address-form-body .form-control {
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            font-size: 0.9rem;
            padding: 10px 14px;
            transition: border-color 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .address-form-body .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, .12);
        }

        .btn-save-address {
            margin-top: 16px;
            background: #5B4B9F;
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save-address:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(102, 126, 234, .35);
        }

        .products-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
        }

        .products-header h6 {
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
            color: #333;
            flex: 1;
        }

        .product-count-badge {
            background: #f0f1ff;
            color: #667eea;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .product-row {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-top: 1px solid #f5f5f5;
            align-items: center;
        }

        .product-row:first-of-type {
            border-top: none;
        }

        .product-image {
            width: 64px;
            height: 86px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            flex: 1;
            min-width: 0;
        }

        .product-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #222;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-author {
            font-size: 0.78rem;
            color: #999;
            margin: 0 0 6px;
        }

        .product-price-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-price {
            color: #667eea;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .product-qty {
            color: #999;
            font-size: 0.85rem;
        }

        .product-subtotal {
            font-weight: 700;
            color: #222;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .section-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-row-left {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #333;
            font-size: 0.92rem;
        }

        .fw-600 {
            font-weight: 600;
        }

        .notes-input {
            border: none;
            border-bottom: 1.5px solid #eee;
            padding: 6px 0;
            font-size: 0.85rem;
            color: #333;
            text-align: right;
            flex: 1;
            max-width: 300px;
            outline: none;
            transition: border-color 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .notes-input:focus {
            border-color: #667eea;
        }

        .notes-input::placeholder {
            color: #bbb;
        }

        .shipping-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            background: #f8faf8;
            border: 1.5px solid #e8f5e9;
            border-radius: 10px;
            margin-top: 10px;
        }

        .shipping-option.selected {
            border-color: #4caf50;
            background: #f1f8f1;
        }

        .shipping-name {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .shipping-est {
            display: block;
            font-size: 0.78rem;
            color: #888;
            margin-top: 2px;
        }

        .shipping-price-free {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .payment-selected-label {
            font-size: 0.82rem;
            color: #667eea;
            font-weight: 600;
        }

        .payment-dropdown {
            border: 1.5px solid #f0f0f0;
            border-radius: 10px;
            margin-bottom: 8px;
            overflow: hidden;
            transition: border-color 0.3s;
        }

        .payment-dropdown.has-selected {
            border-color: #667eea;
        }

        .payment-dropdown-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            cursor: pointer;
            background: #fafbff;
            transition: background 0.2s;
            user-select: none;
        }

        .payment-dropdown-header:hover {
            background: #f0f1ff;
        }

        .payment-dropdown-left {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: #444;
            font-size: 0.9rem;
        }

        .payment-dropdown-left i {
            color: #667eea;
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .payment-dropdown-arrow {
            color: #999;
            font-size: 0.75rem;
            transition: transform 0.3s ease;
        }

        .payment-dropdown.open .payment-dropdown-arrow {
            transform: rotate(180deg);
        }

        .payment-dropdown-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease;
            background: white;
        }

        .payment-dropdown.open .payment-dropdown-body {
            max-height: 400px;
        }

        .payment-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            border-top: 1px solid #f5f5f5;
            transition: background 0.2s;
            margin: 0;
        }

        .payment-item:hover {
            background: #f8f9ff;
        }

        .payment-item input[type="radio"] {
            display: none;
        }

        .payment-item-content {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .payment-item-content img {
            width: 40px;
            height: 24px;
            object-fit: contain;
        }

        .payment-item-content span {
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }

        .payment-check {
            color: #ddd;
            font-size: 1.2rem;
            transition: color 0.2s;
        }

        .payment-item input[type="radio"]:checked~.payment-check {
            color: #667eea;
        }

        .payment-item input[type="radio"]:checked~.payment-item-content span {
            font-weight: 700;
            color: #222;
        }

        .payment-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 0.88rem;
            color: #555;
        }

        .payment-detail-row.total {
            padding-top: 8px;
        }

        .payment-detail-row.total span:first-child {
            font-weight: 700;
            color: #222;
            font-size: 0.95rem;
        }

        .total-price {
            font-weight: 800 !important;
            color: #5B4B9F !important;
            font-size: 1.2rem !important;
        }

        .checkout-bottom-bar {
            position: fixed;
            bottom: 0;
            left: var(--sidebar-width, 280px);
            right: 0;
            background: white;
            border-top: 1px solid #eee;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, .08);
            z-index: 100;
            padding: 0;
            transition: left 0.3s ease;
        }

        body.sidebar-collapsed .checkout-bottom-bar {
            left: 0;
        }

        .bottom-bar-inner {
            max-width: 680px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 24px;
            padding: 14px 24px;
        }

        .bottom-label {
            font-size: 0.85rem;
            color: #888;
        }

        .bottom-total {
            font-size: 1.3rem;
            font-weight: 800;
            color: #667eea;
            display: block;
        }

        .btn-buat-pesanan {
            background: #5B4B9F;
            color: white;
            border: none;
            padding: 14px 48px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.3px;
        }

        .btn-buat-pesanan:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .checkout-page {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            .checkout-bottom-bar {
                left: 0 !important;
            }

            .bottom-bar-inner {
                padding: 12px 16px;
                gap: 16px;
            }

            .btn-buat-pesanan {
                padding: 12px 28px;
                font-size: 0.9rem;
            }

            .bottom-total {
                font-size: 1.1rem;
            }

            .product-title {
                white-space: normal;
                -webkit-line-clamp: 2;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .notes-input {
                max-width: 180px;
            }
        }
    </style>

    <script>
        function toggleAddressForm() {
            const display = document.getElementById('address-display');
            const form = document.getElementById('address-form');

            if (form.style.display === 'none') {
                form.style.display = 'block';
                display.style.display = 'none';
                toggleInputs(true);
            } else {
                form.style.display = 'none';
                display.style.display = 'block';
                toggleInputs(false);
            }
        }

        function toggleInputs(showForm) {
            const formInputs = document.querySelectorAll('#address-form input, #address-form textarea');
            const hiddenInputs = document.querySelectorAll('#hidden-name, #hidden-phone, #hidden-address, #hidden-city, #hidden-postal');

            formInputs.forEach(i => { i.disabled = !showForm; i.name = showForm ? i.name || i.id.replace('input-', '') : ''; });

            if (showForm) {
                hiddenInputs.forEach(i => i.disabled = true);
                document.querySelector('#input-name').name = 'recipient_name';
                document.querySelector('#input-phone').name = 'phone';
                document.querySelector('#input-address').name = 'shipping_address';
                document.querySelector('#input-city').name = 'city';
                document.querySelector('#input-postal').name = 'postal_code';
            } else {
                hiddenInputs.forEach(i => i.disabled = false);
            }
        }

        function saveAddress() {
            const name = document.getElementById('input-name').value;
            const phone = document.getElementById('input-phone').value;
            const address = document.getElementById('input-address').value;
            const city = document.getElementById('input-city').value;
            const postal = document.getElementById('input-postal').value;

            if (!name || !phone || !address || !city || !postal) {
                alert('Lengkapi semua field alamat!');
                return;
            }

            document.querySelector('.address-name').textContent = name;
            document.querySelector('.address-phone').textContent = phone;
            document.getElementById('address-preview').innerHTML = address + '<br><strong>' + city + '</strong> ' + postal;

            document.getElementById('hidden-name').value = name;
            document.getElementById('hidden-phone').value = phone;
            document.getElementById('hidden-address').value = address;
            document.getElementById('hidden-city').value = city;
            document.getElementById('hidden-postal').value = postal;

            toggleAddressForm();
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleInputs(false);

            const radios = document.querySelectorAll('input[name="payment_method"]');
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const label = this.closest('.payment-item').querySelector('.payment-item-content span').textContent;
                    document.getElementById('selected-payment-label').textContent = label;

                    document.querySelectorAll('.payment-dropdown').forEach(d => d.classList.remove('has-selected'));
                    this.closest('.payment-dropdown').classList.add('has-selected');
                });
            });
        });

        function togglePaymentGroup(header) {
            const dropdown = header.closest('.payment-dropdown');
            const isOpen = dropdown.classList.contains('open');

            document.querySelectorAll('.payment-dropdown').forEach(d => d.classList.remove('open'));

            if (!isOpen) {
                dropdown.classList.add('open');
            }
        }
    </script>
@endsection