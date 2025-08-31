<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Edit Achievement - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar .nav-link { color: white; padding: 15px 20px; margin: 5px 0; border-radius: 10px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .achievement-card { transition: all 0.3s; }
        .achievement-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .certificate-preview { max-width: 200px; max-height: 150px; object-fit: contain; }
        .drag-handle { cursor: move; color: #6c757d; }
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
                        <a class="nav-link active" href="{{ route('admin.edit-achivement') }}">
                            <i class="fas fa-trophy me-2"></i> Edit Achievements
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-academic') }}">
                            <i class="fas fa-graduation-cap me-2"></i> Edit Academic
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-work') }}">
                            <i class="fas fa-briefcase me-2"></i> Edit Work
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-image') }}">
                            <i class="fas fa-images me-2"></i> Edit Images
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-contact') }}">
                            <i class="fas fa-envelope me-2"></i> Edit Contact
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-footer') }}">
                            <i class="fas fa-shoe-prints me-2"></i> Edit Footer
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
                        <h2><i class="fas fa-trophy me-2"></i>Edit Achievement</h2>
                        <div>
                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                                <i class="fas fa-plus me-2"></i>Add New Achievement
                            </button>
                            <a href="{{ route('admin.edit-home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </div>

                    <!-- Debug Information -->
                    @if(config('app.debug'))
                    <div class="alert alert-info">
                        <strong>Debug Info:</strong>
                        <br>Achievements Count: {{ $achievements->count() }}
                        <br>Current Time: {{ now() }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <!-- Achievements List -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Achievements List</h5>
                                </div>
                                <div class="card-body">
                                    <div id="achievementsContainer">
                                        @if($achievements && $achievements->count() > 0)
                                            @foreach($achievements as $achievement)
                                                <div class="card mb-3 achievement-card" data-id="{{ $achievement->id }}">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-2">
                                                                <div class="text-center">
                                                                    @if($achievement->certificate_image)
                                                                        <img src="{{ $achievement->getCertificateImageUrlAttribute() }}" alt="Certificate" class="certificate-preview img-fluid mb-2">
                                                                    @elseif($achievement->certificate_url)
                                                                        <img src="{{ $achievement->certificate_url }}" alt="Certificate" class="certificate-preview img-fluid mb-2">
                                                                    @else
                                                                        <div class="certificate-preview bg-light d-flex align-items-center justify-content-center">
                                                                            <i class="fas fa-certificate fa-3x text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="border-start border-primary border-3 me-3" style="height: 40px;"></div>
                                                                    <div>
                                                                        <h6 class="mb-1 fw-bold">{{ $achievement->title }}</h6>
                                                                        @if($achievement->description)
                                                                            <p class="text-muted mb-2 small">{{ Str::limit($achievement->description, 150) }}</p>
                                                                        @endif
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="badge bg-{{ $achievement->is_active ? 'success' : 'secondary' }} me-2">
                                                                                {{ $achievement->is_active ? 'Active' : 'Inactive' }}
                                                                            </span>
                                                                            <span class="text-muted small">Order: {{ $achievement->order }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 text-end">
                                                                <div class="btn-group-vertical" role="group">
                                                                    <button type="button" class="btn btn-sm btn-outline-primary mb-1" onclick="editAchievement({{ $achievement->id }}, '{{ $achievement->title }}', '{{ $achievement->description }}', '{{ $achievement->certificate_url }}', {{ $achievement->order }})">
                                                                        <i class="fas fa-edit me-1"></i>Edit
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-warning mb-1" onclick="toggleAchievement({{ $achievement->id }})">
                                                                        <i class="fas fa-eye{{ $achievement->is_active ? '-slash' : '' }} me-1"></i>{{ $achievement->is_active ? 'Deactivate' : 'Activate' }}
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAchievement({{ $achievement->id }})">
                                                                        <i class="fas fa-trash me-1"></i>Delete
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted py-5">
                                                <i class="fas fa-trophy fa-4x mb-3"></i>
                                                <h5>No achievements added yet</h5>
                                                <p>Start by adding your first achievement!</p>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                                                    <i class="fas fa-plus me-2"></i>Add First Achievement
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Achievement Modal -->
    <div class="modal fade" id="addAchievementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addAchievementForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Achievement Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., Thinking in Object Oriented Programming: Basic Concept">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the achievement, skills learned, etc."></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="certificate_image" class="form-label">Certificate Image</label>
                                    <input type="file" class="form-control" id="certificate_image" name="certificate_image" accept="image/*">
                                    <small class="text-muted">Upload certificate image (JPEG, PNG, JPG, GIF)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="certificate_url" class="form-label">Certificate URL</label>
                                    <input type="url" class="form-control" id="certificate_url" name="certificate_url" placeholder="https://example.com/certificate">
                                    <small class="text-muted">Or provide a URL to the certificate</small>
                                </div>
                                <div class="mb-3">
                                    <label for="order" class="form-label">Display Order *</label>
                                    <input type="number" class="form-control" id="order" name="order" value="1" min="1" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addAchievement()">Add Achievement</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Achievement Modal -->
    <div class="modal fade" id="editAchievementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAchievementForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="editAchievementId" name="id">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Achievement Title *</label>
                                    <input type="text" class="form-control" id="editTitle" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="editDescription" name="description" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editCertificateImage" class="form-label">Certificate Image</label>
                                    <input type="file" class="form-control" id="editCertificateImage" name="certificate_image" accept="image/*">
                                    <small class="text-muted">Upload new image to replace existing one</small>
                                </div>
                                <div class="mb-3">
                                    <label for="editCertificateUrl" class="form-label">Certificate URL</label>
                                    <input type="url" class="form-control" id="editCertificateUrl" name="certificate_url">
                                </div>
                                <div class="mb-3">
                                    <label for="editOrder" class="form-label">Display Order *</label>
                                    <input type="number" class="form-control" id="editOrder" name="order" min="1" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateAchievement()">Update Achievement</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to show alerts
        function showAlert(message, type = 'info') {
            // Remove existing alerts
            const existingAlert = document.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Create new alert
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Insert alert at the top of main content
            const mainContent = document.querySelector('.main-content');
            mainContent.insertBefore(alertDiv, mainContent.firstChild);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Add Achievement
        function addAchievement() {
            const form = document.getElementById('addAchievementForm');
            const formData = new FormData(form);
            
            // Show loading state
            const submitBtn = document.querySelector('#addAchievementModal .btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
            submitBtn.disabled = true;
            
            fetch('{{ route("admin.achievement.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Achievement added successfully!', 'success');
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addAchievementModal'));
                    if (modal) modal.hide();
                    // Reset form
                    form.reset();
                    // Refresh page after 1 second
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                } else {
                    showAlert('Error adding achievement: ' + (data.message || 'Unknown error'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error adding achievement. Please try again.', 'danger');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Edit Achievement
        function editAchievement(id, title, description, certificateUrl, order) {
            document.getElementById('editAchievementId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description || '';
            document.getElementById('editCertificateUrl').value = certificateUrl || '';
            document.getElementById('editOrder').value = order;
            
            const modal = new bootstrap.Modal(document.getElementById('editAchievementModal'));
            modal.show();
        }

        // Update Achievement
        function updateAchievement() {
            const id = document.getElementById('editAchievementId').value;
            const form = document.getElementById('editAchievementForm');
            const formData = new FormData(form);
            
            // Show loading state
            const submitBtn = document.querySelector('#editAchievementModal .btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
            
            fetch(`{{ url('/admin/achievement') }}/${id}/update`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Achievement updated successfully!', 'success');
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editAchievementModal'));
                    if (modal) modal.hide();
                    // Refresh page after 1 second
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                } else {
                    showAlert('Error updating achievement: ' + (data.message || 'Unknown error'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error updating achievement. Please try again.', 'danger');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Delete Achievement
        function deleteAchievement(id) {
            if (confirm('Are you sure you want to delete this achievement? This action cannot be undone.')) {
                fetch(`{{ url('/admin/achievement') }}/${id}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Achievement deleted successfully!', 'success');
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 1000);
                    } else {
                        showAlert('Error deleting achievement: ' + (data.message || 'Unknown error'), 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error deleting achievement. Please try again.', 'danger');
                });
            }
        }

        // Toggle Achievement Status
        function toggleAchievement(id) {
            fetch(`{{ url('/admin/achievement') }}/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                } else {
                    showAlert('Error toggling achievement: ' + (data.message || 'Unknown error'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error toggling achievement. Please try again.', 'danger');
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Achievement editor page loaded');
            
            // Test if Bootstrap modal is available
            if (typeof bootstrap !== 'undefined') {
                console.log('Bootstrap is loaded');
            } else {
                console.error('Bootstrap is not loaded');
            }
        });
    </script>
</body>
</html>
