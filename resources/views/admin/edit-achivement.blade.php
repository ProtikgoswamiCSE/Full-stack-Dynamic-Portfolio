<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achivement - Admin Panel</title>
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
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                        <hr class="bg-white">
                    </div>
                    <nav class="nav flex-column">
                        <a class="{{ request()->routeIs('admin.edit-home') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-home') }}"><i class="fas fa-home me-2"></i> Home</a>
                        <a class="{{ request()->routeIs('admin.edit-home') && !request()->has('section') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-home') }}"><i class="fas fa-home me-2"></i> Edit Home Page</a>
                        <a class="{{ request()->routeIs('admin.edit-home') && request('section')==='skills' ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-home') }}?section=skills"><i class="fas fa-code me-2"></i> Edit Skills</a>
                        <a class="{{ request()->routeIs('admin.edit-home') && request('section')==='social' ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-home') }}?section=social"><i class="fas fa-share-alt me-2"></i> Edit Social Links</a>
                        <a class="{{ request()->routeIs('admin.edit-about') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-about') }}"><i class="fas fa-user me-2"></i> Edit About</a>
                        <a class="{{ request()->routeIs('admin.edit-achivement') ? 'nav-link active' : 'nav-link' }}" href="#"><i class="fas fa-trophy me-2"></i> Edit Achivement</a>
                        <a class="{{ request()->routeIs('admin.edit-academic') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-academic') }}"><i class="fas fa-graduation-cap me-2"></i> Edit Academic</a>
                        <a class="{{ request()->routeIs('admin.edit-work') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-work') }}"><i class="fas fa-briefcase me-2"></i> Edit Work</a>
                        <a class="{{ request()->routeIs('admin.edit-image') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-image') }}"><i class="fas fa-image me-2"></i> Edit Image</a>
                        <a class="{{ request()->routeIs('admin.edit-contact') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-contact') }}"><i class="fas fa-envelope me-2"></i> Edit Contact</a>
                        <a class="{{ request()->routeIs('admin.edit-footer') ? 'nav-link active' : 'nav-link' }}" href="{{ route('admin.edit-footer') }}"><i class="fas fa-shoe-prints me-2"></i> Edit Footer</a>

                        <a class="nav-link" href="{{ url('/') }}" target="_blank"><i class="fas fa-external-link-alt me-2"></i> View Site</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="main-content p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Edit Achivement</h2>
                        <a href="{{ route('admin.edit-home') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-0">Achivement page editor coming soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
