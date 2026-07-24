@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-users"></i> Members List</h4>
                <a href="{{ route('admin.member.create') }}" class="btn btn-light">
                    <i class="fas fa-user-plus"></i> Add New Member
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
                                <th>Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Plan Type</th>
                                <th>Membership / Package</th>
                                <th>Final Price</th>
                                <th>Trainer</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td class="text-center">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/'.$member->photo) }}"
                                             width="45"
                                             height="45"
                                             class="rounded-circle"
                                             style="object-fit:cover;">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}"
                                             width="45"
                                             height="45"
                                             class="rounded-circle">
                                    @endif
                                </td>
                                <td>{{ $member->member_id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>
                                    @if($member->plan_type == 'membership')
                                        <span class="badge bg-primary">Membership</span>
                                    @elseif($member->plan_type == 'package')
                                        <span class="badge bg-success">Package</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $member->membership_plan }}
                                    </span>
                                </td>
                                <td>₹ {{ number_format($member->final_price ?? 0, 2) }}</td>
                                <td>
                                    @if($member->trainer)
                                        {{ $member->trainer->name }}
                                    @else
                                        <span class="badge bg-secondary">Not Assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($member->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ date('d-m-Y', strtotime($member->join_date)) }}</td>
                                <td>
                                    <a href="{{ route('admin.member.show', $member->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.member.edit', $member->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteMember({{ $member->id }})"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x d-block mb-2" style="color: #d1d5db;"></i>
                                    No members found. Click "Add New Member" to add one.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $members->links() }}
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
function deleteMember(id) {
    if(confirm('Are you sure you want to delete this member?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/members/' + id;
        form.submit();
    }
}
</script>
@endsection