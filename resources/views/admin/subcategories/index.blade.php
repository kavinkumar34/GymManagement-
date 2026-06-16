@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:200px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-folder-open me-2 text-primary"></i>Sub Categories</h5>
            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Sub Category
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="10%">Image</th>
                            <th width="25%">Name</th>
                            <th width="25%">Category</th>
                            <th width="15%">Status</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCategories as $sub)
                        <tr>
                            <td class="align-middle">{{ $sub->id }}</td>
                            <td class="align-middle">
                                @if($sub->image)
                                    <img src="{{ asset('storage/'.$sub->image) }}" style="width:40px;height:40px;object-fit:cover;" class="rounded shadow-sm">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center shadow-sm" style="width:40px;height:40px;">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle"><strong>{{ $sub->name }}</strong></td>
                            <td class="align-middle">
                                <span class="badge bg-info text-dark">{{ $sub->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-{{ $sub->is_active ? 'success' : 'secondary' }} px-3 py-2">
                                    <i class="fas fa-{{ $sub->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    {{ $sub->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.subcategories.edit', $sub->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem({{ $sub->id }})">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <form id="delete-form-{{ $sub->id }}" action="{{ route('admin.subcategories.destroy', $sub->id) }}" method="POST" style="display:none;">
                                    @csrf 
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                <p>No sub categories found</p>
                                <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> Add First Sub Category
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $subCategories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional Styles for Better Alignment */
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 5px 12px;
        font-size: 0.75rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover, .btn-outline-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .badge {
        font-weight: 500;
        border-radius: 30px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    .alert {
        border-radius: 10px;
        border-left: 4px solid #28a745;
    }
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        border-bottom: 1px solid #e9ecef;
        padding: 15px 20px;
    }
</style>

<script>
function deleteItem(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this sub category!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

<!-- SweetAlert2 CDN (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection