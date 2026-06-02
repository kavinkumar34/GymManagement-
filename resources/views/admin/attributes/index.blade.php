@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm"  style="margin-left:200px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list-ul me-2 text-primary"></i>Attributes</h5>
            <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Attribute
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
                            <th>Label</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Values</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attributes as $attr)
                        <tr>
                            <td>{{ $attr->id }}</td>
                            <td><strong>{{ $attr->label }}</strong></td>
                            <td><code>{{ $attr->name }}</code></td>
                            <td><span class="badge bg-info">{{ $attr->type }}</span></td>
                            <td>
                                @if($attr->required)
                                    <span class="badge bg-danger">Required</span>
                                @else
                                    <span class="badge bg-secondary">Optional</span>
                                @endif
                              </td>
                            <td>
                                @foreach($attr->values as $val)
                                    <span class="badge bg-light text-dark me-1">{{ $val->value }}</span>
                                @endforeach
                              </td>
                            <td>
                                <a href="{{ route('admin.attributes.edit', $attr->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $attr->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $attr->id }}" action="{{ route('admin.attributes.destroy', $attr->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No attributes found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $attributes->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this attribute?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection