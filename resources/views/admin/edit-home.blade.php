<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Home Page - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-soft: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--primary-gradient);
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--glass-border);
            box-shadow: var(--shadow-soft);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            border-radius: 12px;
            margin: 8px 0;
            padding: 12px 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: var(--glass-bg);
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .main-content {
            background: transparent;
            min-height: 100vh;
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
            border-radius: 20px 20px 0 0;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%, rgba(255,255,255,0.1) 100%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            transform: translateY(-2px);
        }

        .btn {
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-success {
            background: var(--success-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
        }

        .preview-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #667eea;
            border-radius: 15px;
            padding: 30px;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
        }

        .preview-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .social-link-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-link-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .social-link-card:hover::before {
            opacity: 1;
        }

        .social-link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left-color: #4facfe;
        }

        .social-link-card.inactive {
            opacity: 0.6;
            border-left-color: #6c757d;
        }

        .icon-preview {
            font-size: 1.8rem;
            margin-right: 15px;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .social-link-card:hover .icon-preview {
            transform: scale(1.2);
            color: #4facfe;
        }

        .profile-preview-container {
            display: inline-block;
            position: relative;
            transition: all 0.3s ease;
        }

        .profile-preview-container:hover {
            transform: scale(1.05);
        }

        .home__blob-preview {
            fill: var(--bg-color-preview, #4CAF50);
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, var(--shadow-opacity-preview, 0.3)));
            transition: all 0.3s ease;
        }

        .home__blob-img-preview {
            width: 400px;
            height: 400px;
            border: 3px solid var(--border-color-preview, #8B4513);
            border-radius: 50%;
            transition: all 0.3s ease;
            cursor: pointer;
            object-fit: cover;
        }

        .home__blob-img-preview:hover {
            transform: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .current-profile-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #667eea;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .current-profile-img:hover {
            transform: none;
            border-color: #4facfe;
        }

        .current-image-container {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            border: 2px dashed #dee2e6;
        }
        
        .current-profile-img {
            max-width: 200px;
            max-height: 200px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #667eea;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        /* Live Preview Animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .preview-section {
            transition: all 0.3s ease;
        }

        .preview-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .form-control-color {
            transition: all 0.3s ease;
        }

        .form-control-color:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .form-range {
            transition: all 0.3s ease;
        }

        .form-range:hover {
            transform: scale(1.02);
        }

        .form-control-color {
            width: 100%;
            height: 50px;
            padding: 0;
            border: 3px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-control-color:hover {
            border-color: #667eea;
            transform: scale(1.05);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-control.is-valid {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .preview-section .badge {
            transition: all 0.3s ease;
        }

        .preview-section .badge.bg-success {
            animation: pulse-success 0.5s ease-in-out;
        }

        @keyframes pulse-success {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .form-range {
            background: linear-gradient(to right, #667eea, #764ba2);
            height: 8px;
            border-radius: 5px;
        }

        .form-range::-webkit-slider-thumb {
            background: var(--primary-gradient);
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border: none;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            border-left: 5px solid #4facfe;
            color: #0c5460;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(245, 87, 108, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
            border-left: 5px solid #f5576c;
            color: #721c24;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.bg-success {
            background: var(--success-gradient) !important;
        }

        .badge.bg-secondary {
            background: var(--dark-gradient) !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 8px;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 20px 20px 0 0;
        }

        .btn-close {
            filter: invert(1);
        }

        /* Loading animation */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* File upload styling */
        .upload-area {
            position: relative;
        }

        .file-input-wrapper {
            position: relative;
            border: 2px dashed #667eea;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            border-color: #4facfe;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            transform: translateY(-2px);
        }

        .file-input-wrapper.drag-over {
            border-color: #4facfe;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.15) 100%);
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-input-overlay {
            pointer-events: none;
        }

        .file-input-overlay i {
            color: #667eea;
            transition: all 0.3s ease;
        }

        .file-input-wrapper:hover .file-input-overlay i {
            color: #4facfe;
            transform: scale(1.1);
        }

        /* Enhanced form styling */
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            transform: translateY(-2px);
        }

        .form-control:focus + .file-input-overlay {
            opacity: 0.7;
        }

        /* Enhanced button styling */
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
        }

        /* Enhanced card headers */
        .card-header h5 {
            margin: 0;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-header i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Enhanced social link cards */
        .social-link-card .btn {
            padding: 8px 12px;
            font-size: 0.875rem;
            border-radius: 8px;
        }

        .social-link-card .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
        }

        .social-link-card .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }

        .social-link-card .btn-outline-warning {
            border-color: #ffc107;
            color: #ffc107;
        }

        .social-link-card .btn-outline-warning:hover {
            background: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .social-link-card .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .social-link-card .btn-outline-success:hover {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .social-link-card .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .social-link-card .btn-outline-danger:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        /* Enhanced preview section */
        .preview-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #667eea;
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            position: relative;
            overflow: hidden;
        }

        .preview-section::after {
            content: '';
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: var(--primary-gradient);
            border-radius: 50%;
            opacity: 0.1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.1; }
            50% { transform: scale(1.1); opacity: 0.2; }
            100% { transform: scale(1); opacity: 0.1; }
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .card {
                margin-bottom: 1rem;
            }
            
            .profile-preview-container {
                margin: 20px 0;
            }

            .file-input-wrapper {
                padding: 20px;
            }

            .preview-section {
                padding: 20px;
            }

            .d-flex.gap-3 {
                flex-direction: column;
                gap: 10px !important;
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
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link active" href="{{ route('admin.edit-home') }}">
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
                        <a class="nav-link" href="/" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> View Site
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content p-4">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h2 class="mb-2" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">Edit Home Page</h2>
                            <p class="text-muted mb-0">Customize your portfolio's home page content and appearance</p>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="/" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt me-2"></i> View Site
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                            </a>
                        </div>
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
                            <form id="homeContentForm" action="{{ route('admin.update-home') }}" method="POST" onsubmit="return validateForm()">
                                @csrf
                                
                                <!-- Title Section -->
                                <div class="mb-4">
                                    <label for="title" class="form-label">Title (HTML allowed)</label>
                                    <textarea class="form-control" id="title" name="title" rows="3" placeholder="Enter the main title...">{{ $homeContents['title']->content ?? '' }}</textarea>
                                    <div class="form-text">You can use HTML tags like &lt;br&gt; for line breaks and &lt;span&gt; for styling.</div>
                                    <div class="preview-section">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted mb-0">Preview:</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="updateTitlePreview()">
                                                <i class="fas fa-sync-alt me-1"></i>Refresh Preview
                                            </button>
                                        </div>
                                        <div id="title-preview"></div>
                                    </div>
                                </div>

                                <div class="form-check form-switch mb-4">
                                    <input class="form-check-input" type="checkbox" id="animation_enabled" name="animation_enabled" value="1" {{ (isset($homeContents['animation_enabled']) && $homeContents['animation_enabled']->content === '1') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="animation_enabled">Enable homepage animation</label>
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
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted mb-0">Preview:</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="updateSkillsPreview()">
                                                <i class="fas fa-sync-alt me-1"></i>Refresh Preview
                                            </button>
                                        </div>
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

                    <!-- Profile Image Customization -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-image me-2"></i>Profile Image Color Customization</h5>
                        </div>
                        <div class="card-body">
                            <form id="profileImageForm" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Contact Button Text -->
                                <div class="mb-4">
                                    <label for="contact_button_text_profile" class="form-label">Contact Button Text</label>
                                    <input type="text" class="form-control" id="contact_button_text_profile" name="contact_button_text" value="{{ $homeContents['contact_button_text']->content ?? 'Contact' }}" placeholder="Enter button text...">
                                </div>

                                <!-- Profile Image Color Customization -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="background_color" class="form-label">Background Color</label>
                                        <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="{{ $profileSettings->background_color ?? '#4CAF50' }}">
                                        <div class="form-text">Choose the background color for the profile image area</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="border_color" class="form-label">Border Color</label>
                                        <input type="color" class="form-control form-control-color" id="border_color" name="border_color" value="{{ $profileSettings->border_color ?? '#8B4513' }}">
                                        <div class="form-text">Choose the border color for the profile image</div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="shadow_color" class="form-label">Shadow Color</label>
                                        <input type="color" class="form-control form-control-color" id="shadow_color" name="shadow_color" value="{{ $profileSettings->shadow_color ?? '#4CAF50' }}">
                                        <div class="form-text">Choose the shadow color for the profile image</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shadow_opacity" class="form-label">Shadow Opacity</label>
                                        <input type="range" class="form-range" id="shadow_opacity" name="shadow_opacity" min="0" max="100" value="{{ $profileSettings->shadow_opacity ?? 75 }}">
                                        <div class="form-text">Adjust shadow opacity (0-100%)</div>
                                    </div>
                                </div>

                                <!-- Preview Section -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-eye me-2" style="color: #667eea; font-size: 1.2rem;"></i>
                                        <h6 class="mb-0" style="color: #495057; font-weight: 600;">Live Preview</h6>
                                        <div class="ms-auto">
                                            <span class="badge bg-primary">Real-time</span>
                                        </div>
                                    </div>
                                    <div class="preview-section text-center position-relative">
                                        <div class="profile-preview-container">
                                            <svg class="home__blob-preview" viewBox="0 0 479 467" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 450px; height: 450px; --bg-color-preview: {{ $profileSettings->background_color ?? '#4CAF50' }}; --border-color-preview: {{ $profileSettings->border_color ?? '#8B4513' }}; --shadow-color-preview: {{ $profileSettings->shadow_color ?? '#4CAF50' }}; --shadow-opacity-preview: {{ ($profileSettings->shadow_opacity ?? 75) / 100 }};">
                                                <mask id="mask0-preview" mask-type="alpha">
                                                    <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z"/>
                                                </mask>
                                                <g mask="url(#mask0-preview)">
                                                    <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z" fill="var(--bg-color-preview)"/>
                                                    <image class="home__blob-img-preview" x="15" y="25" href="{{ $profileSettings->profile_image ? asset('storage/' . $profileSettings->profile_image) : asset('assets/img/protik.png') }}" width="550" height="550" alt="Profile Preview" style="border: 3px solid var(--border-color-preview); border-radius: 50%; cursor: pointer;" onclick="zoomImage(this)" onerror="this.onerror=null; this.href='{{ asset('assets/img/protik.png') }}';"/>
                                                </g>
                                            </svg>
                                            <div class="mt-3">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <i class="fas fa-search-plus" style="color: #667eea;"></i>
                                                    <small class="text-muted fw-medium">Click image to zoom</small>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">Changes appear instantly as you adjust colors</small>
                                                </div>
                                                <div class="mt-2">
                                                    <span class="badge bg-primary" id="live-preview-indicator">
                                                        <i class="fas fa-eye me-1"></i>Live Preview Active
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Image Upload -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <i class="fas fa-cloud-upload-alt me-2" style="color: #667eea; font-size: 1.2rem;"></i>
                                        <h6 class="mb-0" style="color: #495057; font-weight: 600;">Profile Image Upload</h6>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="upload-area">
                                                <label for="profile_image" class="form-label d-flex align-items-center">
                                                    <i class="fas fa-upload me-2"></i>Upload New Image
                                                </label>
                                                <div class="file-input-wrapper" id="file-drop-zone">
                                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/gif" onchange="previewImage(this)">
                                                    <div class="file-input-overlay">
                                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                                        <p class="mb-0">Click to browse or drag & drop</p>
                                                        <small class="text-muted">JPG, PNG, GIF - Max 5MB</small>
                                                    </div>
                                                </div>
                                                <div class="form-text mt-2">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Supported formats: JPG, PNG, GIF (Maximum 5MB)
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label d-flex align-items-center">
                                                <i class="fas fa-image me-2"></i>Current Image
                                            </label>
                                            <div class="current-image-container">
                                                @if($profileSettings->profile_image)
                                                    <img src="{{ asset('storage/' . $profileSettings->profile_image) }}" 
                                                         alt="Current Profile" 
                                                         class="current-profile-img" 
                                                         id="current-profile-img"
                                                         onerror="this.onerror=null; this.src='{{ asset('assets/img/protik.png') }}'; this.alt='Default Profile';">
                                                    <div class="mt-2">
                                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                                            <i class="fas fa-file-image me-1" style="color: #667eea;"></i>
                                                            <span class="fw-medium">{{ basename($profileSettings->profile_image) }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ asset('assets/img/protik.png') }}" 
                                                         alt="Default Profile" 
                                                         class="current-profile-img" 
                                                         id="current-profile-img"
                                                         onerror="this.onerror=null; this.src='{{ asset('assets/img/protik.png') }}';">
                                                    <div class="mt-2">
                                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                                            <i class="fas fa-image me-1" style="color: #6c757d;"></i>
                                                            <span class="text-muted">Default profile image</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="mt-3">
                                                    <small class="text-muted d-block text-center">
                                                        <i class="fas fa-arrow-up me-1"></i>
                                                        Upload a new image to replace this one
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Alt Text -->
                                <div class="mb-4">
                                    <label for="image_alt_text" class="form-label">Image Alt Text</label>
                                    <input type="text" class="form-control" id="image_alt_text" name="image_alt_text" value="{{ $profileSettings->image_alt_text ?? '' }}" placeholder="Describe the image for screen readers">
                                    <div class="form-text">Describe the image for screen readers</div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>Update Home Page
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

                    <!-- Skills Management -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-code me-2"></i>Skills</h5>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                                <i class="fas fa-plus me-2"></i>Add Skill
                            </button>
                        </div>
                        <div class="card-body">
                            @if(isset($skills) && $skills->count() > 0)
                                <div class="row">
                                    @foreach($skills as $skill)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="social-link-card {{ !$skill->is_active ? 'inactive' : '' }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="{{ $skill->icon_class }} icon-preview"></i>
                                                            <h6 class="mb-0">{{ $skill->name }}</h6>
                                                        </div>
                                                        <small class="text-muted d-block mb-2">Proficiency: {{ $skill->proficiency_percent }}%</small>
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-sm btn-outline-primary" onclick="editSkill('{{ $skill->id }}')">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-{{ $skill->is_active ? 'warning' : 'success' }}" onclick="toggleSkill('{{ $skill->id }}')">
                                                                <i class="fas fa-{{ $skill->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSkill('{{ $skill->id }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge {{ $skill->is_active ? 'bg-success' : 'bg-secondary' }} mb-2">
                                                            {{ $skill->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                        <div>
                                                            <small class="text-muted">Order: {{ $skill->order }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-code fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No skills found</h5>
                                    <p class="text-muted">Add your first skill to get started</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                                        <i class="fas fa-plus me-2"></i>Add First Skill
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
                <form action="{{ route('admin.social.add') }}" method="POST">
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

    <!-- Add Skill Modal -->
    <div class="modal fade" id="addSkillModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.skills.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="skill_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="skill_name" name="name" required placeholder="e.g., HTML/CSS/JS">
                        </div>
                        <div class="mb-3">
                            <label for="skill_icon_class" class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" class="form-control" id="skill_icon_class" name="icon_class" placeholder="e.g., fa-brands fa-html5">
                        </div>
                        <div class="mb-3">
                            <label for="skill_percent" class="form-label">Proficiency (%)</label>
                            <input type="number" class="form-control" id="skill_percent" name="proficiency_percent" min="0" max="100" required placeholder="0-100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Skill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Skill Modal -->
    <div class="modal fade" id="editSkillModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editSkillForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_skill_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_skill_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_skill_icon_class" class="form-label">Icon Class</label>
                            <input type="text" class="form-control" id="edit_skill_icon_class" name="icon_class">
                        </div>
                        <div class="mb-3">
                            <label for="edit_skill_percent" class="form-label">Proficiency (%)</label>
                            <input type="number" class="form-control" id="edit_skill_percent" name="proficiency_percent" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_skill_order" class="form-label">Order</label>
                            <input type="number" class="form-control" id="edit_skill_order" name="order" required min="1">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_skill_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_skill_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Skill</button>
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
                    let content = titleInput.value || '';
                    
                    // Allow basic HTML tags for formatting
                    content = content.replace(/&/g, '&amp;')
                                   .replace(/</g, '&lt;')
                                   .replace(/>/g, '&gt;')
                                   .replace(/&lt;br&gt;/g, '<br>')
                                   .replace(/&lt;span([^&]*)&gt;/g, '<span$1>')
                                   .replace(/&lt;\/span&gt;/g, '</span>');
                    
                    titlePreview.innerHTML = content;
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
                    
                    skillsPreview.innerHTML = skills.map(skill => {
                        const cleanSkill = skill.trim().replace(/^\*\s*/, '');
                        return `<li><i class="fas fa-check-circle me-2" style="color: #667eea;"></i>${cleanSkill}</li>`;
                    }).join('');
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
            
            console.log('Form validation:', { title, subtitle, skills, contactButton });
            
            if (!title) {
                alert('Please enter a title');
                document.getElementById('title').focus();
                return false;
            }
            if (!subtitle) {
                alert('Please enter a subtitle');
                document.getElementById('subtitle').focus();
                return false;
            }
            if (!skills) {
                alert('Please enter at least one skill');
                document.getElementById('skills_list').focus();
                return false;
            }
            if (!contactButton) {
                alert('Please enter contact button text');
                document.getElementById('contact_button_text').focus();
                return false;
            }
            
            console.log('Form validation passed, submitting...');
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
                    
                    document.getElementById('editSocialLinkForm').action = `{{ url('admin/social') }}/${id}/update`;
                    
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
                    form.action = `{{ url('admin/social') }}/${id}/delete`;
                    
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
                form.action = `{{ url('admin/social') }}/${id}/toggle`;
                
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

        // Image preview functionality
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentImg = document.getElementById('current-profile-img');
                    const previewImg = document.querySelector('.home__blob-img-preview');
                    
                    console.log('Updating image preview:', e.target.result);
                    
                    if (currentImg) {
                        currentImg.src = e.target.result;
                        currentImg.style.display = 'block';
                        currentImg.onerror = null; // Remove error handler for new image
                    }
                    if (previewImg) {
                        previewImg.href = e.target.result;
                        previewImg.setAttribute('href', e.target.result);
                        previewImg.onerror = null; // Remove error handler for new image
                    }
                    
                    // Save the image preview to localStorage
                    saveImagePreview(e.target.result);
                    
                    // Show success message
                    showPreviewMessage('Image preview updated successfully!', 'success');
                    
                    console.log('Image preview updated successfully');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Save image preview to localStorage
        function saveImagePreview(imageData) {
            try {
                const imageState = {
                    imageData: imageData,
                    timestamp: Date.now()
                };
                localStorage.setItem('profileImagePreview', JSON.stringify(imageState));
                console.log('Image preview saved to localStorage');
            } catch (error) {
                console.error('Error saving image preview:', error);
            }
        }

        // Load saved image preview from localStorage
        function loadImagePreview() {
            try {
                const savedImage = localStorage.getItem('profileImagePreview');
                if (savedImage) {
                    const imageState = JSON.parse(savedImage);
                    
                    // Check if image is not too old (24 hours)
                    const maxAge = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
                    if (Date.now() - imageState.timestamp < maxAge) {
                        const currentImg = document.getElementById('current-profile-img');
                        const previewImg = document.querySelector('.home__blob-img-preview');
                        
                        if (currentImg && imageState.imageData) {
                            currentImg.src = imageState.imageData;
                            currentImg.style.display = 'block';
                        }
                        
                        if (previewImg && imageState.imageData) {
                            previewImg.href = imageState.imageData;
                            previewImg.setAttribute('href', imageState.imageData);
                        }
                        
                        console.log('Image preview restored from localStorage');
                    } else {
                        console.log('Saved image preview is too old, using default');
                        localStorage.removeItem('profileImagePreview');
                    }
                }
            } catch (error) {
                console.error('Error loading image preview:', error);
            }
        }

        // Ensure images load properly on page load and setup live preview
        document.addEventListener('DOMContentLoaded', function() {
            const currentImg = document.getElementById('current-profile-img');
            const previewImg = document.querySelector('.home__blob-img-preview');
            
            if (currentImg) {
                currentImg.onload = function() {
                    console.log('Current image loaded successfully');
                };
                currentImg.onerror = function() {
                    console.log('Current image failed to load, using fallback');
                    this.src = '{{ asset('assets/img/protik.png') }}';
                };
            }
            
            if (previewImg) {
                previewImg.onload = function() {
                    console.log('Preview image loaded successfully');
                };
                previewImg.onerror = function() {
                    console.log('Preview image failed to load, using fallback');
                    this.href = '{{ asset('assets/img/protik.png') }}';
                };
            }

            // Setup live preview event listeners
            setupLivePreview();
            
            // Load saved image preview
            loadImagePreview();
            
            // Initialize preview with current values
            updateProfilePreview();
        });

        // Setup live preview event listeners
        function setupLivePreview() {
            const colorInputs = ['background_color', 'border_color', 'shadow_color', 'shadow_opacity'];
            
            colorInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    // Add event listeners for real-time updates
                    input.addEventListener('input', function() {
                        updateProfilePreview();
                        savePreviewState(); // Save state on every change
                    });
                    
                    input.addEventListener('change', function() {
                        updateProfilePreview();
                        savePreviewState(); // Save state on change
                    });
                    
                    // For color inputs, also listen to color picker changes
                    if (input.type === 'color') {
                        input.addEventListener('colorchange', function() {
                            updateProfilePreview();
                            savePreviewState();
                        });
                    }
                }
            });
            
            // Load saved state on page load
            loadPreviewState();
            
            console.log('Live preview event listeners setup complete');
        }

        // Save current preview state to localStorage
        function savePreviewState() {
            try {
                const state = {
                    background_color: document.getElementById('background_color')?.value || '#4CAF50',
                    border_color: document.getElementById('border_color')?.value || '#8B4513',
                    shadow_color: document.getElementById('shadow_color')?.value || '#4CAF50',
                    shadow_opacity: document.getElementById('shadow_opacity')?.value || 75,
                    timestamp: Date.now()
                };
                
                localStorage.setItem('profilePreviewState', JSON.stringify(state));
                console.log('Preview state saved:', state);
            } catch (error) {
                console.error('Error saving preview state:', error);
            }
        }

        // Load saved preview state from localStorage
        function loadPreviewState() {
            try {
                const savedState = localStorage.getItem('profilePreviewState');
                if (savedState) {
                    const state = JSON.parse(savedState);
                    
                    // Check if state is not too old (24 hours)
                    const maxAge = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
                    if (Date.now() - state.timestamp < maxAge) {
                        // Restore the saved values
                        if (state.background_color) {
                            const bgInput = document.getElementById('background_color');
                            if (bgInput) bgInput.value = state.background_color;
                        }
                        
                        if (state.border_color) {
                            const borderInput = document.getElementById('border_color');
                            if (borderInput) borderInput.value = state.border_color;
                        }
                        
                        if (state.shadow_color) {
                            const shadowInput = document.getElementById('shadow_color');
                            if (shadowInput) shadowInput.value = state.shadow_color;
                        }
                        
                        if (state.shadow_opacity) {
                            const opacityInput = document.getElementById('shadow_opacity');
                            if (opacityInput) opacityInput.value = state.shadow_opacity;
                        }
                        
                        // Update preview with restored values
                        setTimeout(() => {
                            updateProfilePreview();
                        }, 100);
                        
                        console.log('Preview state restored:', state);
                    } else {
                        console.log('Saved preview state is too old, using defaults');
                        localStorage.removeItem('profilePreviewState');
                    }
                }
            } catch (error) {
                console.error('Error loading preview state:', error);
            }
        }

        // Show preview message
        function showPreviewMessage(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        // Profile image preview functionality
        function updateProfilePreview() {
            try {
                const bgColor = document.getElementById('background_color')?.value || '#4CAF50';
                const borderColor = document.getElementById('border_color')?.value || '#8B4513';
                const shadowColor = document.getElementById('shadow_color')?.value || '#4CAF50';
                const shadowOpacity = (document.getElementById('shadow_opacity')?.value || 75) / 100;
                
                console.log('Updating profile preview:', { bgColor, borderColor, shadowColor, shadowOpacity });
                
                const previewSvg = document.querySelector('.home__blob-preview');
                const previewImg = document.querySelector('.home__blob-img-preview');
                
                if (previewSvg) {
                    // Update CSS variables
                    previewSvg.style.setProperty('--bg-color-preview', bgColor);
                    previewSvg.style.setProperty('--border-color-preview', borderColor);
                    previewSvg.style.setProperty('--shadow-color-preview', shadowColor);
                    previewSvg.style.setProperty('--shadow-opacity-preview', shadowOpacity);
                    
                    // Update the fill color of the blob directly
                    const blobPath = previewSvg.querySelector('path[fill="var(--bg-color-preview)"]');
                    if (blobPath) {
                        blobPath.setAttribute('fill', bgColor);
                    }
                    
                    // Add shadow effect with better color support
                    const shadowRgb = hexToRgb(shadowColor);
                    if (shadowRgb) {
                        previewSvg.style.filter = `drop-shadow(0 8px 16px rgba(${shadowRgb.r}, ${shadowRgb.g}, ${shadowRgb.b}, ${shadowOpacity}))`;
                    } else {
                        previewSvg.style.filter = `drop-shadow(0 8px 16px rgba(0, 0, 0, ${shadowOpacity}))`;
                    }
                }
                
                if (previewImg) {
                    previewImg.style.borderColor = borderColor;
                    previewImg.style.borderWidth = '3px';
                    previewImg.style.borderStyle = 'solid';
                    previewImg.style.transition = 'border-color 0.3s ease';
                }
                
                // Show live preview indicator
                const previewIndicator = document.getElementById('live-preview-indicator');
                if (previewIndicator) {
                    previewIndicator.innerHTML = '<i class="fas fa-check me-1"></i>Live Preview - Updated';
                    previewIndicator.className = 'badge bg-success';
                    previewIndicator.style.animation = 'pulse 0.5s ease-in-out';
                    setTimeout(() => {
                        previewIndicator.innerHTML = '<i class="fas fa-eye me-1"></i>Live Preview Active';
                        previewIndicator.className = 'badge bg-primary';
                        previewIndicator.style.animation = '';
                    }, 1000);
                }
                
                // Add visual feedback to the preview area
                const previewContainer = document.querySelector('.preview-section');
                if (previewContainer) {
                    previewContainer.style.transition = 'transform 0.2s ease';
                    previewContainer.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        previewContainer.style.transform = 'scale(1)';
                    }, 200);
                }
                
                console.log('Profile preview updated successfully');
            } catch (error) {
                console.error('Error updating profile preview:', error);
            }
        }

        // Helper function to convert hex to RGB
        function hexToRgb(hex) {
            const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        // Function to refresh frontend
        function refreshFrontend() {
            const frontendWindow = window.open('/', '_blank');
            if (frontendWindow) {
                frontendWindow.focus();
                showPreviewMessage('Frontend opened in new tab. Changes should be visible after refresh.', 'info');
            }
        }

        // Profile image form submission
        function handleProfileImageSubmit(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
            
            // Validate form
            const requiredFields = ['background_color', 'border_color', 'shadow_color', 'shadow_opacity'];
            let isValid = true;
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field || !field.value) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                showPreviewMessage('Please fill in all required fields', 'danger');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }
            
            fetch('{{ route("admin.update-profile-image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
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
                    showPreviewMessage(data.message || 'Profile image settings updated successfully!', 'success');
                    
                    // Update current image if new image was uploaded
                    const fileInput = document.getElementById('profile_image');
                    if (fileInput.files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const currentImg = document.querySelector('.current-profile-img');
                            if (currentImg) {
                                currentImg.src = e.target.result;
                            }
                            const previewImg = document.querySelector('.home__blob-img-preview');
                            if (previewImg) {
                                previewImg.href = e.target.result;
                            }
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                    
                    // Clear file input
                    fileInput.value = '';
                    
                    // Update preview with new settings
                    updateProfilePreview();
                    
                    // Show option to view frontend
                    setTimeout(() => {
                        const viewFrontend = confirm('Settings updated successfully! Would you like to view the frontend to see the changes?');
                        if (viewFrontend) {
                            window.open('/', '_blank');
                        }
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Update failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showPreviewMessage('Error updating profile image: ' + error.message, 'danger');
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Drag and drop functionality
        function setupDragAndDrop() {
            const dropZone = document.getElementById('file-drop-zone');
            const fileInput = document.getElementById('profile_image');
            
            if (!dropZone || !fileInput) return;
            
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });
            
            // Highlight drop zone when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            // Handle dropped files
            dropZone.addEventListener('drop', handleDrop, false);
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            function highlight(e) {
                dropZone.classList.add('drag-over');
            }
            
            function unhighlight(e) {
                dropZone.classList.remove('drag-over');
            }
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    const file = files[0];
                    
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        showPreviewMessage('Please select a valid image file', 'danger');
                        return;
                    }
                    
                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        showPreviewMessage('File size must be less than 5MB', 'danger');
                        return;
                    }
                    
                    // Set the file to input
                    fileInput.files = files;
                    
                    // Trigger preview
                    previewImage(fileInput);
                }
            }
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Setup title preview
            const titleInput = document.getElementById('title');
            if (titleInput) {
                titleInput.addEventListener('input', updateTitlePreview);
                titleInput.addEventListener('keyup', updateTitlePreview);
            }
            
            // Setup skills preview
            const skillsInput = document.getElementById('skills_list');
            if (skillsInput) {
                skillsInput.addEventListener('input', updateSkillsPreview);
                skillsInput.addEventListener('keyup', updateSkillsPreview);
            }
            
            // Setup form submission handler
            const homeContentForm = document.getElementById('homeContentForm');
            if (homeContentForm) {
                homeContentForm.addEventListener('submit', function(e) {
                    console.log('Form submission started...');
                    
                    // Show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                        submitBtn.disabled = true;
                        
                        // Re-enable after 5 seconds as fallback
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }, 5000);
                    }
                });
            }

            // Profile image form
            const profileForm = document.getElementById('profileImageForm');
            if (profileForm) {
                profileForm.addEventListener('submit', handleProfileImageSubmit);
                
                // Live preview for color changes
                const colorInputs = ['background_color', 'border_color', 'shadow_color', 'shadow_opacity'];
                colorInputs.forEach(inputId => {
                    const input = document.getElementById(inputId);
                    if (input) {
                        input.addEventListener('input', updateProfilePreview);
                    }
                });
                
                // Initialize profile preview
                updateProfilePreview();
            }

            // Setup drag and drop
            setupDragAndDrop();

            // Initialize previews
            updateTitlePreview();
            updateSkillsPreview();

            // Scroll to requested section if query present
            try {
                const params = new URLSearchParams(window.location.search);
                const section = params.get('section');
                if (section === 'skills') {
                    document.getElementById('skills_list')?.closest('.card')?.scrollIntoView({ behavior: 'smooth' });
                } else if (section === 'social') {
                    const socialHeader = Array.from(document.querySelectorAll('.card-header h5')).find(h => h.textContent.includes('Social Media Links'));
                    socialHeader?.closest('.card')?.scrollIntoView({ behavior: 'smooth' });
                }
            } catch (e) {}
        });

        // Global function to test preview functionality
        window.testPreview = function() {
            updateTitlePreview();
            updateSkillsPreview();
            updateProfilePreview();
        };

        // Image zoom functionality
        function zoomImage(img) {
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                cursor: pointer;
            `;
            
            const zoomedImg = document.createElement('img');
            zoomedImg.src = img.href;
            zoomedImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 50%;
                border: 3px solid #fff;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            `;
            
            modal.appendChild(zoomedImg);
            document.body.appendChild(modal);
            
            modal.addEventListener('click', () => {
                document.body.removeChild(modal);
            });
        }
        
        // Skills management
        function editSkill(id) {
            try {
                const skillList = JSON.parse('@json($skills)');
                const skill = skillList.find(s => s.id == id);
                if (!skill) {
                    alert('Skill not found');
                    return;
                }
                document.getElementById('edit_skill_name').value = skill.name || '';
                document.getElementById('edit_skill_icon_class').value = skill.icon_class || '';
                document.getElementById('edit_skill_percent').value = skill.proficiency_percent || 0;
                document.getElementById('edit_skill_order').value = skill.order || 1;
                document.getElementById('edit_skill_is_active').checked = !!skill.is_active;
                document.getElementById('editSkillForm').action = `{{ url('admin/skills') }}/${id}/update`;
                new bootstrap.Modal(document.getElementById('editSkillModal')).show();
            } catch (error) {
                console.error('Error editing skill:', error);
                alert('Error loading skill data. Please try again.');
            }
        }

        function deleteSkill(id) {
            if (confirm('Are you sure you want to delete this skill?')) {
                try {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('admin/skills') }}/${id}/delete`;
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                } catch (error) {
                    console.error('Error deleting skill:', error);
                    alert('Error deleting skill. Please try again.');
                }
            }
        }

        function toggleSkill(id) {
            try {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin/skills') }}/${id}/toggle`;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            } catch (error) {
                console.error('Error toggling skill:', error);
                alert('Error updating skill status. Please try again.');
            }
        }
    </script>
</body>
</html> 