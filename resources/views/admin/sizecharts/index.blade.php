@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid"style=" margin-left:100px;">
    <div class="card shadow-sm mx-auto" style="max-width:1200px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Size Charts</h5>
            <a href="{{ route('admin.sizecharts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Size Chart
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
                            <th>Title</th>
                            <th>Gender</th>
                            <th>Category Type</th>
                            <th>Sizes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizeCharts as $chart)
                        <tr>
                            <td>{{ $chart->id }}</td>
                            <td>
                                @if($chart->image)
                                    <img src="{{ asset('storage/'.$chart->image) }}" style="width:40px;height:40px;object-fit:cover;" class="rounded">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                @endif
                              </td>
                            <td><strong>{{ $chart->title }}</strong></td>
                            <td><span class="badge bg-primary">{{ ucfirst($chart->gender) }}</span></td>
                            <td><span class="badge bg-info">{{ ucfirst($chart->category_type) }}</span></td>
                            <td><span class="badge bg-secondary">{{ is_array($chart->sizes) ? count($chart->sizes) : 0 }} sizes</span></td>
                            <td>
                                <a href="{{ route('admin.sizecharts.edit', $chart->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $chart->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $chart->id }}" action="{{ route('admin.sizecharts.destroy', $chart->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                              </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No size charts found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $sizeCharts->links() }}
        </div>
    </div>
</div>

<script>
function deleteItem(id) {
    if(confirm('Delete this size chart?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection



