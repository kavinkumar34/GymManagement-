@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:200px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-tag me-2 text-primary"></i>Product Types</h5>
            <a href="{{ route('admin.producttypes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Product Type
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Sub Category</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productTypes as $pt)
                        <tr>
                            <td>{{ $pt->id }}</td>
                            <td>
                                @if($pt->image)
                                    <img src="{{ asset('storage/'.$pt->image) }}" style="width:40px;height:40px;object-fit:cover;" class="rounded">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                @endif
                              </td>
                            <td><strong>{{ $pt->name }}</strong></td>
                            <td>{{ $pt->subCategory->name ?? 'N/A' }}</td>
                            <td>{{ $pt->subCategory->category->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $pt->is_active ? 'success' : 'secondary' }}">
                                    {{ $pt->is_active ? 'Active' : 'Inactive' }}
                                </span>
                              </td>
                            <td>
                                <a href="{{ route('admin.producttypes.edit', $pt->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $pt->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $pt->id }}" action="{{ route('admin.producttypes.destroy', $pt->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No product types found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $productTypes->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this product type?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection