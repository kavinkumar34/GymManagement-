@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-4">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--signal); text-decoration: none;">Home</a></li>
                    <li class="breadcrumb-item active" style="color: var(--steel);">Terms & Conditions</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm" style="border-radius: var(--radius-lg); overflow: hidden;">
                <div class="card-header" style="background: var(--ink); color: white; padding: 20px 30px; border-bottom: none;">
                    <h1 class="h3 mb-0" style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fas fa-file-contract me-2" style="color: var(--signal);"></i> Terms & Conditions
                    </h1>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="energy-stripe mb-4"></div>

                    <p class="lead" style="font-weight: 500; color: var(--ink-soft);">
                        By using our website and services, you agree to the following terms and conditions. 
                        Please read them carefully.
                    </p>

                    <hr style="border-color: var(--line); margin: 30px 0;">

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem;">
                        <i class="fas fa-handshake me-2" style="color: var(--success);"></i> Acceptance of Terms
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        By accessing and using this website, you accept and agree to be bound by these terms and conditions. 
                        If you do not agree to these terms, please do not use our website.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-shopping-cart me-2" style="color: var(--signal);"></i> Orders and Payments
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        All orders placed through our website are subject to availability. We reserve the right to cancel 
                        or refuse any order. Payments are processed securely through our trusted payment partners.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-palette me-2" style="color: var(--warning);"></i> Product Information
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        We strive to display accurate product descriptions, images, and pricing. However, we cannot guarantee 
                        that all information is error-free. If we discover an error, we will notify you and offer alternatives.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-gavel me-2" style="color: var(--info);"></i> Intellectual Property
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        All content on this website, including text, images, logos, and graphics, is the property of 
                        {{ \App\Models\Setting::get('company_name', 'Gym Management') }} and is protected by copyright laws. 
                        You may not reproduce or distribute any content without prior written permission.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-user-secret me-2" style="color: var(--signal);"></i> User Accounts
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        You are responsible for maintaining the confidentiality of your account credentials. You agree to 
                        accept responsibility for all activities that occur under your account.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-ban me-2" style="color: var(--danger);"></i> Prohibited Activities
                    </h4>
                    <ul style="color: var(--steel); line-height: 2.2; padding-left: 20px;">
                        <li>Using the website for any unlawful purpose</li>
                        <li>Attempting to gain unauthorized access to our systems</li>
                        <li>Uploading malicious code or viruses</li>
                        <li>Harassing or abusing other users</li>
                        <li>Misrepresenting your identity</li>
                    </ul>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-scale-balanced me-2" style="color: var(--info);"></i> Limitation of Liability
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        To the fullest extent permitted by law, we shall not be liable for any direct, indirect, incidental, 
                        or consequential damages arising from the use of our website or services.
                    </p>

                    <h4 style="font-family: var(--font-display); text-transform: uppercase; color: var(--ink); letter-spacing: 0.3px; font-size: 1.1rem; margin-top: 25px;">
                        <i class="fas fa-phone-alt me-2" style="color: var(--success);"></i> Contact Us
                    </h4>
                    <p style="color: var(--steel); line-height: 1.8;">
                        If you have any questions about these terms, please contact us at 
                        <a href="mailto:{{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}" style="color: var(--signal); text-decoration: none;">
                            {{ \App\Models\Setting::get('footer_email', 'info@fitforge.com') }}
                        </a>
                    </p>

                    <div class="alert" style="background: var(--signal-tint); border-left: 4px solid var(--signal); border-radius: var(--radius-sm); padding: 16px 20px; margin-top: 25px;">
                        <i class="fas fa-info-circle" style="color: var(--signal);"></i>
                        <span style="color: var(--ink-soft); font-weight: 500;">We reserve the right to update these terms at any time. Last updated: {{ date('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection