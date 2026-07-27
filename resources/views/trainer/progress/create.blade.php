@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Add Member Progress
                    </h4>
                    <a href="{{ route('trainer.progress.index') }}" 
                       class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 20px;">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('trainer.progress.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Member -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Member <span class="text-danger">*</span></label>
                            <select name="member_id" class="form-control" style="border-color: #1a472a; border-radius: 8px;" required>
                                <option value="">Select Member</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->member_id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Progress Date</label>
                            <input type="date" name="progress_date" class="form-control" style="border-color: #1a472a; border-radius: 8px;" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Weight -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Weight (Kg)</label>
                            <input type="number" step="0.01" id="weight" name="weight" class="form-control" style="border-color: #1a472a; border-radius: 8px;" required>
                        </div>

                        <!-- Height -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Height (cm)</label>
                            <input type="number" step="0.01" id="height" name="height" class="form-control" style="border-color: #1a472a; border-radius: 8px;" required>
                        </div>

                        <!-- BMI -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">BMI</label>
                            <input type="text" id="bmi" class="form-control" style="background: #f8fafc; border-color: #1a472a; border-radius: 8px;" readonly>
                        </div>

                        <!-- Body Fat -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Body Fat (%)</label>
                            <input type="number" step="0.01" name="body_fat" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 mb-3"></div>

                        <!-- Body Measurements -->
                        <div class="col-12 mb-3">
                            <h6 class="fw-bold" style="color: #0d2818; border-bottom: 2px solid #1a472a; padding-bottom: 8px;">
                                <i class="fas fa-ruler me-2"></i> Body Measurements
                            </h6>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Chest</label>
                            <input type="number" step="0.01" name="chest" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Waist</label>
                            <input type="number" step="0.01" name="waist" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Hips</label>
                            <input type="number" step="0.01" name="hips" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-3 mb-3"></div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Left Arm</label>
                            <input type="number" step="0.01" name="left_arm" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Right Arm</label>
                            <input type="number" step="0.01" name="right_arm" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Left Thigh</label>
                            <input type="number" step="0.01" name="left_thigh" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Right Thigh</label>
                            <input type="number" step="0.01" name="right_thigh" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>

                        <!-- Photos -->
                        <div class="col-12 mb-3">
                            <h6 class="fw-bold" style="color: #0d2818; border-bottom: 2px solid #1a472a; padding-bottom: 8px;">
                                <i class="fas fa-images me-2"></i> Progress Photos
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Before Photo</label>
                            <input type="file" name="before_photo" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">After Photo</label>
                            <input type="file" name="after_photo" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                        </div>

                        <!-- Notes -->
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Notes</label>
                            <textarea name="notes" class="form-control" rows="3" style="border-color: #1a472a; border-radius: 8px;" placeholder="Enter notes..."></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12">
                            <button type="submit" class="btn" style="background: #0d2818; color: white; border-radius: 8px; padding: 10px 30px;">
                                <i class="fas fa-save me-2"></i> Save Progress
                            </button>
                            <a href="{{ route('trainer.progress.index') }}" class="btn btn-secondary" style="border-radius: 8px; padding: 10px 30px;">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function calculateBMI(){
    let w = parseFloat(document.getElementById('weight').value);
    let h = parseFloat(document.getElementById('height').value);
    if(w && h && h > 0){
        document.getElementById('bmi').value = (w / ((h/100) * (h/100))).toFixed(2);
    } else {
        document.getElementById('bmi').value = '';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('weight').addEventListener('keyup', calculateBMI);
    document.getElementById('height').addEventListener('keyup', calculateBMI);
});
</script>

<style>
    .form-control:focus { border-color: #0d2818 !important; box-shadow: 0 0 0 0.2rem rgba(13,40,24,0.15) !important; }
    @media (max-width: 768px) {
        .card-header .d-flex { flex-direction: column; gap: 10px; align-items: flex-start !important; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

@endsection