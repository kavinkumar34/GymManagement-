@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-image"></i> Banner Management</h4>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-light">
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
                        <button type="button" class btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Link</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</div>
                                <td>
                                    @if($banner->image)
                                        <img src="{{ Storage::url($banner->image) }}" width="80" height="50" style="object-fit: cover; border-radius: 8px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </div>
                                <td>
                                    @if($banner->link)
                                        <a href="{{ $banner->link }}" target="_blank">{{ Str::limit($banner->link, 30) }}</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <td>{{ $banner->order }}</div>
                                <td>
                                    @if($banner->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                                <td>
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteBanner({{ $banner->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                             </div>
                            @empty
                             </div>
                                <td colspan="6" class="text-center">No banners found</div>
                             </div>
                            @endforelse
                        </tbody>
                    </div>
                </div>
                
                <div class="mt-3">
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteBanner(id) {
        if(confirm('Are you sure you want to delete this banner?')) {
            let form = document.getElementById('delete-form');
            form.action = '/admin/banners/' + id;
            form.submit();
        }
    }
</script>
@endsection