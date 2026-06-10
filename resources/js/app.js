import './bootstrap';

// ── Navbar scroll effect ──────────────────────────────
const nav = document.querySelector('.harfa-nav');
if (nav) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            nav.style.boxShadow = '0 4px 24px rgba(0,0,0,.10)';
        } else {
            nav.style.boxShadow = '0 1px 0 rgba(0,0,0,.04)';
        }
    }, { passive: true });
}

// ── Flash message auto-dismiss ────────────────────────
document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => {
        el.style.transition = 'opacity .4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    }, 4000);
});

// ── Confirm delete forms ──────────────────────────────
document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => {
        if (!confirm(btn.dataset.confirm)) e.preventDefault();
    });
});
