document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-toggle-icon');
    const body = document.body;

    // Helper: set icon
    function setIcon(isDark) {
        if (isDark) {
            themeIcon.textContent = '🌙';
        } else {
            themeIcon.textContent = '☀️';
        }
    }

    // Initial state
    const isDark = localStorage.getItem('theme') === 'dark';
    if (isDark) {
        body.classList.add('dark-mode');
    }
    setIcon(isDark);

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const willBeDark = !body.classList.contains('dark-mode');
            body.classList.toggle('dark-mode');
            localStorage.setItem('theme', willBeDark ? 'dark' : 'light');

            // Animate icon
            themeIcon.classList.add('spin');
            setTimeout(() => {
                setIcon(willBeDark);
                themeIcon.classList.remove('spin');
            }, 100); // icon changes mid-spin
        });
    }
    // Add animation class always
    themeIcon.classList.add('theme-toggle-animate');
}); 