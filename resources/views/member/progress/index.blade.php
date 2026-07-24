@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="progress-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="progress-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i> My Progress
                        </h4>
                        <span class="progress-count">
                            <i class="fas fa-list me-1"></i>
                            {{ $progress->total() }} Record(s)
                        </span>
                    </div>
                </div>
                
                <div class="progress-card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($progress->count())
                        <div class="table-responsive">
                            <table class="progress-table">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="50">S.No</th>
                                        <th>Date</th>
                                        <th>Trainer</th>
                                        <th>Weight</th>
                                        <th>Height</th>
                                        <th>BMI</th>
                                        <th>Body Fat %</th>
                                        <th>Chest</th>
                                        <th>Waist</th>
                                        <th class="text-center" width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($progress as $row)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="date-cell">
                                                    <i class="fas fa-calendar-day me-1"></i>
                                                    {{ date('d-m-Y', strtotime($row->progress_date)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="trainer-name">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $row->trainer->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="weight-value">{{ $row->weight }} <small>Kg</small></span>
                                            </td>
                                            <td>{{ $row->height }} <small>cm</small></td>
                                            <td>
                                                <span class="bmi-badge">{{ $row->bmi }}</span>
                                            </td>
                                            <td>{{ $row->body_fat }} <small>%</small></td>
                                            <td>{{ $row->chest }}</td>
                                            <td>{{ $row->waist }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-view" data-bs-toggle="modal" data-bs-target="#progressModal{{ $row->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn-chart" data-bs-toggle="modal" data-bs-target="#chartModal{{ $row->member_id }}">
                                                        <i class="fas fa-chart-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Progress Modal -->
                                        <div class="modal fade" id="progressModal{{ $row->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-user me-2"></i> Progress Details
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Basic Info -->
                                                        <div class="modal-info-grid">
                                                            <div class="modal-info-item">
                                                                <span class="modal-label">Date</span>
                                                                <span class="modal-value">{{ date('d-m-Y', strtotime($row->progress_date)) }}</span>
                                                            </div>
                                                            <div class="modal-info-item">
                                                                <span class="modal-label">Trainer</span>
                                                                <span class="modal-value">{{ $row->trainer->name ?? '-' }}</span>
                                                            </div>
                                                            <div class="modal-info-item">
                                                                <span class="modal-label">Weight</span>
                                                                <span class="modal-value">{{ $row->weight }} Kg</span>
                                                            </div>
                                                            <div class="modal-info-item">
                                                                <span class="modal-label">Height</span>
                                                                <span class="modal-value">{{ $row->height }} cm</span>
                                                            </div>
                                                            <div class="modal-info-item">
                                                                <span class="modal-label">BMI</span>
                                                                <span class="modal-value">{{ $row->bmi }}</span>
                                                            </div>
                                                            <div class="modal-info-item">
                                                                <span class="modal-label">Body Fat</span>
                                                                <span class="modal-value">{{ $row->body_fat }} %</span>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <!-- Body Measurements -->
                                                        <h6 class="measurement-title"><i class="fas fa-ruler-combined me-2"></i>Body Measurements</h6>
                                                        <div class="measurement-grid">
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Chest</span>
                                                                <span class="measurement-value">{{ $row->chest }}</span>
                                                            </div>
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Waist</span>
                                                                <span class="measurement-value">{{ $row->waist }}</span>
                                                            </div>
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Hips</span>
                                                                <span class="measurement-value">{{ $row->hips }}</span>
                                                            </div>
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Left Arm</span>
                                                                <span class="measurement-value">{{ $row->left_arm }}</span>
                                                            </div>
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Right Arm</span>
                                                                <span class="measurement-value">{{ $row->right_arm }}</span>
                                                            </div>
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Left Thigh</span>
                                                                <span class="measurement-value">{{ $row->left_thigh }}</span>
                                                            </div>
                                                            <div class="measurement-item">
                                                                <span class="measurement-label">Right Thigh</span>
                                                                <span class="measurement-value">{{ $row->right_thigh }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Notes -->
                                                        @if($row->notes)
                                                            <div class="modal-notes">
                                                                <h6><i class="fas fa-sticky-note me-2"></i>Notes</h6>
                                                                <p>{{ $row->notes }}</p>
                                                            </div>
                                                        @endif

                                                        <!-- Photos -->
                                                        <hr>
                                                        <div class="photo-grid">
                                                            <div class="photo-item">
                                                                <h6><i class="fas fa-camera me-2"></i>Before Photo</h6>
                                                                @if($row->before_photo)
                                                                    <img src="{{ asset('storage/'.$row->before_photo) }}" class="photo-img">
                                                                @else
                                                                    <div class="photo-placeholder">No Image</div>
                                                                @endif
                                                            </div>
                                                            <div class="photo-item">
                                                                <h6><i class="fas fa-camera me-2"></i>After Photo</h6>
                                                                @if($row->after_photo)
                                                                    <img src="{{ asset('storage/'.$row->after_photo) }}" class="photo-img">
                                                                @else
                                                                    <div class="photo-placeholder">No Image</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn-close-modal" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Chart Modal -->
                                        <div class="modal fade" id="chartModal{{ $row->member_id }}" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-chart-line me-2"></i> My Progress Chart
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <canvas id="chart{{ $row->member_id }}" height="120"></canvas>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn-close-modal" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="10" class="empty-row">
                                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                                <p>No Progress Records Found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            {{ $progress->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-chart-line fa-4x"></i>
                            <h5>No Progress Records Found</h5>
                            <p>Your progress records will appear here once added.</p>
                            <p class="text-muted small">Please contact your trainer to update your progress.</p>
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
.progress-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.progress-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.progress-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.progress-card-header h4 i {
    color: #ffd54f;
}

.progress-count {
    background: rgba(255, 255, 255, 0.15);
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.progress-card-body {
    padding: 24px;
}

/* ============================================ */
/* TABLE                                        */
/* ============================================ */
.progress-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
}

.progress-table thead {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
}

.progress-table thead th {
    padding: 12px 14px;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.progress-table tbody tr {
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
    transition: background 0.2s ease;
}

.progress-table tbody tr:hover {
    background: #f8fafc;
}

.progress-table tbody td {
    padding: 10px 14px;
    color: #334155;
    vertical-align: middle;
}

/* ============================================ */
/* TABLE STYLES                                 */
/* ============================================ */
.date-cell {
    font-weight: 500;
    color: #0d1b3e;
    white-space: nowrap;
}

.date-cell i {
    color: #1a2a6c;
}

.trainer-name {
    color: #64748b;
}

.trainer-name i {
    color: #1a2a6c;
}

.weight-value {
    font-weight: 700;
    color: #0d1b3e;
}

.weight-value small {
    font-weight: 400;
    color: #94a3b8;
}

.bmi-badge {
    display: inline-block;
    padding: 2px 12px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.8rem;
    background: #f0f4ff;
    color: #1a2a6c;
}

/* ============================================ */
/* ACTION BUTTONS                               */
/* ============================================ */
.action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.btn-view {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    background: #0d1b3e;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-view:hover {
    background: #1a2a6c;
    transform: scale(1.05);
}

.btn-chart {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    background: #10b981;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-chart:hover {
    background: #059669;
    transform: scale(1.05);
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

.empty-row {
    padding: 40px 20px !important;
    color: #94a3b8;
    text-align: center;
}

.empty-row i {
    display: block;
    color: #94a3b8;
}

.empty-row p {
    margin: 0;
    font-size: 1rem;
}

/* ============================================ */
/* MODAL STYLES                                 */
/* ============================================ */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 60px rgba(13, 27, 62, 0.15);
}

.modal-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    border-radius: 16px 16px 0 0;
    padding: 18px 24px;
}

.modal-header h5 {
    font-weight: 600;
}

.modal-header h5 i {
    color: #ffd54f;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.modal-header .btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 24px;
}

.modal-footer {
    padding: 14px 24px;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.btn-close-modal {
    padding: 8px 24px;
    background: #e2e8f0;
    color: #0d1b3e;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-close-modal:hover {
    background: #0d1b3e;
    color: #ffffff;
}

/* Modal Info Grid */
.modal-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 10px;
    margin-bottom: 16px;
}

.modal-info-item {
    background: #f8fafc;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.modal-label {
    display: block;
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}

.modal-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #0d1b3e;
}

/* Measurement Grid */
.measurement-title {
    color: #0d1b3e;
    font-weight: 600;
    margin-bottom: 12px;
}

.measurement-title i {
    color: #1a2a6c;
}

.measurement-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 8px;
    margin-bottom: 16px;
}

.measurement-item {
    background: #f8fafc;
    padding: 8px 12px;
    border-radius: 6px;
    text-align: center;
    border: 1px solid rgba(13, 27, 62, 0.04);
}

.measurement-label {
    display: block;
    font-size: 0.65rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}

.measurement-value {
    font-size: 0.9rem;
    font-weight: 600;
    color: #0d1b3e;
}

/* Modal Notes */
.modal-notes {
    background: #fefce8;
    padding: 12px 16px;
    border-radius: 8px;
    border-left: 4px solid #f59e0b;
    margin: 12px 0;
}

.modal-notes h6 {
    color: #78350f;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 4px;
}

.modal-notes h6 i {
    color: #f59e0b;
}

.modal-notes p {
    color: #78350f;
    margin: 0;
    font-size: 0.9rem;
}

/* Photo Grid */
.photo-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 8px;
}

.photo-item h6 {
    color: #0d1b3e;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.photo-item h6 i {
    color: #1a2a6c;
}

.photo-img {
    width: 100%;
    max-height: 250px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid rgba(13, 27, 62, 0.1);
}

.photo-placeholder {
    width: 100%;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 8px;
    border: 2px dashed rgba(13, 27, 62, 0.1);
    color: #94a3b8;
    font-size: 0.9rem;
}

/* ============================================ */
/* ALERTS                                       */
/* ============================================ */
.alert-custom-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
    border-radius: 10px;
    padding: 12px 18px;
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
    .progress-table {
        font-size: 0.8rem;
    }
    
    .progress-table thead th,
    .progress-table tbody td {
        padding: 8px 10px;
    }
    
    .photo-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .progress-card-header {
        padding: 14px 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .progress-card-header h4 {
        font-size: 1rem;
    }
    
    .progress-card-body {
        padding: 16px;
    }
    
    .progress-table {
        font-size: 0.75rem;
    }
    
    .progress-table thead th,
    .progress-table tbody td {
        padding: 6px 8px;
    }
    
    .progress-table thead th {
        font-size: 0.65rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }
    
    .btn-view,
    .btn-chart {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }
    
    .modal-info-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .measurement-grid {
        grid-template-columns: 1fr 1fr;
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
    .progress-table {
        font-size: 0.65rem;
    }
    
    .progress-table thead th,
    .progress-table tbody td {
        padding: 4px 6px;
    }
    
    .progress-table thead th {
        font-size: 0.55rem;
        letter-spacing: 0;
    }
    
    .weight-value {
        font-size: 0.75rem;
    }
    
    .bmi-badge {
        font-size: 0.65rem;
        padding: 1px 8px;
    }
    
    .modal-info-grid {
        grid-template-columns: 1fr;
    }
    
    .measurement-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .photo-img {
        max-height: 150px;
    }
}

/* ============================================ */
/* ANIMATIONS                                   */
/* ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.progress-table tbody tr {
    animation: fadeInUp 0.3s ease forwards;
}

.progress-table tbody tr:nth-child(1) { animation-delay: 0.02s; }
.progress-table tbody tr:nth-child(2) { animation-delay: 0.04s; }
.progress-table tbody tr:nth-child(3) { animation-delay: 0.06s; }
.progress-table tbody tr:nth-child(4) { animation-delay: 0.08s; }
.progress-table tbody tr:nth-child(5) { animation-delay: 0.10s; }
.progress-table tbody tr:nth-child(6) { animation-delay: 0.12s; }
.progress-table tbody tr:nth-child(7) { animation-delay: 0.14s; }
.progress-table tbody tr:nth-child(8) { animation-delay: 0.16s; }
.progress-table tbody tr:nth-child(9) { animation-delay: 0.18s; }
.progress-table tbody tr:nth-child(10) { animation-delay: 0.20s; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
@foreach($progress->unique('member_id') as $row)
    (function() {
        const canvas = document.getElementById('chart{{ $row->member_id }}');
        if (canvas) {
            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: {!! json_encode(
                        \App\Models\Progress::where('member_id',$row->member_id)
                            ->orderBy('progress_date')
                            ->pluck('progress_date')
                            ->map(function($date) {
                                return \Carbon\Carbon::parse($date)->format('d-m-Y');
                            })
                    ) !!},
                    datasets: [
                        {
                            label: 'Weight (Kg)',
                            data: {!! json_encode(
                                \App\Models\Progress::where('member_id',$row->member_id)
                                    ->orderBy('progress_date')
                                    ->pluck('weight')
                                    ->map(function($weight) {
                                        return (float)$weight;
                                    })
                            ) !!},
                            borderColor: '#1a2a6c',
                            backgroundColor: 'rgba(26, 42, 108, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#1a2a6c',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        },
                        {
                            label: 'BMI',
                            data: {!! json_encode(
                                \App\Models\Progress::where('member_id',$row->member_id)
                                    ->orderBy('progress_date')
                                    ->pluck('bmi')
                                    ->map(function($bmi) {
                                        return (float)$bmi;
                                    })
                            ) !!},
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(13, 27, 62, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 30
                            }
                        }
                    }
                }
            });
        }
    })();
@endforeach
</script>
@endsection