@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-box"></i> Product Details</h4>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.products') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" class="img-fluid rounded" style="max-height: 250px;">
                            @else
                                <div class="bg-light p-5 text-center rounded">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                    <p class="mt-2">No Image</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr><th>Product Name</th><td>{{ $product->name }}</div></tr>
                            <tr><th>Category</th><td>{{ $product->category->name ?? 'Uncategorized' }}</div></tr>
                            <tr><th>Price</th><td>₹{{ number_format($product->price, 2) }}</div></tr>
                            <tr><th>Discount Price</th><td>
                                @if($product->discount_price)
                                    ₹{{ number_format($product->discount_price, 2) }}
                                    <span class="badge bg-success">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span>
                                @else
                                    No Discount
                                @endif
                            </div></tr>
                            <tr><th>Stock</th><td>
                                @if($product->stock > 0)
                                    <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                @else
                                    <span class="badge bg-danger">Out of stock</span>
                                @endif
                            </div></tr>
                            <tr><th>Featured</th><td>{{ $product->is_featured ? 'Yes' : 'No' }}</div></tr>
                            <tr><th>Best Seller</th><td>{{ $product->is_best_seller ? 'Yes' : 'No' }}</div></tr>
                            <tr><th>Status</th><td>
                                @if($product->status == 'Active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div></tr>
                            <tr><th>Created Date</th><td>{{ $product->created_at->format('d M Y, h:i A') }}</div></tr>
                            <tr><th>Last Updated</th><td>{{ $product->updated_at->format('d M Y, h:i A') }}</div></tr>
                        </div>
                        <div class="mt-3">
                            <h5>Description:</h5>
                            <div class="p-3 bg-light rounded">
                                {{ $product->description ?: 'No description available.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection