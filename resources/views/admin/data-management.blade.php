<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management - Portfolio Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
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
                        <a class="nav-link active" href="{{ route('admin.data-management') }}">
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
                        <h2><i class="fas fa-database me-2"></i>Data Management</h2>
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
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Data Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Management Cards -->
    <div class="row">
        <!-- Reload Data Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-sync-alt fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Reload Data</h5>
                            <p class="text-muted mb-0">Reload all portfolio data from seeders. <strong>Images will be preserved.</strong></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" onclick="reloadData()">
                            <i class="fas fa-sync-alt me-1"></i> Reload Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clear Data Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Clear All Data</h5>
                            <p class="text-muted mb-0">Remove all portfolio data permanently. <strong>Images will be preserved.</strong></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-danger" onclick="clearData()">
                            <i class="fas fa-trash-alt me-1"></i> Clear Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Backup Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center">
                                <i class="fas fa-download fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Create Backup</h5>
                            <p class="text-muted mb-0">Create a backup of current data</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-success" onclick="createBackup()">
                            <i class="fas fa-download me-1"></i> Create Backup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Management Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-archive me-2"></i>Backup Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="backupsTable">
                            <thead>
                                <tr>
                                    <th>Backup File</th>
                                    <th>Size</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backupFiles as $backup)
                                <tr>
                                    <td>
                                        <i class="fas fa-file-archive text-primary me-2"></i>
                                        {{ $backup['filename'] }}
                                    </td>
                                    <td>{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                                    <td>{{ date('Y-m-d H:i:s', $backup['created_at']) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="restoreData('{{ $backup['filename'] }}')">
                                            <i class="fas fa-upload me-1"></i> Restore
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        No backup files found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Statistics -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Data Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-primary">{{ \App\Models\HomeContent::count() }}</h3>
                                <p class="text-muted mb-0">Home Contents</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-success">{{ \App\Models\Skill::count() }}</h3>
                                <p class="text-muted mb-0">Skills</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-info">{{ \App\Models\Achievement::count() }}</h3>
                                <p class="text-muted mb-0">Achievements</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-warning">{{ \App\Models\Academic::count() }}</h3>
                                <p class="text-muted mb-0">Academic Records</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                <!-- Dynamic content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmActionBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmModalBody">
                    <!-- Dynamic content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
// Global variables
let currentAction = null;
let currentBackupFile = null;

// Reload Data Function
function reloadData() {
    showConfirmModal(
        'Reload Data',
        'Are you sure you want to reload all portfolio data? This will restore default content from seeders. <strong>Your uploaded images will be preserved.</strong>',
        'primary',
        function() {
            performAction('reload');
        }
    );
}

// Clear Data Function
function clearData() {
    showConfirmModal(
        'Clear All Data',
        '⚠️ WARNING: This will permanently delete ALL portfolio data! This action cannot be undone. <strong>Your uploaded images will be preserved.</strong> Are you absolutely sure?',
        'danger',
        function() {
            performAction('clear');
        }
    );
}

// Create Backup Function
function createBackup() {
    performAction('backup');
}

// Restore Data Function
function restoreData(backupFile) {
    currentBackupFile = backupFile;
    showConfirmModal(
        'Restore Data',
        `Are you sure you want to restore data from backup: <strong>${backupFile}</strong>? This will replace all current data.`,
        'warning',
        function() {
            performAction('restore');
        }
    );
}

// Show Confirmation Modal
function showConfirmModal(title, message, type, confirmCallback) {
    document.getElementById('confirmModalLabel').textContent = title;
    document.getElementById('confirmModalBody').innerHTML = message;
    
    const confirmBtn = document.getElementById('confirmActionBtn');
    confirmBtn.className = `btn btn-${type}`;
    confirmBtn.textContent = 'Confirm';
    
    // Remove existing event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    // Add new event listener
    newConfirmBtn.addEventListener('click', function() {
        confirmCallback();
        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
    });
    
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

// Perform Action
function performAction(action) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
    
    let url, data = {};
    
    switch(action) {
        case 'reload':
            url = '{{ route("admin.data.reload") }}';
            break;
        case 'clear':
            url = '{{ route("admin.data.clear") }}';
            break;
        case 'backup':
            url = '{{ route("admin.data.backup") }}';
            break;
        case 'restore':
            url = '{{ route("admin.data.restore") }}';
            data = { backup_file: currentBackupFile };
            break;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            
            // Refresh page after successful operations
            if (action === 'reload' || action === 'clear' || action === 'restore') {
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while processing your request.');
    })
    .finally(() => {
        // Restore button state
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// Show Alert
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Insert alert at the top of the page
    const container = document.querySelector('.container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            bootstrap.Alert.getOrCreateInstance(alert).close();
        }
    }, 5000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Data Management page loaded');
});
    </script>
</body>
</html>
