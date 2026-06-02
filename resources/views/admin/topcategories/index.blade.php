@extends('layouts.admin-layout')

@section('content')
<div class="container" style="margin-left:250px;">
    <div class="card shadow-sm" style="max-width:1200px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>Top Categories (GST & Commission)</h5>
            <a href="{{ route('admin.topcategories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add New
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>GST Rate</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCategories as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $item->gst_rate <= 5 ? 'success' : ($item->gst_rate <= 12 ? 'info' : ($item->gst_rate <= 18 ? 'primary' : 'danger')) }}">
                                    {{ $item->gst_rate }}%
                                </span>
                              </td>
                            <td><span class="badge bg-dark">{{ $item->commission_percent }}%</span></td>
                            <td>{{ Str::limit($item->description, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                              </td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.topcategories.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.topcategories.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted">No top categories found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $topCategories->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this top category?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection