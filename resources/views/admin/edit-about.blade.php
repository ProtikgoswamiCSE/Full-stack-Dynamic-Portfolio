<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar .nav-link { color: white; padding: 15px 20px; margin: 5px 0; border-radius: 10px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .content-card { transition: all 0.3s; }
        .content-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .status-badge { font-size: 0.75rem; }
        .btn-action { margin: 2px; }
        .modal-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
        .alert { border-radius: 10px; }
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
                    <a class="nav-link active" href="{{ route('admin.edit-about') }}">
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
                    <h2><i class="fas fa-user me-2"></i>Edit About Page</h2>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addContentModal">
                            <i class="fas fa-plus me-2"></i>Add New Section
                        </button>
                        <a href="/about" target="_blank" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-eye me-2"></i>View About Page
                        </a>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- About Content Cards -->
                <div class="row" id="aboutContentContainer">
                    @foreach($aboutContents as $content)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card content-card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 text-capitalize">{{ $content->display_section }}</h6>
                                <span class="badge {{ $content->is_active ? 'bg-success' : 'bg-secondary' }} status-badge">
                                    {{ $content->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="card-body">
                                @if($content->image)
                                <div class="text-center mb-3">
                                    @if(Str::startsWith($content->image, 'http'))
                                        <img src="{{ $content->image }}" alt="{{ $content->title }}" 
                                             class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}" 
                                             class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                    @endif
                                </div>
                                @endif
                                <h6 class="card-title">{{ $content->title ?: 'No Title' }}</h6>
                                <p class="card-text small text-muted">
                                    {{ Str::limit($content->content, 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Order: {{ $content->order }}</small>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary btn-action" 
                                                onclick="editContent({{ $content->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-warning btn-action" 
                                                onclick="toggleContent({{ $content->id }})">
                                            <i class="fas fa-{{ $content->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-action" 
                                                onclick="deleteContent({{ $content->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($aboutContents->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No About Content Found</h5>
                    <p class="text-muted">Click "Add New Section" to create your first about content.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Content Modal -->
<div class="modal fade" id="contentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New About Section</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="contentForm">
                <div class="modal-body">
                    <input type="hidden" id="contentId" name="id">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="section" class="form-label">Section Type *</label>
                                <select class="form-select" id="section" name="section" required>
                                    <option value="">Select Section</option>
                                    <option value="main">Main About</option>
                                    <option value="ai">Artificial Intelligence</option>
                                    <option value="programming">Programming</option>
                                    <option value="cybersecurity">Cyber Security</option>
                                    <option value="custom">Custom Section</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="custom_section" class="form-label">Custom Section Name</label>
                                <input type="text" class="form-control" id="custom_section" name="custom_section" 
                                       placeholder="Enter custom section name" style="display: none;">
                                <div class="form-text">Only required if "Custom Section" is selected</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="order" class="form-label">Display Order *</label>
                                <input type="number" class="form-control" id="order" name="order" 
                                       min="1" required placeholder="1, 2, 3...">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="Enter section title">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="6" 
                                  required placeholder="Enter the content for this section..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image/GIF Upload</label>
                        <input type="file" class="form-control" id="image" name="image" 
                               accept=".jpg,.jpeg,.png,.gif">
                        <div class="form-text">Upload an image file (JPG, PNG, GIF). Max size: 5MB. GIF files are supported for animations.</div>
                        <div id="currentImage" class="mt-2" style="display: none;">
                            <small class="text-muted">Current image/GIF:</small>
                            <img id="currentImagePreview" class="img-fluid rounded mt-1" style="max-height: 100px;">
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
                <p>Are you sure you want to delete this about section? This action cannot be undone.</p>
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
let deleteContentId = null;

// Show alert message
function showAlert(message, type = 'success') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('#alertContainer').html(alertHtml);
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
}

// Add new content
function addContent() {
    $('#modalTitle').text('Add New About Section');
    $('#contentForm')[0].reset();
    $('#contentId').val('');
    $('#currentImage').hide();
    $('#contentModal').modal('show');
}

// Edit content
function editContent(id) {
    // Fetch content data and populate form
    $.get(`/admin/about/${id}`, function(data) {
        $('#modalTitle').text('Edit About Section');
        $('#contentId').val(data.id);
        $('#section').val(data.section);
        $('#custom_section').val(data.custom_section);
        $('#title').val(data.title);
        $('#content').val(data.content);
        $('#order').val(data.order);
        
        // Show current image if exists
        if (data.image) {
            $('#currentImage').show();
            if (data.image.startsWith('http')) {
                $('#currentImagePreview').attr('src', data.image);
            } else {
                $('#currentImagePreview').attr('src', '/storage/' + data.image);
            }
        } else {
            $('#currentImage').hide();
        }
        
        $('#contentModal').modal('show');
    }).fail(function() {
        showAlert('Error loading content data', 'danger');
    });
}

// Toggle content status
function toggleContent(id) {
    // Find the button that was clicked
    const button = event.target.closest('button');
    const originalIcon = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    $.post(`/admin/about/${id}/toggle`, {
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
        showAlert('Error toggling content status', 'danger');
        // Restore original icon
        button.innerHTML = originalIcon;
        button.disabled = false;
    });
}

// Delete content
function deleteContent(id) {
    deleteContentId = id;
    $('#deleteModal').modal('show');
}

// Confirm delete
$('#confirmDelete').click(function() {
    if (deleteContentId) {
        $.post(`/admin/about/${deleteContentId}/delete`, {
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
            showAlert('Error deleting content', 'danger');
        });
    }
});

// Handle form submission
$('#contentForm').submit(function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const contentId = $('#contentId').val();
    const url = contentId ? `/admin/about/${contentId}/update` : '/admin/about/add';
    
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
            $('#contentModal').modal('hide');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(response.message, 'danger');
        }
    })
    .fail(function() {
        showAlert('Error saving content', 'danger');
    });
});

// Add new content button
$(document).on('click', '[data-bs-target="#addContentModal"]', function() {
    addContent();
});

// Handle custom section field visibility
$(document).on('change', '#section', function() {
    if ($(this).val() === 'custom') {
        $('#custom_section').show().prop('required', true);
    } else {
        $('#custom_section').hide().prop('required', false);
    }
});

// Handle image preview
$(document).on('change', '#image', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#currentImage').show();
            $('#currentImagePreview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>
