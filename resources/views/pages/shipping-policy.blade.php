@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-4">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--signal); text-decoration: none;">Home</a></li>
                    <li class="breadcrumb-item active" style="color: var(--steel);">Shipping Policy</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm" style="border-radius: var(--radius-lg); overflow: hidden;">
                <div class="card-header" style="background: var(--ink); color: white; padding: 20px 30px; border-bottom: none;">
                    <h1 class="h3 mb-0" style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fas fa-truck me-2" style="color: var(--signal);"></i> Shipping Policy
                    </h1>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="energy-stripe mb-4"></div>

                    <p class="lead" style="font-weight: 500; color: var(--ink-soft);">
                        We deliver across India with fast and reliable shipping. Here's everything you need to know about our shipping process.
                    </p>

                    <hr style="border-color: var(--line); margin: 30px 0;">

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem;">
                        <i class="fas fa-clock me-2" style="color: var(--info);"></i> Delivery Time
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        Orders are processed within <strong>24-48 hours</strong> of placement. Standard delivery takes 
                        <strong>3-7 business days</strong> depending on your location. Express delivery options are available 
                        at checkout for faster shipping.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-rupee-sign me-2" style="color: var(--success);"></i> Shipping Charges
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        Shipping charges are calculated based on your location and the weight of the items. You can view the 
                        exact shipping cost at checkout before completing your purchase. Free shipping is available on orders 
                        above <strong>₹999</strong>.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-map-marker-alt me-2" style="color: var(--signal);"></i> Delivery Areas
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        We currently deliver to all major cities and towns across India. If your pincode is not listed at checkout, 
                        please contact our support team for assistance.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-box me-2" style="color: var(--warning);"></i> Order Tracking
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        Once your order is shipped, you will receive a <strong>tracking number</strong> via email and SMS. 
                        You can track your order in real-time through the courier partner's website.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-question-circle me-2" style="color: var(--signal);"></i> Need Help?
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        For any shipping-related queries, please reach out to us at 
                        <a href="mailto:{{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}" style="color: var(--signal); text-decoration: none;">
                            {{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}
                        </a>
                    </p>

                    <div class="alert" style="background: var(--signal-tint); border-left: 4px solid var(--signal); border-radius: var(--radius-sm); padding: 16px 20px; margin-top: 25px;">
                        <i class="fas fa-info-circle" style="color: var(--signal);"></i>
                        <span style="color: var(--ink-soft); font-weight: 500;">Orders placed on weekends will be processed on the next business day.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection