@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fas fa-envelope"></i> Contact Messages</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->subject }}</td>
                                <td>
                                    @if($contact->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($contact->status == 'Read')
                                        <span class="badge bg-info">Read</span>
                                    @else
                                        <span class="badge bg-success">Replied</span>
                                    @endif
                                </td>
                                <td>{{ $contact->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteContact({{ $contact->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                 </td>
                             </tr>
                            @empty
                             <tr><td colspan="7" class="text-center">No messages found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteContact(id) {
    if(confirm('Delete this message?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/contacts/' + id;
        form.submit();
    }
}
</script>
@endsection