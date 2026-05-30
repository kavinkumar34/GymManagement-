@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between">
                <h4><i class="fas fa-envelope"></i> Message Details</h4>
                <a href="{{ route('admin.contacts') }}" class="btn btn-light">Back to List</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                             <tr><th width="30%">Name</th><td>{{ $contact->name }}</td></tr>
                             <tr><th>Email</th><td>{{ $contact->email }}</td></tr>
                             <tr><th>Subject</th><td>{{ $contact->subject }}</td></tr>
                             <tr>
                                <th>Status</th>
                                <td>
                                    <form method="POST" action="{{ route('admin.contacts.status', $contact->id) }}" style="display: inline;">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                            <option value="Pending" {{ $contact->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Read" {{ $contact->status == 'Read' ? 'selected' : '' }}>Read</option>
                                            <option value="Replied" {{ $contact->status == 'Replied' ? 'selected' : '' }}>Replied</option>
                                        </select>
                                    </form>
                                </td>
                             </tr>
                             <tr><th>Received</th><td>{{ $contact->created_at->format('d M Y, h:i A') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h5>Message:</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $contact->message }}
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button class="btn btn-success" onclick="replyEmail('{{ $contact->email }}')">
                        <i class="fas fa-reply"></i> Reply via Email
                    </button>
                    <button class="btn btn-danger" onclick="deleteContact({{ $contact->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
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
function deleteContact(id) {
    if(confirm('Delete this message?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/contacts/' + id;
        form.submit();
    }
}

function replyEmail(email) {
    window.location.href = 'mailto:' + email;
}
</script>
@endsection