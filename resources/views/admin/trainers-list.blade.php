@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-chalkboard-user"></i> Trainers List</h4>
                <a href="{{ route('admin.trainer.create') }}" class="btn btn-light">
                    <i class="fas fa-user-plus"></i> Add New Trainer
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
                                <th>Trainer ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Assigned Members</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trainers as $trainer)
                            <tr>
                                <td>{{ $trainer->id }}</td>
                                <td>{{ $trainer->trainer_id }}</td>
                                <td>{{ $trainer->name }}</td>
                                <td>{{ $trainer->email }}</td>
                                <td>{{ $trainer->phone }}</td>
                                <td><span class="badge bg-info">{{ $trainer->specialization }}</span></td>
                                <td>{{ $trainer->experience }} years</td>
                                <td><span class="badge bg-primary">{{ $trainer->assigned_members ?? 0 }} Members</span></td>
                                <td>
                                    @if($trainer->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.trainer.edit', $trainer->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteTrainer({{ $trainer->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a href="{{ route('admin.trainer.show', $trainer->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No trainers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $trainers->links() }}
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
function deleteTrainer(id) {
    if(confirm('Are you sure you want to delete this trainer?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/trainers/' + id;
        form.submit();
    }
}
</script>
@endsection