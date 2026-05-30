@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-box"></i> Products Management</h4>
                <a href="{{ route('admin.products.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Add Product
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
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Featured</th>
                                <th>Best Seller</th>
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
                                        <img src="{{ Storage::url($product->image) }}" width="50" height="50" style="object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="bg-light p-2 text-center" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                 </div>
                                <td>{{ $product->category ? $product->category->name : 'Uncategorized' }}</div>
                                <td>₹{{ number_format($product->price, 2) }}</div>
                                <td>
                                    @if($product->discount_price)
                                        ₹{{ number_format($product->discount_price, 2) }}
                                        <span class="badge bg-success">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span>
                                    @else
                                        <span class="text-muted">No Discount</span>
                                    @endif
                                 </div>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of stock</span>
                                    @endif
                                 </div>
                                <td>
                                    @if($product->is_featured)
                                        <span class="badge bg-warning">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                 </div>
                                <td>
                                    @if($product->is_best_seller)
                                        <span class="badge bg-danger">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                 </div>
                                <td>
                                    @if($product->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                 </div>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info" title="View Product">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})" title="Delete Product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                 </div>
                             </div>
                            @empty
                             </div>
                                <td colspan="11" class="text-center">
                                    <div class="py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5>No products found</h5>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Add Your First Product
                                        </a>
                                    </div>
                                </div>
                             </div>
                            @endforelse
                        </tbody>
                    </div>
                </div>
                
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-product-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteProduct(id) {
        if(confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            let form = document.getElementById('delete-product-form');
            form.action = '/admin/products/' + id;
            form.submit();
        }
    }
</script>
@endsection