<!-- Left Sidebar for Admin -->
@php
    use App\Models\ProductReview;
    use App\Models\Contact;
    use App\Models\Order;
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
            $lastViewedAt = session('payments_last_viewed_at', now()->subDays(30));
            $newPendingOrders = Order::where('payment_status', 'PENDING')
                ->where('created_at', '>', $lastViewedAt)
                ->count();
        }
    } catch (\Exception $e) {
        $newPendingOrders = 0;
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
            <strong>ADMIN<span class="text-danger">PANEL</span></strong>
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
                @if($pendingReviewsCount > 0)
                    <span class="badge bg-warning ms-2" style="font-size: 0.7rem; padding: 2px 8px; border-radius: 10px;">{{ $pendingReviewsCount }}</span>
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
                        @if($pendingReviewsCount > 0)
                            <span class="badge bg-warning ms-2" style="font-size: 0.6rem; padding: 1px 6px; border-radius: 8px;">{{ $pendingReviewsCount }}</span>
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
                @if($pendingCount > 0)
                    <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                @endif
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
            </ul>
        </li>

        <!-- Payments -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.payments.index') }}" id="paymentsNavLink" onclick="markPaymentsViewed()">
                <i class="fas fa-credit-card"></i> <span>Payments</span>
                @if($newPendingOrders > 0)
                    <span class="badge bg-danger ms-2" id="pendingBadge">{{ $newPendingOrders }}</span>
                @endif
            </a>
        </li>

        <!-- Deliverable Pincodes -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/pincodes') }}">
                <i class="fas fa-map-marker-alt"></i> <span>Deliverable Pincodes</span>
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
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <i class="fas fa-user-shield"></i> 
            <span>{{ $adminName }}</span>
        </div>
        <a class="logout-btn" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
    </div>
</div>

<form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
// Function to mark payments as viewed when clicked
function markPaymentsViewed() {
    fetch('{{ route("admin.payments.mark-viewed") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              const badge = document.getElementById('pendingBadge');
              if (badge) {
                  badge.style.display = 'none';
              }
          }
      });
}

// Function to check for new orders periodically
function checkNewOrders() {
    fetch('{{ route("admin.payments.check-new") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('pendingBadge');
            if (data.new_count > 0) {
                if (badge) {
                    badge.textContent = data.new_count;
                    badge.style.display = 'inline-block';
                } else {
                    const navLink = document.getElementById('paymentsNavLink');
                    if (navLink) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'badge bg-danger ms-2';
                        newBadge.id = 'pendingBadge';
                        newBadge.textContent = data.new_count;
                        navLink.appendChild(newBadge);
                    }
                }
            } else {
                if (badge) {
                    badge.style.display = 'none';
                }
            }
        });
}

// Check for new orders every 30 seconds
setInterval(checkNewOrders, 30000);

// Check once when page loads
document.addEventListener('DOMContentLoaded', checkNewOrders);

