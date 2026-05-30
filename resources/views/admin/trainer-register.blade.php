@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4><i class="fas fa-chalkboard-user"></i> Trainer Registration</h4>
                <small>Register new fitness trainer</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.trainer.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Personal Information</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <!-- Professional Information -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Professional Information</h5>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Experience (years)</label>
                            <input type="number" name="experience" class="form-control" min="0">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Specialization <span class="text-danger">*</span></label>
                            <select name="specialization" class="form-control" required>
                                <option value="Cardio">Cardio</option>
                                <option value="Yoga">Yoga</option>
                                <option value="Weight Training">Weight Training</option>
                                <option value="CrossFit">CrossFit</option>
                                <option value="Zumba">Zumba</option>
                                <option value="Body Building">Body Building</option>
                                <option value="Personal Training">Personal Training</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Salary (₹ per month)</label>
                            <input type="number" step="0.01" name="salary" class="form-control">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Join Date <span class="text-danger">*</span></label>
                            <input type="date" name="join_date" class="form-control" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Shift Timing <span class="text-danger">*</span></label>
                            <select name="shift_timing" class="form-control" required>
                                <option value="Morning (6AM-12PM)">Morning (6AM-12PM)</option>
                                <option value="Evening (12PM-6PM)">Evening (12PM-6PM)</option>
                                <option value="Night (6PM-10PM)">Night (6PM-10PM)</option>
                                <option value="Full Day">Full Day</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Certifications</label>
                            <textarea name="certification" class="form-control" rows="2" placeholder="List your certifications and qualifications"></textarea>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Register Trainer
                        </button>
                        <a href="{{ route('admin.trainers') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection