<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Footer - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar .nav-link { color: white; padding: 15px 20px; margin: 5px 0; border-radius: 10px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .social-input-group { position: relative; }
        .social-input-group .form-control { padding-left: 45px; }
        .social-input-group .social-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; }
        .preview-section { background: #f8f9fa; border-radius: 10px; padding: 20px; margin-top: 20px; }
        .social-link-card { transition: all 0.3s; }
        .social-link-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
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
                        <a class="nav-link" href="{{ route('admin.edit-image') }}">
                            <i class="fas fa-images me-2"></i> Edit Images
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-contact') }}">
                            <i class="fas fa-envelope me-2"></i> Edit Contact
                        </a>
                        <a class="nav-link active" href="{{ route('admin.edit-footer') }}">
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
                        <h2>Edit Footer</h2>
                        <a href="{{ route('admin.edit-home') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>

                    <!-- Debug Information -->
                    @if(config('app.debug'))
                    <div class="alert alert-info">
                        <strong>Debug Info:</strong>
                        <br>Footer Data: {{ $footer ? 'Found (ID: ' . $footer->id . ')' : 'Not found' }}
                        <br>Social Links Count: {{ $socialLinks->count() }}
                        <br>Current Time: {{ now() }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Footer Content Editor -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Footer Content Editor</h5>
                                </div>
                                <div class="card-body">
                                    <form id="footerForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="title" class="form-label">Footer Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="{{ $footer->title ?? '' }}" placeholder="Enter footer title">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="copyright_text" class="form-label">Copyright Text</label>
                                                <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="{{ $footer->copyright_text ?? '' }}" placeholder="© 2024 Your Name">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Footer Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter footer description">{{ $footer->description ?? '' }}</textarea>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Update Footer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Social Media Links Management -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Social Media Links</h5>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSocialModal">
                                        <i class="fas fa-plus me-2"></i>Add New Link
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="socialLinksContainer">
                                        @if($socialLinks && $socialLinks->count() > 0)
                                            @foreach($socialLinks as $link)
                                                <div class="card mb-3 social-link-card" data-id="{{ $link->id }}">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="border-start border-primary border-3 me-3" style="height: 40px;"></div>
                                                                    <div>
                                                                        <div class="d-flex align-items-center mb-1">
                                                                            <i class="{{ $link->getIconClass() }} fa-lg me-2 {{ $link->getColorClass() }}"></i>
                                                                            <h6 class="mb-0 text-capitalize">{{ $link->platform }}</h6>
                                                                        </div>
                                                                        <div class="text-muted small">{{ $link->platform }}</div>
                                                                        <div class="text-truncate" style="max-width: 200px;">{{ $link->url }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-end">
                                                                <span class="badge bg-{{ $link->is_active ? 'success' : 'secondary' }} mb-2">
                                                                    {{ $link->is_active ? 'Active' : 'Inactive' }}
                                                                </span>
                                                                <div class="text-muted small mb-2">Order: {{ $link->order }}</div>
                                                                <div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editSocialLink({{ $link->id }}, '{{ addslashes($link->platform) }}', '{{ addslashes($link->url) }}', {{ $link->order }})">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="toggleSocialLink('{{ $link->id }}')">
                                                                        <i class="fas fa-eye{{ $link->is_active ? '-slash' : '' }}"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSocialLink({{ $link->id }})">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted py-4">
                                                <i class="fas fa-share-alt fa-3x mb-3"></i>
                                                <p>No social media links added yet.</p>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSocialModal">
                                                    <i class="fas fa-plus me-2"></i>Add First Link
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Live Preview</h5>
                                </div>
                                <div class="card-body">
                                    <div class="preview-section">
                                        <div id="previewTitle" class="h6 mb-2">{{ $footer->title ?? 'Footer Title' }}</div>
                                        <div id="previewDescription" class="text-muted mb-3">{{ $footer->description ?? 'Footer description will appear here...' }}</div>
                                        
                                        <div class="social-links mb-3">
                                            <div id="previewSocial" class="d-flex gap-2">
                                                @if($socialLinks && $socialLinks->count() > 0)
                                                    @foreach($socialLinks->where('is_active', true) as $link)
                                                        <a href="{{ $link->url }}" class="{{ $link->getColorClass() }}" target="_blank">
                                                            <i class="{{ $link->getIconClass() }} fa-lg"></i>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div id="previewCopyright" class="text-muted small">
                                            {{ $footer->copyright_text ?? '© 2024 Your Name. All rights reserved.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Social Media Link Modal -->
    <div class="modal fade" id="addSocialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Social Media Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addSocialForm">
                        @csrf
                        <div class="mb-3">
                            <label for="platform" class="form-label">Platform</label>
                            <select class="form-select" id="platform" name="platform" required onchange="handlePlatformSelectChange(this, 'customPlatformWrapper')">
                                <option value="">Select Platform</option>
                                <option value="facebook">Facebook</option>
                                <option value="twitter">Twitter</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="github">GitHub</option>
                                <option value="instagram">Instagram</option>
                                <option value="youtube">YouTube</option>
                                <option value="telegram">Telegram</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="__custom">Custom</option>
                            </select>
                            <div id="customPlatformWrapper" class="mt-2" style="display:none;">
                                <input type="text" class="form-control" id="customPlatform" placeholder="Type custom platform name (e.g., Behance)">
                                <div class="form-text">A generic link icon will be used for custom platforms.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="url" name="url" required placeholder="https://example.com/yourprofile">
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="order" name="order" value="1" min="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addSocialLink()">Add Link</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Social Media Link Modal -->
    <div class="modal fade" id="editSocialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Social Media Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editSocialForm">
                        @csrf
                        <input type="hidden" id="editSocialId" name="id">
                        <div class="mb-3">
                            <label for="editPlatform" class="form-label">Platform</label>
                            <select class="form-select" id="editPlatform" name="platform" required onchange="handlePlatformSelectChange(this, 'editCustomPlatformWrapper')">
                                <option value="facebook">Facebook</option>
                                <option value="twitter">Twitter</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="github">GitHub</option>
                                <option value="instagram">Instagram</option>
                                <option value="youtube">YouTube</option>
                                <option value="telegram">Telegram</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="__custom">Custom</option>
                            </select>
                            <div id="editCustomPlatformWrapper" class="mt-2" style="display:none;">
                                <input type="text" class="form-control" id="editCustomPlatform" placeholder="Type custom platform name">
                                <div class="form-text">A generic link icon will be used for custom platforms.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editUrl" class="form-label">URL</label>
                            <input type="url" class="form-control" id="editUrl" name="url" required>
                        </div>
                        <div class="mb-3">
                            <label for="editOrder" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="editOrder" name="order" min="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateSocialLink()">Update Link</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getCsrfToken() {
            const tag = document.querySelector('meta[name="csrf-token"]');
            return tag ? tag.getAttribute('content') : '';
        }

        // Live preview updates for text fields
        document.getElementById('title').addEventListener('input', function() {
            document.getElementById('previewTitle').textContent = this.value || 'Footer Title';
        });

        document.getElementById('description').addEventListener('input', function() {
            document.getElementById('previewDescription').textContent = this.value || 'Footer description will appear here...';
        });

        document.getElementById('copyright_text').addEventListener('input', function() {
            document.getElementById('previewCopyright').textContent = this.value || '© 2024 Your Name. All rights reserved.';
        });

        // Helper: show custom platform field
        function handlePlatformSelectChange(selectEl, wrapperId) {
            const wrapper = document.getElementById(wrapperId);
            if (!wrapper) return;
            if (selectEl.value === '__custom') {
                wrapper.style.display = 'block';
            } else {
                wrapper.style.display = 'none';
            }
        }

        // Social Media Links Management
        function addSocialLink() {
            const form = document.getElementById('addSocialForm');
            const formData = new FormData(form);
            formData.append('_token', getCsrfToken());
            // If custom selected, override platform with typed value
            const platformSelect = document.getElementById('platform');
            if (platformSelect && platformSelect.value === '__custom') {
                const customValue = (document.getElementById('customPlatform')?.value || '').trim();
                if (!customValue) {
                    alert('Please enter a custom platform name.');
                    return;
                }
                formData.set('platform', customValue);
            }
            
            // Show loading state
            const submitBtn = document.querySelector('#addSocialModal .btn-primary');
            const originalText = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
                submitBtn.disabled = true;
            }
            
            fetch('{{ route("admin.footer.social.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Social link added successfully!');
                    location.reload();
                } else {
                    alert('Error adding social link: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding social link. Please try again.');
            })
            .finally(() => {
                // Reset button state
                if (submitBtn) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
        }

        function editSocialLink(id, platform, url, order) {
            document.getElementById('editSocialId').value = id;
            const editSelect = document.getElementById('editPlatform');
            const known = ['facebook','twitter','linkedin','github','instagram','youtube','telegram','whatsapp'];
            if (known.includes(platform)) {
                editSelect.value = platform;
                handlePlatformSelectChange(editSelect, 'editCustomPlatformWrapper');
                document.getElementById('editCustomPlatform').value = '';
            } else {
                editSelect.value = '__custom';
                handlePlatformSelectChange(editSelect, 'editCustomPlatformWrapper');
                document.getElementById('editCustomPlatform').value = platform;
            }
            document.getElementById('editUrl').value = url;
            document.getElementById('editOrder').value = order;
            
            const modal = new bootstrap.Modal(document.getElementById('editSocialModal'));
            modal.show();
        }

        function updateSocialLink() {
            const id = document.getElementById('editSocialId').value;
            const form = document.getElementById('editSocialForm');
            const formData = new FormData(form);
            formData.append('_token', getCsrfToken());
            const editSelect = document.getElementById('editPlatform');
            if (editSelect && editSelect.value === '__custom') {
                const customValue = (document.getElementById('editCustomPlatform')?.value || '').trim();
                if (!customValue) {
                    alert('Please enter a custom platform name.');
                    return;
                }
                formData.set('platform', customValue);
            }
            
            // Show loading state
            const submitBtn = document.querySelector('#editSocialModal .btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
            
            fetch(`{{ url('/admin/footer/social') }}/${id}/update`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Social link updated successfully!');
                    location.reload();
                } else {
                    alert('Error updating social link: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating social link. Please try again.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        function deleteSocialLink(id) {
            if (confirm('Are you sure you want to delete this social link?')) {
                fetch(`{{ url('/admin/footer/social') }}/${id}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ _token: getCsrfToken() })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Social link deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error deleting social link: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting social link. Please try again.');
                });
            }
        }

        function toggleSocialLink(id) {
            fetch(`{{ url('/admin/footer/social') }}/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ _token: getCsrfToken() })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error toggling social link: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error toggling social link. Please try again.');
            });
        }

        // Form submission for footer content
        document.getElementById('footerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            
            fetch('{{ route("admin.footer.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Footer updated successfully!', 'success');
                    // Update preview sections immediately
                    updatePreview();
                    // Refresh page after 2 seconds to show updated data
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 2000);
                } else {
                    showAlert('Error updating footer: ' + (data.message || 'Unknown error'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error updating footer. Please try again.', 'danger');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Footer editor page loaded');
            
            // Test if Bootstrap modal is available
            if (typeof bootstrap !== 'undefined') {
                console.log('Bootstrap is loaded');
            } else {
                console.error('Bootstrap is not loaded');
            }
            
            // Test if social links are available
            const socialLinksContainer = document.getElementById('socialLinksContainer');
            if (socialLinksContainer) {
                console.log('Social links container found');
            } else {
                console.error('Social links container not found');
            }
        });
    </script>
</body>
</html>
