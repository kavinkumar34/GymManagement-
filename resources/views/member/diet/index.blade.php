@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="diet-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="diet-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-utensils me-2"></i> My Diet Plans
                        </h4>
                        <span class="diet-count">
                            <i class="fas fa-list me-1"></i>
                            {{ $dietPlans->count() }} Plan(s)
                        </span>
                    </div>
                </div>
                
                <div class="diet-card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($dietPlans->count())
                        <div class="row g-4">
                            @foreach($dietPlans as $diet)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                    <div class="diet-card">
                                        <!-- Diet Header -->
                                        <div class="diet-card-header-section">
                                            <h5 class="diet-title">
                                                <i class="fas fa-apple-alt me-2"></i>
                                                {{ $diet->title }}
                                            </h5>
                                            <span class="diet-status-badge {{ strtolower($diet->status) }}">
                                                <i class="fas fa-circle me-1"></i>
                                                {{ $diet->status }}
                                            </span>
                                        </div>

                                        <!-- Diet Body -->
                                        <div class="diet-card-body">
                                            <div class="diet-info-grid">
                                                <div class="info-item">
                                                    <span class="info-label">
                                                        <i class="fas fa-bullseye me-1"></i> Goal
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $diet->goal ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">
                                                        <i class="fas fa-user-tie me-1"></i> Trainer
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $diet->trainer->name ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">
                                                        <i class="fas fa-calendar-alt me-1"></i> Start Date
                                                    </span>
                                                    <span class="info-value">
                                                        {{ \Carbon\Carbon::parse($diet->start_date)->format('d M Y') }}
                                                    </span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">
                                                        <i class="fas fa-calendar-check me-1"></i> End Date
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $diet->end_date ? \Carbon\Carbon::parse($diet->end_date)->format('d M Y') : 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            @if($diet->description)
                                                <p class="diet-description">
                                                    <i class="fas fa-align-left me-1"></i>
                                                    {{ Str::limit($diet->description, 60) }}
                                                </p>
                                            @endif

                                            <!-- Meal Count -->
                                            <div class="meal-count">
                                                <i class="fas fa-utensils me-1"></i>
                                                {{ $diet->meals->count() }} Meal(s)
                                            </div>
                                        </div>

                                        <!-- Diet Footer -->
                                        <div class="diet-card-footer">
                                            <a href="{{ route('member.diet.show', $diet->id) }}" class="btn-view-diet">
                                                <i class="fas fa-eye me-2"></i> View Details
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if(method_exists($dietPlans, 'links'))
                            <div class="pagination-wrapper">
                                {{ $dietPlans->links() }}
                            </div>
                        @endif
                        
                    @else
                        <div class="empty-state">
                            <i class="fas fa-utensils fa-4x"></i>
                            <h5>No Diet Plans Assigned</h5>
                            <p>You haven't been assigned any diet plans yet.</p>
                            <p class="text-muted small">Please contact your trainer for a diet plan.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.diet-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.diet-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.diet-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.diet-card-header h4 i {
    color: #ffd54f;
}

