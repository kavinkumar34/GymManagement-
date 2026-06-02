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
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCategories as $sub)
                        <tr>
                            <td>{{ $sub->id }}</td>
                            <td>
                                @if($sub->image)
                                    <img src="{{ asset('storage/'.$sub->image) }}" style="width:40px;height:40px;object-fit:cover;" class="rounded">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                @endif
                              </td>
                            <td><strong>{{ $sub->name }}</strong></td>
                            <td>{{ $sub->category->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $sub->is_active ? 'success' : 'secondary' }}">
                                    {{ $sub->is_active ? 'Active' : 'Inactive' }}
                                </span>
                              </table>
                            <td>
                                <a href="{{ route('admin.subcategories.edit', $sub->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $sub->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $sub->id }}" action="{{ route('admin.subcategories.destroy', $sub->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No sub categories found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $subCategories->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this sub category?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection