<!-- Left Sidebar for Admin - White Text Theme -->
@php
    use App\Models\ProductReview;
    use App\Models\Contact;
    use App\Models\Order;
    use App\Models\Offer;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Schema;

    // Reviews count with error handling
    $pendingReviewsCount = 0;
    try {
        if (Schema::hasTable('product_reviews')) {
            $pendingReviewsCount = ProductReview::where('status', 'pending')->count();
        }
    } catch (\Exception $e) {
        $pendingReviewsCount = 0;
    }

    // Contact messages count
    $pendingCount = 0;
    try {
        if (Schema::hasTable('contacts')) {
            $pendingCount = Contact::where('status', 'Pending')->count();
        }
    } catch (\Exception $e) {
        $pendingCount = 0;
    }

    // New pending orders count
    $newPendingOrders = 0;
    try {
        if (Schema::hasTable('orders')) {
            $lastViewedAt = cache()->get('orders_last_viewed', now()->subDays(30));

            $newPendingOrders = Order::where('payment_status', 'PENDING')
                ->where('created_at', '>', $lastViewedAt)
                ->count();
        }
    } catch (\Exception $e) {
        $newPendingOrders = 0;
    }

    // Active offers count
    $activeOffersCount = 0;
    try {
        if (Schema::hasTable('offers')) {
            $activeOffersCount = Offer::where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count();
        }
    } catch (\Exception $e) {
        $activeOffersCount = 0;
    }

    // Get admin name safely
    $adminName = 'Admin';
    try {
        if (auth()->guard('admin')->check()) {
            $adminName = auth()->guard('admin')->user()->name ?? 'Admin';
        }
    } catch (\Exception $e) {
        $adminName = 'Admin';
    }
@endphp

