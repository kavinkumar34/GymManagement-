@extends('layouts.app')

@section('content')
<style>
    /* ================================================================
       DESIGN TOKENS — FitForge Athletic System
       Display: Anton (poster-weight, athletic)
       Body:    Plus Jakarta Sans (clean, modern e-commerce)
    ================================================================ */
    @import url('https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --ink: #14161A;
        --ink-soft: #2B2E34;
        --canvas: #FAF9F6;
        --fog: #EFEDE7;
        --steel: #6B7280;
        --line: #E4E1D8;
        --signal: #FF4405;
        --signal-dark: #D93A03;
        --signal-tint: #FFF1EC;
        --success: #16A34A;
        --success-tint: #E8F8ED;
        --info: #2563EB;
        --info-tint: #EAF1FE;
        --font-display: 'Anton', 'Arial Narrow', sans-serif;
        --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --radius-lg: 18px;
        --radius-md: 12px;
        --radius-sm: 8px;
        --shadow-card: 0 1px 2px rgba(20,22,26,0.04), 0 8px 24px rgba(20,22,26,0.06);
        --shadow-card-hover: 0 18px 40px rgba(20,22,26,0.14);
    }

    /* ===== PREVENT HORIZONTAL SCROLL ===== */
    html,
    body {
        overflow-x: hidden !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    body {
        font-family: var(--font-body);
        color: var(--ink);
        background: var(--canvas);
    }

    /* Signature element: a repeating diagonal "energy stripe" */
    .energy-stripe {
        height: 4px;
        width: 56px;
        border-radius: 3px;
        background: repeating-linear-gradient(
            -45deg,
            var(--signal) 0px,
            var(--signal) 6px,
            var(--ink) 6px,
            var(--ink) 12px
        );
    }

    .section-eyebrow {
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--signal);
        margin-bottom: 6px;
        display: block;
    }

    .section-heading {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--ink);
        line-height: 1;
    }

    /* ===== ABOUT HERO ===== */
    .about-hero {
        background: var(--ink);
        padding: 80px 0;
        text-align: center;
        color: white;
        margin-bottom: 50px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .about-hero h1 {
        font-family: var(--font-display);
        font-weight: 400;
        font-size: 3rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    
    .about-hero h1 i {
        color: var(--signal);
    }
    
    .about-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 400;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .about-hero .hero-icon {
        font-size: 4rem;
        color: var(--signal);
        margin-bottom: 20px;
        display: block;
    }

    .about-section {
        padding: 50px 0;
        border-bottom: 1px solid var(--line);
    }
    
    .about-section:last-child {
        border-bottom: none;
    }
    
    .about-image {
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        width: 100%;
        height: 350px;
        object-fit: cover;
        border: 1px solid var(--line);
        transition: all 0.3s;
    }
    
    .about-image:hover {
        box-shadow: var(--shadow-card-hover);
    }
    
    .about-content h3 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: 20px;
    }
    
    .about-content h3 i {
        color: var(--signal);
        margin-right: 10px;
    }
    
    .about-content p {
        color: var(--steel);
        line-height: 1.8;
        margin-bottom: 20px;
        font-weight: 400;
    }
    
    .about-content strong {
        color: var(--ink);
        font-weight: 700;
    }

    /* ===== BUTTONS ===== */
    .btn-shop-now {
        background: var(--signal);
        color: white;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: var(--font-body);
    }
    
    .btn-shop-now:hover {
        background: var(--signal-dark);
        transform: scale(1.05);
        color: white;
        box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
    }
    
    .btn-shop-now i {
        margin-right: 8px;
    }
    
    .btn-join-gym1 {
        background: var(--ink);
        color: white;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-left: 15px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: var(--font-body);
    }
    
    .btn-join-gym1:hover {
        background: var(--signal);
        transform: scale(1.05);
        color: white;
        box-shadow: 0 6px 20px rgba(255, 68, 5, 0.3);
    }
    
    .btn-join-gym1 i {
        margin-right: 8px;
    }

    /* ===== FEATURE CARD ===== */
    .feature-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px 20px;
        text-align: center;
        transition: all 0.28s ease;
        height: 100%;
        border: 1px solid var(--line);
        box-shadow: var(--shadow-card);
    }
    
    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .feature-icon {
        font-size: 3rem;
        color: var(--signal);
        margin-bottom: 20px;
    }
    
    .feature-card h4 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: 15px;
        font-size: 1.1rem;
    }
    
    .feature-card p {
        color: var(--steel);
        font-weight: 400;
        margin-bottom: 0;
        line-height: 1.6;
    }

    /* ===== PRODUCT CATEGORY ===== */
    .product-category {
        background: white;
        border-radius: var(--radius-lg);
        padding: 25px 15px;
        text-align: center;
        box-shadow: var(--shadow-card);
        transition: all 0.28s ease;
        height: 100%;
        border: 1px solid var(--line);
    }
    
    .product-category:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .product-category i {
        font-size: 2.8rem;
        color: var(--signal);
        margin-bottom: 15px;
    }
    
    .product-category h4 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        font-size: 1rem;
        color: var(--ink);
        margin-bottom: 8px;
    }
    
    .product-category small {
        color: var(--steel);
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* ===== STATS CARD ===== */
    .stats-card {
        background: var(--ink);
        color: white;
        padding: 30px 20px;
        text-align: center;
        border-radius: var(--radius-lg);
        transition: all 0.3s;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
    }
    
    .stats-number {
        font-family: var(--font-display);
        font-weight: 400;
        font-size: 2.5rem;
        letter-spacing: 0.5px;
        color: var(--signal);
    }
    
    .stats-card p {
        font-weight: 500;
        opacity: 0.8;
        margin-top: 5px;
        margin-bottom: 0;
    }

    /* ===== MEMBERSHIP CARD ===== */
    .membership-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px 25px;
        text-align: center;
        box-shadow: var(--shadow-card);
        transition: all 0.28s ease;
        height: 100%;
        border: 1px solid var(--line);
        position: relative;
    }
    
    .membership-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .membership-card.popular {
        border: 2px solid var(--signal);
        position: relative;
    }
    
    .popular-badge {
        position: absolute;
        top: -12px;
        right: 20px;
        background: var(--signal);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .membership-card h4 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        color: var(--ink);
        font-size: 1.2rem;
    }
    
    .price {
        font-family: var(--font-display);
        font-weight: 400;
        font-size: 2rem;
        color: var(--signal);
        margin: 20px 0;
        letter-spacing: 0.3px;
    }
    
    .price small {
        font-size: 0.9rem;
        color: var(--steel);
        font-family: var(--font-body);
        font-weight: 400;
    }
    
    .membership-card ul {
        list-style: none;
        padding: 0;
        text-align: left;
        margin: 20px 0;
    }
    
    .membership-card ul li {
        padding: 8px 0;
        border-bottom: 1px solid var(--line);
        font-weight: 500;
        color: var(--ink-soft);
        font-size: 0.85rem;
    }
    
    .membership-card ul li:last-child {
        border-bottom: none;
    }
    
    .membership-card ul li i {
        color: var(--success);
        margin-right: 10px;
        width: 18px;
    }
    
    .btn-membership {
        background: var(--signal);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        width: 100%;
        transition: all 0.3s;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-size: 0.85rem;
        font-family: var(--font-body);
    }
    
    .btn-membership:hover {
        background: var(--signal-dark);
        color: white;
        transform: scale(1.02);
    }

    /* ===== CTA SECTION ===== */
    .cta-section {
        background: var(--ink);
        padding: 60px 40px;
        text-align: center;
        color: white;
        border-radius: var(--radius-lg);
        margin: 50px 0;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .cta-section .cta-icon {
        font-size: 3rem;
        color: var(--signal);
        margin: 0 10px 20px;
        display: inline-block;
    }
    
    .cta-section h3 {
        font-family: var(--font-display);
        font-weight: 400;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .cta-section p {
        font-size: 1.1rem;
        opacity: 0.8;
        font-weight: 400;
        max-width: 600px;
        margin: 0 auto 20px;
    }

    /* ===== SECTION TITLE ===== */
    .section-title-wrapper {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .section-title-wrapper .section-heading {
        font-size: 2rem;
    }

    /* ============================================================ */
    /* ===== RESPONSIVE ===== */
    /* ============================================================ */

    @media (max-width: 992px) {
        .about-hero h1 {
            font-size: 2.5rem;
        }
        
        .about-hero p {
            font-size: 1rem;
        }
        
        .about-image {
            height: 280px;
        }
        
        .cta-section {
            padding: 40px 20px;
        }
        
        .cta-section h3 {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 768px) {
        .about-hero {
            padding: 50px 0;
        }
        
        .about-hero h1 {
            font-size: 2rem;
        }
        
        .about-hero .hero-icon {
            font-size: 3rem;
        }
        
        .about-hero p {
            font-size: 0.95rem;
        }
        
        .btn-join-gym1 {
            margin-left: 0;
            margin-top: 10px;
        }
        
        .about-image {
            height: 200px;
            margin-bottom: 20px;
        }
        
        .about-section {
            padding: 30px 0;
        }
        
        .section-title-wrapper .section-heading {
            font-size: 1.6rem;
        }
        
        .cta-section h3 {
            font-size: 1.3rem;
        }
        
        .cta-section p {
            font-size: 0.95rem;
        }
        
        .stats-number {
            font-size: 2rem;
        }
        
        .price {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 576px) {
        .about-hero {
            padding: 30px 0;
        }
        
        .about-hero h1 {
            font-size: 1.5rem;
        }
        
        .about-hero .hero-icon {
            font-size: 2.5rem;
        }
        
        .about-hero p {
            font-size: 0.85rem;
        }
        
        .about-image {
            height: 160px;
        }
        
        .btn-shop-now,
        .btn-join-gym1 {
            padding: 10px 20px;
            font-size: 0.8rem;
            display: block;
            width: 100%;
            text-align: center;
            margin-left: 0;
        }
        
        .btn-join-gym1 {
            margin-top: 8px;
        }
        
        .feature-card {
            padding: 20px 15px;
        }
        
        .feature-icon {
            font-size: 2.2rem;
        }
        
        .feature-card h4 {
            font-size: 0.95rem;
        }
        
        .product-category {
            padding: 15px 10px;
        }
        
        .product-category i {
            font-size: 2rem;
        }
        
        .product-category h4 {
            font-size: 0.85rem;
        }
        
        .stats-card {
            padding: 20px 15px;
        }
        
        .stats-number {
            font-size: 1.6rem;
        }
        
        .stats-card p {
            font-size: 0.8rem;
        }
        
        .membership-card {
            padding: 20px 15px;
        }
        
        .membership-card h4 {
            font-size: 1rem;
        }
        
        .price {
            font-size: 1.4rem;
        }
        
        .membership-card ul li {
            font-size: 0.8rem;
        }
        
        .cta-section {
            padding: 30px 15px;
        }
        
        .cta-section .cta-icon {
            font-size: 2rem;
        }
        
        .cta-section h3 {
            font-size: 1.1rem;
        }
        
        .cta-section p {
            font-size: 0.85rem;
        }
        
        .section-title-wrapper .section-heading {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 400px) {
        .about-hero h1 {
            font-size: 1.2rem;
        }
        
        .about-hero p {
            font-size: 0.75rem;
        }
        
        .about-content h3 {
            font-size: 1rem;
        }
        
        .about-content p {
            font-size: 0.8rem;
        }
        
        .btn-shop-now,
        .btn-join-gym1 {
            font-size: 0.7rem;
            padding: 8px 15px;
        }
        
        .feature-card h4 {
            font-size: 0.8rem;
        }
        
        .feature-card p {
            font-size: 0.75rem;
        }
        
        .stats-number {
            font-size: 1.3rem;
        }
        
        .price {
            font-size: 1.2rem;
        }
    }
</style>

<!-- ===== HERO SECTION ===== -->
<div class="about-hero">
    <div class="container">
        <span class="hero-icon">
            <i class="fas fa-store"></i>
        </span>
        <h1>Welcome to <span style="color: var(--signal);">FitForge</span> Athletics</h1>
        <p>India's Premier Online Fitness Store | Premium Gym Equipment | Authentic Supplements | Gym Wear</p>
        <div class="energy-stripe mx-auto" style="margin: 20px auto;"></div>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn-shop-now">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
            <a href="{{ route('member.trainer.login') }}" class="btn-join-gym1">
                <i class="fas fa-dumbbell"></i> Join Our Gym
            </a>
        </div>
    </div>
</div>

<!-- ============ E-COMMERCE SECTION (FIRST) ============ -->

<!-- About Our Store -->
<div class="container about-section">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4">
            <img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                 class="about-image" 
                 alt="FitForge Online Store">
        </div>
        <div class="col-md-6 about-content">
            <h3><i class="fas fa-store"></i> About Our Online Store</h3>
            <p>Welcome to <strong>FitForge Athletics</strong> - your one-stop destination for all fitness needs! We are India's fastest-growing online fitness store, offering premium quality gym equipment, authentic supplements, stylish gym wear, and fitness accessories.</p>
            <p>Since our launch, we have served over <strong>10,000+ satisfied customers</strong> across India with fast delivery and 100% authentic products.</p>
            <p>Whether you're a fitness enthusiast, a professional athlete, or a gym owner, we have everything you need to achieve your fitness goals.</p>
            <a href="{{ url('/') }}" class="btn-shop-now mt-3">
                <i class="fas fa-shopping-cart"></i> Start Shopping
            </a>
        </div>
    </div>
</div>

<!-- Product Categories -->
<div class="container about-section">
    <div class="section-title-wrapper">
        <span class="section-eyebrow">Browse the Range</span>
        <h2 class="section-heading">Shop by Category</h2>
        <div class="energy-stripe mx-auto"></div>
    </div>
    <div class="row">
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-dumbbell"></i>
                <h4>Equipment</h4>
                <small>Dumbbells, Benches</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-tshirt"></i>
                <h4>Gym Wear</h4>
                <small>T-shirts, Shorts</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-shoe-prints"></i>
                <h4>Footwear</h4>
                <small>Training Shoes</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-capsules"></i>
                <h4>Supplements</h4>
                <small>Protein, BCAA</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-shopping-bag"></i>
                <h4>Accessories</h4>
                <small>Bags, Gloves</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-heartbeat"></i>
                <h4>Trackers</h4>
                <small>Smart Watches</small>
            </div>
        </div>
    </div>
</div>

<!-- Why Shop With Us -->
<div class="container about-section">
    <div class="section-title-wrapper">
        <span class="section-eyebrow">Why Choose Us</span>
        <h2 class="section-heading">Why Shop With Us?</h2>
        <div class="energy-stripe mx-auto"></div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h4>Free Shipping</h4>
                <p>Free shipping on orders above ₹999</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>100% Authentic</h4>
                <p>Guaranteed genuine products</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <h4>Easy Returns</h4>
                <p>7-day easy return policy</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h4>24/7 Support</h4>
                <p>Customer support always ready</p>
            </div>
        </div>
    </div>
</div>

<!-- Store Statistics -->
<div class="container about-section">
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stats-card">
                <div class="stats-number">10K+</div>
                <p>Happy Customers</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stats-card">
                <div class="stats-number">500+</div>
                <p>Products Available</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stats-card">
                <div class="stats-number">25K+</div>
                <p>Orders Delivered</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stats-card">
                <div class="stats-number">4.8★</div>
                <p>Customer Rating</p>
            </div>
        </div>
    </div>
</div>

<!-- ============ GYM SECTION (SECOND) ============ -->

<!-- About Our Gym -->
<div class="container about-section">
    <div class="row align-items-center">
        <div class="col-md-6 about-content">
            <h3><i class="fas fa-dumbbell"></i> About Our Gym</h3>
            <p>Welcome to <strong>FitForge Athletics</strong> - where fitness meets excellence! We are a premium fitness center dedicated to helping you achieve your health and wellness goals.</p>
            <p>Our state-of-the-art facility spans over <strong>10,000 sq.ft</strong> with the latest gym equipment, dedicated workout zones, cardio area, strength training zone, and functional fitness area.</p>
            <p>Whether you're a beginner or a professional athlete, we have everything you need to transform your body and mind.</p>
            <a href="{{ route('member.register') }}" class="btn-join-gym1 mt-3">
                <i class="fas fa-user-plus"></i> Join Our Gym Today
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                 class="about-image" 
                 alt="FitForge Gym">
        </div>
    </div>
</div>

<!-- Gym Features -->
<div class="container about-section">
    <div class="section-title-wrapper">
        <span class="section-eyebrow">World Class Facilities</span>
        <h2 class="section-heading">Gym Facilities</h2>
        <div class="energy-stripe mx-auto"></div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h4>Modern Equipment</h4>
                <p>Latest cardio and strength training equipment from top brands</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <h4>Expert Trainers</h4>
                <p>Certified personal trainers with years of experience</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Flexible Hours</h4>
                <p>Open 6 AM to 10 PM, 7 days a week</p>
            </div>
        </div>
    </div>
</div>

<!-- Membership Plans -->
<div class="container about-section">
    <div class="section-title-wrapper">
        <span class="section-eyebrow">Choose Your Plan</span>
        <h2 class="section-heading">Membership Plans</h2>
        <div class="energy-stripe mx-auto"></div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="membership-card">
                <h4>Basic Plan</h4>
                <div class="price">₹1,999<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> Gym access (6 AM - 10 PM)</li>
                    <li><i class="fas fa-check"></i> Basic equipment access</li>
                    <li><i class="fas fa-check"></i> Locker facility</li>
                    <li><i class="fas fa-check"></i> Changing rooms</li>
                </ul>
                <a href="{{ route('member.trainer.login') }}" class="btn-membership">Join Now</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="membership-card popular">
                <div class="popular-badge">Most Popular</div>
                <h4>Premium Plan</h4>
                <div class="price">₹3,499<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> 24/7 Gym access</li>
                    <li><i class="fas fa-check"></i> Personal trainer (4 sessions/month)</li>
                    <li><i class="fas fa-check"></i> Custom diet plan</li>
                    <li><i class="fas fa-check"></i> Group classes included</li>
                    <li><i class="fas fa-check"></i> 10% off on store products</li>
                </ul>
                <a href="{{ route('member.trainer.login') }}" class="btn-membership">Join Now</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="membership-card">
                <h4>Pro Plan</h4>
                <div class="price">₹5,999<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> 24/7 Gym access</li>
                    <li><i class="fas fa-check"></i> Dedicated personal trainer</li>
                    <li><i class="fas fa-check"></i> Custom meal plan</li>
                    <li><i class="fas fa-check"></i> All group classes</li>
                    <li><i class="fas fa-check"></i> 20% off on store products</li>
                    <li><i class="fas fa-check"></i> Free fitness assessment</li>
                </ul>
                <a href="{{ route('member.trainer.login') }}" class="btn-membership">Join Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="container">
    <div class="cta-section">
        <span class="cta-icon"><i class="fas fa-dumbbell"></i></span>
        <span class="cta-icon"><i class="fas fa-shopping-cart"></i></span>
        <span class="cta-icon"><i class="fas fa-heart"></i></span>
        <h3>Ready to Transform Your Life?</h3>
        <p>Shop premium fitness products OR Join our world-class gym - The choice is yours!</p>
        <div class="energy-stripe mx-auto" style="margin: 15px auto;"></div>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn-shop-now">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
            <a href="{{ route('member.trainer.login') }}" class="btn-join-gym1">
                <i class="fas fa-dumbbell"></i> Join Gym
            </a>
        </div>
    </div>
</div>

<!-- Contact & Location -->
<div class="container about-section mb-5">
    <div class="section-title-wrapper">
        <span class="section-eyebrow">Visit Us</span>
        <h2 class="section-heading">Our Location</h2>
        <div class="energy-stripe mx-auto"></div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h4>Our Location</h4>
                <p>123 Fitness Street,<br>Chennai - 600001,<br>Tamil Nadu, India</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Opening Hours</h4>
                <p><strong>Gym:</strong> Mon-Sat: 6AM - 10PM<br>Sun: 8AM - 8PM</p>
                <p><strong>Online Store:</strong> 24/7</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h4>Contact Info</h4>
                <p>Phone: +91 98765 43210<br>Email: info@fitforge.com<br>WhatsApp: +91 98765 43211</p>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('contact') }}" class="btn-shop-now">
            <i class="fas fa-envelope"></i> Contact Us
        </a>
    </div>
</div>
@endsection