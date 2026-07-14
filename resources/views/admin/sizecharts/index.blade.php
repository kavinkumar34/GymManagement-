@extends('layouts.admin-layout')

@section('content')
<style>
    .container-fluid {
        margin-left: 100px;
        padding: 20px;
    }
    .card {
        max-width: 1200px;
        margin: 0 auto;
    }
    .badge-gender-men { background: #0d6efd; color: white; }
    .badge-gender-women { background: #dc3545; color: white; }
    .badge-gender-kids { background: #ffc107; color: #212529; }
    .badge-gender-unisex { background: #6f42c1; color: white; }
    .badge-category-topwear { background: #198754; color: white; }
    .badge-category-bottomwear { background: #fd7e14; color: white; }
    .badge-category-footwear { background: #0dcaf0; color: #212529; }
    .action-btns .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }
    .action-btns .btn-view {
        background: #e7f3ff;
        color: #0d6efd;
        border: 1px solid #b6d4fe;
    }
    .action-btns .btn-view:hover {
        background: #0d6efd;
        color: white;
    }
    .action-btns .btn-edit {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffe69c;
    }
    .action-btns .btn-edit:hover {
        background: #856404;
        color: white;
    }
    .action-btns .btn-delete {
        background: #f8d7da;
        color: #dc3545;
        border: 1px solid #f5c2c7;
    }
    .action-btns .btn-delete:hover {
        background: #dc3545;
        color: white;
    }
    .size-chart-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    .size-chart-placeholder {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 16px;
    }
    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 20px 25px;
        background: #f8f9fa;
        border-radius: 16px 16px 0 0;
    }
    .modal-header .modal-title {
        font-weight: 700;
        font-size: 18px;
    }
    .modal-body {
        padding: 25px;
    }
    .detail-row {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: #1a1a2e;
    }
    .size-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .size-table th {
        background: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }
    .size-table td {
        padding: 8px 10px;
        border: 1px solid #dee2e6;
        text-align: center;
        font-size: 13px;
    }
    .size-table tr:hover {
        background: #f8f9fa;
    }
    .size-table .size-label {
        font-weight: 600;
        color: #0d6efd;
    }
    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 15px 25px;
        background: #f8f9fa;
        border-radius: 0 0 16px 16px;
    }
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }
    .modal-image {
        max-height: 200px;
        width: 100%;
        object-fit: contain;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
    }
</style>

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2 text-primary"></i>
                Size Charts
                <span class="badge bg-secondary ms-2">{{ $sizeCharts->total() }}</span>
            </h5>
            <a href="{{ route('admin.sizecharts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Size Chart
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="60">Image</th>
                            <th>Title</th>
                            <th>Gender</th>
                            <th>Category Type</th>
                            <th>Sizes</th>
                            <th width="140">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizeCharts as $chart)
                        <tr>
                            <td class="text-muted">#{{ $chart->id }}</td>
                            <td>
                                @if($chart->image)
                                    <img src="{{ asset('storage/'.$chart->image) }}" class="size-chart-image" alt="{{ $chart->title }}">
                                @else
                                    <div class="size-chart-placeholder">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $chart->title }}</strong>
                                @php
                                    $sizesCount = 0;
                                    if ($chart->sizes) {
                                        if (is_array($chart->sizes)) {
                                            $sizesCount = count($chart->sizes);
                                        } else {
                                            $sizesCount = count(json_decode($chart->sizes, true) ?: []);
                                        }
                                    }
                                @endphp
                                <br>
                                <small class="text-muted">{{ $sizesCount }} size(s)</small>
                            </td>
                            <td>
                                @php
                                    $genderColors = [
                                        'men' => 'badge-gender-men',
                                        'women' => 'badge-gender-women',
                                        'kids' => 'badge-gender-kids',
                                        'unisex' => 'badge-gender-unisex'
                                    ];
                                @endphp
                                <span class="badge {{ $genderColors[$chart->gender] ?? 'bg-secondary' }}">
                                    {{ ucfirst($chart->gender ?? 'Unisex') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $categoryColors = [
                                        'topwear' => 'badge-category-topwear',
                                        'bottomwear' => 'badge-category-bottomwear',
                                        'footwear' => 'badge-category-footwear'
                                    ];
                                @endphp
                                <span class="badge {{ $categoryColors[$chart->category_type] ?? 'bg-secondary' }}">
                                    {{ ucfirst($chart->category_type ?? 'Topwear') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    <i class="fas fa-ruler me-1"></i> {{ $sizesCount }}
                                </span>
                                @if($chart->default_unit)
                                    <br>
                                    <small class="text-muted">Unit: {{ strtoupper($chart->default_unit) }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns d-flex gap-1">
                                    <!-- View Button -->
                                    <button class="btn btn-view" onclick="viewSizeChart({{ $chart->id }})" title="View Size Chart">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.sizecharts.edit', $chart->id) }}" class="btn btn-edit" title="Edit Size Chart">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <button class="btn btn-delete" onclick="deleteItem({{ $chart->id }})" title="Delete Size Chart">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $chart->id }}" action="{{ route('admin.sizecharts.destroy', $chart->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3 d-block"></i>
                                <h6 class="text-muted">No size charts found</h6>
                                <a href="{{ route('admin.sizecharts.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i> Add First Size Chart
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Showing {{ $sizeCharts->firstItem() ?? 0 }} to {{ $sizeCharts->lastItem() ?? 0 }} of {{ $sizeCharts->total() }} size charts
                    </small>
                </div>
                <div>
                    {{ $sizeCharts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Size Chart Modal -->
<div class="modal fade" id="viewSizeChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    <span id="modalChartTitle">Size Chart Details</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalChartBody">
                <div class="loading-spinner">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading size chart details...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
                <a href="#" id="editSizeChartBtn" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Size Chart
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Are you sure you want to delete this size chart? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function viewSizeChart(id) {
    var modal = new bootstrap.Modal(document.getElementById('viewSizeChartModal'));
    var body = document.getElementById('modalChartBody');
    var title = document.getElementById('modalChartTitle');
    
    body.innerHTML = `
        <div class="loading-spinner">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading size chart details...</p>
            </div>
        </div>
    `;
    
    modal.show();
    
    fetch(`/admin/size-charts/${id}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var chart = data.sizeChart;
            title.textContent = chart.title + ' - Size Chart Details';
            
            var sizes = chart.sizes || [];
            var fieldNames = {
                'topwear': ['Size', 'Chest', 'Waist', 'Length', 'Sleeve'],
                'bottomwear': ['Size', 'Waist', 'Length', 'Inseam'],
                'footwear': ['Size', 'Length', 'Width', 'Heel']
            };
            
            var fields = fieldNames[chart.category_type] || ['Size'];
            var sizeHtml = '';
            
            if (sizes.length > 0) {
                sizeHtml = `
                    <div class="table-responsive mt-3">
                        <table class="size-table">
                            <thead>
                                <tr>
                                    ${fields.map(function(field) {
                                        return `<th>${field}</th>`;
                                    }).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                ${sizes.map(function(size) {
                                    var rowData = fields.map(function(field) {
                                        var fieldKey = field.toLowerCase();
                                        if (fieldKey === 'size') {
                                            return `<td><span class="size-label">${size.size || '-'}</span></td>`;
                                        }
                                        return `<td>${size[fieldKey] || '-'}</td>`;
                                    }).join('');
                                    return `<tr>${rowData}</tr>`;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            } else {
                sizeHtml = `<p class="text-muted text-center py-3">No size measurements available</p>`;
            }
            
            var genderColors = {
                'men': 'badge-gender-men',
                'women': 'badge-gender-women',
                'kids': 'badge-gender-kids',
                'unisex': 'badge-gender-unisex'
            };
            
            var categoryColors = {
                'topwear': 'badge-category-topwear',
                'bottomwear': 'badge-category-bottomwear',
                'footwear': 'badge-category-footwear'
            };
            
            var categoryLabels = {
                'topwear': 'Topwear',
                'bottomwear': 'Bottomwear',
                'footwear': 'Footwear'
            };
            
            body.innerHTML = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        ${chart.image ? 
                            `<img src="/storage/${chart.image}" class="modal-image" alt="${chart.title}">` :
                            `<div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="height:200px; width:100%;">
                                <i class="fas fa-chart-line fa-3x"></i>
                            </div>`
                        }
                    </div>
                    <div class="col-md-8">
                        <h5>${chart.title}</h5>
                        <div class="mb-3">
                            <span class="badge ${genderColors[chart.gender] || 'bg-secondary'} me-2">
                                ${chart.gender ? chart.gender.charAt(0).toUpperCase() + chart.gender.slice(1) : 'Unisex'}
                            </span>
                            <span class="badge ${categoryColors[chart.category_type] || 'bg-secondary'}">
                                ${categoryLabels[chart.category_type] || chart.category_type || 'Topwear'}
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-row">
                                    <div class="detail-label">Default Unit</div>
                                    <div class="detail-value">${chart.default_unit ? chart.default_unit.toUpperCase() : 'in'}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-row">
                                    <div class="detail-label">Total Sizes</div>
                                    <div class="detail-value">${sizes.length}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-row">
                                    <div class="detail-label">Created At</div>
                                    <div class="detail-value">${new Date(chart.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' })}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-row">
                                    <div class="detail-label">Last Updated</div>
                                    <div class="detail-value">${new Date(chart.updated_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' })}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h6 class="mt-2">
                    <i class="fas fa-ruler me-2 text-primary"></i> 
                    Size Measurements 
                    <small class="text-muted">(${chart.category_type ? categoryLabels[chart.category_type] : 'Topwear'})</small>
                </h6>
                ${sizeHtml}
            `;
            
            // Set edit button link
            document.getElementById('editSizeChartBtn').href = `/admin/sizecharts/${chart.id}/edit`;
            
        } else {
            body.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                    <h6 class="text-danger">Error loading size chart details</h6>
                    <p class="text-muted">${data.message || 'Please try again later'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        body.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                <h6 class="text-danger">Error loading size chart details</h6>
                <p class="text-muted">Please try again later</p>
            </div>
        `;
        console.error('Error:', error);
    });
}
</script>
@endsection