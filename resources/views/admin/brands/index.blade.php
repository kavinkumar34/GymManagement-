@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-building me-2 text-primary"></i>Brands</h5>
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Brand
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
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>
                                @if($brand->logo)
                                    <img src="{{ asset('storage/'.$brand->logo) }}" style="width:40px;height:40px;object-fit:cover;" class="rounded">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <i class="fas fa-building"></i>
                                    </div>
                                @endif
                              </td>
                            <td><strong>{{ $brand->name }}</strong></td>
                            <td>{{ Str::limit($brand->description, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $brand->is_active ? 'success' : 'secondary' }}">
                                    {{ $brand->is_active ? 'Active' : 'Inactive' }}
                                </span>
                              </td>
                            <td>
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $brand->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $brand->id }}" action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No brands found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $brands->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this brand?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection