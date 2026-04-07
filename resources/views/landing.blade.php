<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NebulaBooks - Your Gateway to Knowledge</title>
    <meta name="description" content="Discover thousands of books across all genres at NebulaBooks. From bestsellers to hidden gems, find your perfect read.">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-light: #818cf8;
            --secondary-color: #8b5cf6;
            --accent-color: #f59e0b;
            --accent-pink: #ec4899;
            --dark-bg: #1e1b4b;
            --darker-bg: #0f0d2e;
            --light-bg: #f8f9fa;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.12);
            --text-muted: #94a3b8;
            --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 20px 60px rgba(99, 102, 241, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow-x: hidden;
            color: #1e293b;
        }


        
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 1px 20px rgba(0, 0, 0, 0.06);
            padding: 12px 0;
            transition: all 0.3s;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-brand i {
            color: #5B4B9F;
        }
        .nav-link {
            font-weight: 600;
            color: var(--dark-bg) !important;
            margin: 0 10px;
            position: relative;
            transition: color 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s;
            transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 80%; }
        .nav-link:hover { color: var(--primary-color) !important; }

        .hero-section {
            background: #5B4B9F;
            color: white;
            padding: 140px 0 100px;
            position: relative;
            overflow: hidden;
            min-height: 600px;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(139, 92, 246, 0.15);
            filter: blur(80px);
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -100px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(236, 72, 153, 0.1);
            filter: blur(60px);
        }
        .hero-content { 
            position: relative; 
            z-index: 2; 
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }
        .hero-badge i { color: var(--accent-color); }
        .hero-title {
            font-size: 3.8rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.15;
            letter-spacing: -0.02em;
        }
        .hero-title .gradient-text {
            color: #ffffff;
        }
        .hero-subtitle {
            font-size: 1.15rem;
            opacity: 0.85;
            margin-bottom: 2rem;
            line-height: 1.7;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-search-wrapper {
            position: relative;
            max-width: 560px;
            margin: 0 auto 2rem auto;
            z-index: 10;
        }
        .hero-search {
            display: flex;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 6px;
            backdrop-filter: blur(20px);
            transition: all 0.3s;
        }
        .hero-search:focus-within {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 8px 40px rgba(99, 102, 241, 0.3);
        }
        .hero-search input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 14px 20px;
            color: white;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            outline: none;
        }
        .hero-search input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .hero-search button {
            background: #5B4B9F;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .hero-search button:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.5);
        }

        .search-results {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            max-height: 420px;
            overflow-y: auto;
            display: none;
            z-index: 100;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }
        .search-results.active { display: block; }
        .search-results::-webkit-scrollbar { width: 6px; }
        .search-results::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        .search-result-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 20px;
            text-decoration: none;
            color: var(--dark-bg);
            transition: all 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }
        .search-result-item:last-child { border-bottom: none; }
        .search-result-item:hover {
            background: #f8fafc;
            color: var(--primary-color);
        }
        .search-result-item img {
            width: 50px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .search-result-info { flex: 1; }
        .search-result-info h6 {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 4px;
            color: #1e293b;
        }
        .search-result-info small {
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        .search-result-info .search-price {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.85rem;
        }
        .search-empty {
            padding: 32px 20px;
            text-align: center;
            color: var(--text-muted);
        }
        .search-empty i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
            opacity: 0.4;
        }
        .search-loading {
            padding: 24px;
            text-align: center;
            color: var(--text-muted);
        }
        .search-loading .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            border-width: 2px;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 2rem;
            justify-content: center;
        }
        .hero-stat {
            text-align: center;
        }
        .hero-stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            display: block;
            color: #fbbf24;
        }
        .hero-stat-label {
            font-size: 0.8rem;
            opacity: 0.6;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .btn-hero {
            padding: 15px 36px;
            font-size: 1rem;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.25);
        }
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
            color: var(--primary-color);
        }
        .btn-hero-outline {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            background: transparent;
        }
        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-3px);
        }

        .hero-visual {
            position: relative;
            z-index: 2;
        }
        .floating-emoji {
            position: absolute;
            font-size: 2.5rem;
            animation: floatAround 6s ease-in-out infinite;
            opacity: 0.7;
        }
        .floating-emoji:nth-child(1) { top: 10%; right: 10%; animation-delay: 0s; }
        .floating-emoji:nth-child(2) { top: 50%; right: 30%; animation-delay: 1.5s; }
        .floating-emoji:nth-child(3) { bottom: 20%; right: 15%; animation-delay: 3s; }
        .floating-emoji:nth-child(4) { top: 30%; right: 50%; animation-delay: 4.5s; font-size: 2rem; }
        @keyframes floatAround {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(-10px) rotate(-3deg); }
            75% { transform: translateY(-25px) rotate(3deg); }
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(91, 75, 159, 0.08);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 16px;
            border: 1px solid rgba(99, 102, 241, 0.15);
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-bg);
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .features-section {
            padding: 80px 0;
            background: var(--light-bg);
        }
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 1px solid #f1f5f9;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #5B4B9F;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
        }
        .feature-card:hover::before { opacity: 1; }
        .feature-icon {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 1.8rem;
            background: #5B4B9F;
            color: white;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }
        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--dark-bg);
        }
        .feature-desc {
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .book-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: var(--card-shadow);
            background: white;
            height: 100%;
        }
        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
        }
        .book-image-wrapper {
            position: relative;
            overflow: hidden;
        }
        .book-image {
            height: 280px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.5s;
        }
        .book-card:hover .book-image {
            transform: scale(1.05);
        }
        .book-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .book-card:hover .book-overlay { opacity: 1; }
        .book-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #5B4B9F;
            color: white;
            padding: 5px 14px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        .book-rank-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9rem;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .rank-gold { background: #f59e0b; color: white; }
        .rank-silver { background: #9ca3af; color: white; }
        .rank-bronze { background: #cd7f32; color: white; }
        .rank-default { background: #5B4B9F; color: white; }

        .book-body {
            padding: 20px;
        }
        .book-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--dark-bg);
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .book-author {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .book-author i { color: var(--primary-light); font-size: 0.75rem; }
        .book-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .book-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: #5B4B9F;
        }
        .book-sold {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--accent-color);
            font-size: 0.8rem;
            font-weight: 600;
        }
        .btn-view-book {
            background: #5B4B9F;
            border: none;
            color: white;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-view-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .popular-section {
            padding: 80px 0;
            background: #f8f7ff;
        }

        .featured-section {
            padding: 80px 0;
            background: white;
        }

        .newest-section {
            padding: 80px 0;
            background: #f1f0ff;
        }



        .story-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--card-shadow);
            border: 1px solid #f1f5f9;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%;
        }
        .story-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
        }
        .story-card .story-icon {
            width: 80px;
            height: 80px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            font-size: 2rem;
            background: #5B4B9F;
            color: white;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }
        .story-card h4 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 12px;
            color: var(--dark-bg);
        }
        .story-card p {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 0.95rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #5B4B9F;
            margin-bottom: 8px;
        }
        .stat-label {
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 600;
        }

        .value-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            border: 1px solid #f1f5f9;
            box-shadow: var(--card-shadow);
            transition: all 0.3s;
        }
        .value-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-hover-shadow);
        }
        .value-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            background: rgba(91, 75, 159, 0.1);
            color: var(--primary-color);
            border: 2px solid rgba(99, 102, 241, 0.2);
        }
        .value-card h5 {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 12px;
            color: var(--dark-bg);
        }
        .value-card p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .contact-section {
            background: #5B4B9F;
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        .contact-section::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(139, 92, 246, 0.1);
            filter: blur(80px);
        }
        .contact-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(236, 72, 153, 0.08);
            filter: blur(60px);
        }
        .contact-form-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 40px;
        }
        .contact-form-card .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .contact-form-card .form-control,
        .contact-form-card .form-select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: white;
            padding: 14px 18px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }
        .contact-form-card .form-control::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }
        .contact-form-card .form-control:focus,
        .contact-form-card .form-select:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
            color: white;
        }
        .contact-form-card .form-select option {
            background: var(--dark-bg);
            color: white;
        }
        .contact-form-card textarea.form-control {
            min-height: 130px;
            resize: vertical;
        }
        .btn-send-message {
            background: #5B4B9F;
            border: none;
            color: white;
            padding: 16px 40px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            justify-content: center;
        }
        .btn-send-message:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(91, 75, 159, 0.4);
            background: #6d5fa8;
        }
        .contact-info-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            padding: 28px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
            transition: all 0.3s;
        }
        .contact-info-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-4px);
        }
        .contact-info-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 14px;
            background: #5B4B9F;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            box-shadow: 0 6px 18px rgba(99, 102, 241, 0.3);
        }
        .contact-info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 4px;
            font-weight: 600;
        }
        .contact-info-value {
            font-size: 1rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0;
        }
        .contact-info-value a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .contact-info-value a:hover {
            color: var(--primary-light);
        }
        .contact-success {
            display: none;
            text-align: center;
            padding: 40px 20px;
        }
        .contact-success.show {
            display: block;
            animation: fadeInUp 0.5s ease;
        }
        .contact-success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #34d399;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 8px 30px rgba(52, 211, 153, 0.3);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .footer {
            background: var(--darker-bg);
            color: white;
            padding: 60px 0 30px;
        }
        .footer-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }
        .footer-links a:hover {
            color: white;
            padding-left: 6px;
        }
        .social-links a {
            display: inline-flex;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.7);
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s;
            font-size: 1rem;
        }
        .social-links a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        .footer-brand-desc {
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .btn-view-all {
            background: white;
            color: var(--primary-color);
            border: 2px solid rgba(99, 102, 241, 0.2);
            padding: 14px 36px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-view-all:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
        }



        @media (max-width: 991px) {
            .hero-title { font-size: 2.8rem; }
            .hero-stats { gap: 24px; }
            .hero-stat-number { font-size: 1.4rem; }
            .contact-form-card { padding: 28px; }
        }
        @media (max-width: 768px) {
            .hero-section { padding: 120px 0 60px; min-height: auto; }
            .hero-title { font-size: 2.2rem; }
            .hero-subtitle { font-size: 1rem; }
            .hero-stats { gap: 20px; }
            .hero-stat-number { font-size: 1.2rem; }
            .section-title { font-size: 1.8rem; }
            .hero-search button span { display: none; }
            .hero-search button { padding: 14px 18px; }
            .floating-emoji { display: none; }
            .contact-form-card { padding: 24px; }
            .contact-section { padding: 60px 0; }
            .story-card { padding: 24px; }
            .stats-container { gap: 20px; }
            .stat-number { font-size: 2rem; }
        }
    </style>
</head>
<body>
    

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="main-navbar">
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
                        <a class="nav-link" href="#popular">Populer</a>
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

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 hero-content">
                  
                    <h1 class="hero-title">
                        Temukan Buku<br>
                        <span class="gradient-text">Favoritmu</span> di Sini
                    </h1>
                    <p class="hero-subtitle">
                        Jelajahi ribuan buku dari berbagai genre. Dari bestseller hingga hidden gems, temukan buku impianmu di NebulaBooks.
                    </p>

                    <div class="hero-search-wrapper" id="search-wrapper">
                        <div class="hero-search">
                            <input type="text"
                                   id="hero-search-input"
                                   placeholder="Cari judul buku, penulis, atau penerbit..."
                                   autocomplete="off">
                            <button type="button" id="hero-search-btn">
                                <i class="fas fa-search"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                        <div class="search-results" id="search-results"></div>
                    </div>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('books.index') }}" class="btn btn-hero btn-hero-primary">
                            <i class="fas fa-book"></i> Jelajahi Buku
                        </a>
                        <a href="#popular" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-fire"></i> Buku Populer
                        </a>
                    </div>

                    
                </div>
            </div>
        </div>
    </section>



    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-tag">
                    <i class="fas fa-sparkles"></i> Kenapa Kami?
                </span>
                <h2 class="section-title">Kenapa Memilih NebulaBooks?</h2>
                <p class="section-subtitle">Semua yang kamu butuhkan untuk pengalaman membaca terbaik</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 fade-up" style="transition-delay: 0s">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3 class="feature-title">Koleksi Lengkap</h3>
                        <p class="feature-desc">Akses ribuan buku dari berbagai genre dan kategori. Dari literatur klasik hingga rilis terbaru.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-up" style="transition-delay: 0.1s">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">Pengiriman Cepat</h3>
                        <p class="feature-desc">Buku dikirim cepat ke alamatmu. Lacak pesananmu secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-up" style="transition-delay: 0.2s">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">Support 24/7</h3>
                        <p class="feature-desc">Butuh bantuan? Chat dengan kami via WhatsApp kapan saja. Kami selalu siap membantu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-section" id="popular">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-tag">
                    <i class="fas fa-fire"></i> Paling Diminati
                </span>
                <h2 class="section-title">Buku Populer</h2>
                <p class="section-subtitle">Buku-buku yang paling banyak dibeli dan diminati oleh para pembaca kami</p>
            </div>

            <div class="row g-4">
                @forelse($popularBooks as $index => $book)
                <div class="col-lg-3 col-md-6 fade-up" style="transition-delay: {{ $index * 0.1 }}s">
                    <div class="card book-card">
                        <div class="book-image-wrapper">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="book-image" alt="{{ $book->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x400/6366f1/ffffff?text={{ urlencode(Str::limit($book->title, 15)) }}" class="book-image" alt="{{ $book->title }}">
                            @endif
                            <div class="book-overlay"></div>
                            @php
                                $rankClass = match($index) {
                                    0 => 'rank-gold',
                                    1 => 'rank-silver',
                                    2 => 'rank-bronze',
                                    default => 'rank-default'
                                };
                            @endphp
                            <span class="book-rank-badge {{ $rankClass }}">#{{ $index + 1 }}</span>
                            @if($book->category)
                                <span class="book-badge">{{ $book->category->name }}</span>
                            @endif
                        </div>
                        <div class="book-body">
                            <h5 class="book-title">{{ Str::limit($book->title, 40) }}</h5>
                            <p class="book-author"><i class="fas fa-pen-nib"></i> {{ $book->author }}</p>
                            <div class="book-footer">
                                <span class="book-price">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                <a href="{{ route('books.show', $book) }}" class="btn-view-book">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                            @if($book->total_sold > 0)
                            <div class="mt-2">
                                <span class="book-sold"><i class="fas fa-shopping-bag"></i> {{ $book->total_sold }} terjual</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data penjualan buku.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>



    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="footer-title">
                        <i class="fas fa-book-open me-2"></i>NebulaBooks
                    </h3>
                    <p class="footer-brand-desc">Gerbang menuju cerita dan pengetahuan tanpa batas. Temukan, baca, dan berkembang bersama NebulaBooks.</p>
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
                        <li><a href="#popular">Buku Populer</a></li>
                        <li><a href="#books">Buku Favorit</a></li>
                        <li><a href="#newest">Buku Terbaru</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Company</h5>
                    <ul class="footer-links">
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <ul class="footer-links">
                        <li>
                            <a href="tel:+628815309693">
                                <i class="fas fa-phone me-2"></i>+62 881 5309 693
                            </a>
                        </li>
                        <li>
                            <a href="mailto:hello@nebulabooks.com">
                                <i class="fas fa-envelope me-2"></i>hello@nebulabooks.com
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="bg-white opacity-10 my-4">
            <div class="text-center" style="color: rgba(255,255,255,0.35);">
                <p class="mb-0">&copy; {{ date('Y') }} NebulaBooks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.getElementById('hero-search-input');
        const searchResults = document.getElementById('search-results');
        const searchWrapper = document.getElementById('search-wrapper');
        let searchTimeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.remove('active');
                searchResults.innerHTML = '';
                return;
            }

            searchResults.classList.add('active');
            searchResults.innerHTML = `
                <div class="search-loading">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 mb-0">Mencari buku...</p>
                </div>
            `;

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('landing.search') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResults.innerHTML = `
                                <div class="search-empty">
                                    <i class="fas fa-search"></i>
                                    <p class="mb-0">Tidak ada buku ditemukan untuk "<strong>${query}</strong>"</p>
                                </div>
                            `;
                        } else {
                            let html = '';
                            data.forEach(book => {
                                html += `
                                    <a href="${book.url}" class="search-result-item">
                                        <img src="${book.image}" alt="${book.title}">
                                        <div class="search-result-info">
                                            <h6>${book.title}</h6>
                                            <small>${book.author} • ${book.category}</small>
                                            <div class="search-price">${book.price}</div>
                                        </div>
                                        <i class="fas fa-chevron-right" style="color: #d1d5db;"></i>
                                    </a>
                                `;
                            });
                            searchResults.innerHTML = html;
                        }
                    })
                    .catch(() => {
                        searchResults.innerHTML = `
                            <div class="search-empty">
                                <i class="fas fa-exclamation-circle"></i>
                                <p class="mb-0">Terjadi kesalahan. Coba lagi nanti.</p>
                            </div>
                        `;
                    });
            }, 350);
        });

        document.addEventListener('click', function (e) {
            if (!searchWrapper.contains(e.target)) {
                searchResults.classList.remove('active');
            }
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                if (query.length >= 2) {
                    window.location.href = `{{ route('books.index') }}?search=${encodeURIComponent(query)}`;
                }
            }
        });

        document.getElementById('hero-search-btn').addEventListener('click', function () {
            const query = searchInput.value.trim();
            if (query.length >= 2) {
                window.location.href = `{{ route('books.index') }}?search=${encodeURIComponent(query)}`;
            }
        });

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -60px 0px',
            threshold: 0.1
        };

        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-up').forEach(el => fadeObserver.observe(el));

        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('main-navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.boxShadow = '0 1px 20px rgba(0, 0, 0, 0.06)';
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });

        const Form = document.getElementById('contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const btn = this.querySelector('.btn-send-message');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                btn.disabled = true;

                setTimeout(() => {
                    document.getElementById('contact-form-content').style.display = 'none';
                    document.getElementById('contact-success').classList.add('show');
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }, 1500);
            });
        }

        function resetContactForm() {
            document.getElementById('contact-form').reset();
            document.getElementById('contact-form-content').style.display = 'block';
            document.getElementById('contact-success').classList.remove('show');
        }
    </script>
</body>
</html>