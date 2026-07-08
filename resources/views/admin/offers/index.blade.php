@extends('layouts.admin-layout')

@section('content')
    <style>
        /* ===== FIX: Content should start after sidebar ===== */
        /* This ensures the content stays within the remaining area */
        .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
            max-width: 100% !important;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .col-12 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* ===== Additional styles ===== */
        .offer-badge {
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
        }

        .offer-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .offer-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .offer-badge.scheduled {
            background: #fff3cd;
            color: #856404;
        }

        .offer-badge.expired {
            background: #e2e3e5;
            color: #383d41;
        }

        .discount-badge {
            background: #dc3545;
            color: white;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .card {
            border-radius: 6px !important;
            border: 1px solid #e9ecef !important;
        }

        .card-header {
            padding: 5px 10px !important;
            background: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef !important;
        }

        .card-body {
            padding: 6px 10px !important;
        }

        .card-footer {
            padding: 3px 10px !important;
            background: transparent !important;
            border-top: 1px solid #e9ecef !important;
        }

        .form-control,
        .form-select {
            font-size: 12px;
            padding: 3px 8px;
            height: 28px;
        }

        .btn-sm {
            padding: 1px 5px;
            font-size: 10px;
        }

        .badge {
            font-size: 8px !important;
            padding: 1px 5px !important;
        }

        .form-check {
            padding-left: 16px !important;
        }

        .form-check-input {
            width: 12px !important;
            height: 12px !important;
            margin-top: 1px !important;
        }

        .form-check-label {
            font-size: 9px !important;
        }

        ul {
            font-size: 9px;
            padding-left: 15px;
            margin: 2px 0 0 0;
        }

        ul li {
            font-size: 9px;
        }

        .text-muted {
            font-size: 9px !important;
        }

        .mb-1 {
            margin-bottom: 0.2rem !important;
        }

        .mb-2 {
            margin-bottom: 0.4rem !important;
        }

        .mt-2 {
            margin-top: 0.4rem !important;
        }

        .gap-1 {
            gap: 0.15rem !important;
        }

        .g-1 {
            --bs-gutter-y: 0.15rem;
            --bs-gutter-x: 0.15rem;
        }

        .pagination {
            --bs-pagination-padding-x: 0.4rem;
            --bs-pagination-padding-y: 0.15rem;
            --bs-pagination-font-size: 11px;
        }

        .py-2 {
            padding-top: 0.15rem !important;
            padding-bottom: 0.15rem !important;
        }
    </style>

    <!-- ===== MAIN CONTENT WRAPPER ===== -->
    <div
        style="margin-left: 270px; padding: 20px 25px; min-height: 100vh; background: #f0f4f8; width: calc(100% - 270px); float: left; box-sizing: border-box;">

        <div class="row" style="margin:0; padding:0;">
            <div class="col-12" style="padding:0;">

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 style="font-size:15px; margin:0;"><i class="fas fa-tags text-primary me-2"></i> Combo Offers</h5>
                    <a href="{{ route('admin.offers.create') }}" class="btn btn-primary"
                        style="font-size:12px; padding:4px 12px;">
                        <i class="fas fa-plus me-1"></i> Create Combo
                    </a>
                </div>

                <!-- Filters -->
                <div class="card mb-2">
                    <div class="card-body" style="padding:6px 12px;">
                        <div class="row g-1 align-items-center" style="margin:0;">
                            <div class="col-md-3" style="padding:0 5px;">
                                <input type="text" id="searchOffers" class="form-control" placeholder="Search..."
                                    onkeyup="filterOffers()" style="font-size:12px; padding:3px 8px; height:28px;">
                            </div>
                            <div class="col-md-2" style="padding:0 5px;">
                                <select id="filterStatus" class="form-select" onchange="filterOffers()"
                                    style="font-size:12px; padding:3px 8px; height:28px;">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>
                            <div class="col-md-2" style="padding:0 5px;">
                                <select id="filterComboType" class="form-select" onchange="filterOffers()"
                                    style="font-size:12px; padding:3px 8px; height:28px;">
                                    <option value="">All Types</option>
                                    <option value="single_product">Single</option>
                                    <option value="multiple_products">Multiple</option>
                                    <option value="price_based">Price-Based</option>
                                </select>
                            </div>
                            <div class="col-md-2" style="padding:0 5px;">
                                <button class="btn btn-danger" onclick="bulkDelete()" id="bulkDeleteBtn"
                                    style="display:none; font-size:11px; padding:2px 10px;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                            <div class="col-md-3 text-end" style="padding:0 5px;">
                                <span class="text-muted" id="selectedCount" style="font-size:11px;">0 selected</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Offers List -->
                <div class="row" id="offersContainer" style="margin:0; padding:0;">
                    @if ($offers->count() > 0)
                        @foreach ($offers as $offer)
                            <div class="col-md-6 col-lg-4 mb-2 offer-item" data-id="{{ $offer->id }}"
                                data-status="{{ $offer->status }}" data-combo-type="{{ $offer->combo_type }}"
                                data-name="{{ strtolower($offer->offer_name) }}"
                                data-code="{{ strtolower($offer->offer_code) }}" style="padding:0 5px;">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 style="font-size:12px; font-weight:600; margin:0;">{{ $offer->offer_name }}
                                            </h6>
                                            <small style="font-size:9px; color:#6c757d;">{{ $offer->offer_code }}</small>
                                        </div>
                                        <span class="offer-badge {{ $offer->status }}">{{ ucfirst($offer->status) }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-1">
                                            <span class="badge bg-secondary">{{ $offer->getComboTypeLabel() }}</span>
                                            <span class="badge bg-primary">{{ $offer->getTypeLabel() }}</span>
                                        </div>

                                        <div class="mb-1">
                                            <strong style="font-size:10px;">Discount:</strong>
                                            <span class="discount-badge">{{ $offer->getDiscountText() }}</span>
                                            @if ($offer->max_discount_amount)
                                                <br><small style="font-size:9px; color:#6c757d;">Max:
                                                    ₹{{ number_format($offer->max_discount_amount, 2) }}</small>
                                            @endif
                                        </div>

                                        @if ($offer->min_order_amount)
                                            <div class="mb-1">
                                                <small style="font-size:9px; color:#6c757d;">Min:
                                                    ₹{{ number_format($offer->min_order_amount, 2) }}</small>
                                            </div>
                                        @endif

                                        <!-- Products -->
                                        <div class="mb-1">
                                            <strong style="font-size:10px;">Products:</strong>
                                            @php
                                                $products = $offer->applicable_products;
                                                if (is_string($products)) {
                                                    $products = json_decode($products, true);
                                                }
                                                $products = is_array($products) ? $products : [];
                                            @endphp
                                            @if (!empty($products) && is_array($products))
                                                <ul style="font-size:9px; padding-left:15px; margin:2px 0 0 0;">
                                                    @foreach (array_slice($products, 0, 3) as $productId)
                                                        @php $product = \App\Models\Product::find($productId); @endphp
                                                        @if ($product)
                                                            <li>{{ Str::limit($product->name, 15) }}
                                                                (₹{{ number_format($product->price, 0) }})</li>
                                                        @endif
                                                    @endforeach
                                                    @if (count($products) > 3)
                                                        <li style="color:#6c757d;">+{{ count($products) - 3 }} more</li>
                                                    @endif
                                                </ul>
                                            @else
                                                <span style="font-size:9px; color:#6c757d;">No products</span>
                                            @endif
                                        </div>

                                        <div class="mb-1">
                                            <small style="font-size:9px;">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($offer->start_date)->format('d M Y') }}
                                                <i class="fas fa-arrow-right mx-1"></i>
                                                {{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}
                                                @if (\Carbon\Carbon::now()->gt($offer->end_date))
                                                    <span class="badge bg-danger"
                                                        style="font-size:7px; padding:1px 4px;">Expired</span>
                                                @endif
                                            </small>
                                        </div>

                                        <div class="mb-1">
                                            <small style="font-size:9px; color:#6c757d;">
                                                <i class="fas fa-users me-1"></i>
                                                Used: {{ $offer->usage_count }}
                                                @if ($offer->usage_limit_total)
                                                    / {{ $offer->usage_limit_total }}
                                                @else
                                                    / ∞
                                                @endif
                                                @if ($offer->usage_limit_per_user)
                                                    <span class="ms-2">| Per user:
                                                        {{ $offer->usage_limit_per_user }}</span>
                                                @endif
                                            </small>
                                        </div>

                                        <div class="form-check mt-1" style="padding-left:16px;">
                                            <input type="checkbox" class="form-check-input offer-checkbox"
                                                value="{{ $offer->id }}" onchange="updateSelectedCount()"
                                                style="width:12px; height:12px; margin-top:1px;">
                                            <label class="form-check-label" style="font-size:9px;">Select</label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.offers.edit', $offer->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="duplicateOffer({{ $offer->id }})" title="Duplicate">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-{{ $offer->status == 'active' ? 'warning' : 'success' }}"
                                                onclick="toggleOffer({{ $offer->id }})"
                                                title="{{ $offer->status == 'active' ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas fa-{{ $offer->status == 'active' ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteOffer({{ $offer->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12" style="padding:0 5px;">
                            <div class="text-center py-3">
                                <i class="fas fa-tags fa-2x text-muted mb-2"></i>
                                <h6 style="font-size:14px;">No Combo Offers Found</h6>
                                <p style="font-size:12px; color:#6c757d;">Create your first combo offer.</p>
                                <a href="{{ route('admin.offers.create') }}" class="btn btn-primary"
                                    style="font-size:12px; padding:4px 12px;">
                                    <i class="fas fa-plus me-1"></i> Create Combo
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($offers->count() > 0)
                    <div class="d-flex justify-content-center mt-2">
                        {{ $offers->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
    <!-- ===== END MAIN CONTENT WRAPPER ===== -->

    <script>
        var csrfToken = '{{ csrf_token() }}';

        function showToast(message, type) {
            var toast = document.createElement('div');
            toast.className = 'alert alert-' + (type || 'success') + ' alert-dismissible fade show';
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.style.minWidth = '200px';
            toast.style.fontSize = '11px';
            toast.style.padding = '6px 12px';
            toast.innerHTML = message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:8px;"></button>';
            document.body.appendChild(toast);
            setTimeout(function() {
                toast.remove();
            }, 3000);
        }

        function filterOffers() {
            var searchTerm = document.getElementById('searchOffers').value.toLowerCase();
            var statusFilter = document.getElementById('filterStatus').value;
            var comboFilter = document.getElementById('filterComboType').value;

            var items = document.querySelectorAll('.offer-item');
            items.forEach(function(item) {
                var status = item.dataset.status;
                var comboType = item.dataset.comboType;
                var name = item.dataset.name;
                var code = item.dataset.code;

                var matchStatus = !statusFilter || status === statusFilter;
                var matchCombo = !comboFilter || comboType === comboFilter;
                var matchSearch = !searchTerm || name.includes(searchTerm) || code.includes(searchTerm);

                item.style.display = (matchStatus && matchCombo && matchSearch) ? '' : 'none';
            });
        }

        function updateSelectedCount() {
            var checkboxes = document.querySelectorAll('.offer-checkbox:checked');
            var count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count + ' selected';

            var bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            bulkDeleteBtn.style.display = count > 0 ? 'inline-block' : 'none';
        }

        function getSelectedIds() {
            var checkboxes = document.querySelectorAll('.offer-checkbox:checked');
            var ids = [];
            checkboxes.forEach(function(cb) {
                ids.push(parseInt(cb.value));
            });
            return ids;
        }

        function bulkDelete() {
            var ids = getSelectedIds();
            if (ids.length === 0) {
                showToast('Select at least one offer.', 'warning');
                return;
            }
            if (!confirm('Delete ' + ids.length + ' offer(s)?')) return;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.offers.bulk-delete') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function() {
                var response = JSON.parse(xhr.responseText);
                showToast(response.message, response.success ? 'success' : 'danger');
                if (response.success) setTimeout(function() {
                    location.reload();
                }, 1500);
            };
            xhr.send(JSON.stringify({
                ids: ids,
                _token: csrfToken
            }));
        }

        function toggleOffer(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/offers/' + id + '/toggle', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function() {
                var response = JSON.parse(xhr.responseText);
                showToast(response.message, response.success ? 'success' : 'danger');
                if (response.success) setTimeout(function() {
                    location.reload();
                }, 1000);
            };
            xhr.send(JSON.stringify({
                _token: csrfToken
            }));
        }

        function duplicateOffer(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/offers/' + id + '/duplicate', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function() {
                var response = JSON.parse(xhr.responseText);
                showToast(response.message, response.success ? 'success' : 'danger');
                if (response.success) setTimeout(function() {
                    location.reload();
                }, 1000);
            };
            xhr.send(JSON.stringify({
                _token: csrfToken
            }));
        }

        function deleteOffer(id) {
            if (!confirm('Delete this offer?')) return;
            var xhr = new XMLHttpRequest();
            xhr.open('DELETE', '/admin/offers/' + id, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function() {
                var response = JSON.parse(xhr.responseText);
                showToast(response.message, response.success ? 'success' : 'danger');
                if (response.success) setTimeout(function() {
                    location.reload();
                }, 1000);
            };
            xhr.send(JSON.stringify({
                _token: csrfToken
            }));
        }
    </script>
@endsection
