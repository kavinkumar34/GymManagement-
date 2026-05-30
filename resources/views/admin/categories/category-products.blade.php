@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-box"></i> Products in Category: <strong>{{ $category->name }}</strong></h4>
                <a href="{{ route('admin.categories') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back to Categories
                </a>
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
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>₹{{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->discount_price)
                                        ₹{{ number_format($product->discount_price, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if($product->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center">No products in this category</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteProduct(id) {
    if(confirm('Delete this product?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/products/' + id;
        form.submit();
    }
}
</script>
@endsection