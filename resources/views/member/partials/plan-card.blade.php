<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
    <div class="plan-card">
        <!-- Image Section -->
        <div class="plan-image">
            @if($plan->image)
                <img src="{{ asset('storage/'.$plan->image) }}" 
                     alt="{{ $plan->plan_name ?? $plan->package_name }}"
                     style="object-fit: cover;">
            @else
                <img src="{{ asset('images/no-image.png') }}" 
                     alt="No Image"
                     style="object-fit: cover;">
            @endif
            
            <span class="badge-status {{ $plan->status == 'Active' ? 'active' : 'inactive' }}">
                {{ $plan->status == 'Active' ? 'Available' : 'Not Available' }}
            </span>
        </div>

        <!-- Content Section -->
        <div class="plan-content">
            <h5 class="plan-title">{{ $plan->plan_name ?? $plan->package_name }}</h5>
            
            <p class="plan-duration">
                <i class="fas fa-clock me-1"></i>
                {{ $plan->duration }} {{ ucfirst($plan->duration_type) }}
            </p>

            <!-- Price Section -->
            <div class="plan-price">
                @if(isset($plan->discount) && $plan->discount > 0)
                    <span class="old-price">₹ {{ number_format($plan->price, 2) }}</span>
                    <span class="discount-badge-inline">
                        <i class="fas fa-tag me-1"></i>
                        {{ $plan->discount_type == 'Flat' ? '₹' : '' }}
                        {{ $plan->discount }}
                        {{ $plan->discount_type == 'Percentage' ? '%' : '' }} OFF
                    </span>
                @endif
                <div class="price-row">
                    <span class="new-price">₹ {{ number_format($plan->final_price ?? $plan->price, 2) }}</span>
                    <span class="price-duration">/ {{ $plan->duration }} {{ $plan->duration_type }}</span>
                </div>
            </div>

            @if($plan->description)
                <p class="plan-description">{{ Str::limit($plan->description, 80) }}</p>
            @endif

            <!-- Buy Button -->
            @if($plan->status == 'Active')
                @if($hasActivePlan)
                    <button class="buy-btn buy-btn-disabled" disabled>
                        <i class="fas fa-clock me-1"></i> Active Plan
                    </button>
                @else
                    <button class="buy-btn" onclick="initiatePayment('{{ $type }}', {{ $plan->id }}, {{ $plan->final_price ?? $plan->price }}, '{{ addslashes($plan->plan_name ?? $plan->package_name) }}')">
                        <i class="fas fa-shopping-cart me-1"></i> Buy Now
                    </button>
                @endif
            @else
                <button class="buy-btn buy-btn-disabled" disabled>
                    <i class="fas fa-times-circle me-1"></i> Not Available
                </button>
            @endif
        </div>
    </div>
</div>