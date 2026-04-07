@extends('layouts1.user')

@section('title', $book->title . ' - NebulaBooks')
@section('page-title', $book->title)
@section('page-subtitle', 'Detail Buku')

@section('content')
<div class="container-fluid px-4 py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Katalog Buku</a></li>
            <li class="breadcrumb-item active">{{ $book->title }}</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="book-detail-image">
                @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" 
                         alt="{{ $book->title }}"
                         onerror="this.src='https://via.placeholder.com/300x400/667eea/ffffff?text={{ urlencode($book->title) }}'">
                @else
                    <img src="https://via.placeholder.com/300x400/667eea/ffffff?text={{ urlencode($book->title) }}" 
                         alt="{{ $book->title }}">
                @endif
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="book-detail-info">
                <span class="book-category-badge">{{ $book->category->name ?? 'Uncategorized' }}</span>
                <h1 class="book-title">{{ $book->title }}</h1>
                <p class="book-author">By {{ $book->author }}</p>
                
                <div class="book-rating mb-3">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span>(4.5)</span>
                </div>

                <div class="book-price-section mb-3">
                    <h2 class="current-price">Rp {{ number_format($book->price, 0, ',', '.') }}</h2>
                    @if($book->stock > 0)
                        <p class="stock-info text-success">
                            <i class="fas fa-check-circle"></i> Stok tersedia: {{ $book->stock }} buku
                        </p>
                    @else
                        <p class="stock-info text-danger">
                            <i class="fas fa-times-circle"></i> Stok habis
                        </p>
                    @endif
                </div>

                <div class="book-meta mb-3">
                    <div class="meta-item">
                        <i class="fas fa-barcode"></i>
                        <span><strong>ISBN:</strong> {{ $book->isbn }}</span>
                    </div>
                    @if($book->penerbit)
                    <div class="meta-item">
                        <i class="fas fa-building"></i>
                        <span><strong>Penerbit:</strong> {{ $book->penerbit }}</span>
                    </div>
                    @endif
                    @if($book->tahun_terbit)
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit }}</span>
                    </div>
                    @endif
                </div>

                <div class="book-actions mb-3">
                    @if($book->stock > 0)
                        <button class="btn btn-primary">
                            <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Beli Sekarang
                        </button>
                    @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-ban me-2"></i>Stok Habis
                        </button>
                    @endif
                    <button class="btn btn-outline-danger" disabled style="display: none;">
                        <i class="fas fa-heart me-2"></i>Wishlist
                    </button>
                </div>

                @if($book->sinopsis)
                <div class="book-description">
                    <h5><i class="fas fa-book-open me-2"></i>Sinopsis</h5>
                    <div class="sinopsis-content">
                        {!! nl2br(e($book->sinopsis)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($relatedBooks->count() > 0)
    <div class="related-books-section">
        <h4 class="section-title">Buku Terkait</h4>
        <div class="row g-3">
            @foreach($relatedBooks as $relatedBook)
            <div class="col-md-3">
                <div class="book-card">
                    <div class="book-image-wrapper">
                        @if($relatedBook->image)
                            <img src="{{ asset('storage/' . $relatedBook->image) }}" 
                                 alt="{{ $relatedBook->title }}"
                                 onerror="this.src='https://via.placeholder.com/250x350/667eea/ffffff?text={{ urlencode(substr($relatedBook->title, 0, 20)) }}'">
                        @else
                            <img src="https://via.placeholder.com/250x350/667eea/ffffff?text={{ urlencode(substr($relatedBook->title, 0, 20)) }}" 
                                 alt="{{ $relatedBook->title }}">
                        @endif
                    </div>
                    <div class="book-info">
                        <h6 class="book-title">{{ Str::limit($relatedBook->title, 40) }}</h6>
                        <p class="book-author">{{ $relatedBook->author }}</p>
                        <p class="book-price">Rp {{ number_format($relatedBook->price, 0, ',', '.') }}</p>
                        <a href="{{ route('books.show', $relatedBook) }}" class="btn btn-sm btn-primary w-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
.breadcrumb {
    background: white;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    font-size: 0.9rem;
}

.breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #666;
}

.book-detail-image {
    background: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 3px 15px rgba(0,0,0,.08);
    text-align: center;
}

.book-detail-image img {
    width: 100%;
    max-width: 280px;
    border-radius: 8px;
    box-shadow: 0 6px 20px rgba(0,0,0,.12);
}

.book-detail-info {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,.08);
}

.book-category-badge {
    display: inline-block;
    background: #5B4B9F;
    color: white;
    padding: 5px 15px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.book-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 8px;
}

.book-author {
    font-size: 1rem;
    color: #666;
    margin-bottom: 10px;
}

.book-rating {
    font-size: 1rem;
    color: #ffc107;
}

.book-rating span {
    color: #666;
    margin-left: 8px;
    font-size: 0.95rem;
}

.book-price-section {
    padding: 15px 0;
    border-top: 2px solid #f0f0f0;
    border-bottom: 2px solid #f0f0f0;
}

.current-price {
    font-size: 1.8rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 8px;
}

.stock-info {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0;
}

.book-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
}

.meta-item i {
    color: #667eea;
    width: 18px;
    font-size: 0.9rem;
}

.book-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.book-actions .btn {
    font-size: 0.9rem;
    padding: 8px 16px;
}

.book-description {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.book-description h5 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 15px;
    color: #333;
    display: flex;
    align-items: center;
}

.book-description h5 i {
    color: #667eea;
}

.sinopsis-content {
    font-size: 0.95rem;
    line-height: 1.8;
    color: #555;
    text-align: justify;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.sinopsis-content p {
    margin-bottom: 15px;
}

.sinopsis-content p:last-child {
    margin-bottom: 0;
}

.related-books-section {
    margin-top: 30px;
}

.section-title {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
}

.book-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(0,0,0,.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.book-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,.12);
}

.book-card .book-image-wrapper {
    height: 250px;
    overflow: hidden;
}

.book-card .book-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-card .book-info {
    padding: 15px;
}

.book-card .book-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.book-card .book-author {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 8px;
}

.book-card .book-price {
    font-size: 1rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 12px;
}

@media (max-width: 768px) {
    .book-title {
        font-size: 1.5rem;
    }
    
    .current-price {
        font-size: 1.5rem;
    }
    
    .book-actions {
        flex-direction: column;
    }
    
    .book-actions .btn {
        width: 100%;
    }
}
</style>
