@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="appointment-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="appointment-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-plus me-2"></i> Book Appointment
                        </h4>
                        <a href="{{ route('member.appointment.index') }}" class="btn-back-header">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                
                <div class="appointment-card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-custom-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> Please fix the following errors:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('member.appointment.store') }}" method="POST" id="appointmentForm">
                        @csrf

                        <!-- Trainer Info -->
                        <div class="trainer-info-box">
                            <div class="trainer-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="trainer-details">
                                <span class="trainer-label">Trainer</span>
                                <span class="trainer-name">{{ $trainer->name }}</span>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-day me-1"></i> Appointment Date
                                </label>
                                <input type="date"
                                       name="appointment_date"
                                       class="form-control"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                <small class="form-hint">Select a future date</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock me-1"></i> Appointment Time
                                </label>
                                <input type="time"
                                       name="appointment_time"
                                       class="form-control"
                                       required>
                                <small class="form-hint">Select preferred time</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-bullseye me-1"></i> Purpose
                                </label>
                                <input type="text"
                                       name="purpose"
                                       class="form-control"
                                       placeholder="e.g., Fitness consultation, Diet plan review"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note me-1"></i> Description (Optional)
                                </label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Describe your requirements in detail..."></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane me-2"></i> Book Appointment
                            </button>
                            <a href="{{ route('member.appointment.index') }}" class="btn-cancel">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.appointment-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.appointment-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.appointment-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.appointment-card-header h4 i {
    color: #ffd54f;
}

.btn-back-header {
    display: inline-flex;
    align-items: center;
    padding: 6px 16px;
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back-header:hover {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

.appointment-card-body {
    padding: 24px;
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

.alert-custom-danger {
    background: #fef2f2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 12px 18px;
}

.alert-custom-danger ul {
    padding-left: 20px;
}

/* ============================================ */
/* TRAINER INFO BOX                             */
/* ============================================ */
.trainer-info-box {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid rgba(13, 27, 62, 0.06);
    margin-bottom: 24px;
}

.trainer-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.5rem;
}

.trainer-details {
    display: flex;
    flex-direction: column;
}

.trainer-label {
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}

.trainer-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0d1b3e;
}

/* ============================================ */
/* FORM                                         */
/* ============================================ */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #0d1b3e;
    margin-bottom: 6px;
}

.form-label i {
    color: #1a2a6c;
}

.form-control {
    padding: 10px 14px;
    border: 1px solid rgba(13, 27, 62, 0.1);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #ffffff;
    color: #0d1b3e;
}

.form-control:focus {
    outline: none;
    border-color: #1a2a6c;
    box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.1);
}

.form-control[readonly] {
    background: #f8fafc;
    cursor: not-allowed;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.form-hint {
    font-size: 0.75rem;
    color: #94a3b8;
    margin-top: 4px;
}

/* ============================================ */
/* FORM ACTIONS                                 */
/* ============================================ */
.form-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    padding-top: 20px;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.btn-submit {
    padding: 12px 32px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 27, 62, 0.25);
}

.btn-cancel {
    padding: 12px 24px;
    background: #e2e8f0;
    color: #0d1b3e;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-cancel:hover {
    background: #cbd5e1;
    color: #0d1b3e;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .appointment-card-header {
        padding: 14px 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .appointment-card-header h4 {
        font-size: 1rem;
    }
    
    .appointment-card-body {
        padding: 16px;
    }
    
    .trainer-info-box {
        padding: 12px 16px;
    }
    
    .trainer-avatar {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .trainer-name {
        font-size: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-submit,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .appointment-card-body {
        padding: 12px;
    }
    
    .trainer-info-box {
        flex-direction: column;
        text-align: center;
        padding: 12px;
    }
    
    .form-label {
        font-size: 0.8rem;
    }
    
    .form-control {
        font-size: 0.85rem;
        padding: 8px 12px;
    }
}
</style>
@endsection