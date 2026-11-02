/**
 * Market Theme — Slide-Out Mini Cart Drawer Module
 */

export function initCartDrawer() {
  const triggers = document.querySelectorAll('[data-toggle="cart-drawer"]');
  const drawer = document.getElementById('cart-drawer');
  const overlay = document.getElementById('cart-drawer-overlay');
  const closeBtn = document.querySelector('[data-close="cart-drawer"]');

  if (!drawer || !overlay) return;

  function openCart(e) {
    if (e) e.preventDefault();
    drawer.classList.add('is-open');
    overlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeCart() {
    drawer.classList.remove('is-open');
    overlay.classList.remove('is-active');
    document.body.style.overflow = '';
  }

  triggers.forEach((btn) => btn.addEventListener('click', openCart));
  overlay.addEventListener('click', closeCart);
  if (closeBtn) closeBtn.addEventListener('click', closeCart);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
      closeCart();
    }
  });

  // Listen to WooCommerce added_to_cart trigger
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', () => {
      openCart();
    });
  }
}