<div class="admin-sidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-dumbbell me-2"></i>
            <strong>ADMIN<span class="text-accent">PANEL</span></strong>
        </a>
    </div>
    <ul class="sidebar-nav" id="sidebarNav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>

        <!-- Products Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-box"></i> <span>Products</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.products.create') }}">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-list"></i> Products List
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.subcategories.index') }}">
                        <i class="fas fa-folder-open"></i> Sub Categories
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.producttypes.index') }}">
                        <i class="fas fa-tag"></i> Product Types
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.brands.index') }}">
                        <i class="fas fa-building"></i> Brands
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.attributes.index') }}">
                        <i class="fas fa-list-ul"></i> Attributes
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.topcategories.index') }}">
                        <i class="fas fa-layer-group"></i> Top Categories
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.sizecharts.index') }}">
                        <i class="fas fa-chart-line"></i> Size Charts
                    </a>
                </li>
            </ul>
        </li>

        <!-- Reviews Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-star"></i> <span>Reviews</span>
                <span class="dropdown-arrow">▼</span>
                @if ($pendingReviewsCount > 0)
                    <span class="badge bg-warning ms-2">{{ $pendingReviewsCount }}</span>
                @endif
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.reviews.index') }}">
                        <i class="fas fa-list"></i> All Reviews
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.reviews.pending') }}">
                        <i class="fas fa-clock"></i> Pending Reviews
                        @if ($pendingReviewsCount > 0)
                            <span class="badge bg-warning ms-2">{{ $pendingReviewsCount }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.reviews.approved') }}">
                        <i class="fas fa-check-circle"></i> Approved Reviews
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.reviews.rejected') }}">
                        <i class="fas fa-times-circle"></i> Rejected Reviews
                    </a>
                </li>
            </ul>
        </li>

        <!-- Contact Messages -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-envelope"></i> <span>Contact Messages</span>
                @if ($pendingCount > 0)
                    <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                @endif
            </a>
        </li>

        <!-- Payments -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.payments.index') }}" id="paymentsNavLink"
                onclick="markPaymentsViewed()">
                <i class="fas fa-credit-card"></i> <span>Orders</span>
                @if ($newPendingOrders > 0)
                    <span class="badge bg-danger ms-2" id="pendingBadge">{{ $newPendingOrders }}</span>
                @endif
            </a>
        </li>

        <!-- Deliverable Pincodes -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/pincodes') }}">
                <i class="fas fa-map-marker-alt"></i> <span>Shipping Charges</span>
            </a>
        </li>

        <!-- Banners -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/banners') }}">
                <i class="fas fa-image"></i> <span>Banners</span>
            </a>
        </li>

        <!-- Settings -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings') }}">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
        </li>

        <!-- ===== OFFERS MENU - NEW ===== -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-tags"></i> <span>Offers</span>
                <span class="dropdown-arrow">▼</span>
                @if ($activeOffersCount > 0)
                    <span class="badge bg-success ms-2">{{ $activeOffersCount }}</span>
                @endif
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.offers.create') }}">
                        <i class="fas fa-plus"></i> Create Offer
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.offers.index') }}">
                        <i class="fas fa-list"></i> All Offers
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.offers.status', 'active') }}">
                        <i class="fas fa-check-circle text-success"></i> Active Offers
                        @if ($activeOffersCount > 0)
                            <span class="badge bg-success ms-2">{{ $activeOffersCount }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.offers.status', 'scheduled') }}">
                        <i class="fas fa-clock text-warning"></i> Scheduled Offers
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.offers.status', 'expired') }}">
                        <i class="fas fa-hourglass-end text-muted"></i> Expired Offers
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.offers.status', 'inactive') }}">
                        <i class="fas fa-pause-circle text-danger"></i> Inactive Offers
                    </a>
                </li>
            </ul>
        </li>
        <!-- ===== COUPONS MENU ===== -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-ticket-alt"></i> <span>Coupons</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.coupons.create') }}">
                        <i class="fas fa-plus"></i> Add Coupon
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.coupons.index') }}">
                        <i class="fas fa-list"></i> All Coupons
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.coupons.index') }}?status=active">
                        <i class="fas fa-check-circle text-success"></i> Active Coupons
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.coupons.index') }}?status=expired">
                        <i class="fas fa-clock text-warning"></i> Expired Coupons
                    </a>
                </li>
            </ul>
        </li>
        <!-- ===== GYM ONE DIVIDER ===== -->
        <li class="nav-divider">
            <span class="divider-text">Gym One</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.gym.dashboard') }}">
                <i class="fas fa-dumbbell"></i> <span>Dashboard</span>
            </a>
        </li>

        <!-- Members Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-users"></i> <span>Members</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.member.create') }}">
                        <i class="fas fa-user-plus"></i> Add Member
                    </a>
                </li>

                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.member.index') }}">
                        <i class="fas fa-list"></i> Member List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Trainers Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-chalkboard-user"></i> <span>Trainers</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.trainer.create') }}">
                        <i class="fas fa-user-plus"></i> Add Trainer
                    </a>
                </li>

                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.trainer.index') }}">
                        <i class="fas fa-list"></i> Trainer List
                    </a>
                </li>
            </ul>
        </li>


        <!-- Membership Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-id-card"></i>
                <span>Membership</span>
                <span class="dropdown-arrow">▼</span>
            </a>

            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.membership.create') }}">
                        <i class="fas fa-plus-circle"></i> Add Membership
                    </a>
                </li>

                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.membership.index') }}">
                        <i class="fas fa-list"></i> Membership List
                    </a>
                </li>
            </ul>
        </li>



        <!--Package GropDown -->

        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-id-card"></i>
                <span>Package</span>
                <span class="dropdown-arrow">▼</span>
            </a>

            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.package.create') }}">
                        <i class="fas fa-plus-circle"></i> Add Package
                    </a>
                </li>

                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.package.index') }}">
                        <i class="fas fa-list"></i> Package List
                    </a>
                </li>
            </ul>
        </li>
        <!-- ============================================ -->
        <!-- ASSIGN TRAINER - NEW MENU                    -->
        <!-- ============================================ -->
        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-user-tag"></i>
                <span>Assign Trainer</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.assign.trainer.index') }}">
                        <i class="fas fa-users"></i> Assign Trainer to Member
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.assign.trainer.list') }}">
                        <i class="fas fa-list"></i> Assigned Members List
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-user-tag"></i>
                <span>Payments</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.hand.payment') }}">
                        <i class="fas fa-hand-holding-usd"></i> Hand Payment
                    </a>
                </li>
                {{-- 
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.payment.orders') }}">
                        <i class="fas fa-list"></i>Membership Payment
                    </a>
                </li>
                --}}
            </ul>
        </li>




            <li class="nav-item has-dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                <i class="fas fa-user-tag"></i>
                <span>Attendance</span>
                <span class="dropdown-arrow">▼</span>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.member-attendance.index') }}">
 Member Attendance
                    </a>
                </li>
                <li>
                    <a class="dropdown-item-custom" href="{{ route('admin.trainer-attendance.index') }}">
                                                              

Trainer Attendance
                    </a>
                </li>
            </ul>
        </li>





    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <i class="fas fa-user-shield"></i>
            <span>{{ $adminName }}</span>
        </div>
        <a class="logout-btn" href="#"
            onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
    </div>
</div>

<form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    // ============ DROPDOWN CLICK TOGGLE - IMPROVED ============
    document.addEventListener('DOMContentLoaded', function() {

        // ===========================
        // DROPDOWN TOGGLE
        // ===========================
        const dropdowns = document.querySelectorAll('.has-dropdown');

        dropdowns.forEach(function(dropdown) {

            const toggle = dropdown.querySelector('.dropdown-toggle');
            const menu = dropdown.querySelector('.dropdown-menu-custom');
            const arrow = dropdown.querySelector('.dropdown-arrow');

            toggle.addEventListener('click', function(e) {

                e.preventDefault();
                e.stopPropagation();

                // Close other dropdowns
                dropdowns.forEach(function(item) {

                    if (item !== dropdown) {

                        item.classList.remove('active');

                        const m = item.querySelector('.dropdown-menu-custom');
                        const a = item.querySelector('.dropdown-arrow');

                        if (m) m.style.display = 'none';
                        if (a) a.style.transform = 'rotate(0deg)';
                    }

                });

                // Toggle current dropdown
                if (dropdown.classList.contains('active')) {

                    dropdown.classList.remove('active');

                    menu.style.display = 'none';

                    if (arrow)
                        arrow.style.transform = 'rotate(0deg)';

                } else {

                    dropdown.classList.add('active');

                    menu.style.display = 'block';

                    if (arrow)
                        arrow.style.transform = 'rotate(180deg)';

                }

            });

        });


        // ==========================================
        // KEEP CURRENT DROPDOWN OPEN AFTER PAGE LOAD
        // ==========================================
        const currentUrl = window.location.href;

        document.querySelectorAll('.dropdown-item-custom').forEach(function(item) {

            if (item.href === currentUrl ||
                currentUrl.startsWith(item.href)) {

                item.classList.add('active');

                const parent = item.closest('.has-dropdown');

                if (parent) {

                    parent.classList.add('active');

                    const menu = parent.querySelector('.dropdown-menu-custom');
                    const arrow = parent.querySelector('.dropdown-arrow');

                    if (menu)
                        menu.style.display = 'block';

                    if (arrow)
                        arrow.style.transform = 'rotate(180deg)';

                }

            }

        });


        // ===========================
        // CLICK OUTSIDE
        // ===========================
        document.addEventListener('click', function(e) {

            if (!e.target.closest('.admin-sidebar')) {

                dropdowns.forEach(function(dropdown) {

                    dropdown.classList.remove('active');

                    const menu = dropdown.querySelector('.dropdown-menu-custom');
                    const arrow = dropdown.querySelector('.dropdown-arrow');

                    if (menu)
                        menu.style.display = 'none';

                    if (arrow)
                        arrow.style.transform = 'rotate(0deg)';

                });

            }

        });


        // ===========================
        // MARK PAYMENTS VIEWED
        // ===========================
        window.markPaymentsViewed = function() {

            const badge = document.getElementById("pendingBadge");

            if (badge) {

                badge.style.display = "none";

                badge.innerHTML = "";

            }

            fetch('{{ route('admin.payments.mark-viewed') }}', {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            });

        }


        // ===========================
        // CHECK NEW ORDERS
        // ===========================
        function checkNewOrders() {

            fetch('{{ route('admin.payments.check-new') }}')
                .then(res => res.json())
                .then(data => {

                    let badge = document.getElementById("pendingBadge");

                    if (data.new_count > 0) {

                        if (!badge) {

                            badge = document.createElement("span");

                            badge.id = "pendingBadge";

                            badge.className = "badge bg-danger ms-2";

                            document.getElementById("paymentsNavLink").appendChild(badge);

                        }

                        badge.innerHTML = data.new_count;

                        badge.style.display = "inline-block";

                    }

                });

        }

        checkNewOrders();

        checkNewOrders();

        setInterval(checkNewOrders, 2000);
    });
</script>

<style>
    /* ===== DARK THEME SIDEBAR - ALL WHITE TEXT ===== */
    .admin-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 270px;
        height: 100vh;
        background: linear-gradient(180deg, #0d1b2a 0%, #1b3a5c 50%, #0d1b2a 100%);
        color: #ffffff;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.5);
        border-right: 1px solid rgba(255, 255, 255, 0.06);
    }

    /* Custom scrollbar */
    .admin-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: #0d1b2a;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: #4a9eff;
        border-radius: 10px;
    }

    /* ===== HEADER ===== */
    .sidebar-header {
        padding: 22px 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
        background: rgba(0, 0, 0, 0.25);
    }

    .sidebar-brand {
        color: #ffffff;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .sidebar-brand i {
        color: #4a9eff;
        font-size: 1.4rem;
        text-shadow: 0 0 30px rgba(74, 158, 255, 0.2);
    }

    .sidebar-brand .text-accent {
        color: #4a9eff !important;
        font-weight: 800;
        text-shadow: 0 0 30px rgba(74, 158, 255, 0.15);
    }

    .sidebar-brand:hover {
        color: #4a9eff;
        text-shadow: 0 0 30px rgba(74, 158, 255, 0.25);
    }

    /* ===== NAVIGATION - ALL WHITE TEXT ===== */
    .sidebar-nav {
        list-style: none;
        padding: 10px 0;
        margin: 0;
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 80px;
    }

    .sidebar-nav .nav-item {
        margin: 2px 0;
        position: relative;
        display: block;
        width: 100%;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        padding: 11px 20px;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        border-left: 3px solid transparent;
        width: 100%;
        box-sizing: border-box;
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    .sidebar-nav .nav-link:hover {
        background: rgba(74, 158, 255, 0.1);
        color: #ffffff;
        border-left-color: #4a9eff;
    }

    .sidebar-nav .nav-link.active {
        background: rgba(74, 158, 255, 0.15);
        color: #ffffff;
        border-left-color: #4a9eff;
        font-weight: 600;
    }

    .sidebar-nav .nav-link i {
        width: 28px;
        margin-right: 12px;
        font-size: 1.1rem;
        flex-shrink: 0;
        text-align: center;
        color: #8ab4f8;
        transition: all 0.3s;
    }

    .sidebar-nav .nav-link:hover i {
        color: #4a9eff;
    }

    .sidebar-nav .nav-link.active i {
        color: #4a9eff;
    }

    .sidebar-nav .nav-link span {
        flex: 1;
        white-space: nowrap;
        color: #ffffff;
    }

    .dropdown-arrow {
        margin-left: 8px;
        font-size: 9px;
        transition: transform 0.3s;
        flex-shrink: 0;
        color: #8ab4f8;
    }

    .has-dropdown.active .dropdown-arrow {
        transform: rotate(180deg);
        color: #4a9eff;
    }

    /* ===== DROPDOWN MENU - ALL WHITE TEXT ===== */
    .dropdown-menu-custom {
        display: none;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 0;
        padding: 4px 0;
        margin: 0;
        list-style: none;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        width: 100%;
        position: relative;
        overflow: hidden;
    }


    .has-dropdown.active .dropdown-menu-custom {
        display: block !important;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item-custom {
        display: flex;
        align-items: center;
        padding: 9px 20px 9px 60px;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s;
        white-space: nowrap;
        width: 100%;
        border-left: 3px solid transparent;
        box-sizing: border-box;
        font-size: 13px;
    }

    .dropdown-item-custom:hover {
        background: rgba(74, 158, 255, 0.1);
        color: #ffffff;
        border-left-color: #4a9eff;
    }

    .dropdown-item-custom i {
        width: 25px;
        margin-right: 12px;
        font-size: 0.85rem;
        flex-shrink: 0;
        text-align: center;
        color: #8ab4f8;
    }

    .dropdown-item-custom:hover i {
        color: #4a9eff;
    }

    /* ===== GYM ONE DIVIDER ===== */
    .nav-divider {
        padding: 18px 20px 8px 20px;
        position: relative;
        margin: 8px 0 4px 0;
    }

    .nav-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 20px;
        right: 20px;
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(74, 158, 255, 0.4), transparent);
        opacity: 0.5;
    }

    .divider-text {
        display: inline-block;
        background: #0d1b2a;
        padding: 0 14px;
        position: relative;
        z-index: 1;
        color: #4a9eff;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 3px;
        text-align: center;
        width: 100%;
        text-shadow: 0 0 30px rgba(74, 158, 255, 0.15);
    }

    /* ===== BADGES ===== */
    .badge {
        margin-left: auto;
        flex-shrink: 0;
        font-size: 0.6rem;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 600;
    }

    .badge.bg-warning {
        background-color: #ffa726 !important;
        color: #0d1b2a;
    }

    .badge.bg-danger {
        background-color: #ef5350 !important;
        color: #ffffff;
    }

    .badge.bg-success {
        background-color: #4caf50 !important;
        color: #ffffff;
    }

    /* ===== SIDEBAR FOOTER ===== */
    .sidebar-footer {
        position: relative;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
        margin-top: auto;
    }

    .user-info {
        padding: 6px 0;
        font-size: 0.9rem;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-info i {
        font-size: 1.1rem;
        color: #4a9eff;
        width: 25px;
        flex-shrink: 0;
        text-align: center;
        text-shadow: 0 0 20px rgba(74, 158, 255, 0.2);
    }

    .user-info span {
        font-weight: 500;
        letter-spacing: 0.5px;
        color: #ffffff;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        padding: 6px 0;
        color: #ef5350;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s;
        cursor: pointer;
        margin-top: 3px;
        font-size: 0.9rem;
    }

    .logout-btn i {
        margin-right: 10px;
        width: 25px;
        flex-shrink: 0;
        text-align: center;
    }

    .logout-btn:hover {
        color: #ff6b6b;
        text-shadow: 0 0 25px rgba(239, 83, 80, 0.3);
    }

    /* ===== MAIN CONTENT ===== */
    .admin-main-content {
        margin-left: 270px;
        padding: 20px;
        min-height: 100vh;
        background: #f0f4f8;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .admin-sidebar {
            width: 70px;
        }

        .admin-sidebar .sidebar-brand strong,
        .admin-sidebar .sidebar-brand .text-accent,
        .admin-sidebar .sidebar-nav .nav-link span,
        .admin-sidebar .user-info span,
        .admin-sidebar .logout-btn span,
        .dropdown-arrow {
            display: none;
        }

        .admin-sidebar .sidebar-nav .nav-link i {
            margin-right: 0;
        }

        .admin-sidebar .sidebar-nav .nav-link {
            justify-content: center;
            padding: 12px;
            border-left: none;
        }

        .admin-sidebar .sidebar-nav .nav-link:hover {
            border-left: none;
        }

        .nav-divider {
            display: none;
        }

        .dropdown-menu-custom {
            position: fixed;
            left: 70px;
            top: 0;
            width: 200px;
            max-height: 100vh;
            overflow-y: auto;
            z-index: 1001;
            border-radius: 0 8px 8px 0;
            background: #1b3a5c;
        }

        .dropdown-item-custom {
            padding: 10px 15px 10px 20px;
        }

        .admin-main-content {
            margin-left: 70px;
        }

        .sidebar-footer {
            padding: 10px;
        }

        .user-info {
            justify-content: center;
            padding: 5px 0;
        }

        .logout-btn {
            justify-content: center;
            padding: 5px 0;
        }

        .badge {
            display: none !important;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 3px;
        }
    }

    @media (max-width: 480px) {
        .admin-sidebar {
            width: 55px;
        }

        .admin-sidebar .sidebar-nav .nav-link {
            padding: 10px;
            font-size: 0.9rem;
        }

        .admin-sidebar .sidebar-nav .nav-link i {
            font-size: 1rem;
        }

        .admin-main-content {
            margin-left: 55px;
            padding: 10px;
        }

        .dropdown-menu-custom {
            left: 55px;
            width: 180px;
        }
    }

    .dropdown-item-custom.active {
        background: rgba(74, 158, 255, 0.18);
        border-left: 3px solid #4a9eff;
        color: #ffffff;
        font-weight: 600;
    }

    .dropdown-item-custom.active i {
        color: #4a9eff;
    }

    #pendingBadge {
        animation: badgeBlink 1s infinite;
    }

    @keyframes badgeBlink {

        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: .3;
            transform: scale(1.25);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }

    }

    .blinkBadge {

        animation: blink 1s infinite;

    }

    @keyframes blink {

        0% {
            opacity: 1;
        }

        50% {
            opacity: .3;
            transform: scale(1.25);
        }

        100% {
            opacity: 1;
        }

    }
</style>
