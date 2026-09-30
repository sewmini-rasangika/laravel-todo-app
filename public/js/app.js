function toggleDetails(e, row) {
        
        if (e.target.closest('a, button, form')) return;

        const item = row.parentElement;
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.task-item.open').forEach(i => i.classList.remove('open'));
        if (!wasOpen) item.classList.add('open');
    }
