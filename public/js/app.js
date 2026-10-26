/**
 * Neobrutalist Portfolio Main Menu — Vanilla JS Interactions
 */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile navigation drawer toggle
    const navToggle = document.querySelector('[data-nav-toggle]');
    const navLinks = document.querySelector('[data-nav-links]');

    if (navToggle && navLinks) {
        navToggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.toggle('is-open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            navToggle.textContent = isOpen ? '[CLOSE X]' : '[MENU =]';
        });
    }

    // 2. Dismiss flash toast banners
    document.querySelectorAll('[data-toast-close]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const toast = btn.closest('.brutal-toast');
            if (toast) toast.remove();
        });
    });

    // 3. Make interactive Bento tiles with data-href clickable
    document.querySelectorAll('[data-href]').forEach((card) => {
        card.addEventListener('click', (event) => {
            if (event.target.closest('a, button, input, textarea, select')) {
                return;
            }
            const targetUrl = card.getAttribute('data-href');
            if (targetUrl) {
                window.location.href = targetUrl;
            }
        });
    });

    // 4. Main Menu Keyboard Shortcuts (Press 1 = About, 2 = Projects, 3 = Contact, H = Home)
    document.addEventListener('keydown', (event) => {
        const tag = (event.target.tagName || '').toLowerCase();
        if (['input', 'textarea', 'select'].includes(tag) || event.metaKey || event.ctrlKey || event.altKey) {
            return;
        }

        const routes = {
            '1': '/about',
            '2': '/projects',
            '3': '/contact',
            'h': '/',
            '0': '/',
        };

        const key = event.key.toLowerCase();
        if (routes[key]) {
            window.location.href = routes[key];
        }
    });
});

