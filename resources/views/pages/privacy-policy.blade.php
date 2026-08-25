@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-4">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--signal); text-decoration: none;">Home</a></li>
                    <li class="breadcrumb-item active" style="color: var(--steel);">Privacy Policy</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm" style="border-radius: var(--radius-lg); overflow: hidden;">
                <div class="card-header" style="background: var(--ink); color: white; padding: 20px 30px; border-bottom: none;">
                    <h1 class="h3 mb-0" style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fas fa-shield-alt me-2" style="color: var(--signal);"></i> Privacy Policy
                    </h1>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="energy-stripe mb-4"></div>

                    <p class="lead" style="font-weight: 500; color: var(--ink-soft);">
                        We value your privacy and are committed to protecting your personal information. 
                        This policy explains how we collect, use, and safeguard your data.
                    </p>

                    <hr style="border-color: var(--line); margin: 30px 0;">

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem;">
                        <i class="fas fa-database me-2" style="color: var(--info);"></i> Information We Collect
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        We collect personal information that you provide to us, including:
                    </p>
                    <ul style="color: var(--steel); line-height: 2.2; padding-left: 20px;">
                        <li>Name, email address, phone number, and shipping address</li>
                        <li>Payment information (processed securely through our payment partners)</li>
                        <li>Order history and preferences</li>
                        <li>Device and browsing information (cookies and analytics)</li>
                    </ul>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-lock me-2" style="color: var(--success);"></i> How We Use Your Information
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        Your information is used to:
                    </p>
                    <ul style="color: var(--steel); line-height: 2.2; padding-left: 20px;">
                        <li>Process and deliver your orders</li>
                        <li>Communicate with you about your orders and updates</li>
                        <li>Improve our products and services</li>
                        <li>Send promotional offers (only with your consent)</li>
                        <li>Provide customer support and resolve issues</li>
                    </ul>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-shield-virus me-2" style="color: var(--signal);"></i> Data Security
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        We implement robust security measures to protect your personal information from unauthorized access, 
                        alteration, or disclosure. All sensitive data is encrypted using industry-standard protocols.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-cookie me-2" style="color: var(--warning);"></i> Cookies
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        We use cookies to enhance your browsing experience and analyze site traffic. You can manage your 
                        cookie preferences in your browser settings at any time.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-user-edit me-2" style="color: var(--info);"></i> Your Rights
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        You have the right to access, modify, or delete your personal information. To exercise these rights, 
                        please contact us at 
                        <a href="mailto:{{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}" style="color: var(--signal); text-decoration: none;">
                            {{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}
                        </a>
                    </p>

                    <div class="alert" style="background: var(--signal-tint); border-left: 4px solid var(--signal); border-radius: var(--radius-sm); padding: 16px 20px; margin-top: 25px;">
                        <i class="fas fa-info-circle" style="color: var(--signal);"></i>
                        <span style="color: var(--ink-soft); font-weight: 500;">We update this policy periodically. Last updated: {{ date('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection