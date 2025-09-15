@extends('index')
@push('styles')
<title>Work - Protik Goswami</title>

<!-- Glider.js CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/projects.css') }}">
@endpush
@section('work-section')
<!--===== WORK =====-->
@php
    $works = \App\Models\Work::getActiveOrdered();
@endphp

<section class="work section" id="work">
    <h2 class="section-title">💼 My Work Experience</h2>
    <div class="project-cards">
        <div class="card-container">
            @forelse($works as $work)
                <div class="card uniform-card work-card" data-work-id="{{ $work->id }}">
                    <div class="card-image">
                        @if($work->image_url)
                            <img src="{{ $work->image_url }}" alt="{{ $work->title }}">
                        @else
                            <div class="work-placeholder">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $work->title }}</h3>
                        @if($work->company_name)
                            <p class="company-name">{{ $work->company_name }}</p>
                        @endif
                        @if($work->position)
                            <p class="position">{{ $work->position }}</p>
                        @endif
                        @if($work->date_range)
                            <p class="date-range">{{ $work->date_range }}</p>
                        @endif
                        @if($work->technologies && is_array($work->technologies))
                            <div class="work-tech">
                                @foreach($work->technologies as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="work-links">
                            @if($work->work_url)
                                <a href="{{ $work->work_url }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-external-link-alt"></i> View Work
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- Hover overlay with full description -->
                    <div class="work-overlay">
                        <div class="overlay-content">
                            <h3>{{ $work->title }}</h3>
                            @if($work->company_name)
                                <p class="company-name">{{ $work->company_name }}</p>
                            @endif
                            @if($work->position)
                                <p class="position">{{ $work->position }}</p>
                            @endif
                            @if($work->date_range)
                                <p class="date-range">{{ $work->date_range }}</p>
                            @endif
                            @if($work->description)
                                <p class="full-description">{{ $work->description }}</p>
                            @endif
                            @if($work->technologies && is_array($work->technologies))
                                <div class="work-tech">
                                    @foreach($work->technologies as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <!-- Links in overlay -->
                            <div class="overlay-links">
                                @if($work->work_url)
                                    <a href="{{ $work->work_url }}" target="_blank" class="btn btn-primary btn-sm overlay-btn">
                                        <i class="fas fa-external-link-alt"></i> View Work
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card uniform-card blank-card">
                    <div class="blank-content">
                        <i class="fas fa-plus-circle"></i>
                        <p>No work experience yet. Add some work experience from the admin panel!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

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
@endsection

<style>
.blank-card {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
}

.blank-content {
    text-align: center;
    color: #666;
}

.blank-content i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.blank-content p {
    font-size: 1.1rem;
    margin: 0;
}

/* Work-specific styles */
.work-card {
    position: relative;
}

.company-name {
    font-size: 0.9rem;
    color: #666;
    margin: 5px 0;
    font-weight: 500;
}

.position {
    font-size: 0.85rem;
    color: #888;
    margin: 3px 0;
    font-style: italic;
}

.date-range {
    font-size: 0.8rem;
    color: #999;
    margin: 3px 0;
}

.work-tech {
    margin: 10px 0;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.work-links {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: auto;
}

.work-links .btn {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.work-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.work-placeholder i {
    font-size: 3rem;
    opacity: 0.8;
}

.work-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.9);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 20px;
    pointer-events: none;
}

.work-card:hover .work-overlay {
    opacity: 1;
    pointer-events: auto;
}

.overlay-content .company-name {
    color: #e0e0e0;
    font-size: 1rem;
}

.overlay-content .position {
    color: #ccc;
    font-size: 0.9rem;
}

.overlay-content .date-range {
    color: #bbb;
    font-size: 0.85rem;
}

.overlay-links {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 15px;
}

.overlay-btn {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 10;
    position: relative;
}

/* Add Work Button */
.add-work-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-size: 1.5rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
    z-index: 1000;
}

.add-work-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    color: white;
}

/* Modal styles */
.modal-content {
    border-radius: 15px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
}

.modal-header .btn-close {
    filter: invert(1);
}

/* Form styles */
.form-control {
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

/* Button styles */
.btn-primary {
    background: #667eea;
    border-color: #667eea;
}

.btn-primary:hover {
    background: #5a6fd8;
    border-color: #5a6fd8;
}

.btn-outline-primary {
    color: #667eea;
    border-color: #667eea;
}

.btn-outline-primary:hover {
    background: #667eea;
    border-color: #667eea;
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    border-color: #dc3545;
}

/* Responsive design */
@media (max-width: 768px) {
    .work-links {
        flex-direction: column;
        gap: 5px;
    }
    
    .work-links .btn {
        font-size: 0.7rem;
        padding: 3px 6px;
    }
    
    .add-work-btn {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}
</style>

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

    // Add floating add button
    const addButton = document.createElement('button');
    addButton.className = 'add-work-btn';
    addButton.innerHTML = '<i class="fas fa-plus"></i>';
    addButton.title = 'Add Work Experience';
    addButton.onclick = function() {
        new bootstrap.Modal(document.getElementById('addWorkModal')).show();
    };
    document.body.appendChild(addButton);
});

function addWork() {
    const formData = new FormData(document.getElementById('addWorkForm'));
    
    // Show loading state
    const submitBtn = document.querySelector('#addWorkForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';
    submitBtn.disabled = true;
    
    fetch('{{ route("work.add") }}', {
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
    
    fetch(`{{ url('work') }}/${workId}`)
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
    
    fetch(`{{ url('work') }}/${workId}/update`, {
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
        fetch(`{{ url('work') }}/${workId}/delete`, {
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
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="${iconClass} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Add new alert
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
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
</script>