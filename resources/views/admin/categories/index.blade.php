@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:150px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-folder me-2 text-primary"></i>Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Category
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Top Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>
                                @if($cat->image)
                                    <img src="{{ asset('storage/'.$cat->image) }}" style="width:40px;height:40px;object-fit:cover;" class="rounded">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                @endif
                              </td>
                            <td><strong>{{ $cat->name }}</strong></td>
                            <td>{{ $cat->topCategory->name ?? 'N/A' }} (@if($cat->topCategory) GST:{{ $cat->topCategory->gst_rate }}% @endif)</td>
                            <td>
                                <span class="badge bg-{{ $cat->is_active ? 'success' : 'secondary' }}">
                                    {{ $cat->is_active ? 'Active' : 'Inactive' }}
                                </span>
                              </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $cat->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $cat->id }}" action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No categories found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this category?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection