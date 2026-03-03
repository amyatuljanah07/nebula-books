@extends('layouts1.user')

@section('page-title', 'Katalog Buku')
@section('page-subtitle', 'Temukan buku favorit Anda')

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

    <div class="catalog-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold mb-0">Katalog Buku</h2>
                <p class="text-muted mb-0">Temukan buku favorit Anda</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-sync me-2"></i>Reset Filter
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card search-filter-card">
                <div class="card-body">
                    <form action="{{ route('books.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Cari judul buku, penulis, atau ISBN..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="category" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tertinggi</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama: Z-A</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid - 2 Columns -->
    <div class="row g-4">
        @forelse($books as $book)
        <div class="col-md-6">
            <div class="book-card-horizontal">
                @if($book->stock <= 5 && $book->stock > 0)
                    <div class="book-badge sale">Stok Terbatas</div>
                @elseif($book->stock == 0)
                    <div class="book-badge" style="background: #6c757d;">Habis</div>
                @endif
                
                <div class="book-image-wrapper">
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" 
                             alt="{{ $book->title }}"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400/667eea/ffffff?text={{ urlencode(substr($book->title, 0, 20)) }}'">
                    @else
                        <img src="https://via.placeholder.com/300x400/667eea/ffffff?text={{ urlencode(substr($book->title, 0, 20)) }}" alt="{{ $book->title }}">
                    @endif
                </div>
                
                <div class="book-details">
                    <span class="book-category">{{ $book->category->name ?? 'Uncategorized' }}</span>
                    <h5 class="book-title">{{ $book->title }}</h5>
                    <p class="book-author">{{ $book->author }}</p>
                    <p class="book-description">
                        {{ Str::limit($book->sinopsis ?? 'Tidak ada deskripsi', 120) }}
                    </p>
                    <div class="book-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5)</span>
                    </div>
                    <div class="book-footer-horizontal">
                        <div class="book-price">
                            <span class="current-price">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            @if($book->stock > 0)
                                <small class="text-success"><i class="fas fa-check-circle"></i> Stok: {{ $book->stock }}</small>
                            @else
                                <small class="text-danger"><i class="fas fa-times-circle"></i> Stok Habis</small>
                            @endif
                        </div>
                        <div class="book-actions">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger" title="Wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                            @if($book->stock > 0)
                                <form action="{{ route('user.cart.add', $book) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary" title="Tambah ke Keranjang">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled title="Stok Habis">
                                    <i class="fas fa-ban"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-book-open" style="font-size: 5rem; color: #ddd;"></i>
                <h4 class="mt-3 text-muted">Tidak ada buku ditemukan</h4>
                <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori</p>
                <a href="{{ route('books.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-sync me-2"></i>Reset Pencarian
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
    <div class="row mt-5 mb-4">
        <div class="col-12">
            <nav>
                <ul class="pagination justify-content-center custom-pagination">
                    {{-- Previous Page Link --}}
                    @if ($books->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $books->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($books->links()->elements[0] as $page => $url)
                        @if ($page == $books->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($books->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $books->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    @endif
</div>

<style>
.search-filter-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}

.search-box input {
    padding-left: 45px;
    border-radius: 10px;
    border: 2px solid #e9ecef;
}

.search-box input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.book-card-horizontal {
    background: white;
    border-radius: 15px;
    padding: 1rem;
    box-shadow: 0 2px 15px rgba(0,0,0,.08);
    display: flex;
    gap: 1rem;
    position: relative;
    transition: all 0.3s ease;
    height: 100%;
}

.book-card-horizontal:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,.15);
}

.book-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #f5576c 0%, #ff6b6b 100%);
    color: white;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.65rem;
    font-weight: 600;
    z-index: 10;
}

.book-badge.new {
    background: linear-gradient(135deg, #0acffe 0%, #495aff 100%);
}

.book-badge.sale {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.book-image-wrapper {
    flex-shrink: 0;
    width: 110px;
    height: 160px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.12);
}

.book-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.book-card-horizontal:hover .book-image-wrapper img {
    transform: scale(1.05);
}

.book-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.book-category {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 600;
    margin-bottom: 0.4rem;
    align-self: flex-start;
}

.book-title {
    font-size: 1rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.3rem;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.book-author {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 0.4rem;
    font-weight: 500;
}

.book-description {
    font-size: 0.75rem;
    color: #555;
    line-height: 1.5;
    margin-bottom: 0.6rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.book-rating {
    color: #ffc107;
    font-size: 0.75rem;
}

.book-rating span {
    color: #666;
    margin-left: 3px;
    font-weight: 500;
}

.book-footer-horizontal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 0.6rem;
    border-top: 1px solid #f0f0f0;
}

.book-price {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.current-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #667eea;
}

.old-price {
    font-size: 0.75rem;
    color: #999;
    text-decoration: line-through;
}

.book-actions {
    display: flex;
    gap: 0.4rem;
}

.book-actions .btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.book-actions .btn-outline-primary:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
    transform: translateY(-2px);
}

.book-actions .btn-outline-danger:hover {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-color: transparent;
    color: white;
    transform: translateY(-2px);
}

.book-actions .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.book-actions .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.custom-pagination .page-link {
    border: none;
    margin: 0 5px;
    border-radius: 8px;
    color: #667eea;
    font-weight: 600;
    padding: 10px 15px;
}

.custom-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.custom-pagination .page-link:hover {
    background: #f8f9fa;
    color: #667eea;
}

/* Responsive */
@media (max-width: 768px) {
    .book-card-horizontal {
        flex-direction: column;
    }
    
    .book-image-wrapper {
        width: 100%;
        height: 200px;
    }
}
</style>
