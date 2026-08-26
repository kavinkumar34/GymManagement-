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
                        <a href="{{ route('trainer.member-attendance.index') }}" class="btn"
                            style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 20px;">
                            <i class="fas fa-arrow-left me-2"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-left: 4px solid #dc3545;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('trainer.member-attendance.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <!-- ========================================== -->
                            <!-- MEMBER SELECTION - CHECKBOX STYLE          -->
                            <!-- ========================================== -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-users me-1" style="color: #1a472a;"></i> Select Member(s) <span
                                            class="text-danger">*</span>
                                    </label>

                                    <!-- ===== CHECKBOX STYLE (MULTIPLE SELECTION) ===== -->
                                    <div class="border rounded p-3"
                                        style="height:250px; overflow-y:auto; border-color: #1a472a !important; background: #f8fafc;">

                                        @foreach ($members as $member)
                                            <div class="form-check mb-3 p-2" style="border-bottom: 1px solid #e5e7eb;">
                                                <input type="checkbox" class="form-check-input"
                                                    id="member{{ $member->id }}" name="member_ids[]"
                                                    value="{{ $member->id }}"
                                                    {{ in_array($member->id, old('member_ids', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="member{{ $member->id }}">
                                                    <strong style="color: #0d2818;">{{ $member->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $member->email ?? 'No Email' }}</small>
                                                    <br>
                                                    @if (isset($member->plan_type) && $member->plan_type == 'membership')
                                                        <span class="badge"
                                                            style="background: #0d2818; color: #ffd54f;">Membership</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background: #ffd54f; color: #0d2818;">Package</span>
                                                    @endif
                                                    <span class="badge" style="background: #1a472a; color: white;">
                                                        {{ $member->membership_plan ?? ($member->package_name ?? 'N/A') }}
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach

                                        @if ($members->isEmpty())
                                            <div class="text-center text-muted py-3">
                                                <i class="fas fa-users fa-2x d-block mb-2"></i>
                                                No members found. Please add members first.
                                            </div>
                                        @endif
                                    </div>

                                    @error('member_ids')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('member_ids.*')
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
                                    <input type="date" name="attendance_date" class="form-control"
                                        style="border-color: #1a472a; border-radius: 8px;"
                                        value="{{ old('attendance_date', date('Y-m-d')) }}" required>
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
                                    <select name="status" class="form-select"
                                        style="border-color: #1a472a; border-radius: 8px;">
                                        <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>
                                            Present
                                        </option>
                                        <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>
                                            Absent
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
                                    <input type="time" name="check_in" class="form-control"
                                        style="border-color: #1a472a; border-radius: 8px;" value="{{ old('check_in') }}">
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
                                    <input type="time" name="check_out" class="form-control"
                                        style="border-color: #1a472a; border-radius: 8px;" value="{{ old('check_out') }}">
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
                                    <textarea name="remarks" class="form-control" rows="3" style="border-color: #1a472a; border-radius: 8px;"
                                        placeholder="Enter any remarks or notes...">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Current Time Display -->
                            <div class="col-12">
                                <div class="p-3"
                                    style="background: #f8fafc; border-radius: 10px; border-left: 3px solid #1a472a;">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Current Time: <strong id="currentTime">{{ date('h:i:s A') }}</strong>
                                        <span class="mx-2">|</span>
                                        Current Date: <strong>{{ date('d M Y') }}</strong>
                                    </small>
                                </div>
                            </div>

                            <!-- Selected Count Display -->
                            <div class="col-12">
                                <div class="p-2" style="background: #e8f5e9; border-radius: 8px; border-left: 3px solid #2e7d32;">
                                    <small>
                                        <i class="fas fa-check-circle" style="color: #2e7d32;"></i>
                                        Selected Members: <strong id="selectedCount">0</strong>
                                        <span class="text-muted">(Select members from the list above)</span>
                                    </small>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12">
                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="submit" class="btn"
                                        style="background: #0d2818; color: white; border-radius: 8px; padding: 10px 30px;">
                                        <i class="fas fa-save me-2"></i> Save Attendance
                                    </button>
                                    <a href="{{ route('trainer.member-attendance.index') }}" class="btn btn-secondary"
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

            // ===== UPDATE SELECTED COUNT =====
            const checkboxes = document.querySelectorAll('input[name="member_ids[]"]');
            const selectedCount = document.getElementById('selectedCount');

            function updateSelectedCount() {
                const checked = document.querySelectorAll('input[name="member_ids[]"]:checked');
                selectedCount.textContent = checked.length;
            }

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Initial count
            updateSelectedCount();
        });
    </script>
@endpush

@push('styles')
    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #0d2818 !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 40, 24, 0.15) !important;
        }

        .form-check-input:checked {
            background-color: #0d2818;
            border-color: #0d2818;
        }

        .form-check {
            transition: all 0.3s ease;
        }

        .form-check:hover {
            background: rgba(13, 40, 24, 0.05);
            border-radius: 8px;
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

            .form-control,
            .form-select {
                font-size: 0.85rem;
            }

            .card-header h4 {
                font-size: 1.1rem;
            }

            .border.rounded.p-3 {
                height: 180px !important;
            }
        }
    </style>
@endpush