.diet-count {
    background: rgba(255, 255, 255, 0.15);
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.diet-card-body {
    padding: 24px;
}

/* ============================================ */
/* DIET CARD - Professional Design              */
/* ============================================ */
.diet-card {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.diet-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(13, 27, 62, 0.12);
}

/* ============================================ */
/* DIET HEADER SECTION                          */
/* ============================================ */
.diet-card-header-section {
    padding: 18px 20px 12px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
}

.diet-title {
    color: #0d1b3e;
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0;
    flex: 1;
}

.diet-title i {
    color: #10b981;
}

.diet-status-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.diet-status-badge.active {
    background: #ecfdf5;
    color: #065f46;
}

.diet-status-badge.active i {
    color: #10b981;
}

.diet-status-badge.completed {
    background: #f0f4ff;
    color: #1a2a6c;
}

.diet-status-badge.completed i {
    color: #1a2a6c;
}

.diet-status-badge.cancelled {
    background: #fef2f2;
    color: #991b1b;
}

.diet-status-badge.cancelled i {
    color: #ef4444;
}

/* ============================================ */
/* DIET BODY                                    */
/* ============================================ */
.diet-card-body {
    padding: 16px 20px;
    flex: 1;
}

.diet-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 20px;
    margin-bottom: 12px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.info-label i {
    color: #1a2a6c;
}

.info-value {
    font-size: 0.85rem;
    font-weight: 600;
    color: #0d1b3e;
    margin-top: 1px;
}

/* ============================================ */
/* DIET DESCRIPTION                             */
/* ============================================ */
.diet-description {
    color: #64748b;
    font-size: 0.85rem;
    line-height: 1.5;
    margin-bottom: 10px;
    padding: 8px 12px;
    background: #f8fafc;
    border-radius: 6px;
    border-left: 3px solid #10b981;
}

.diet-description i {
    color: #10b981;
}

/* ============================================ */
/* MEAL COUNT                                   */
/* ============================================ */
.meal-count {
    font-size: 0.8rem;
    color: #64748b;
    padding: 6px 12px;
    background: #f8fafc;
    border-radius: 8px;
    display: inline-block;
}

.meal-count i {
    color: #1a2a6c;
}

/* ============================================ */
/* DIET FOOTER                                  */
/* ============================================ */
.diet-card-footer {
    padding: 14px 20px 20px;
    background: #f8fafc;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.btn-view-diet {
    width: 100%;
    padding: 10px 16px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-view-diet:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 27, 62, 0.25);
    color: #ffffff;
}

.btn-view-diet i {
    color: #ffd54f;
}

/* ============================================ */
/* ALERTS - Custom Colors                       */
/* ============================================ */
.alert-custom-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
    border-radius: 10px;
    padding: 12px 18px;
}

/* ============================================ */
/* EMPTY STATE                                  */
/* ============================================ */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed rgba(13, 27, 62, 0.08);
}

.empty-state i {
    color: #94a3b8;
    margin-bottom: 12px;
}

.empty-state h5 {
    color: #0d1b3e;
    font-weight: 600;
}

.empty-state p {
    color: #94a3b8;
    margin-bottom: 0;
}

/* ============================================ */
/* PAGINATION                                   */
/* ============================================ */
.pagination-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.pagination-wrapper .pagination {
    gap: 4px;
    margin-bottom: 0;
}

.pagination-wrapper .page-item .page-link {
    color: #0d1b3e;
    border: 1px solid rgba(13, 27, 62, 0.08);
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    border-color: #0d1b3e;
    color: #ffffff;
}

.pagination-wrapper .page-item .page-link:hover {
    background: rgba(13, 27, 62, 0.05);
    border-color: #0d1b3e;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .diet-info-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 768px) {
    .diet-card-header {
        padding: 14px 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .diet-card-header h4 {
        font-size: 1rem;
    }
    
    .diet-card-body {
        padding: 16px;
    }
    
    .diet-card-header-section {
        padding: 14px 16px 10px;
        flex-direction: column;
        gap: 8px;
    }
    
    .diet-title {
        font-size: 1rem;
    }
    
    .diet-info-grid {
        grid-template-columns: 1fr 1fr;
        gap: 6px 12px;
    }
    
    .info-value {
        font-size: 0.8rem;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
    
    .pagination-wrapper .page-item .page-link {
        padding: 4px 10px;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .diet-info-grid {
        grid-template-columns: 1fr;
        gap: 6px;
    }
    
    .diet-card-footer {
        padding: 12px 16px 16px;
    }
    
    .btn-view-diet {
        font-size: 0.85rem;
        padding: 8px 14px;
    }
    
    .diet-count {
        font-size: 0.75rem;
        padding: 2px 10px;
    }
    
    .diet-description {
        font-size: 0.8rem;
    }
}

/* ============================================ */
/* ANIMATIONS                                   */
/* ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.diet-card {
    animation: fadeInUp 0.5s ease forwards;
}

.diet-card:nth-child(1) { animation-delay: 0.05s; }
.diet-card:nth-child(2) { animation-delay: 0.1s; }
.diet-card:nth-child(3) { animation-delay: 0.15s; }
.diet-card:nth-child(4) { animation-delay: 0.2s; }
.diet-card:nth-child(5) { animation-delay: 0.25s; }
.diet-card:nth-child(6) { animation-delay: 0.3s; }
</style>
@endsection