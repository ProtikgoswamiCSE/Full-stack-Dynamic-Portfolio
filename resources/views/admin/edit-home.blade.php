<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Home Page - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .preview-section {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .social-link-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
        }
        .social-link-card.inactive {
            opacity: 0.6;
            border-left-color: #6c757d;
        }
        .icon-preview {
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                        <hr class="bg-white">
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link active" href="{{ route('admin.edit-home') }}">
                            <i class="fas fa-home me-2"></i> Edit Home Page
                        </a>
                        <a class="nav-link" href="{{ route('admin.initialize-content') }}">
                            <i class="fas fa-database me-2"></i> Initialize Content
                        </a>
                        <a class="nav-link" href="{{ url('/') }}" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> View Site
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Edit Home Page</h2>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Home Content Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-home me-2"></i>Home Page Content</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.update-home') }}" method="POST" onsubmit="return validateForm()">
                                @csrf
                                
                                <!-- Title Section -->
                                <div class="mb-4">
                                    <label for="title" class="form-label">Title (HTML allowed)</label>
                                    <textarea class="form-control" id="title" name="title" rows="3" placeholder="Enter the main title...">{{ $homeContents['title']->content ?? '' }}</textarea>
                                    <div class="form-text">You can use HTML tags like &lt;br&gt; for line breaks and &lt;span&gt; for styling.</div>
                                    <div class="preview-section">
                                        <h6 class="text-muted mb-2">Preview:</h6>
                                        <div id="title-preview"></div>
                                    </div>
                                </div>

                                <!-- Subtitle Section -->
                                <div class="mb-4">
                                    <label for="subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $homeContents['subtitle']->content ?? '' }}" placeholder="Enter subtitle...">
                                </div>

                                <!-- Skills List Section -->
                                <div class="mb-4">
                                    <label for="skills_list" class="form-label">Skills (one per line, start with *)</label>
                                    <textarea class="form-control" id="skills_list" name="skills_list" rows="6" placeholder="* Skill 1&#10;* Skill 2&#10;* Skill 3">{{ $homeContents['skills_list']->content ?? '' }}</textarea>
                                    <div class="form-text">Each skill should be on a new line and start with an asterisk (*).</div>
                                    <div class="preview-section">
                                        <h6 class="text-muted mb-2">Preview:</h6>
                                        <ul id="skills-preview" class="list-unstyled"></ul>
                                    </div>
                                </div>

                                <!-- Contact Button Section -->
                                <div class="mb-4">
                                    <label for="contact_button_text" class="form-label">Contact Button Text</label>
                                    <input type="text" class="form-control" id="contact_button_text" name="contact_button_text" value="{{ $homeContents['contact_button_text']->content ?? '' }}" placeholder="Enter button text...">
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Update Home Page
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Social Media Management -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Social Media Links</h5>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSocialLinkModal">
                                <i class="fas fa-plus me-2"></i>Add New Link
                            </button>
                        </div>
                        <div class="card-body">
                            @if($socialLinks->count() > 0)
                                <div class="row">
                                    @foreach($socialLinks as $link)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="social-link-card {{ !$link->is_active ? 'inactive' : '' }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="{{ $link->icon_class }} icon-preview"></i>
                                                            <h6 class="mb-0">{{ $link->name }}</h6>
                                                        </div>
                                                        <small class="text-muted d-block mb-2">{{ $link->platform }}</small>
                                                        <div class="mb-2">
                                                            <a href="{{ $link->url }}" target="_blank" class="text-decoration-none">
                                                                {{ Str::limit($link->url, 30) }}
                                                            </a>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-sm btn-outline-primary" onclick="editSocialLink('{{ $link->id }}')">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-{{ $link->is_active ? 'warning' : 'success' }}" onclick="toggleSocialLink('{{ $link->id }}')">
                                                                <i class="fas fa-{{ $link->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSocialLink('{{ $link->id }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge {{ $link->is_active ? 'bg-success' : 'bg-secondary' }} mb-2">
                                                            {{ $link->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                        <div>
                                                            <small class="text-muted">Order: {{ $link->order }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-share-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No social media links found</h5>
                                    <p class="text-muted">Add your first social media link to get started</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSocialLinkModal">
                                        <i class="fas fa-plus me-2"></i>Add First Link
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Social Link Modal -->
    <div class="modal fade" id="addSocialLinkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Social Media Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.social-links.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="platform" class="form-label">Platform</label>
                            <input type="text" class="form-control" id="platform" name="platform" required placeholder="e.g., github, facebook, instagram">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="e.g., GitHub, Facebook, Instagram">
                        </div>
                        <div class="mb-3">
                            <label for="icon_class" class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" class="form-control" id="icon_class" name="icon_class" required placeholder="e.g., fa-brands fa-github">
                            <div class="form-text">Use FontAwesome icon classes. You can find them at <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a></div>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="url" name="url" required placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Social Link Modal -->
    <div class="modal fade" id="editSocialLinkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Social Media Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editSocialLinkForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_platform" class="form-label">Platform</label>
                            <input type="text" class="form-control" id="edit_platform" name="platform" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_icon_class" class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" class="form-control" id="edit_icon_class" name="icon_class" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="edit_url" name="url" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_order" class="form-label">Order</label>
                            <input type="number" class="form-control" id="edit_order" name="order" required min="1">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Live preview functionality
        function updateTitlePreview() {
            try {
                const titleInput = document.getElementById('title');
                const titlePreview = document.getElementById('title-preview');
                if (titleInput && titlePreview) {
                    titlePreview.innerHTML = titleInput.value || '';
                }
            } catch (error) {
                console.error('Error updating title preview:', error);
            }
        }

        function updateSkillsPreview() {
            try {
                const skillsInput = document.getElementById('skills_list');
                const skillsPreview = document.getElementById('skills-preview');
                if (skillsInput && skillsPreview) {
                    const skills = skillsInput.value.split('\n').filter(skill => skill.trim() !== '');
                    skillsPreview.innerHTML = skills.map(skill => 
                        `<li>${skill.trim()}</li>`
                    ).join('');
                }
            } catch (error) {
                console.error('Error updating skills preview:', error);
            }
        }

        // Form validation
        function validateForm() {
            const title = document.getElementById('title').value.trim();
            const subtitle = document.getElementById('subtitle').value.trim();
            const skills = document.getElementById('skills_list').value.trim();
            const contactButton = document.getElementById('contact_button_text').value.trim();
            
            if (!title) {
                alert('Please enter a title');
                return false;
            }
            if (!subtitle) {
                alert('Please enter a subtitle');
                return false;
            }
            if (!skills) {
                alert('Please enter at least one skill');
                return false;
            }
            if (!contactButton) {
                alert('Please enter contact button text');
                return false;
            }
            return true;
        }

        // Social media link management
        function editSocialLink(id) {
            try {
                // Get link data and populate modal
                const links = JSON.parse('@json($socialLinks)');
                const linkData = links.find(l => l.id == id);
                
                if (linkData) {
                    document.getElementById('edit_platform').value = linkData.platform || '';
                    document.getElementById('edit_name').value = linkData.name || '';
                    document.getElementById('edit_icon_class').value = linkData.icon_class || '';
                    document.getElementById('edit_url').value = linkData.url || '';
                    document.getElementById('edit_order').value = linkData.order || 1;
                    document.getElementById('edit_is_active').checked = linkData.is_active || false;
                    
                    document.getElementById('editSocialLinkForm').action = `{{ url('admin/social-links') }}/${id}/update`;
                    
                    new bootstrap.Modal(document.getElementById('editSocialLinkModal')).show();
                } else {
                    alert('Social media link not found!');
                }
            } catch (error) {
                console.error('Error editing social link:', error);
                alert('Error loading social media link data. Please try again.');
            }
        }

        function deleteSocialLink(id) {
            if (confirm('Are you sure you want to delete this social media link?')) {
                try {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('admin/social-links') }}/${id}/delete`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                } catch (error) {
                    console.error('Error deleting social link:', error);
                    alert('Error deleting social media link. Please try again.');
                }
            }
        }

        function toggleSocialLink(id) {
            try {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin/social-links') }}/${id}/toggle`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            } catch (error) {
                console.error('Error toggling social link:', error);
                alert('Error updating social media link status. Please try again.');
            }
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const skillsInput = document.getElementById('skills_list');
            
            if (titleInput) {
                titleInput.addEventListener('input', updateTitlePreview);
            }
            if (skillsInput) {
                skillsInput.addEventListener('input', updateSkillsPreview);
            }

            // Initialize previews
            updateTitlePreview();
            updateSkillsPreview();
        });
    </script>
</body>
</html> 