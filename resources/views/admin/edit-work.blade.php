<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Work - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar .nav-link { color: white; padding: 15px 20px; margin: 5px 0; border-radius: 10px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
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
                        <a class="nav-link active" href="{{ route('admin.edit-work') }}">
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
                        <h2>Edit Work</h2>
                        <a href="{{ route('admin.edit-home') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-briefcase me-2"></i>Work Experience Management
                            </h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWorkModal">
                                <i class="fas fa-plus me-1"></i>Add New Work Experience
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Work Experience Page:</strong> Manage your work experience portfolio. Add, edit, and organize your work experiences here.
                            </div>
                            
                            <!-- Work Experience List -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Title</th>
                                            <th>Company</th>
                                            <th>Position</th>
                                            <th>Date Range</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="worksTableBody">
                                        @forelse($works as $work)
                                            <tr data-work-id="{{ $work->id }}">
                                                <td>{{ $work->order }}</td>
                                                <td>{{ $work->title }}</td>
                                                <td>{{ $work->company_name ?? 'N/A' }}</td>
                                                <td>{{ $work->position ?? 'N/A' }}</td>
                                                <td>{{ $work->date_range }}</td>
                                                <td>
                                                    <span class="badge {{ $work->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $work->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" onclick="editWork({{ $work->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-{{ $work->is_active ? 'warning' : 'success' }}" onclick="toggleWork({{ $work->id }})">
                                                        <i class="fas fa-{{ $work->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteWork({{ $work->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No work experiences found. Add your first work experience!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <a href="{{ url('/work') }}" target="_blank" class="btn btn-info">
                                    <i class="fas fa-external-link-alt me-1"></i>View Work Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Work Modal -->
    <div class="modal fade" id="addWorkModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Work Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addWorkForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Job Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="position" name="position">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Order *</label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ $works->count() + 1 }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image_url" class="form-label">Image URL</label>
                                    <input type="url" class="form-control" id="image_url" name="image_url">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="work_url" class="form-label">Work URL</label>
                                    <input type="url" class="form-control" id="work_url" name="work_url">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_current" name="is_current">
                                        <label class="form-check-label" for="is_current">
                                            Current Position
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="technologies" class="form-label">Technologies (comma-separated)</label>
                            <input type="text" class="form-control" id="technologies" name="technologies" placeholder="Laravel, Vue.js, MySQL">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Work Experience</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Work Modal -->
    <div class="modal fade" id="editWorkModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Work Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWorkForm">
                    @csrf
                    <input type="hidden" id="edit_work_id" name="work_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_title" class="form-label">Job Title *</label>
                                    <input type="text" class="form-control" id="edit_title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="edit_company_name" name="company_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="edit_position" name="position">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_order" class="form-label">Order *</label>
                                    <input type="number" class="form-control" id="edit_order" name="order" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_image_url" class="form-label">Image URL</label>
                                    <input type="url" class="form-control" id="edit_image_url" name="image_url">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_work_url" class="form-label">Work URL</label>
                                    <input type="url" class="form-control" id="edit_work_url" name="work_url">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="edit_start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="edit_start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="edit_end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="edit_end_date" name="end_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="edit_is_current" name="is_current">
                                        <label class="form-check-label" for="edit_is_current">
                                            Current Position
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_technologies" class="form-label">Technologies (comma-separated)</label>
                            <input type="text" class="form-control" id="edit_technologies" name="technologies" placeholder="Laravel, Vue.js, MySQL">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Work Experience</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Work Management JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Add Work Form
        document.getElementById('addWorkForm').addEventListener('submit', function(e) {
            e.preventDefault();
            addWork();
        });

        // Edit Work Form
        document.getElementById('editWorkForm').addEventListener('submit', function(e) {
            e.preventDefault();
            updateWork();
        });
    });

    function addWork() {
        const formData = new FormData(document.getElementById('addWorkForm'));
        
        // Show loading state
        const submitBtn = document.querySelector('#addWorkForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';
        submitBtn.disabled = true;
        
        fetch('{{ route("admin.work.add") }}', {
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
                showAlert('success', data.message);
                // Close modal and reload
                const modal = bootstrap.Modal.getInstance(document.getElementById('addWorkModal'));
                modal.hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message || 'Failed to add work experience');
            }
        })
        .catch(error => {
            console.error('Error adding work experience:', error);
            showAlert('error', 'Error adding work experience: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    function editWork(workId) {
        // Show loading state
        showAlert('info', 'Loading work experience data...');
        
        fetch(`{{ url('admin/work') }}/${workId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.id) {
                document.getElementById('edit_work_id').value = data.id;
                document.getElementById('edit_title').value = data.title || '';
                document.getElementById('edit_company_name').value = data.company_name || '';
                document.getElementById('edit_position').value = data.position || '';
                document.getElementById('edit_description').value = data.description || '';
                document.getElementById('edit_image_url').value = data.image_url || '';
                document.getElementById('edit_work_url').value = data.work_url || '';
                document.getElementById('edit_start_date').value = data.start_date || '';
                document.getElementById('edit_end_date').value = data.end_date || '';
                document.getElementById('edit_order').value = data.order || 1;
                document.getElementById('edit_is_current').checked = data.is_current || false;
                document.getElementById('edit_technologies').value = Array.isArray(data.technologies) ? data.technologies.join(', ') : (data.technologies || '');
                
                // Clear any existing alerts
                const existingAlerts = document.querySelectorAll('.alert');
                existingAlerts.forEach(alert => alert.remove());
                
                new bootstrap.Modal(document.getElementById('editWorkModal')).show();
            } else {
                showAlert('error', 'Error fetching work experience data: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error fetching work experience:', error);
            showAlert('error', 'Error fetching work experience: ' + error.message);
        });
    }

    function updateWork() {
        const formData = new FormData(document.getElementById('editWorkForm'));
        const workId = document.getElementById('edit_work_id').value;
        
        // Show loading state
        const submitBtn = document.querySelector('#editWorkForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
        submitBtn.disabled = true;
        
        fetch(`{{ url('admin/work') }}/${workId}/update`, {
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
                showAlert('success', data.message);
                // Close modal and reload
                const modal = bootstrap.Modal.getInstance(document.getElementById('editWorkModal'));
                modal.hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message || 'Failed to update work experience');
            }
        })
        .catch(error => {
            console.error('Error updating work experience:', error);
            showAlert('error', 'Error updating work experience: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    function deleteWork(workId) {
        if (confirm('Are you sure you want to delete this work experience?')) {
            fetch(`{{ url('admin/work') }}/${workId}/delete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }

            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    location.reload();
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                showAlert('error', 'Error deleting work experience: ' + error.message);
            });
        }
    }

    function toggleWork(workId) {
        fetch(`{{ url('admin/work') }}/${workId}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }

        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Error toggling work experience: ' + error.message);
        });
    }

    function showAlert(type, message) {
        let alertClass;
        let iconClass;
        
        switch(type) {
            case 'success':
                alertClass = 'alert-success';
                iconClass = 'fas fa-check-circle';
                break;
            case 'error':
                alertClass = 'alert-danger';
                iconClass = 'fas fa-exclamation-circle';
                break;
            case 'info':
                alertClass = 'alert-info';
                iconClass = 'fas fa-info-circle';
                break;
            case 'warning':
                alertClass = 'alert-warning';
                iconClass = 'fas fa-exclamation-triangle';
                break;
            default:
                alertClass = 'alert-info';
                iconClass = 'fas fa-info-circle';
        }
        
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
        const container = document.querySelector('.main-content.p-4') || document.querySelector('.main-content') || document.body;
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-dismiss after 5 seconds (except for info alerts)
        if (type !== 'info') {
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    }
    </script>
</body>
</html>

</html>
