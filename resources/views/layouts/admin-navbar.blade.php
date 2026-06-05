<!-- Left Sidebar for Admin -->
<div class="admin-sidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-dumbbell me-2"></i>
            <strong>ADMIN<span class="text-danger">PANEL</span></strong>
        </a>
    </div>
    <ul class="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>

        <!-- Products Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link" href="#">
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

        <!-- Contact Messages -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-envelope"></i> <span>Contact Messages</span>
                @php 
                    use App\Models\Contact;
                    $pendingCount = Contact::where('status', 'Pending')->count(); 
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                @endif
            </a>
        </li>

        <!-- Members Dropdown -->
        <li class="nav-item has-dropdown">
            <a class="nav-link" href="{{ route('admin.members') }}">
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
            <a class="nav-link" href="{{ route('admin.trainers') }}">
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
                @php
                    use App\Models\Order;
                    $lastViewedAt = session('payments_last_viewed_at', now()->subDays(30));
                    $newPendingOrders = Order::where('payment_status', 'PENDING')
                        ->where('created_at', '>', $lastViewedAt)
                        ->count();
                @endphp
                @if($newPendingOrders > 0)
                    <span class="badge bg-danger ms-2" id="pendingBadge">{{ $newPendingOrders }}</span>
                @endif
            </a>
        </li>

        <!-- Banners -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.banners.index') }}">
                <i class="fas fa-image"></i> <span>Banners</span>
            </a>
        </li>

        <!-- Settings -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings') }}">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
        </li>
@php
    use Illuminate\Support\Facades\Route;
@endphp

@if(Route::has('admin.pincodes.index'))
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.pincodes.index') }}">
        <i class="fas fa-map-marker-alt"></i> Deliverable Pincodes
    </a>
</li>
@endif
    </ul>

    <div class="sidebar-footer">
        <div class="user-info">
            <i class="fas fa-user-shield"></i> {{ auth()->guard('admin')->user()->name ?? 'Admin' }}
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
    }

    .sidebar-header {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #2d2d4a;
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
        margin: 20px 0;
    }

    .sidebar-nav .nav-item {
        margin: 5px 0;
        position: relative;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #a0a0c0;
        text-decoration: none;
        transition: all 0.3s;
    }

    .sidebar-nav .nav-link i {
        width: 25px;
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .sidebar-nav .nav-link:hover {
        background: #2d2d4a;
        color: white;
    }

    .sidebar-nav .nav-link.active {
        background: #e94560;
        color: white;
    }

    .dropdown-arrow {
        margin-left: auto;
        font-size: 10px;
        transition: transform 0.3s;
    }

    .has-dropdown:hover .dropdown-arrow {
        transform: rotate(180deg);
    }

    .dropdown-menu-custom {
        position: absolute;
        left: 0;
        top: 100%;
        background: #2d2d4a;
        border-radius: 8px;
        min-width: 200px;
        padding: 8px 0;
        margin: 0;
        list-style: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1001;
    }

    .has-dropdown:hover .dropdown-menu-custom {
        opacity: 1;
        visibility: visible;
        top: 100%;
    }

    .dropdown-item-custom {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: #a0a0c0;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .dropdown-item-custom i {
        width: 25px;
        margin-right: 10px;
        font-size: 0.9rem;
    }

    .dropdown-item-custom:hover {
        background: #e94560;
        color: white;
    }

    .sidebar-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        border-top: 1px solid #2d2d4a;
    }

    .user-info {
        padding: 10px 0;
        font-size: 0.9rem;
        color: #a0a0c0;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        padding: 10px;
        color: #ff6b6b;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .logout-btn i {
        margin-right: 10px;
    }

    .logout-btn:hover {
        background: #ff6b6b;
        color: white;
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
        .admin-sidebar .user-info,
        .admin-sidebar .logout-btn span,
        .dropdown-arrow {
            display: none;
        }
        .dropdown-menu-custom {
            left: 70px;
            top: 0;
        }
        .has-dropdown:hover .dropdown-menu-custom {
            top: 0;
            left: 70px;
        }
        .admin-sidebar .sidebar-nav .nav-link i {
            margin-right: 0;
        }
        .admin-main-content {
            margin-left: 70px;
        }
    }
</style>