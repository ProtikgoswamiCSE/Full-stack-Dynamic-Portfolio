<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achievements - Admin Panel</title>
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
        .status-badge { font-size: 0.75rem; }
        .btn-action { margin: 2px; }
        .modal-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
        .alert { border-radius: 10px; }
        .certificate-preview { max-width: 200px; max-height: 150px; object-fit: contain; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
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
                    <a class="nav-link" href="{{ route('admin.edit-project') }}">
                        <i class="fas fa-project-diagram me-2"></i> Edit Project
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
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="main-content p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-trophy me-2"></i>Edit Achievements</h2>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#achievementModal">
                            <i class="fas fa-plus me-2"></i>Add New Achievement
                        </button>
                        <a href="/achivement" target="_blank" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-eye me-2"></i>View Achievements Page
                        </a>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Achievements Cards -->
                <div class="row" id="achievementsContainer">
                    @foreach($achievements as $achievement)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card achievement-card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Achievement</h6>
                                <span class="badge {{ $achievement->is_active ? 'bg-success' : 'bg-secondary' }} status-badge">
                                    {{ $achievement->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="card-body">
                                @if($achievement->certificate_image)
                                <div class="text-center mb-3">
                                    @if(Str::endsWith($achievement->certificate_image, '.pdf'))
                                        <div class="certificate-preview bg-light d-flex flex-column align-items-center justify-content-center rounded">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <small class="text-muted">PDF File</small>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $achievement->certificate_image) }}" 
                                             alt="{{ $achievement->title }}" 
                                             class="certificate-preview img-fluid rounded">
                                    @endif
                                </div>
                                @elseif($achievement->certificate_url)
                                <div class="text-center mb-3">
                                    <img src="{{ $achievement->certificate_url }}" 
                                         alt="{{ $achievement->title }}" 
                                         class="certificate-preview img-fluid rounded">
                                </div>
                                @else
                                <div class="text-center mb-3">
                                    <div class="certificate-preview bg-light d-flex align-items-center justify-content-center rounded">
                                        <i class="fas fa-certificate fa-3x text-muted"></i>
                                    </div>
                                </div>
                                @endif
                                
                                <h6 class="card-title">{{ $achievement->title ?: 'No Title' }}</h6>
                                <p class="card-text small text-muted">
                                    {{ Str::limit($achievement->description, 100) }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Order: {{ $achievement->order }}</small>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary btn-action" 
                                                onclick="editAchievement({{ $achievement->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-warning btn-action" 
                                                onclick="toggleAchievement({{ $achievement->id }})">
                                            <i class="fas fa-{{ $achievement->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-action" 
                                                onclick="deleteAchievement({{ $achievement->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($achievements->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Achievements Found</h5>
                    <p class="text-muted">Click "Add New Achievement" to create your first achievement.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Achievement Modal -->
<div class="modal fade" id="achievementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Achievement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="achievementForm">
                <div class="modal-body">
                    <input type="hidden" id="achievementId" name="id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Achievement Title *</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       required placeholder="e.g., Thinking in Object Oriented Programming: Basic Concept">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" 
                                          placeholder="Describe the achievement, skills learned, etc."></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                                                            <div class="mb-3">
                                    <label for="certificate_image" class="form-label">Certificate File</label>
                                    <input type="file" class="form-control" id="certificate_image" name="certificate_image" 
                                           accept=".jpg,.jpeg,.png,.gif,.pdf">
                                    <div class="form-text">Upload certificate file (JPG, PNG, GIF, PDF). Max size: 5MB.</div>
                                </div>
                            <div class="mb-3">
                                <label for="certificate_url" class="form-label">Certificate URL</label>
                                <input type="url" class="form-control" id="certificate_url" name="certificate_url" 
                                       placeholder="https://example.com/certificate">
                                <div class="form-text">Or provide a URL to the certificate</div>
                            </div>
                            <div class="mb-3">
                                <label for="order" class="form-label">Display Order *</label>
                                <input type="number" class="form-control" id="order" name="order" 
                                       min="1" required placeholder="1, 2, 3...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this achievement? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let deleteAchievementId = null;

// Show alert message
function showAlert(message, type = 'success') {
    console.log('Showing alert:', message, type);
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('#alertContainer').html(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Add new achievement
function addAchievement() {
    $('#modalTitle').text('Add New Achievement');
    $('#achievementForm')[0].reset();
    $('#achievementId').val('');
    $('#achievementModal').modal('show');
}

// Edit achievement
function editAchievement(id) {
    // Fetch achievement data and populate form
    $.get(`/admin/achievement/${id}`, function(data) {
        $('#modalTitle').text('Edit Achievement');
        $('#achievementId').val(data.id);
        $('#title').val(data.title);
        $('#description').val(data.description);
        $('#certificate_url').val(data.certificate_url);
        $('#order').val(data.order);
        $('#achievementModal').modal('show');
    }).fail(function() {
        showAlert('Error loading achievement data', 'danger');
    });
}

// Toggle achievement status
function toggleAchievement(id) {
    // Find the button that was clicked
    const button = event.target.closest('button');
    const originalIcon = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    $.post(`/admin/achievement/${id}/toggle`, {
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        if (response.success) {
            showAlert(response.message);
            
            // Update the UI immediately without page reload
            const card = button.closest('.card');
            const statusBadge = card.querySelector('.status-badge');
            const icon = button.querySelector('i');
            
            if (response.is_active) {
                // Now active - show eye-slash icon
                statusBadge.className = 'badge bg-success status-badge';
                statusBadge.textContent = 'Active';
                icon.className = 'fas fa-eye-slash';
            } else {
                // Now inactive - show eye icon
                statusBadge.className = 'badge bg-secondary status-badge';
                statusBadge.textContent = 'Inactive';
                icon.className = 'fas fa-eye';
            }
            
            // Re-enable button
            button.disabled = false;
        } else {
            showAlert(response.message, 'danger');
            // Restore original icon
            button.innerHTML = originalIcon;
            button.disabled = false;
        }
    })
    .fail(function(xhr, status, error) {
        console.error('Toggle error:', xhr.responseText);
        showAlert('Error toggling achievement status', 'danger');
        // Restore original icon
        button.innerHTML = originalIcon;
        button.disabled = false;
    });
}

// Delete achievement
function deleteAchievement(id) {
    deleteAchievementId = id;
    $('#deleteModal').modal('show');
}

// Confirm delete
$('#confirmDelete').click(function() {
    if (deleteAchievementId) {
        $.post(`/admin/achievement/${deleteAchievementId}/delete`, {
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            if (response.success) {
                showAlert(response.message);
                $('#deleteModal').modal('hide');
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert(response.message, 'danger');
            }
        })
        .fail(function() {
            showAlert('Error deleting achievement', 'danger');
        });
    }
});

// Handle form submission
$('#achievementForm').submit(function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const achievementId = $('#achievementId').val();
    const url = achievementId ? `/admin/achievement/${achievementId}/update` : '/admin/achievement/add';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .done(function(response) {
        if (response.success) {
            showAlert(response.message);
            $('#achievementModal').modal('hide');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(response.message, 'danger');
        }
    })
    .fail(function() {
        showAlert('Error saving achievement', 'danger');
    });
});

// Add new achievement button
$(document).on('click', '[data-bs-target="#achievementModal"]', function() {
    addAchievement();
});
</script>

</body>
</html>
