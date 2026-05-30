@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-tags"></i> Categories Management</h4>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Add Category
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
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Category Name</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <i class="{{ $category->icon }}" style="font-size: 1.5rem;"></i>
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </div>
                                <td>
                                    <span class="badge bg-primary">{{ $category->products_count ?? 0 }} Products</span>
                                </div>
                                <td>
                                    @if($category->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                                <td>{{ $category->created_at->format('d M Y') }}</div>
                                <td>
                                    <!-- View Products Button -->
                                    <a href="{{ route('admin.categories.products', $category->id) }}" class="btn btn-sm btn-info" title="View Products">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning" title="Edit Category">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory({{ $category->id }})" title="Delete Category">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                 </div>
                             </div>
                            @empty
                             </div>
                                <td colspan="7" class="text-center">No categories found</div>
                             </div>
                            @endforelse
                        </tbody>
                    </div>
                </div>
                
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteCategory(id) {
        if(confirm('Are you sure? This will also delete all products in this category.')) {
            let form = document.getElementById('delete-form');
            form.action = '/admin/categories/' + id;
            form.submit();
        }
    }
</script>
@endsection