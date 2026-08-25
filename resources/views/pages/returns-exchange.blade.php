@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-4">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--signal); text-decoration: none;">Home</a></li>
                    <li class="breadcrumb-item active" style="color: var(--steel);">Returns & Exchange</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm" style="border-radius: var(--radius-lg); overflow: hidden;">
                <div class="card-header" style="background: var(--ink); color: white; padding: 20px 30px; border-bottom: none;">
                    <h1 class="h3 mb-0" style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fas fa-undo-alt me-2" style="color: var(--signal);"></i> Returns & Exchange Policy
                    </h1>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="energy-stripe mb-4"></div>

                    <p class="lead" style="font-weight: 500; color: var(--ink-soft);">
                        We want you to be completely satisfied with your purchase. If you're not happy with your order, 
                        we're here to help.
                    </p>

                    <hr style="border-color: var(--line); margin: 30px 0;">

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem;">
                        <i class="fas fa-check-circle me-2" style="color: var(--success);"></i> 30-Day Return Policy
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        You have <strong>30 days</strong> from the date of delivery to return your item for a full refund. 
                        Items must be returned in their original condition, unused, and with all original tags and packaging intact.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-exchange-alt me-2" style="color: var(--info);"></i> Exchange Policy
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        If you received a defective or incorrect item, we will exchange it for the correct product free of charge. 
                        Please contact our support team within <strong>7 days</strong> of receiving the order to initiate an exchange.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-arrow-right me-2" style="color: var(--signal);"></i> How to Return or Exchange
                    </h4>
                    <ol style="color: var(--steel); line-height: 2.2; padding-left: 20px;">
                        <li>Log in to your account and go to <strong>"My Orders"</strong></li>
                        <li>Select the order containing the item you wish to return</li>
                        <li>Click on <strong>"Return/Exchange"</strong> and fill out the request form</li>
                        <li>Print the shipping label and package your item securely</li>
                        <li>Drop off the package at your nearest courier service</li>
                    </ol>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-gift me-2" style="color: var(--signal);"></i> Refund Process
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        Once we receive your returned item, we will inspect it and notify you of the approval or rejection 
                        of your refund. If approved, the refund will be processed to your original payment method within 
                        <strong>5-7 business days</strong>.
                    </p>

                    <div class="alert" style="background: var(--signal-tint); border-left: 4px solid var(--signal); border-radius: var(--radius-sm); padding: 16px 20px; margin-top: 25px;">
                        <i class="fas fa-info-circle" style="color: var(--signal);"></i>
                        <span style="color: var(--ink-soft); font-weight: 500;">Need help? Contact our support team at <a href="mailto:{{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}" style="color: var(--signal); text-decoration: none;">{{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection