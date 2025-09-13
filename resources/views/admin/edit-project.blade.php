<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Project - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global font improvements */
        body {
            font-size: 16px;
            line-height: 1.6;
        }
        
        /* Sidebar improvements */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar h4 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            border-radius: 10px;
            margin: 8px 0;
            padding: 12px 16px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
            font-weight: 600;
        }
        .sidebar .nav-link i {
            font-size: 1.1rem;
        }
        
        /* Main content improvements */
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .main-content h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .main-content h4 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #34495e;
        }
        .main-content .text-muted {
            font-size: 1.1rem;
        }
        
        /* Card improvements */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        
        /* Table improvements */
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
        }
        
        /* Button improvements */
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        
        /* Modal improvements */
        .modal-content {
            border-radius: 15px;
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .sidebar .nav-link {
                font-size: 0.95rem;
                padding: 10px 12px;
            }
            .main-content h2 {
                font-size: 1.8rem;
            }
            .main-content h4 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="position-sticky pt-3">
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('admin.edit-home') }}">
                        <i class="fas fa-home me-2"></i> Edit Home
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
                    <a class="nav-link active" href="{{ route('admin.edit-project') }}">
                        <i class="fas fa-project-diagram me-2"></i> Edit Project
                    </a>
                    <a class="nav-link" href="{{ route('admin.edit-image') }}">
                        <i class="fas fa-images me-2"></i> Edit Images
                    </a>
                    <a class="nav-link" href="{{ route('admin.edit-contact') }}">
                        <i class="fas fa-envelope me-2"></i> Edit Contact
                    </a>
                    <a class="nav-link" href="{{ route('admin.edit-footer') }}">
                        <i class="fas fa-window-maximize me-2"></i> Edit Footer
                    </a>
                    <a class="nav-link" href="{{ route('admin.data-management') }}">
                        <i class="fas fa-database me-2"></i> Data Management
                    </a>
                    <a class="nav-link" href="/" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i> View Site
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-project-diagram me-2"></i>Edit Project</h2>
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

                <!-- Project Management Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-project-diagram me-2"></i>Project Management
                                </h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                                    <i class="fas fa-plus me-1"></i>Add New Project
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Project Page:</strong> Manage your project portfolio. Add, edit, and organize your projects here.
                                </div>
                                
                                <!-- Projects List -->
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Technologies</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="projectsTableBody">
                                            @forelse($projects as $project)
                                                <tr data-project-id="{{ $project->id }}">
                                                    <td>{{ $project->order }}</td>
                                                    <td>{{ $project->title }}</td>
                                                    <td>{{ Str::limit($project->description, 50) }}</td>
                                                    <td>{{ is_array($project->technologies) ? implode(', ', $project->technologies) : $project->technologies }}</td>
                                                    <td>
                                                        <span class="badge {{ $project->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $project->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editProject({{ $project->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-{{ $project->is_active ? 'warning' : 'success' }}" onclick="toggleProject({{ $project->id }})">
                                                            <i class="fas fa-{{ $project->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteProject({{ $project->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No projects found. Add your first project!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ url('/project') }}" target="_blank" class="btn btn-info">
                                        <i class="fas fa-external-link-alt me-1"></i>View Project Page
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Project Modal -->
                <div class="modal fade" id="addProjectModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Project</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="addProjectForm">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Project Title *</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="order" class="form-label">Order *</label>
                                                <input type="number" class="form-control" id="order" name="order" value="{{ $projects->count() + 1 }}" required>
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
                                                <label for="project_url" class="form-label">Project URL</label>
                                                <input type="url" class="form-control" id="project_url" name="project_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="github_url" class="form-label">GitHub URL</label>
                                                <input type="url" class="form-control" id="github_url" name="github_url">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="technologies" class="form-label">Technologies (comma-separated)</label>
                                                <input type="text" class="form-control" id="technologies" name="technologies" placeholder="Laravel, Vue.js, MySQL">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Project Modal -->
                <div class="modal fade" id="editProjectModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Project</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editProjectForm">
                                <input type="hidden" id="edit_project_id" name="project_id">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_title" class="form-label">Project Title *</label>
                                                <input type="text" class="form-control" id="edit_title" name="title" required>
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
                                                <label for="edit_project_url" class="form-label">Project URL</label>
                                                <input type="url" class="form-control" id="edit_project_url" name="project_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_github_url" class="form-label">GitHub URL</label>
                                                <input type="url" class="form-control" id="edit_github_url" name="github_url">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_technologies" class="form-label">Technologies (comma-separated)</label>
                                                <input type="text" class="form-control" id="edit_technologies" name="technologies" placeholder="Laravel, Vue.js, MySQL">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Project Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Add Project Form
    document.getElementById('addProjectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addProject();
    });

    // Edit Project Form
    document.getElementById('editProjectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateProject();
    });
});

function addProject() {
    const formData = new FormData(document.getElementById('addProjectForm'));
    
    fetch('{{ route("admin.project.add") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
        showAlert('error', 'Error adding project: ' + error.message);
    });
}

function editProject(projectId) {
    fetch(`{{ url('admin/project') }}/${projectId}`)
    .then(response => response.json())
    .then(data => {
        if (data.id) {
            document.getElementById('edit_project_id').value = data.id;
            document.getElementById('edit_title').value = data.title || '';
            document.getElementById('edit_description').value = data.description || '';
            document.getElementById('edit_image_url').value = data.image_url || '';
            document.getElementById('edit_project_url').value = data.project_url || '';
            document.getElementById('edit_github_url').value = data.github_url || '';
            document.getElementById('edit_order').value = data.order || 1;
            document.getElementById('edit_technologies').value = Array.isArray(data.technologies) ? data.technologies.join(', ') : (data.technologies || '');
            
            new bootstrap.Modal(document.getElementById('editProjectModal')).show();
        } else {
            showAlert('error', 'Error fetching project data');
        }
    })
    .catch(error => {
        showAlert('error', 'Error fetching project: ' + error.message);
    });
}

function updateProject() {
    const formData = new FormData(document.getElementById('editProjectForm'));
    const projectId = document.getElementById('edit_project_id').value;
    
    fetch(`{{ url('admin/project') }}/${projectId}/update`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
        showAlert('error', 'Error updating project: ' + error.message);
    });
}

function deleteProject(projectId) {
    if (confirm('Are you sure you want to delete this project?')) {
        fetch(`{{ url('admin/project') }}/${projectId}/delete`, {
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
            showAlert('error', 'Error deleting project: ' + error.message);
        });
    }
}

function toggleProject(projectId) {
    fetch(`{{ url('admin/project') }}/${projectId}/toggle`, {
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
        showAlert('error', 'Error toggling project: ' + error.message);
    });
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
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
    </div>
</body>
</html>
