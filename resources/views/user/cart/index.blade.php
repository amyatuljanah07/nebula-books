@extends('layouts1.user')

@section('page-title', 'Keranjang')
@section('page-subtitle', 'Kelola belanjaan Anda')

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

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4">
            <div class="card cart-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Keranjang Belanja
                        <span class="badge bg-primary ms-2">{{ $cartItems->count() }} Items</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($cartItems as $item)
                    <!-- Cart Item -->
                    <div class="cart-item">
                        <div class="cart-item-checkbox">
                            <input type="checkbox" class="form-check-input item-checkbox" checked>
                        </div>
                        <div class="cart-item-image">
                            @if($item->book->image)
                                <img src="{{ asset('storage/' . $item->book->image) }}" 
                                     alt="{{ $item->book->title }}"
                                     onerror="this.src='https://via.placeholder.com/100x140/667eea/ffffff?text=Book'">
                            @else
                                <img src="https://via.placeholder.com/100x140/667eea/ffffff?text=Book" alt="{{ $item->book->title }}">
                            @endif
                        </div>
                        <div class="cart-item-details">
                            <h6 class="cart-item-title">{{ $item->book->title }}</h6>
                            <p class="cart-item-author">{{ $item->book->author }}</p>
                            <span class="cart-item-category">{{ $item->book->category->name ?? 'Uncategorized' }}</span>
                            <div class="cart-item-stock">
                                @if($item->book->stock >= $item->quantity)
                                    <i class="fas fa-check-circle text-success"></i>
                                    Stok tersedia
                                @else
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                    Stok tidak cukup
                                @endif
                            </div>
                        </div>
                        <div class="cart-item-price">
                            <div class="price-current">Rp {{ number_format($item->book->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="cart-item-quantity">
                            <form action="{{ route('user.cart.update', $item) }}" method="POST" class="quantity-form">
                                @csrf
                                <div class="quantity-control">
                                    <button type="button" class="qty-btn minus" onclick="updateQuantity(this, -1, {{ $item->id }}, {{ $item->book->stock }})">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" class="qty-input" value="{{ $item->quantity }}" 
                                           min="1" max="{{ $item->book->stock }}" data-price="{{ $item->book->price }}" readonly>
                                    <button type="button" class="qty-btn plus" onclick="updateQuantity(this, 1, {{ $item->id }}, {{ $item->book->stock }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="cart-item-total">
                            <div class="item-total-price" data-item-total>Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}</div>
                        </div>
                        <div class="cart-item-actions">
                            <button class="btn-action wishlist" title="Pindah ke Wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                            <form action="{{ route('user.cart.remove', $item) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="empty-cart text-center py-5">
                        <i class="fas fa-shopping-cart" style="font-size: 5rem; color: #ddd;"></i>
                        <h4 class="mt-3 text-muted">Keranjang Belanja Kosong</h4>
                        <p class="text-muted">Yuk, mulai belanja dan temukan buku favoritmu!</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-book me-2"></i>Cari Buku
                        </a>
                    </div>
                    @endforelse
                </div>
                @if($cartItems->count() > 0)
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <input type="checkbox" class="form-check-input me-2" id="selectAll" checked>
                            <label for="selectAll">Pilih Semua</label>
                        </div>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteSelected()">
                            <i class="fas fa-trash me-2"></i>Hapus yang Dipilih
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        @if($cartItems->count() > 0)
        <div class="col-lg-4">
            <div class="card summary-card sticky-top">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Ringkasan Belanja
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Promo Code -->
                    <div class="promo-section mb-3">
                        <label class="form-label">Kode Promo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan kode">
                            <button class="btn btn-primary">Gunakan</button>
                        </div>
                    </div>

                    <!-- Summary Details -->
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal ({{ $cartItems->count() }} items)</span>
                            <span class="fw-bold" id="subtotal-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row discount">
                            <span>
                                <i class="fas fa-tag me-1"></i>
                                Diskon
                            </span>
                            <span class="text-success fw-bold">- Rp 0</span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Admin</span>
                            <span>Rp 5.000</span>
                        </div>
                        <hr>
                        <div class="summary-row total">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary" id="total-display">Rp {{ number_format($subtotal + 5000, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('user.checkout') }}" class="btn btn-checkout w-100">
                        <i class="fas fa-lock me-2"></i>
                        Lanjut ke Pembayaran
                    </a>

                    <!-- Continue Shopping -->
                    <a href="{{ route('books.index') }}" class="btn-continue-shopping">
                        <i class="fas fa-arrow-left me-2"></i>
                        Lanjut Belanja
                    </a>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card info-card mt-3">
                <div class="card-body">
                    <h6 class="mb-3">
                        <i class="fas fa-shipping-fast me-2 text-primary"></i>
                        Info Pengiriman
                    </h6>
                    <ul class="info-list">
                        <li><i class="fas fa-check-circle text-success"></i> Gratis ongkir min. Rp 100.000</li>
                        <li><i class="fas fa-check-circle text-success"></i> Estimasi 2-3 hari kerja</li>
                        <li><i class="fas fa-check-circle text-success"></i> Garansi 100% original</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.cart-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,.08);
}

.cart-card .card-header {
    background: white;
    border-bottom: 2px solid #f0f0f0;
    padding: 1.25rem 1.5rem;
    border-radius: 15px 15px 0 0;
}

.cart-card .card-header h5 {
    font-weight: 700;
    color: #333;
}

.cart-item {
    display: grid;
    grid-template-columns: 40px 100px 1fr 150px 120px 120px 80px;
    gap: 1rem;
    padding: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    align-items: center;
    transition: background 0.3s ease;
}

.cart-item:hover {
    background: #f8f9fa;
}

.cart-item-checkbox {
    display: flex;
    align-items: center;
}

.cart-item-image {
    width: 100px;
    height: 140px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.1);
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-details {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.cart-item-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.cart-item-author {
    font-size: 0.85rem;
    color: #666;
    margin: 0;
}

.cart-item-category {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 600;
    width: fit-content;
}

.cart-item-stock {
    font-size: 0.8rem;
    font-weight: 500;
}

.cart-item-price {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.price-current {
    font-size: 1.1rem;
    font-weight: 700;
    color: #667eea;
}

.price-original {
    font-size: 0.85rem;
    color: #999;
    text-decoration: line-through;
}

.price-discount {
    display: inline-block;
    background: #f5576c;
    color: white;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 600;
    width: fit-content;
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.qty-btn {
    background: white;
    border: none;
    width: 32px;
    height: 32px;
    cursor: pointer;
    color: #667eea;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.qty-btn:hover {
    background: #667eea;
    color: white;
}

.qty-input {
    width: 50px;
    height: 32px;
    border: none;
    text-align: center;
    font-weight: 600;
    color: #333;
}

.qty-input:focus {
    outline: none;
}

.item-total-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
}

.cart-item-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.btn-action {
    background: white;
    border: 1px solid #e9ecef;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-action.wishlist:hover {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-color: transparent;
    color: white;
}

.btn-action.delete:hover {
    background: #f5576c;
    border-color: transparent;
    color: white;
}

.cart-card .card-footer {
    background: #f8f9fa;
    border-top: 2px solid #e9ecef;
    padding: 1rem 1.5rem;
}

/* Summary Card */
.summary-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,.08);
}

.summary-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    padding: 1.25rem 1.5rem;
}

@media (min-width: 992px) {
    .summary-card {
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 110px);
        overflow-y: auto;
    }
}

