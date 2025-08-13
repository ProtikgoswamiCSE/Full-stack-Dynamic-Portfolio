<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
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
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .social-link-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
        }
        .social-link-item.inactive {
            opacity: 0.6;
            border-left-color: #6c757d;
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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-home') }}">
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
                        <h2>Dashboard</h2>
                        <div class="text-muted">Welcome to Admin Panel</div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x mb-3"></i>
                                    <h5>Content Sections</h5>
                                    <h3>{{ $homeContents->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-edit fa-3x mb-3"></i>
                                    <h5>Editable Pages</h5>
                                    <h3>1</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-share-alt fa-3x mb-3"></i>
                                    <h5>Social Links</h5>
                                    <h3>{{ $socialLinks->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-3x mb-3"></i>
                                    <h5>Last Updated</h5>
                                    <h6>{{ $homeContents->first() ? $homeContents->first()->updated_at->diffForHumans() : 'Never' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Overview -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Content Overview</h5>
                        </div>
                        <div class="card-body">
                            @if($homeContents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Section</th>
                                                <th>Content Preview</th>
                                                <th>Last Updated</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($homeContents as $content)
                                                <tr>
                                                    <td><strong>{{ ucfirst(str_replace('_', ' ', $content->section)) }}</strong></td>
                                                    <td>
                                                        <span class="text-muted">
                                                            {{ Str::limit(strip_tags($content->content), 50) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $content->updated_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.edit-home') }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-database fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No content found</h5>
                                    <p class="text-muted">Initialize the content to get started</p>
                                    <a href="{{ route('admin.initialize-content') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Initialize Content
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social Media Links Overview -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Social Media Links</h5>
                            <a href="{{ route('admin.edit-home') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Manage Links
                            </a>
                        </div>
                        <div class="card-body">
                            @if($socialLinks->count() > 0)
                                <div class="row">
                                    @foreach($socialLinks as $link)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="social-link-item {{ !$link->is_active ? 'inactive' : '' }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <i class="{{ $link->icon_class }} me-2"></i>
                                                            {{ $link->name }}
                                                        </h6>
                                                        <small class="text-muted">{{ $link->platform }}</small>
                                                        <div class="mt-2">
                                                            <a href="{{ $link->url }}" target="_blank" class="text-decoration-none">
                                                                {{ Str::limit($link->url, 30) }}
                                                            </a>
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
                                    <p class="text-muted">Initialize the content to get started</p>
                                    <a href="{{ route('admin.initialize-content') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Initialize Content
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 