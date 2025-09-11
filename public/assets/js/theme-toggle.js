document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-toggle-icon');
    const body = document.body;

    // Helper: set icon
    function setIcon(isDark) {
        themeIcon.textContent = isDark ? '🌙' : '☀️';
    }

    // Initial state
    const isDarkStored = localStorage.getItem('theme') === 'dark';
    if (isDarkStored) {
        body.classList.add('dark-mode');
    }
    setIcon(isDarkStored);

    if (themeToggle) {
        themeToggle.addEventListener('click', function (e) {
            try {
                // Prevent any default click behavior or bubbling to links
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            const isDarkNow = body.classList.contains('dark-mode');
            const willBeDark = !isDarkNow;

            // Toggle theme immediately
            body.classList.toggle('dark-mode');
            localStorage.setItem('theme', willBeDark ? 'dark' : 'light');

            // Set icon immediately
            setIcon(willBeDark);

            // Animate icon (optional)
            themeIcon.classList.add('spin');
            setTimeout(() => {
                themeIcon.classList.remove('spin');
            }, 300); // match your spin animation duration
            } catch (err) {
                // Fail silently so the page never hangs
                console.error('Theme toggle failed', err);
            }
        });
    }

    // Always add animation class (if needed)
    themeIcon.classList.add('theme-toggle-animate');
});
