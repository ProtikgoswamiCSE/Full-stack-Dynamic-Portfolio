<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Images - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar .nav-link { color: white; padding: 15px 20px; margin: 5px 0; border-radius: 10px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; }
        .ai-image-preview img { max-height: 300px; width: 100%; object-fit: cover; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Admin Panel
                    </h4>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-home') }}">
                            <i class="fas fa-edit me-2"></i> Edit Home
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-about') }}">
                            <i class="fas fa-user me-2"></i> Edit About
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-achivement') }}">
                            <i class="fas fa-trophy me-2"></i> Edit Achievements
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-academic') }}">
                            <i class="fas fa-graduation-cap me-2"></i> Edit Academic
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-work') }}">
                            <i class="fas fa-briefcase me-2"></i> Edit Work
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-project') }}">
                            <i class="fas fa-project-diagram me-2"></i> Edit Project
                        </a>
                        <a class="nav-link active" href="{{ route('admin.edit-image') }}">
                            <i class="fas fa-images me-2"></i> Edit Images
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-contact') }}">
                            <i class="fas fa-envelope me-2"></i> Edit Contact
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-footer') }}">
                            <i class="fas fa-shoe-prints me-2"></i> Edit Footer
                        </a>
                        <a class="nav-link" href="{{ route('admin.data-management') }}">
                            <i class="fas fa-database me-2"></i> Data Management
                        </a>
                        <a class="nav-link" href="{{ route('admin.login-details') }}">
                            <i class="fas fa-user-shield me-2"></i> Login Details
                        </a>
                        <a class="nav-link" href="/" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> View Site
                        </a>
                    </nav>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="main-content p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-images me-2"></i>Edit Images</h2>
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-3">Welcome, {{ Auth::user()->name }}!</span>
                            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- AI Image Management for Skills Page -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-robot me-2"></i>AI Image for Skills Page</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateAiImageModal">
                                <i class="fas fa-upload me-2"></i>Update AI Image
                            </button>
                        </div>
                        <div class="card-body">
                            @if(isset($aiImage) && $aiImage)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ai-image-preview">
                                            <img src="{{ asset('storage/' . $aiImage->image_path) }}" 
                                                 alt="{{ $aiImage->alt_text }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 300px; width: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-info-circle me-2"></i>Image Information</h6>
                                        <p><strong>Alt Text:</strong> {{ $aiImage->alt_text ?: 'No alt text provided' }}</p>
                                        <p><strong>Uploaded:</strong> {{ $aiImage->created_at->format('M d, Y H:i') }}</p>
                                        <p><strong>Last Updated:</strong> {{ $aiImage->updated_at->format('M d, Y H:i') }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-success">Active</span>
                                        </p>
                                        <div class="mt-3">
                                            <button class="btn btn-outline-primary btn-sm" onclick="refreshAiImage()">
                                                <i class="fas fa-sync-alt me-1"></i>Refresh Preview
                                            </button>
                                            <a href="{{ url('/skills') }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-external-link-alt me-1"></i>View on Skills Page
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-robot fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No AI Image Set</h5>
                                    <p class="text-muted">Upload an AI-generated image for the skills page</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateAiImageModal">
                                        <i class="fas fa-upload me-2"></i>Upload AI Image
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Gallery Images Management -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-photo-film me-2"></i>Gallery Images (Image page)</h5>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGalleryImageModal">
                                <i class="fas fa-plus me-2"></i>Add Image
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach(($galleryImages ?? []) as $g)
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/' . $g->image_path) }}" class="card-img-top" alt="{{ $g->alt_text }}" style="height:220px; object-fit:cover">
                                            <div class="card-body">
                                                <p class="mb-1"><strong>Alt:</strong> {{ $g->alt_text ?? '—' }}</p>
                                                <p class="mb-1"><strong>Order:</strong> {{ $g->order }}</p>
                                                <p class="mb-2"><strong>Status:</strong> <span class="badge {{ $g->is_active?'bg-success':'bg-secondary' }}">{{ $g->is_active?'Active':'Hidden' }}</span></p>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-outline-primary btn-sm" onclick="openEditGallery({{ $g->id }}, '{{ $g->alt_text }}', {{ $g->order }}, {{ $g->is_active?1:0 }})"><i class="fas fa-pen"></i></button>
                                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteGallery({{ $g->id }})"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if(($galleryImages ?? collect())->isEmpty())
                                    <p class="text-muted">No gallery images yet. Add one.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Image Management Info -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Image Management Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-lightbulb me-2"></i>How AI Images Work:</h6>
                                <ul class="mb-0">
                                    <li>AI images are displayed on the skills page and automatically refresh every 2 seconds</li>
                                    <li>Only one AI image can be active at a time</li>
                                    <li>Uploaded images are stored in the storage/app/public/ai-images directory</li>
                                    <li>Supported formats: JPEG, PNG, JPG, GIF (Max 5MB)</li>
                                    <li>Images are optimized for web display</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update AI Image Modal -->
    <div class="modal fade" id="updateAiImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update AI Image for Skills Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="updateAiImageForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ai_image" class="form-label">AI Generated Image</label>
                            <input type="file" class="form-control" id="ai_image" name="image" accept="image/*" required>
                            <div class="form-text">Upload a new AI-generated image (JPEG, PNG, JPG, GIF - Max 5MB)</div>
                        </div>
                        <div class="mb-3">
                            <label for="ai_alt_text" class="form-label">Alt Text</label>
                            <input type="text" class="form-control" id="ai_alt_text" name="alt_text" placeholder="Describe the image for accessibility">
                            <div class="form-text">Optional: Describe the image for screen readers</div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> This image will be displayed on the skills page and will automatically refresh every 2 seconds for visitors.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Update AI Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Gallery Image Modal -->
    <div class="modal fade" id="addGalleryImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Gallery Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addGalleryForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alt Text</label>
                            <input type="text" class="form-control" name="alt_text" placeholder="optional">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" class="form-control" name="order" min="1" placeholder="auto">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Gallery Image Modal -->
    <div class="modal fade" id="editGalleryImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gallery Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editGalleryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_gallery_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Replace Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alt Text</label>
                            <input type="text" class="form-control" name="alt_text" id="edit_gallery_alt">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" class="form-control" name="order" id="edit_gallery_order" min="1">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="edit_gallery_active" name="is_active">
                            <label class="form-check-label" for="edit_gallery_active">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // AI Image Management Functions
        function refreshAiImage() {
            fetch('/api/ai-image/skills')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the image preview
                        const imgElement = document.querySelector('.ai-image-preview img');
                        if (imgElement) {
                            imgElement.src = data.image_url + '?t=' + new Date().getTime();
                            imgElement.alt = data.alt_text;
                        }
                        
                        // Update the info section
                        const altTextElement = document.querySelector('.ai-image-preview').parentElement.nextElementSibling.querySelector('p:first-child');
                        if (altTextElement) {
                            altTextElement.innerHTML = `<strong>Alt Text:</strong> ${data.alt_text || 'No alt text'}`;
                        }
                        
                        // Show success message
                        showNotification('AI image refreshed successfully!', 'success');
                    } else {
                        showNotification('Failed to refresh AI image', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error refreshing AI image:', error);
                    showNotification('Error refreshing AI image', 'error');
                });
        }

        // Handle AI image form submission
        document.getElementById('updateAiImageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
            submitBtn.disabled = true;
            
            fetch('{{ route("admin.ai-image.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('updateAiImageModal'));
                    modal.hide();
                    
                    // Refresh the page to show updated image
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error updating AI image:', error);
                showNotification('Error updating AI image', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Gallery JS
        document.getElementById('addGalleryForm')?.addEventListener('submit', function(e){
            e.preventDefault();
            const formData = new FormData(this);
            fetch('{{ route('admin.gallery.add') }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            }).then(r=>r.json()).then(d=>{
                if(d.success){ showNotification('Image added','success'); setTimeout(()=>location.reload(),800); } else { showNotification('Failed to add','error'); }
            }).catch(()=>showNotification('Error adding','error'));
        });

        function openEditGallery(id, alt, order, active){
            document.getElementById('edit_gallery_id').value = id;
            document.getElementById('edit_gallery_alt').value = alt || '';
            document.getElementById('edit_gallery_order').value = order || 1;
            document.getElementById('edit_gallery_active').checked = !!active;
            new bootstrap.Modal(document.getElementById('editGalleryImageModal')).show();
        }

        document.getElementById('editGalleryForm')?.addEventListener('submit', function(e){
            e.preventDefault();
            const id = document.getElementById('edit_gallery_id').value;
            const formData = new FormData(this);
            fetch(`/admin/gallery/${id}/update`, {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            }).then(r=>r.json()).then(d=>{
                if(d.success){ showNotification('Image updated','success'); setTimeout(()=>location.reload(),800); } else { showNotification('Failed to update','error'); }
            }).catch(()=>showNotification('Error updating','error'));
        });

        function deleteGallery(id){
            if(!confirm('Delete this image?')) return;
            fetch(`/admin/gallery/${id}/delete`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
            .then(r=>r.json()).then(d=>{
                if(d.success){ showNotification('Image deleted','success'); setTimeout(()=>location.reload(),800); } else { showNotification('Failed to delete','error'); }
            }).catch(()=>showNotification('Error deleting','error'));
        }

        // Notification function
        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="${iconClass} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert
            const container = document.querySelector('.main-content .p-4');
            container.insertAdjacentHTML('afterbegin', alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>
