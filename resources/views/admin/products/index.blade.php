@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-box me-2 text-primary"></i>Products</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Product</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light"><tr><th>ID</th><th>Image</th><th>Name</th><th>SKU</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" style="width:50px;height:50px;object-fit:cover;" class="rounded">@else<div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;"><i class="fas fa-box"></i></div>@endif</td>
                            <td><strong>{{ $product->name }}</strong><br><small class="text-muted">{{ $product->category->name ?? '' }} > {{ $product->subCategory->name ?? '' }}</small></td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>₹{{ number_format($product->price,2) }}<br>@if($product->discount_price)<span class="badge bg-success">-{{ round((($product->price-$product->discount_price)/$product->price)*100) }}%</span>@endif</td>
                            <td><span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">{{ $product->stock }}</span></td>
                            <td><span class="badge bg-{{ $product->status == 'Active' ? 'success' : 'secondary' }}">{{ $product->status }}</span></td>
                            <td><a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a><button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteItem({{ $product->id }})"><i class="fas fa-trash"></i></button><form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form></td>
                        </tr>
                        @empty<tr><td colspan="8" class="text-center">No products found</td></tr>@endforelse
                    </tbody>
                </table>
            </div>
            {{ $products->links() }}
        </div>
    </div>
</div>
<script>function deleteItem(id){if(confirm('Delete product?')){document.getElementById('delete-form-'+id).submit();}}</script>
@endsection