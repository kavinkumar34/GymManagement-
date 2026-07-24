@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-box"></i>
                    Packages List
                </h4>

                <a href="{{ route('admin.package.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i>
                    Add Package
                </a>

            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle text-center">

                        <thead class="table-dark">
                            <tr>
                                <th width="60">#</th>
                                <th width="100">Image</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Features</th>
                                <th>Status</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($packages as $key => $package)
                                <tr>
                                    <td>{{ $packages->firstItem() + $key }}</td>
                                    <td>
    @if($package->image)
        <img src="{{ asset('storage/' . $package->image) }}"
             width="70"
             height="70"
             class="rounded border"
             style="object-fit: cover;">
    @else
        <span class="text-muted">No Image</span>
    @endif
</td>

                                    <td>
                                        <strong>{{ $package->package_name }}</strong>
                                        @if($package->description)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>₹ {{ number_format($package->price, 2) }}</strong>
                                    </td>

                                    <td>
                                        {{ $package->duration }} {{ $package->duration_type }}
                                    </td>

                                    <td>
                                        @php
                                            $features = $package->getFeaturesArrayAttribute();
                                        @endphp
                                        @if(count($features) > 0)
                                            <span class="badge bg-info">{{ count($features) }}</span>
                                            <small class="text-muted d-block">
                                                {{ Str::limit(implode(', ', $features), 50) }}
                                            </small>
                                        @else
                                            <span class="text-muted">No features</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($package->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.package.edit', $package->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.package.destroy', $package->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this package?')">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="text-center p-4">
                                            <h5 class="text-muted">No Packages Found</h5>
                                            <a href="{{ route('admin.package.create') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-plus"></i>
                                                Create First Package
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $packages->links() }}
                </div>

            </div>

        </div>

    </div>
</div>

@endsection