<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NebulaBooks - Your Gateway to Knowledge</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --dark-bg: #1e1b4b;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* WhatsApp Float Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 5px 20px rgba(37, 211, 102, 0.5);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            background: #128C7E;
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.7);
            color: white;
        }

        .whatsapp-float i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        .btn-hero {
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
            border: none;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: var(--primary-color);
        }

        .btn-hero-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: var(--light-bg);
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-bg);
        }

        .feature-desc {
            color: #6b7280;
            line-height: 1.8;
        }

        /* Featured Books Section */
        .featured-section {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 20px;
            color: var(--dark-bg);
        }

        .section-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 50px;
            font-size: 1.1rem;
        }

        .book-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .book-image {
            height: 300px;
            object-fit: cover;
            width: 100%;
        }

        .book-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .book-title {
            font-weight: 700;
            color: var(--dark-bg);
            margin-bottom: 8px;
        }

        .book-author {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .book-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #312e81 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .cta-desc {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        /* Footer */
        .footer {
            background: var(--dark-bg);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            color: white;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark-bg) !important;
            margin: 0 10px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }

            .whatsapp-float {
                width: 50px;
                height: 50px;
                font-size: 24px;
                bottom: 20px;
                right: 20px;
            }

            .animated-book {
    animation: floatBook 3s ease-in-out infinite;
    /* opsional: tambahkan shadow biar lebih pop */
    filter: drop-shadow(0 8px 24px rgba(30,27,75,0.15));
}
@keyframes floatBook {
    0%, 100% { transform: translateY(0);}
    50% { transform: translateY(-24px);}
}
        }
    </style>
</head>
<body>
    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/628815309693?text=Halo%20NebulaBooks,%20saya%20ingin%20bertanya%20tentang%20buku" 
       class="whatsapp-float" 
       target="_blank"
       title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-book-open me-2"></i>NebulaBooks
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#books">Books</a>
                    </li>
                   
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-outline-primary btn-sm ms-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Sign Up
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('books.index') }}"><i class="fas fa-store me-2"></i>Browse Books</a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-dashboard me-2"></i>Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fas fa-dashboard me-2"></i>Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Discover Your Next Great Read</h1>
                <p class="hero-subtitle">Explore thousands of books across all genres. From bestsellers to hidden gems, find your perfect book at NebulaBooks.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('books.index') }}" class="btn btn-hero btn-hero-primary">
                        <i class="fas fa-book me-2"></i>Explore Books
                    </a>
                    <a href="#features" class="btn btn-hero btn-hero-outline">
                        Learn More
                    </a>
                </div>
            </div>
       
        </div>
    </div>
</section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose NebulaBooks?</h2>
            <p class="section-subtitle">Everything you need for the perfect reading experience</p>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3 class="feature-title">Vast Collection</h3>
                        <p class="feature-desc">Access thousands of books across all genres and categories. From classic literature to the latest releases.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">Fast Delivery</h3>
                        <p class="feature-desc">Get your books delivered quickly to your doorstep. Track your order in real-time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">24/7 Support</h3>
                        <p class="feature-desc">Need help? Chat with us on WhatsApp anytime. We're always here to assist you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <section class="featured-section" id="books">
        <div class="container">
            <h2 class="section-title">Featured Books</h2>
            <p class="section-subtitle">Handpicked recommendations just for you</p>
            
            <div class="row g-4">
                @forelse($featuredBooks as $book)
                <div class="col-md-4">
                    <div class="card book-card">
                        <div class="position-relative">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="book-image" alt="{{ $book->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x400?text=No+Image" class="book-image" alt="{{ $book->title }}">
                            @endif
                            @if($book->category_id)
                                <span class="book-badge">{{ $book->category->name ?? 'Uncategorized' }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="book-title">{{ Str::limit($book->title, 40) }}</h5>
                            <p class="book-author">by {{ $book->author }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="book-price">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                <a href="{{ route('books.show', $book) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No books available at the moment.</p>
                    <a href="https://wa.me/628815309693?text=Halo,%20saya%20ingin%20request%20buku" 
                       class="btn btn-success mt-3" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Request a Book
                    </a>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-right me-2"></i>View All Books
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="cta-title">Need Help? We're Here!</h2>
            <p class="cta-desc">Have questions? Chat with us on WhatsApp for instant support</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                    <i class="fas fa-user-plus me-2"></i>Create Free Account
                </a>
               
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="footer-title">
                        <i class="fas fa-book-open me-2"></i>NebulaBooks
                    </h3>
                    <p class="text-white-50">Your gateway to endless stories and knowledge. Discover, read, and grow with NebulaBooks.</p>
                    <div class="social-links mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('books.index') }}">Browse Books</a></li>
                        <li><a href="#">Categories</a></li>
                        <li><a href="#">Bestsellers</a></li>
                        <li><a href="#">New Arrivals</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Company</h5>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
              
            </div>
            <hr class="bg-white opacity-25 my-4">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2025 NebulaBooks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>