<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My To-Do App</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon-512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>
<body>
<div class="container">
    <h1>✨ My To-Do List</h1>
    <p class="sub">Everything you need to do today,all in one place.</p>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content confirm-modal">
            <div class="modal-body text-center">
                <div class="confirm-icon">🗑️</div>
                <h5 class="confirm-title">Delete this task?</h5>
                <p class="confirm-text">
                    "<strong id="deleteTaskName"></strong>" will be permanently deleted. This action cannot be undone.
                </p>
                <form id="deleteForm" method="POST" class="d-flex gap-2 justify-content-center">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-edit" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-del">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        document.getElementById('deleteForm').action = btn.dataset.action;
        document.getElementById('deleteTaskName').textContent = btn.dataset.name;
    });
</script>
</body>
</html>