<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Login Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <style>
        body { background: linear-gradient(180deg, #6a86f0, #6a4fd8); min-height: 100vh; }
        .sidebar { background: transparent; color: #fff; min-height: 100vh; }
        .nav-link { color: #eae7ff; border-radius: 12px; padding: 10px 14px; }
        .nav-link.active, .nav-link:hover { background: rgba(255,255,255,0.18); color: #fff; }
        .content-card { border: none; border-radius: 16px; box-shadow: 0 6px 24px rgba(0,0,0,0.18); }
        .label { color: #6c757d; font-weight: 600; text-transform: uppercase; font-size: .8rem; }
        .value { font-weight: 600; }
        .readonly-note { font-size: .9rem; color: #6c757d; }
    </style>
    <script>
        // Disable context menu and key actions that could imply edit/delete on this page
        document.addEventListener('contextmenu', function(e){ e.preventDefault(); });
    </script>
    @php($currentRoute = request()->route()->getName())
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
                    <a class="nav-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-home' ? 'active' : '' }}" href="{{ route('admin.edit-home') }}">
                        <i class="fas fa-edit me-2"></i> Edit Home
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-about' ? 'active' : '' }}" href="{{ route('admin.edit-about') }}">
                        <i class="fas fa-user me-2"></i> Edit About
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-achivement' ? 'active' : '' }}" href="{{ route('admin.edit-achivement') }}">
                        <i class="fas fa-trophy me-2"></i> Edit Achievements
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-academic' ? 'active' : '' }}" href="{{ route('admin.edit-academic') }}">
                        <i class="fas fa-graduation-cap me-2"></i> Edit Academic
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-work' ? 'active' : '' }}" href="{{ route('admin.edit-work') }}">
                        <i class="fas fa-briefcase me-2"></i> Edit Work
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-project' ? 'active' : '' }}" href="{{ route('admin.edit-project') }}">
                        <i class="fas fa-project-diagram me-2"></i> Edit Project
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-image' ? 'active' : '' }}" href="{{ route('admin.edit-image') }}">
                        <i class="fas fa-images me-2"></i> Edit Images
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-contact' ? 'active' : '' }}" href="{{ route('admin.edit-contact') }}">
                        <i class="fas fa-envelope me-2"></i> Edit Contact
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.edit-footer' ? 'active' : '' }}" href="{{ route('admin.edit-footer') }}">
                        <i class="fas fa-shoe-prints me-2"></i> Edit Footer
                    </a>
                    <a class="nav-link {{ $currentRoute === 'admin.data-management' ? 'active' : '' }}" href="{{ route('admin.data-management') }}">
                        <i class="fas fa-database me-2"></i> Data Management
                    </a>
                    <a class="nav-link active" href="{{ route('admin.login-details') }}">
                        <i class="fas fa-user-shield me-2"></i> Login Details
                    </a>
                    <a class="nav-link" href="/" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i> View Site
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card content-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-user-shield text-primary me-2"></i>
                        <h4 class="mb-0">Login Details</h4>
                    </div>
                    <p class="readonly-note">This page is read-only. You can view your login information but cannot change or delete it here.</p>
                    <hr>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="label">Name</div>
                            <div class="value">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="label">Email</div>
                            <div class="value">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="label">Account Created</div>
                            <div class="value">{{ optional($user->created_at)->format('d M Y, h:i A') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="label">Last Login</div>
                            <div class="value">{{ optional($user->last_login_at)->format('d M Y, h:i A') ?? '—' }}</div>
                        </div>
                    </div>

                    <h5 class="mb-3"><i class="fas fa-user-gear me-2"></i>Security Settings</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('admin.security.update-login-code') }}" class="card p-3">
                                @csrf
                                <label class="form-label fw-semibold">Change Login Code</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" id="loginCodeInput" name="new_code" class="form-control" placeholder="Enter new code (e.g., 15-5841)" value="{{ old('new_code', config('services.admin_login_code')) }}" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="const i=document.getElementById('loginCodeInput'); i.type = i.type==='password' ? 'text' : 'password'; this.innerHTML = i.type==='password' ? '<i class=\'fas fa-eye\'></i>' : '<i class=\'fas fa-eye-slash\'></i>'"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-save me-1"></i>Save</button>
                                </div>
                                <small class="text-muted mt-2">Current saved code is prefilled above. This updates `ADMIN_LOGIN_CODE` in .env.</small>
                            </form>
                        </div>
                    </div>

                    <h5 class="mb-3"><i class="fas fa-users me-2"></i>All Registered Admins</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                    <th>Last Login</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\User::orderByDesc('created_at')->get() as $index => $u)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ optional($u->created_at)->format('d M Y, h:i A') }}</td>
                                        <td>{{ optional($u->last_login_at)->format('d M Y, h:i A') ?? '—' }}</td>
                                        <td class="text-end">
                                            @if(auth()->id() !== $u->id)
                                                <form method="POST" action="{{ route('admin.security.delete-user', $u->id) }}" onsubmit="return confirm('Delete this user? This cannot be undone.');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-user-times me-1"></i>Delete
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">You</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


