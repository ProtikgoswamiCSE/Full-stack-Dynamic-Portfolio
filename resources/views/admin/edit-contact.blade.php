<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact - Admin Panel</title>
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
                        <a class="nav-link" href="{{ route('admin.edit-project') }}">
                            <i class="fas fa-project-diagram me-2"></i> Edit Project
                        </a>
                        <a class="nav-link" href="{{ route('admin.edit-image') }}">
                            <i class="fas fa-images me-2"></i> Edit Images
                        </a>
                        <a class="nav-link active" href="{{ route('admin.edit-contact') }}">
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
            <div class="col-md-9 col-lg-10">
                <div class="main-content p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Edit Contact</h2>
                        <a href="{{ route('admin.edit-home') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="fas fa-inbox me-2"></i>Contact Messages</h5>
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(isset($messages) && count($messages))
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <input type="checkbox" id="selectAll" class="form-check-input me-2">
                                        <label for="selectAll" class="form-check-label">Select All</label>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" id="deleteSelectedBtn" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt me-1"></i> Delete Selected
                                        </button>
                                        <form action="{{ route('admin.contact.delete-all') }}" method="POST" onsubmit="return confirm('Delete ALL messages?')" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash me-1"></i> Delete All
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Received At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($messages as $msg)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" value="{{ $msg->id }}" class="selectItem form-check-input">
                                                    </td>
                                                    <td>{{ $msg->name }}</td>
                                                    <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
                                                    <td style="max-width:480px; white-space:pre-wrap;">{{ $msg->message }}</td>
                                                    <td>{{ $msg->created_at->timezone(config('app.timezone'))->format('Y-m-d h:i A') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.contact.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')" class="m-0 p-0">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <form id="bulkDeleteForm" action="{{ route('admin.contact.bulk-delete') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <p class="text-muted mb-0">No messages yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function(){
            const selectAll = document.getElementById('selectAll');
            const items = document.querySelectorAll('.selectItem');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            const bulkForm = document.getElementById('bulkDeleteForm');
            if (selectAll) {
                selectAll.addEventListener('change', function(){
                    items.forEach(cb => cb.checked = selectAll.checked);
                });
            }
            if (deleteSelectedBtn && bulkForm) {
                deleteSelectedBtn.addEventListener('click', function(){
                    const checked = Array.from(document.querySelectorAll('.selectItem:checked'));
                    if (checked.length === 0) {
                        alert('Please select at least one message.');
                        return;
                    }
                    if (!confirm('Delete selected messages?')) return;
                    // Clear previous hidden inputs
                    bulkForm.querySelectorAll('input[name="ids[]"]').forEach(n => n.remove());
                    // Append selected IDs
                    checked.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.value;
                        bulkForm.appendChild(input);
                    });
                    bulkForm.submit();
                });
            }
        })();
    </script>
</body>
</html>
