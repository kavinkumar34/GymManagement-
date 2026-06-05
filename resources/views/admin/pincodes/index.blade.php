@extends('layouts.app')

@section('content')
<div class="container" style="margin-left:200px;>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Deliverable Pincodes</h4>
            <div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                    <i class="fas fa-upload"></i> Bulk Import
                </button>
                <a href="{{ route('admin.pincodes.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pincode</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Delivery Days</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pincodes as $pincode)
                    <tr>
                        <td>{{ $pincode->id }}</td>
                        <td>{{ $pincode->pincode }}</td>
                        <td>{{ $pincode->city ?? '-' }}</td>
                        <td>{{ $pincode->state ?? '-' }}</td>
                        <td>{{ $pincode->delivery_days }} days</td>
                        <td>
                            @if($pincode->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pincodes.edit', $pincode->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.pincodes.destroy', $pincode->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this pincode?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $pincodes->links() }}
        </div>
    </div>
</div>

<!-- Bulk Import Modal -->
<div class="modal fade" id="bulkImportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pincodes.bulk') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Import Pincodes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea name="pincodes" class="form-control" rows="10" placeholder="Enter one pincode per line&#10;600001&#10;600002&#10;600003"></textarea>
                    <small class="text-muted">Enter one pincode per line (6 digits only)</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection