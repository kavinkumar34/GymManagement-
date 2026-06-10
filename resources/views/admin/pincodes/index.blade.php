@extends('layouts.app')

@section('content')
<style>
    .container {
        margin-left: 200px;
        max-width: calc(100% - 220px);
        min-height: 100vh;
        padding-bottom: 2rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .shipping-amount {
        font-weight: bold;
        color: #10b981;
    }
    body {
        margin-bottom: 0;
    }
    footer {
        display: none;
    }
    .select-all-checkbox {
        cursor: pointer;
    }
    .bulk-actions-bar {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .bulk-actions-bar.show {
        display: flex;
    }
    .selected-count {
        background: #3b82f6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
    .bulk-shipping-input {
        width: 120px;
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }
    .btn-bulk-update {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
    }
    .btn-bulk-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
    }
    .state-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-truck"></i> Deliverable States & Shipping Charges</h4>
            <div>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                    <i class="fas fa-upload"></i> Bulk Import
                </button>
                <a href="{{ route('admin.pincodes.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add State
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="bulk-actions-bar">
                <span class="selected-count" id="selectedCount">0 selected</span>
                <input type="number" id="bulkShippingCharge" class="bulk-shipping-input" placeholder="Shipping charge" step="0.01" min="0">
                <button class="btn-bulk-update" onclick="bulkUpdateShipping()">
                    <i class="fas fa-edit"></i> Update Shipping
                </button>
                <button class="btn-bulk-delete" onclick="bulkDeleteStates()">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
                <button class="btn btn-secondary btn-sm" onclick="clearSelection()">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
            
            <div class="table-responsive">
                <form id="bulkForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="selectAllCheckbox" class="select-all-checkbox" onclick="toggleSelectAll()">
                                </th>
                                <th width="5%">ID</th>
                                <th width="35%">State Name</th>
                                <th width="20%">Shipping Charge</th>
                                <th width="15%">Status</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pincodes as $pincode)
                            <tr id="row-{{ $pincode->id }}">
                                <td class="text-center">
                                    <input type="checkbox" class="state-checkbox" value="{{ $pincode->id }}" data-state="{{ $pincode->state }}" data-shipping="{{ $pincode->shipping_charge }}" onclick="updateSelectedCount()">
                                </td>
                                <td>{{ $pincode->id }}</td>
                                <td><strong>{{ $pincode->state }}</strong></td>
                                <td>
                                    <span class="shipping-amount" id="shipping-{{ $pincode->id }}">₹{{ number_format($pincode->shipping_charge, 2) }}</span>
                                </td>
                                <td>
                                    @if($pincode->is_active)
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pincodes.edit', $pincode->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pincodes.destroy', $pincode->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this state?')" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No states found. Click "Add State" to add one.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>
            
            <div class="mt-3">
                {{ $pincodes->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Bulk Import Modal -->
<div class="modal fade" id="bulkImportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pincodes.bulk') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-upload"></i> Bulk Import States</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Enter States (One per line)</label>
                        <textarea name="states" class="form-control" rows="10" placeholder="Format: State Name|shipping_charge
Tamil Nadu|50
Karnataka|70
Maharashtra|80
Kerala|60
Delhi|100

OR just state name (shipping charge will be 0):
Tamil Nadu
Karnataka
Maharashtra"></textarea>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle"></i> 
                            Format: <strong>State Name|shipping_charge</strong> (separate with pipe |)<br>
                            Example: Tamil Nadu|50 , Karnataka|70
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import States</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
let selectedStates = [];

// Toggle select all checkboxes
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.state-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelectedCount();
}

// Update selected count and show/hide bulk actions bar
function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.state-checkbox:checked');
    const count = checkboxes.length;
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkBar = document.getElementById('bulkActionsBar');
    
    selectedStates = [];
    checkboxes.forEach(checkbox => {
        selectedStates.push({
            id: checkbox.value,
            state: checkbox.getAttribute('data-state'),
            shipping: checkbox.getAttribute('data-shipping')
        });
    });
    
    if (count > 0) {
        selectedCountSpan.innerHTML = count + ' selected';
        bulkBar.classList.add('show');
    } else {
        bulkBar.classList.remove('show');
    }
}

// Clear all selections
function clearSelection() {
    const checkboxes = document.querySelectorAll('.state-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllCheckbox').checked = false;
    updateSelectedCount();
}

// Bulk update shipping charges
async function bulkUpdateShipping() {
    const shippingCharge = document.getElementById('bulkShippingCharge').value;
    
    if (!shippingCharge) {
        alert('Please enter a shipping charge amount');
        return;
    }
    
    if (selectedStates.length === 0) {
        alert('Please select at least one state');
        return;
    }
    
    if (!confirm(`Update shipping charge to ₹${shippingCharge} for ${selectedStates.length} state(s)?`)) {
        return;
    }
    
    const updateBtn = document.querySelector('.btn-bulk-update');
    const originalText = updateBtn.innerHTML;
    updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    updateBtn.disabled = true;
    
    try {
        const response = await fetch('/admin/pincodes/bulk-update-shipping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                state_ids: selectedStates.map(s => s.id),
                shipping_charge: shippingCharge
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update the displayed shipping amounts
            selectedStates.forEach(state => {
                const shippingSpan = document.getElementById(`shipping-${state.id}`);
                if (shippingSpan) {
                    shippingSpan.innerHTML = '₹' + parseFloat(shippingCharge).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            });
            
            alert(`Successfully updated ${selectedStates.length} state(s)!`);
            clearSelection();
            document.getElementById('bulkShippingCharge').value = '';
        } else {
            alert(data.message || 'Error updating shipping charges');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Network error. Please try again.');
    } finally {
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
    }
}

// Bulk delete states
async function bulkDeleteStates() {
    if (selectedStates.length === 0) {
        alert('Please select at least one state');
        return;
    }
    
    if (!confirm(`Are you sure you want to delete ${selectedStates.length} state(s)? This action cannot be undone.`)) {
        return;
    }
    
    const deleteBtn = document.querySelector('.btn-bulk-delete');
    const originalText = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    deleteBtn.disabled = true;
    
    try {
        const response = await fetch('/admin/pincodes/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                state_ids: selectedStates.map(s => s.id)
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove the rows from the table
            selectedStates.forEach(state => {
                const row = document.getElementById(`row-${state.id}`);
                if (row) {
                    row.remove();
                }
            });
            
            alert(`Successfully deleted ${selectedStates.length} state(s)!`);
            clearSelection();
            
            // Reload page if no rows left
            const remainingRows = document.querySelectorAll('.state-checkbox').length;
            if (remainingRows === 0) {
                location.reload();
            }
        } else {
            alert(data.message || 'Error deleting states');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Network error. Please try again.');
    } finally {
        deleteBtn.innerHTML = originalText;
        deleteBtn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Deliverable states page loaded');
});
</script>
@endsection