@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i> My Members
                    </h4>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-user me-1"></i> Total: <span id="totalCount">{{ $members->count() }}</span>
                        </span>
                        <span class="badge" style="background: #ffd54f; color: #0d2818;">
                            <i class="fas fa-check-circle me-1"></i> Active: <span id="activeCount">{{ $members->where('status', 'Active')->count() }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">

                @if($members->count() > 0)

                <!-- Search and Filter Section -->
                <div class="row g-3 mb-4">
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: #0d2818; color: white; border: none;">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchMember" placeholder="Search by name, email or phone...">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <select class="form-select" id="filterStatus">
                            <option value="all">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <select class="form-select" id="filterPlan">
                            <option value="all">All Plans</option>
                            <option value="membership">Membership</option>
                            <option value="package">Package</option>
                        </select>
                    </div>
                    <div class="col-md-1 col-lg-2">
                        <button class="btn w-100" style="background: #0d2818; color: white; border-radius: 8px;" onclick="resetFilters()">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="membersTable">
                        <thead style="background: #0d2818; color: white;">
                            <tr>
                                <th width="50">#</th>
                                <th width="70">Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Plan</th>
                                <th>Goal</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody id="membersTableBody">
                            @foreach($members as $key => $member)
                            <tr data-status="{{ $member->status }}" data-plan="{{ $member->plan_type ?? 'none' }}" data-name="{{ strtolower($member->name) }}" data-email="{{ strtolower($member->email) }}" data-phone="{{ $member->phone }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($member->photo)
                                        <img src="{{ asset('storage/'.$member->photo) }}"
                                             width="50"
                                             height="50"
                                             class="rounded-circle border"
                                             style="object-fit: cover;"
                                             alt="{{ $member->name }}">
                                    @else
                                        <div class="avatar-placeholder" style="width: 50px; height: 50px; background: linear-gradient(135deg, #0d2818, #1a472a); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px; margin: 0 auto;">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge" style="background: #1a472a; color: white;">{{ $member->member_id }}</span></td>
                                <td class="member-name"><strong>{{ $member->name }}</strong></td>
                                <td class="member-phone">{{ $member->phone }}</td>
                                <td class="member-plan">
                                    @if($member->plan_type == 'membership')
                                        <span class="badge" style="background: #0d2818; color: #ffd54f;">
                                            <i class="fas fa-id-card me-1"></i> Membership
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $member->membership_plan }}</small>
                                    @elseif($member->plan_type == 'package')
                                        <span class="badge" style="background: #ffd54f; color: #0d2818;">
                                            <i class="fas fa-box me-1"></i> Package
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $member->membership_plan }}</small>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge" style="background: #8b5cf6; color: white;">
                                        {{ $member->goal_type ?? 'Fitness' }}
                                    </span>
                                </td>
                                <td class="member-status">
                                    @if($member->status == 'Active')
                                        <span class="badge" style="background: #10b981; color: white; padding: 5px 15px;">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                        </span>
                                    @else
                                        <span class="badge" style="background: #ef4444; color: white; padding: 5px 15px;">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm" style="background: #0d2818; color: white; border-radius: 8px;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#memberModal{{ $member->id }}">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="text-center py-4" style="display: none;">
                    <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No members found matching your search</h5>
                    <p class="text-muted">Try adjusting your search or filter criteria</p>
                </div>

                <!-- Member Detail Modals -->
                @foreach($members as $member)
                <div class="modal fade" id="memberModal{{ $member->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                                <h5 class="modal-title">
                                    <i class="fas fa-user-circle me-2"></i> Member Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Profile Image -->
                                    <div class="col-md-4 text-center mb-4">
                                        @if($member->photo)
                                            <img src="{{ asset('storage/'.$member->photo) }}"
                                                 class="rounded-circle border"
                                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #ffd54f !important;"
                                                 alt="{{ $member->name }}">
                                        @else
                                            <div style="width: 150px; height: 150px; background: linear-gradient(135deg, #0d2818, #1a472a); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 50px; margin: 0 auto; border: 4px solid #ffd54f;">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <h5 class="mt-3 mb-0">{{ $member->name }}</h5>
                                        <small class="text-muted">{{ $member->member_id }}</small>
                                        <div class="mt-2">
                                            @if($member->status == 'Active')
                                                <span class="badge" style="background: #10b981; color: white; padding: 5px 20px;">
                                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                                </span>
                                            @else
                                                <span class="badge" style="background: #ef4444; color: white; padding: 5px 20px;">
                                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Member Details -->
                                    <div class="col-md-8">
                                        <div class="row g-2">
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Gender</small>
                                                    <strong>{{ $member->gender ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Age</small>
                                                    <strong>{{ $member->age ?? 'N/A' }} years</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">DOB</small>
                                                    <strong>{{ $member->dob ? date('d M Y', strtotime($member->dob)) : 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Phone</small>
                                                    <strong>{{ $member->phone }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Email</small>
                                                    <strong>{{ $member->email }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Join Date</small>
                                                    <strong>{{ $member->join_date ? date('d M Y', strtotime($member->join_date)) : 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Height</small>
                                                    <strong>{{ $member->height ?? 'N/A' }} cm</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Weight</small>
                                                    <strong>{{ $member->weight ?? 'N/A' }} kg</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">BMI</small>
                                                    <strong>{{ $member->bmi ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Goal</small>
                                                    <strong>{{ $member->goal_type ?? 'Fitness' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Plan Type</small>
                                                    <strong>{{ ucfirst($member->plan_type ?? 'N/A') }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Plan Name</small>
                                                    <strong>{{ $member->membership_plan ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Duration</small>
                                                    <strong>{{ $member->membership_duration ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Final Price</small>
                                                    <strong>₹{{ number_format($member->final_price ?? 0, 2) }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Emergency Contact</small>
                                                    <strong>{{ $member->emergency_contact ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Address</small>
                                                    <strong>{{ $member->address ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="info-item" style="background: #f8fafc; padding: 10px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                    <small class="text-muted d-block">Medical Issues</small>
                                                    <strong>{{ $member->medical_issues ?? 'None' }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" style="background: #0d2818; color: white; border-radius: 25px; padding: 8px 30px;" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i> Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @else
                <div class="alert" style="background: rgba(13, 40, 24, 0.05); border-left: 4px solid #1a472a; border-radius: 10px;">
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">No members have been assigned to you.</h5>
                        <p class="text-muted">Members assigned to you will appear here.</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all elements
    const searchInput = document.getElementById('searchMember');
    const filterStatus = document.getElementById('filterStatus');
    const filterPlan = document.getElementById('filterPlan');
    const tableBody = document.getElementById('membersTableBody');
    const noResults = document.getElementById('noResults');
    const totalCount = document.getElementById('totalCount');
    const activeCount = document.getElementById('activeCount');
    
    if (!tableBody) return;
    
    const rows = tableBody.getElementsByTagName('tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusFilter = filterStatus.value;
        const planFilter = filterPlan.value;
        
        let visibleCount = 0;
        let activeVisibleCount = 0;
        
        for (let row of rows) {
            // Get data from data attributes
            const name = row.getAttribute('data-name') || '';
            const email = row.getAttribute('data-email') || '';
            const phone = row.getAttribute('data-phone') || '';
            const status = row.getAttribute('data-status') || '';
            const plan = row.getAttribute('data-plan') || '';
            
            // Check search match
            const matchesSearch = searchTerm === '' || 
                                 name.includes(searchTerm) || 
                                 email.includes(searchTerm) || 
                                 phone.includes(searchTerm);
            
            // Check status filter
            const matchesStatus = statusFilter === 'all' || status === statusFilter;
            
            // Check plan filter
            const matchesPlan = planFilter === 'all' || plan === planFilter;
            
            // Show/hide row
            if (matchesSearch && matchesStatus && matchesPlan) {
                row.style.display = '';
                visibleCount++;
                if (status === 'Active') {
                    activeVisibleCount++;
                }
            } else {
                row.style.display = 'none';
            }
        }
        
        // Update counts
        if (totalCount) totalCount.textContent = visibleCount;
        if (activeCount) activeCount.textContent = activeVisibleCount;
        
        // Show/hide no results message
        if (noResults) {
            if (visibleCount === 0 && rows.length > 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
    }
    
    // Event listeners - auto filter on each change
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    if (filterStatus) {
        filterStatus.addEventListener('change', filterTable);
    }
    if (filterPlan) {
        filterPlan.addEventListener('change', filterTable);
    }
    
    // Initial filter
    filterTable();
});

// Reset function
function resetFilters() {
    document.getElementById('searchMember').value = '';
    document.getElementById('filterStatus').value = 'all';
    document.getElementById('filterPlan').value = 'all';
    
    // Trigger filter
    const searchInput = document.getElementById('searchMember');
    const filterStatus = document.getElementById('filterStatus');
    const filterPlan = document.getElementById('filterPlan');
    
    // Use custom event to trigger filter
    if (searchInput) {
        searchInput.dispatchEvent(new Event('input'));
    }
    if (filterStatus) {
        filterStatus.dispatchEvent(new Event('change'));
    }
    if (filterPlan) {
        filterPlan.dispatchEvent(new Event('change'));
    }
}
</script>
@endpush

@push('styles')
<style>
    /* Custom Scrollbar */
    .modal-content::-webkit-scrollbar {
        width: 6px;
    }
    .modal-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .modal-content::-webkit-scrollbar-thumb {
        background: #1a472a;
        border-radius: 10px;
    }
    .modal-content::-webkit-scrollbar-thumb:hover {
        background: #0d2818;
    }

    /* Table hover effect */
    .table-hover tbody tr:hover {
        background: rgba(13, 40, 24, 0.03);
        transition: all 0.3s ease;
    }
    
    /* Table row transition */
    .table-hover tbody tr {
        transition: all 0.3s ease;
    }

    /* Responsive fixes */
    @media (max-width: 768px) {
        .card-header .d-flex {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start !important;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-body .row > .col-md-4 {
            margin-bottom: 20px;
        }
        
        .info-item {
            padding: 8px 12px !important;
        }
        
        .btn.w-100 {
            padding: 8px 10px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .btn-sm {
            padding: 3px 8px;
            font-size: 0.7rem;
        }
        
        .badge {
            font-size: 0.65rem;
        }
        
        .avatar-placeholder {
            width: 35px !important;
            height: 35px !important;
            font-size: 14px !important;
        }
        
        .input-group .form-control {
            font-size: 0.85rem;
        }
        
        .form-select {
            font-size: 0.85rem;
            padding: 6px 10px;
        }
        
        .modal-body {
            padding: 15px;
        }
        
        .modal-dialog {
            margin: 5px;
        }
    }
    
    /* Search input focus effect */
    #searchMember:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.25);
    }
    
    /* Select focus effect */
    .form-select:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.25);
    }
</style>
@endpush