.promo-section .form-label {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.summary-details {
    margin-top: 1rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    font-size: 0.9rem;
    color: #666;
}

.summary-row.discount {
    background: #f0fdf4;
    padding: 0.75rem 1rem;
    margin: 0 -1rem;
    border-radius: 8px;
}

.summary-row.total {
    font-size: 1.2rem;
    padding-top: 1rem;
}

.summary-row.total .text-primary {
    font-size: 1.5rem;
}

.voucher-info {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    padding: 0.875rem 1rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 1rem 0;
    font-size: 0.85rem;
    color: #92400e;
}

.voucher-info i {
    font-size: 1.2rem;
}

.btn-checkout {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-continue-shopping {
    display: block;
    text-align: center;
    color: #667eea;
    text-decoration: none;
    margin-top: 1rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.btn-continue-shopping:hover {
    color: #764ba2;
}

/* Info Card */
.info-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,.08);
}

.info-card h6 {
    font-weight: 700;
    color: #333;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    padding: 0.5rem 0;
    font-size: 0.85rem;
    color: #666;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Responsive */
@media (max-width: 992px) {
    .cart-item {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .cart-item-image {
        width: 100%;
        height: 200px;
    }
    
    .cart-item-actions {
        flex-direction: row;
    }
    
    .summary-card {
        position: relative !important;
        top: 0 !important;
        max-height: none !important;
    }
}
</style>

<script>
// Update Quantity
function updateQuantity(btn, change, cartId, maxStock) {
    const input = btn.parentElement.querySelector('.qty-input');
    let currentValue = parseInt(input.value);
    let newValue = currentValue + change;
    
    if (newValue < 1) newValue = 1;
    if (newValue > maxStock) {
        alert('Jumlah melebihi stok yang tersedia!');
        return;
    }
    
    input.value = newValue;
    
    // Submit form via AJAX
    const form = btn.closest('.quantity-form');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update item total
            const price = parseFloat(input.dataset.price);
            const itemTotal = btn.closest('.cart-item').querySelector('[data-item-total]');
            itemTotal.textContent = 'Rp ' + (price * newValue).toLocaleString('id-ID');
            
            // Update summary
            updateSummary();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload(); // Fallback: reload page
    });
}

// Update Summary
function updateSummary() {
    let subtotal = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
        const cartItem = checkbox.closest('.cart-item');
        const input = cartItem.querySelector('.qty-input');
        const price = parseFloat(input.dataset.price);
        const quantity = parseInt(input.value);
        subtotal += price * quantity;
    });
    
    const adminFee = 5000;
    const total = subtotal + adminFee;
    
    document.getElementById('subtotal-display').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Select All
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSummary();
});

// Checkbox change
document.querySelectorAll('.item-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSummary);
});

// Delete Selected
function deleteSelected() {
    const selected = document.querySelectorAll('.item-checkbox:checked');
    if (selected.length === 0) {
        alert('Pilih item yang ingin dihapus');
        return;
    }
    
    if (confirm('Yakin ingin menghapus ' + selected.length + ' item?')) {
        selected.forEach(checkbox => {
            const deleteBtn = checkbox.closest('.cart-item').querySelector('.btn-action.delete');
            deleteBtn.click();
        });
    }
}
</script>

@endsection