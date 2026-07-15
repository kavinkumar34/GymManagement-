@extends('layouts.admin-layout')

@section('content')
<style>
.cor{
        background: linear-gradient(180deg, #0d1b2a 0%, #1b3a5c 50%, #0d1b2a 100%);
                color: #ffffff;


}
</style>
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header cor text-white d-flex justify-content-between align-items-center">
                <h4> Banner Management</h4>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Banner
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Link</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $key => $banner)
                                <tr>
                                    <td>{{ $banners->firstItem() + $key }}</td>
                                    <td>
                                        @if($banner->image)
                                            <img src="{{ Storage::url($banner->image) }}" alt="Banner" style="width: 80px; height: 50px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($banner->link)
                                            <a href="{{ $banner->link }}" target="_blank">{{ Str::limit($banner->link, 30) }}</a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $banner->order }}</td>
                                    <td>
                                        <span class="badge {{ $banner->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $banner->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No banners found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== ADD THIS CODE - AUTO HIDE ALERT AFTER 5 SECONDS ====== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto hide success alert after 5 seconds
        var successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 500);
            }, 5000);
        }
        
        // Auto hide error alert after 5 seconds
        var errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.transition = 'opacity 0.5s ease';
                errorAlert.style.opacity = '0';
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 500);
            }, 5000);
        }
    });
</script>
@endsection