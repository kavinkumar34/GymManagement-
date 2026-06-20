@extends('layouts.admin-layout')

@section('content')
<style>
    .review-image-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .review-image-gallery .gallery-item {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .review-image-gallery .gallery-item:hover {
        transform: scale(1.05);
    }
    .review-image-gallery .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .review-image-gallery .gallery-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .review-detail-modal .modal-dialog {
        max-width: 800px;
    }
    .review-detail-modal .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    .review-detail-modal .modal-header {
        background: linear-gradient(135deg, #1e293b, #2d3a4b);
        color: white;
        border-bottom: none;
        padding: 20px;
    }
    .review-detail-modal .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }
    .review-detail-modal .modal-body {
        padding: 25px;
    }
    
    .detail-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #eef2f6;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: 600;
        color: #475569;
        width: 150px;
        flex-shrink: 0;
    }
    .detail-value {
        color: #1e293b;
        flex: 1;
    }
    
    .rating-display {
        font-size: 1.2rem;
    }
    .rating-display .fas.fa-star {
        color: #f59e0b;
    }
    .rating-display .fas.fa-star.text-muted {
        color: #e2e8f0;
    }
    
    .media-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
    }
    .media-preview .media-item {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        position: relative;
    }
    .media-preview .media-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .media-preview .media-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .media-preview .media-item .media-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: rgba(0,0,0,0.7);
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-star"></i> Product Reviews</h4>
            <div>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-light btn-sm">All</a>
                <a href="{{ route('admin.reviews.pending') }}" class="btn btn-warning btn-sm">Pending</a>
                <a href="{{ route('admin.reviews.approved') }}" class="btn btn-success btn-sm">Approved</a>
                <a href="{{ route('admin.reviews.rejected') }}" class="btn btn-danger btn-sm">Rejected</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Media</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->product->name ?? 'N/A' }}</td>
                            <td>{{ $review->user->name ?? 'N/A' }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </td>
                            <td>{{ Str::limit($review->description, 50) }}</td>
                            <td>
                                @php
                                    $images = is_string($review->images) ? json_decode($review->images, true) : $review->images;
                                    $videos = is_string($review->videos) ? json_decode($review->videos, true) : $review->videos;
                                    $imageCount = is_array($images) ? count($images) : 0;
                                    $videoCount = is_array($videos) ? count($videos) : 0;
                                @endphp
                                @if($imageCount > 0)
                                    <span class="badge bg-info">{{ $imageCount }} Images</span>
                                @endif
                                @if($videoCount > 0)
                                    <span class="badge bg-danger">{{ $videoCount }} Videos</span>
                                @endif
                                @if($imageCount == 0 && $videoCount == 0)
                                    <span class="badge bg-secondary">No Media</span>
                                @endif
                            </td>
                            <td>
                                @if($review->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($review->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <!-- ⭐ View Button -->
                                <button type="button" class="btn btn-info btn-sm" title="View Details" onclick="viewReviewDetails({{ $review->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                @if($review->status == 'pending')
                                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('Delete this review?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <h5>No reviews found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ⭐ Review Details Modal -->
<div class="modal fade review-detail-modal" id="reviewDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-star me-2"></i> Review Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reviewDetailBody">
                <!-- Content will be injected by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ⭐ Image/Video Lightbox Modal -->
<div class="modal fade" id="mediaLightboxModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: rgba(0,0,0,0.9);">
            <div class="modal-body text-center p-0">
                <button type="button" class="btn-close btn-close-white position-absolute" style="top: 15px; right: 15px; z-index: 10;" data-bs-dismiss="modal"></button>
                <div id="lightboxContent" style="max-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
                    <!-- Content will be injected -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ⭐ View Review Details
async function viewReviewDetails(reviewId) {
    try {
        const response = await fetch(`/admin/reviews/${reviewId}/details`);
        const data = await response.json();
        
        if (data.success && data.review) {
            renderReviewDetails(data.review);
            const modal = new bootstrap.Modal(document.getElementById('reviewDetailModal'));
            modal.show();
        } else {
            alert('Error loading review details');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error loading review details');
    }
}

// ⭐ Render Review Details
function renderReviewDetails(review) {
    const body = document.getElementById('reviewDetailBody');
    
    // Parse images and videos
    let images = [];
    let videos = [];
    
    if (review.images) {
        try {
            images = typeof review.images === 'string' ? JSON.parse(review.images) : review.images;
        } catch(e) {
            images = [];
        }
    }
    if (review.videos) {
        try {
            videos = typeof review.videos === 'string' ? JSON.parse(review.videos) : review.videos;
        } catch(e) {
            videos = [];
        }
    }
    
    // Build status badge
    let statusBadge = '';
    if (review.status === 'pending') {
        statusBadge = '<span class="badge bg-warning">Pending</span>';
    } else if (review.status === 'approved') {
        statusBadge = '<span class="badge bg-success">Approved</span>';
    } else {
        statusBadge = '<span class="badge bg-danger">Rejected</span>';
    }
    
    // Build rating stars
    let starsHtml = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= review.rating) {
            starsHtml += '<i class="fas fa-star text-warning"></i>';
        } else {
            starsHtml += '<i class="fas fa-star text-muted"></i>';
        }
    }
    
    // Build media gallery
    let mediaHtml = '';
    if (images.length > 0) {
        mediaHtml += '<div class="review-image-gallery">';
        images.forEach(function(image, index) {
            mediaHtml += `
                <div class="gallery-item" onclick="openLightbox('image', '/storage/${image}', 'Image ${index + 1}')">
                    <img src="/storage/${image}" alt="Review Image ${index + 1}">
                </div>
            `;
        });
        mediaHtml += '</div>';
    }
    
    if (videos.length > 0) {
        mediaHtml += '<div class="review-image-gallery">';
        videos.forEach(function(video, index) {
            mediaHtml += `
                <div class="gallery-item" onclick="openLightbox('video', '/storage/${video}', 'Video ${index + 1}')">
                    <video src="/storage/${video}"></video>
                </div>
            `;
        });
        mediaHtml += '</div>';
    }
    
    if (!images.length && !videos.length) {
        mediaHtml = '<span class="text-muted">No media uploaded</span>';
    }
    
    body.innerHTML = `
        <div class="detail-row">
            <span class="detail-label">Review ID</span>
            <span class="detail-value">#${review.id}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Product</span>
            <span class="detail-value"><strong>${review.product_name || 'N/A'}</strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">User</span>
            <span class="detail-value">${review.user_name || 'N/A'} (${review.user_email || 'N/A'})</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Rating</span>
            <span class="detail-value rating-display">${starsHtml}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">${statusBadge}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Review</span>
            <span class="detail-value">${review.description || 'No description'}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Media</span>
            <span class="detail-value">${mediaHtml}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Submitted On</span>
            <span class="detail-value">${new Date(review.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
        </div>
    `;
}

// ⭐ Open Lightbox for images/videos
function openLightbox(type, src, title) {
    const content = document.getElementById('lightboxContent');
    
    if (type === 'image') {
        content.innerHTML = `
            <div style="max-width: 90vw; max-height: 85vh;">
                <img src="${src}" alt="${title}" style="max-width: 100%; max-height: 85vh; border-radius: 8px;">
                <p style="color: white; margin-top: 10px; text-align: center;">${title}</p>
            </div>
        `;
    } else if (type === 'video') {
        content.innerHTML = `
            <div style="max-width: 90vw; max-height: 85vh;">
                <video controls style="max-width: 100%; max-height: 85vh; border-radius: 8px;">
                    <source src="${src}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p style="color: white; margin-top: 10px; text-align: center;">${title}</p>
            </div>
        `;
    }
    
    const modal = new bootstrap.Modal(document.getElementById('mediaLightboxModal'));
    modal.show();
}

// ⭐ Close lightbox on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const lightbox = bootstrap.Modal.getInstance(document.getElementById('mediaLightboxModal'));
        if (lightbox) {
            lightbox.hide();
        }
    }
});
</script>
@endsection