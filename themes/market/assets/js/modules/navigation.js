/**
 * Market Theme — Navigation & Drawer Module
 */

export function initNavigation() {
  const toggleBtn = document.querySelector('[data-toggle="mobile-nav"]');
  const drawer = document.getElementById('mobile-nav-drawer');
  const overlay = document.getElementById('mobile-nav-overlay');
  const closeBtn = document.querySelector('[data-close="mobile-nav"]');

  if (!toggleBtn || !drawer || !overlay) return;

  function openNav() {
    drawer.classList.add('is-open');
    overlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';
    toggleBtn.setAttribute('aria-expanded', 'true');
  }

  function closeNav() {
    drawer.classList.remove('is-open');
    overlay.classList.remove('is-active');
    document.body.style.overflow = '';
    toggleBtn.setAttribute('aria-expanded', 'false');
  }

  toggleBtn.addEventListener('click', openNav);
  overlay.addEventListener('click', closeNav);
  if (closeBtn) closeBtn.addEventListener('click', closeNav);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
      closeNav();
    }
  });
}
