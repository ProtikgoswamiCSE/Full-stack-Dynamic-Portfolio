<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Academic - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar .nav-link { color: white; padding: 15px 20px; margin: 5px 0; border-radius: 10px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .academic-card { transition: all 0.3s; }
        .academic-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
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
                    <a class="nav-link" href="{{ route('admin.edit-achivement') }}">
                        <i class="fas fa-trophy me-2"></i> Edit Achievements
                    </a>
                    <a class="nav-link active" href="{{ route('admin.edit-academic') }}">
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
                    <h2><i class="fas fa-graduation-cap me-2"></i>Edit Academic</h2>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#academicModal">
                            <i class="fas fa-plus me-2"></i>Add New Academic Record
                        </button>
                        <a href="/academic" target="_blank" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-eye me-2"></i>View Academic Page
                        </a>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Academic Cards -->
                <div class="row" id="academicsContainer">
                    @foreach($academics as $academic)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card academic-card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Academic Record</h6>
                                <span class="badge {{ $academic->is_active ? 'bg-success' : 'bg-secondary' }} status-badge">
                                    {{ $academic->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="card-body">
                                @if($academic->certificate_image)
                                <div class="text-center mb-3">
                                    @if(Str::endsWith($academic->certificate_image, '.pdf'))
                                        <div class="certificate-preview bg-light d-flex flex-column align-items-center justify-content-center rounded">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <small class="text-muted">PDF File</small>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $academic->certificate_image) }}" 
                                             alt="{{ $academic->institution_name }}" 
                                             class="certificate-preview img-fluid rounded">
                                    @endif
                                </div>
                                @elseif($academic->certificate_url)
                                <div class="text-center mb-3">
                                    <img src="{{ $academic->certificate_url }}" 
                                         alt="{{ $academic->institution_name }}" 
                                         class="certificate-preview img-fluid rounded">
                                </div>
                                @else
                                <div class="text-center mb-3">
                                    <div class="certificate-preview bg-light d-flex align-items-center justify-content-center rounded">
                                        <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                    </div>
                                </div>
                                @endif
                                
                                <h6 class="card-title">{{ $academic->institution_name }}</h6>
                                <p class="card-text small text-muted">
                                    <strong>{{ $academic->degree_title }}</strong><br>
                                    <strong>Field:</strong> {{ $academic->field_of_study }}<br>
                                    <strong>Period:</strong> 
                                    @if($academic->start_year && $academic->end_year)
                                        {{ $academic->start_year }}-{{ $academic->end_year }}
                                    @elseif($academic->start_year)
                                        {{ $academic->start_year }}-Present
                                    @elseif($academic->end_year)
                                        Completed {{ $academic->end_year }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Order: {{ $academic->order }}</small>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary btn-action" 
                                                onclick="editAcademic({{ $academic->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-warning btn-action" 
                                                onclick="toggleAcademic({{ $academic->id }})">
                                            <i class="fas fa-{{ $academic->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-action" 
                                                onclick="deleteAcademic({{ $academic->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($academics->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Academic Records Found</h5>
                    <p class="text-muted">Click "Add New Academic Record" to create your first academic entry.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Academic Modal -->
<div class="modal fade" id="academicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Academic Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="academicForm">
                <div class="modal-body">
                    <input type="hidden" id="academicId" name="id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="institution_name" class="form-label">Institution Name *</label>
                                <input type="text" class="form-control" id="institution_name" name="institution_name" 
                                       required placeholder="e.g., Daffodil International University">
                            </div>
                            <div class="mb-3">
                                <label for="degree_title" class="form-label">Degree/Title *</label>
                                <input type="text" class="form-control" id="degree_title" name="degree_title" 
                                       required placeholder="e.g., Bachelor of Science">
                            </div>
                            <div class="mb-3">
                                <label for="field_of_study" class="form-label">Field of Study *</label>
                                <input type="text" class="form-control" id="field_of_study" name="field_of_study" 
                                       required placeholder="e.g., Computer Science and Engineering">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_year" class="form-label">Start Year</label>
                                        <input type="number" class="form-control" id="start_year" name="start_year" 
                                               min="1900" max="{{ date('Y') + 10 }}" placeholder="e.g., 2021">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_year" class="form-label">End Year</label>
                                        <input type="number" class="form-control" id="end_year" name="end_year" 
                                               min="1900" max="{{ date('Y') + 10 }}" placeholder="e.g., 2024">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" 
                                          placeholder="Additional details about your academic experience..."></textarea>
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
                <p>Are you sure you want to delete this academic record? This action cannot be undone.</p>
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
let deleteAcademicId = null;

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

// Add new academic record
function addAcademic() {
    $('#modalTitle').text('Add New Academic Record');
    $('#academicForm')[0].reset();
    $('#academicId').val('');
    $('#academicModal').modal('show');
}

// Edit academic record
function editAcademic(id) {
    // Fetch academic data and populate form
    $.get(`/admin/academic/${id}`, function(data) {
        $('#modalTitle').text('Edit Academic Record');
        $('#academicId').val(data.id);
        $('#institution_name').val(data.institution_name);
        $('#degree_title').val(data.degree_title);
        $('#field_of_study').val(data.field_of_study);
        $('#start_year').val(data.start_year);
        $('#end_year').val(data.end_year);
        $('#description').val(data.description);
        $('#certificate_url').val(data.certificate_url);
        $('#order').val(data.order);
        $('#academicModal').modal('show');
    }).fail(function() {
        showAlert('Error loading academic data', 'danger');
    });
}

// Toggle academic status
function toggleAcademic(id) {
    // Find the button that was clicked
    const button = event.target.closest('button');
    const originalIcon = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    $.post(`/admin/academic/${id}/toggle`, {
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
        showAlert('Error toggling academic status', 'danger');
        // Restore original icon
        button.innerHTML = originalIcon;
        button.disabled = false;
    });
}

// Delete academic record
function deleteAcademic(id) {
    deleteAcademicId = id;
    $('#deleteModal').modal('show');
}

// Confirm delete
$('#confirmDelete').click(function() {
    if (deleteAcademicId) {
        $.post(`/admin/academic/${deleteAcademicId}/delete`, {
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
            showAlert('Error deleting academic record', 'danger');
        });
    }
});

// Handle form submission
$('#academicForm').submit(function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const academicId = $('#academicId').val();
    const url = academicId ? `/admin/academic/${academicId}/update` : '/admin/academic/add';
    
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
            $('#academicModal').modal('hide');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(response.message, 'danger');
        }
    })
    .fail(function() {
        showAlert('Error saving academic record', 'danger');
    });
});

// Add new academic record button
$(document).on('click', '[data-bs-target="#academicModal"]', function() {
    addAcademic();
});
</script>

</body>
</html>
