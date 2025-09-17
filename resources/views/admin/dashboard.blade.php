<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio Management</title>
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
        
        /* Stats cards improvements */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .stats-card .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .stats-card .card-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .stats-card .card-text {
            font-size: 1.1rem;
            font-weight: 500;
            opacity: 0.9;
        }
        
        /* Action cards improvements */
        .admin-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            border-radius: 15px;
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .admin-card .card-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }
        .admin-card .card-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .admin-card .card-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        .admin-card .btn {
            font-size: 1rem;
            font-weight: 500;
            padding: 10px 20px;
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
            .stats-card .card-title {
                font-size: 2rem;
            }
            .admin-card .card-title {
                font-size: 1.2rem;
            }
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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
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

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
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

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-trophy card-icon"></i>
                                    <h5 class="card-title">{{ \App\Models\Achievement::count() }}</h5>
                                    <p class="card-text">Achievements</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-code card-icon"></i>
                                    <h5 class="card-title">{{ \App\Models\Skill::count() }}</h5>
                                    <p class="card-text">Skills</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-share-alt card-icon"></i>
                                    <h5 class="card-title">{{ \App\Models\SocialMediaLink::count() }}</h5>
                                    <p class="card-text">Social Links</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-home card-icon"></i>
                                    <h5 class="card-title">{{ \App\Models\HomeContent::count() }}</h5>
                                    <p class="card-text">Content Sections</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="mb-3">Quick Actions</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card admin-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-edit text-primary card-icon"></i>
                                    <h5 class="card-title">Edit Home Page</h5>
                                    <p class="card-text">Update your main page content, title, subtitle, and skills.</p>
                                    <a href="{{ route('admin.edit-home') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i>Go to Editor
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card admin-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-trophy text-success card-icon"></i>
                                    <h5 class="card-title">Manage Achievements</h5>
                                    <p class="card-text">Add, edit, or remove your achievements and certificates.</p>
                                    <a href="{{ route('admin.edit-achivement') }}" class="btn btn-success">
                                        <i class="fas fa-arrow-right me-2"></i>Manage
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card admin-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-share-alt text-info card-icon"></i>
                                    <h5 class="card-title">Social Media</h5>
                                    <p class="card-text">Manage your social media links and profiles.</p>
                                    <a href="{{ route('admin.edit-home') }}#social-media" class="btn btn-info">
                                        <i class="fas fa-arrow-right me-2"></i>Manage
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card admin-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-code text-warning card-icon"></i>
                                    <h5 class="card-title">Manage Skills</h5>
                                    <p class="card-text">Add, edit, or reorder your technical skills.</p>
                                    <a href="{{ route('admin.edit-home') }}#skills" class="btn btn-warning">
                                        <i class="fas fa-arrow-right me-2"></i>Manage
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card admin-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-shoe-prints text-secondary card-icon"></i>
                                    <h5 class="card-title">Footer Settings</h5>
                                    <p class="card-text">Customize your footer content and social links.</p>
                                    <a href="{{ route('admin.edit-footer') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>Manage
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card admin-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-eye text-dark card-icon"></i>
                                    <h5 class="card-title">Preview Site</h5>
                                    <p class="card-text">View your portfolio website as visitors see it.</p>
                                    <a href="/" target="_blank" class="btn btn-dark">
                                        <i class="fas fa-external-link-alt me-2"></i>View Site
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">No recent activity to display.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
