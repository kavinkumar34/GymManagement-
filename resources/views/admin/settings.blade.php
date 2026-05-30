@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fas fa-cog"></i> Company Settings</h4>
                <small>Manage your company branding</small>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] }}" required>
                            </div>
                            <small class="text-muted">This name appears in navbar</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Logo Icon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-code"></i></span>
                                <input type="text" name="company_logo" class="form-control" value="{{ $settings['company_logo'] }}" placeholder="fas fa-dumbbell">
                            </div>
                            <small class="text-muted">Font Awesome icon class (e.g., fas fa-dumbbell, fas fa-heart)</small>
                            <div class="mt-2">
                                <span class="badge bg-info">Preview: <i class="{{ $settings['company_logo'] }}"></i></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primary Color</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-palette"></i></span>
                                <input type="color" name="primary_color" class="form-control" value="{{ $settings['primary_color'] }}" style="width: 80px;">
                                <input type="text" name="primary_color_text" class="form-control" value="{{ $settings['primary_color'] }}" readonly>
                            </div>
                            <small class="text-muted">Main theme color</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secondary Color</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-palette"></i></span>
                                <input type="color" name="secondary_color" class="form-control" value="{{ $settings['secondary_color'] }}" style="width: 80px;">
                                <input type="text" name="secondary_color_text" class="form-control" value="{{ $settings['secondary_color'] }}" readonly>
                            </div>
                            <small class="text-muted">Secondary theme color</small>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.reload();">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    </div>
                </form>
                
                <hr class="mt-4">
                
                <h5>Live Preview</h5>
                <div class="preview-box p-3 bg-dark rounded mt-2">
                    <div class="d-flex align-items-center">
                        <i class="{{ $settings['company_logo'] }} me-2" style="font-size: 2rem; color: white;"></i>
                        <strong style="color: white; font-size: 1.2rem;">{{ $settings['company_name'] }}</strong>
                    </div>
                    <small class="text-muted">This is how your logo will appear in navbar</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update color picker
    document.querySelector('input[name="primary_color"]').addEventListener('change', function() {
        document.querySelector('input[name="primary_color_text"]').value = this.value;
    });
    
    document.querySelector('input[name="secondary_color"]').addEventListener('change', function() {
        document.querySelector('input[name="secondary_color_text"]').value = this.value;
    });
</script>
@endsection