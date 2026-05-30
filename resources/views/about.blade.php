@extends('layouts.app')

@section('content')
<style>
    .about-hero {
        background: linear-gradient(135deg, #000000 0%, #1a1a2e 100%);
        padding: 80px 0;
        text-align: center;
        color: white;
        margin-bottom: 50px;
    }
    .about-hero h1 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .about-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    .about-section {
        padding: 50px 0;
        border-bottom: 1px solid #eee;
    }
    .about-image {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        width: 100%;
        height: 350px;
        object-fit: cover;
    }
    .about-content h3 {
        color: #dc3545;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .about-content p {
        color: #555;
        line-height: 1.8;
        margin-bottom: 20px;
    }
    .btn-shop-now {
        background: #dc3545;
        color: white;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        border: none;
        cursor: pointer;
    }
    .btn-shop-now:hover {
        background: #000000;
        transform: scale(1.05);
        color: white;
    }
    .btn-join-gym1 {
        background: #000000;
        color: white;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-left: 15px;
    }
    .btn-join-gym1:hover {
        background: #dc3545;
        transform: scale(1.05);
        color: white;
    }
    .feature-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        transition: transform 0.3s;
        height: 100%;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .feature-icon {
        font-size: 3rem;
        color: #dc3545;
        margin-bottom: 20px;
    }
    .feature-card h4 {
        margin-bottom: 15px;
        font-weight: bold;
    }
    .product-category {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        height: 100%;
    }
    .product-category:hover {
        transform: translateY(-5px);
    }
    .product-category i {
        font-size: 3rem;
        color: #dc3545;
        margin-bottom: 15px;
    }
    .product-category h4 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    .membership-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        height: 100%;
        border: 1px solid #eee;
    }
    .membership-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .membership-card.popular {
        border: 2px solid #dc3545;
        position: relative;
    }
    .popular-badge {
        position: absolute;
        top: -12px;
        right: 20px;
        background: #dc3545;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    .price {
        font-size: 2rem;
        font-weight: bold;
        color: #dc3545;
        margin: 20px 0;
    }
    .price small {
        font-size: 0.9rem;
        color: #999;
    }
    .membership-card ul {
        list-style: none;
        padding: 0;
        text-align: left;
        margin: 20px 0;
    }
    .membership-card ul li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    .membership-card ul li i {
        color: #28a745;
        margin-right: 10px;
    }
    .btn-membership {
        background: #dc3545;
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        width: 100%;
        transition: all 0.3s;
    }
    .btn-membership:hover {
        background: #000000;
        color: white;
    }
    .stats-card {
        background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
        color: white;
        padding: 30px;
        text-align: center;
        border-radius: 15px;
    }
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
    }
    .cta-section {
        background: linear-gradient(135deg, #000000 0%, #1a1a2e 100%);
        padding: 60px 0;
        text-align: center;
        color: white;
        border-radius: 20px;
        margin: 50px 0;
    }
    .cta-section h3 {
        font-size: 2rem;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 2rem;
        }
        .btn-join-gym1{
            margin-left: 0;
            margin-top: 10px;
        }
        .about-image {
            height: 200px;
            margin-bottom: 20px;
        }
    }
</style>

<!-- Hero Section -->
<div class="about-hero">
    <div class="container">
        <i class="fas fa-store" style="font-size: 4rem; margin-bottom: 20px;"></i>
        <h1>Welcome to GYM MANAGEMENT STORE</h1>
        <p>India's Premier Online Fitness Store | Premium Gym Equipment | Authentic Supplements | Gym Wear</p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn-shop-now">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
            <a href="{{ route('member.register') }}" class="btn-join-gym1">
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
            <img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" class="about-image" alt="Our Online Store">
        </div>
        <div class="col-md-6 about-content">
            <h3>About Our Online Store</h3>
            <p>Welcome to <strong>GYM MANAGEMENT STORE</strong> - your one-stop destination for all fitness needs! We are India's fastest-growing online fitness store, offering premium quality gym equipment, authentic supplements, stylish gym wear, and fitness accessories.</p>
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
    <h3 class="text-center mb-5" style="color: #000000;">Shop by Category</h3>
    <div class="row">
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-dumbbell"></i>
                <h4>Gym Equipment</h4>
                <small>Dumbbells, Benches, Bars</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-tshirt"></i>
                <h4>Gym Wear</h4>
                <small>T-shirts, Shorts, Tracks</small>
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
                <small>Protein, BCAA, Vitamins</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-shopping-bag"></i>
                <h4>Accessories</h4>
                <small>Bags, Gloves, Belts</small>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-4">
            <div class="product-category">
                <i class="fas fa-heartbeat"></i>
                <h4>Fitness Trackers</h4>
                <small>Smart Watches, Bands</small>
            </div>
        </div>
    </div>
</div>

<!-- Why Shop With Us -->
<div class="container about-section">
    <h3 class="text-center mb-5" style="color: #000000;">Why Shop With Us?</h3>
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
                <div class="stats-number">10,000+</div>
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
                <div class="stats-number">25,000+</div>
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
            <h3>About Our Gym</h3>
            <p>Welcome to <strong>GYM MANAGEMENT</strong> - where fitness meets excellence! We are a premium fitness center dedicated to helping you achieve your health and wellness goals.</p>
            <p>Our state-of-the-art facility spans over <strong>10,000 sq.ft</strong> with the latest gym equipment, dedicated workout zones, cardio area, strength training zone, and functional fitness area.</p>
            <p>Whether you're a beginner or a professional athlete, we have everything you need to transform your body and mind.</p>
            <a href="{{ route('member.register') }}" class="btn-join-gym1 mt-3">
                <i class="fas fa-user-plus"></i> Join Our Gym Today
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" class="about-image" alt="Our Gym">
        </div>
    </div>
</div>

<!-- Gym Features -->
<div class="container about-section">
    <h3 class="text-center mb-5" style="color: #000000;">Gym Facilities</h3>
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
    <h3 class="text-center mb-5" style="color: #000000;">Membership Plans</h3>
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
                <a href="{{ route('member.register') }}" class="btn-membership">Join Now</a>
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
                <a href="{{ route('member.register') }}" class="btn-membership">Join Now</a>
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
                <a href="{{ route('member.register') }}" class="btn-membership">Join Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="container">
    <div class="cta-section">
        <i class="fas fa-dumbbell" style="font-size: 3rem; margin-bottom: 20px;"></i>
        <i class="fas fa-shopping-cart" style="font-size: 3rem; margin: 0 15px;"></i>
        <i class="fas fa-heart" style="font-size: 3rem; margin-bottom: 20px;"></i>
        <h3>Ready to Transform Your Life?</h3>
        <p>Shop premium fitness products OR Join our world-class gym - The choice is yours!</p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn-shop-now">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
            <a href="{{ route('member.register') }}" class="btn-join-gym1">
                <i class="fas fa-dumbbell"></i> Join Gym
            </a>
        </div>
    </div>
</div>

<!-- Contact & Location -->
<div class="container about-section mb-5">
    <h3 class="text-center mb-5" style="color: #000000;">Visit Our Gym / Store Location</h3>
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
                <p>Phone: +91 98765 43210<br>Email: info@gymmanagement.com<br>WhatsApp: +91 98765 43211</p>
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