// ============ DROPDOWN CLICK TOGGLE ============
document.addEventListener('DOMContentLoaded', function() {
    // Get all dropdown toggle links
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const parent = this.parentElement;
            const dropdownMenu = parent.querySelector('.dropdown-menu-custom');
            
            if (dropdownMenu) {
                // Close all other dropdowns
                document.querySelectorAll('.has-dropdown').forEach(function(item) {
                    if (item !== parent) {
                        item.classList.remove('active');
                        const menu = item.querySelector('.dropdown-menu-custom');
                        if (menu) {
                            menu.style.display = 'none';
                        }
                        const arrow = item.querySelector('.dropdown-arrow');
                        if (arrow) {
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    }
                });
                
                // Toggle current dropdown
                parent.classList.toggle('active');
                if (parent.classList.contains('active')) {
                    dropdownMenu.style.display = 'block';
                    const arrow = toggle.querySelector('.dropdown-arrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(180deg)';
                    }
                } else {
                    dropdownMenu.style.display = 'none';
                    const arrow = toggle.querySelector('.dropdown-arrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                }
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.has-dropdown')) {
            document.querySelectorAll('.has-dropdown.active').forEach(function(item) {
                item.classList.remove('active');
                const menu = item.querySelector('.dropdown-menu-custom');
                if (menu) {
                    menu.style.display = 'none';
                }
                const arrow = item.querySelector('.dropdown-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        }
    });
});
</script>

<style>
    .admin-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 260px;
        height: 100vh;
        background: #1a1a2e;
        color: white;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    /* Custom scrollbar */
    .admin-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: #1a1a2e;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: #e94560;
        border-radius: 10px;
    }

    .sidebar-header {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #2d2d4a;
        flex-shrink: 0;
    }

    .sidebar-brand {
        color: white;
        text-decoration: none;
        font-size: 1.2rem;
    }

    .sidebar-brand:hover {
        color: #e94560;
    }

    .sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0;
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 100px;
        position: relative;
    }

    .sidebar-nav .nav-item {
        margin: 0;
        position: relative;
        display: block;
        width: 100%;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #a0a0c0;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        border-left: 3px solid transparent;
        width: 100%;
        box-sizing: border-box;
    }

    .sidebar-nav .nav-link:hover {
        background: #2d2d4a;
        color: white;
        border-left-color: #e94560;
    }

    .sidebar-nav .nav-link.active {
        background: #e94560;
        color: white;
        border-left-color: #fff;
    }

    .sidebar-nav .nav-link i {
        width: 25px;
        margin-right: 12px;
        font-size: 1.1rem;
        flex-shrink: 0;
        text-align: center;
    }

    .sidebar-nav .nav-link span {
        flex: 1;
        white-space: nowrap;
    }

    .dropdown-arrow {
        margin-left: 8px;
        font-size: 10px;
        transition: transform 0.3s;
        flex-shrink: 0;
    }

    /* Dropdown Menu - Pushes content below */
    .dropdown-menu-custom {
        display: none;
        background: #2d2d4a;
        border-radius: 0;
        padding: 0;
        margin: 0;
        list-style: none;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .has-dropdown.active .dropdown-menu-custom {
        display: block !important;
    }

    .dropdown-item-custom {
        display: flex;
        align-items: center;
        padding: 10px 20px 10px 57px;
        color: #a0a0c0;
        text-decoration: none;
        transition: all 0.3s;
        white-space: nowrap;
        width: 100%;
        border-left: 3px solid transparent;
        box-sizing: border-box;
    }

    .dropdown-item-custom:hover {
        background: #e94560;
        color: white;
        border-left-color: #fff;
    }

    .dropdown-item-custom i {
        width: 25px;
        margin-right: 12px;
        font-size: 0.9rem;
        flex-shrink: 0;
        text-align: center;
    }

    .badge {
        margin-left: auto;
        flex-shrink: 0;
    }

    .badge.bg-warning {
        background-color: #f59e0b !important;
        color: #1a1a2e;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 10px;
    }

    .badge.bg-danger {
        background-color: #dc3545 !important;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 10px;
    }

    .sidebar-footer {
        position: relative;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px 20px;
        border-top: 1px solid #2d2d4a;
        background: #1a1a2e;
        flex-shrink: 0;
        margin-top: auto;
    }

    .user-info {
        padding: 8px 0;
        font-size: 0.9rem;
        color: #a0a0c0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-info i {
        font-size: 1.1rem;
        color: #e94560;
        width: 25px;
        flex-shrink: 0;
        text-align: center;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        padding: 8px 0;
        color: #ff6b6b;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s;
        cursor: pointer;
        margin-top: 5px;
    }

    .logout-btn i {
        margin-right: 10px;
        width: 25px;
        flex-shrink: 0;
        text-align: center;
    }

    .logout-btn:hover {
        color: #ff4757;
    }

    /* Adjust main content to accommodate sidebar */
    .admin-main-content {
        margin-left: 260px;
        padding: 20px;
        min-height: 100vh;
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            width: 70px;
        }
        .admin-sidebar .sidebar-brand strong,
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
        .dropdown-menu-custom {
            position: fixed;
            left: 70px;
            top: 0;
            width: 200px;
            max-height: 100vh;
            overflow-y: auto;
            z-index: 1001;
            border-radius: 0 8px 8px 0;
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
</style>