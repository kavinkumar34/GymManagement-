@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-user-check me-2"></i> Mark Member Attendance
                    </h4>
                    <a href="{{ route('trainer.member-attendance.index') }}" 
                       class="btn" 
                       style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 20px;">
                        <i class="fas fa-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="card-body">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545;">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('trainer.member-attendance.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Member -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1" style="color: #1a472a;"></i> Member
                                </label>
                                <select name="member_id" class="form-select" style="border-color: #1a472a; border-radius: 8px;" required>
                                    <option value="">Select Member</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->member_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1" style="color: #1a472a;"></i> Date
                                </label>
                                <input type="date"
                                       name="attendance_date"
                                       class="form-control"
                                       style="border-color: #1a472a; border-radius: 8px;"
                                       value="{{ old('attendance_date', date('Y-m-d')) }}"
                                       required>
                                @error('attendance_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-check-circle me-1" style="color: #1a472a;"></i> Status
                                </label>
                                <select name="status" class="form-select" style="border-color: #1a472a; border-radius: 8px;">
                                    <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>
                                        <i class="fas fa-check me-1"></i> Present
                                    </option>
                                    <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>
                                        <i class="fas fa-times me-1"></i> Absent
                                    </option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Check In -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock me-1" style="color: #1a472a;"></i> Check In
                                </label>
                                <input type="time"
                                       name="check_in"
                                       class="form-control"
                                       style="border-color: #1a472a; border-radius: 8px;"
                                       value="{{ old('check_in') }}">
                                @error('check_in')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Check Out -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock me-1" style="color: #1a472a;"></i> Check Out
                                </label>
                                <input type="time"
                                       name="check_out"
                                       class="form-control"
                                       style="border-color: #1a472a; border-radius: 8px;"
                                       value="{{ old('check_out') }}">
                                @error('check_out')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-comment me-1" style="color: #1a472a;"></i> Remarks
                                </label>
                                <textarea name="remarks"
                                          class="form-control"
                                          rows="3"
                                          style="border-color: #1a472a; border-radius: 8px;"
                                          placeholder="Enter any remarks or notes...">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Time Display -->
                        <div class="col-12">
                            <div class="p-3" style="background: #f8fafc; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Current Time: <strong id="currentTime">{{ date('h:i:s A') }}</strong>
                                    <span class="mx-2">|</span>
                                    Current Date: <strong>{{ date('d M Y') }}</strong>
                                </small>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn" style="background: #0d2818; color: white; border-radius: 8px; padding: 10px 30px;">
                                    <i class="fas fa-save me-2"></i> Save Attendance
                                </button>
                                <a href="{{ route('trainer.member-attendance.index') }}" 
                                   class="btn btn-secondary" 
                                   style="border-radius: 8px; padding: 10px 30px;">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Update current time every second
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour12: true,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('currentTime').textContent = timeString;
    }
    updateTime();
    setInterval(updateTime, 1000);

    // Auto-fill check-in time when status is Present
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const checkInInput = document.querySelector('input[name="check_in"]');
        const checkOutInput = document.querySelector('input[name="check_out"]');

        statusSelect.addEventListener('change', function() {
            if (this.value === 'Present' && !checkInInput.value) {
                const now = new Date();
                const timeString = now.toTimeString().slice(0, 5);
                checkInInput.value = timeString;
            }
        });

        checkInInput.addEventListener('focus', function() {
            if (!this.value) {
                const now = new Date();
                const timeString = now.toTimeString().slice(0, 5);
                this.value = timeString;
            }
        });

        checkOutInput.addEventListener('focus', function() {
            if (!this.value) {
                const now = new Date();
                const timeString = now.toTimeString().slice(0, 5);
                this.value = timeString;
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d2818 !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 40, 24, 0.15) !important;
    }

    @media (max-width: 768px) {
        .card-header .d-flex {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start !important;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .form-control, .form-select {
            font-size: 0.85rem;
        }
        .card-header h4 {
            font-size: 1.1rem;
        }
    }
</style>
@endpush