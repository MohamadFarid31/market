/**
 * Market Theme — Sticky Header & Direction-Aware Mobile Search
 *
 * @package Market
 */

export function initHeader() {
  const siteHeader = document.getElementById('masthead');
  if (!siteHeader) return;

  const mobileSearchWrap = document.querySelector('.header-mobile-search-wrap');
  const mobileSearchInput = mobileSearchWrap ? mobileSearchWrap.querySelector('input[type="search"]') : null;
  const bottomSearchTrigger = document.getElementById('mobile-bottom-search-trigger');

  const HIDE_AFTER_Y = 70;
  const DOWN_THRESHOLD = 16;
  const UP_THRESHOLD = 8;

  let lastScrollY = getScrollY();
  let scrollAnchorY = lastScrollY;
  let lastDirection = 0; // 1 = down, -1 = up, 0 = neutral
  let ticking = false;
  let isMobileFocused = false;
  let isHidden = false;

  function getScrollY() {
    const raw = window.pageYOffset || document.documentElement.scrollTop || 0;
    const maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
    return Math.min(Math.max(0, raw), maxScroll);
  }

  function syncStickyOffset() {
    if (!mobileSearchWrap) return;
    mobileSearchWrap.style.setProperty('--mobile-header-height', `${siteHeader.offsetHeight}px`);
  }

  function showMobileSearch() {
    if (!mobileSearchWrap || !isHidden) return;
    isHidden = false;
    mobileSearchWrap.classList.remove('is-hidden');
  }

  function hideMobileSearch() {
    if (!mobileSearchWrap || isHidden || isMobileFocused) return;
    isHidden = true;
    mobileSearchWrap.classList.add('is-hidden');
  }

  if (mobileSearchInput) {
    mobileSearchInput.addEventListener('focus', () => {
      isMobileFocused = true;
      showMobileSearch();
    });
    mobileSearchInput.addEventListener('blur', () => {
      isMobileFocused = false;
      scrollAnchorY = getScrollY();
    });
  }

  function update() {
    const currentScrollY = getScrollY();

    siteHeader.classList.toggle('is-scrolled', currentScrollY > 10);

    if (mobileSearchWrap) {
      if (window.innerWidth >= 1024 || currentScrollY <= HIDE_AFTER_Y || isMobileFocused) {
        showMobileSearch();
        scrollAnchorY = currentScrollY;
        lastDirection = 0;
      } else {
        const step = currentScrollY - lastScrollY;
        if (step > 0) {
          if (lastDirection !== 1) {
            lastDirection = 1;
            scrollAnchorY = lastScrollY;
          }
          if (currentScrollY - scrollAnchorY >= DOWN_THRESHOLD) {
            hideMobileSearch();
            scrollAnchorY = currentScrollY;
          }
        } else if (step < 0) {
          if (lastDirection !== -1) {
            lastDirection = -1;
            scrollAnchorY = lastScrollY;
          }
          if (scrollAnchorY - currentScrollY >= UP_THRESHOLD) {
            showMobileSearch();
            scrollAnchorY = currentScrollY;
          }
        }
      }
    }

    lastScrollY = currentScrollY;
    ticking = false;
  }

  function requestUpdate() {
    if (!ticking) {
      window.requestAnimationFrame(update);
      ticking = true;
    }
  }

  window.addEventListener('scroll', requestUpdate, { passive: true });
  window.addEventListener('resize', () => {
    syncStickyOffset();
    requestUpdate();
  }, { passive: true });

  if ('ResizeObserver' in window) {
    new ResizeObserver(syncStickyOffset).observe(siteHeader);
  }

  if (bottomSearchTrigger) {
    bottomSearchTrigger.addEventListener('click', (e) => {
      e.preventDefault();
      showMobileSearch();
      if (mobileSearchInput) {
        setTimeout(() => {
          mobileSearchInput.focus({ preventScroll: true });
        }, 150);
      }
    });
  }

  syncStickyOffset();
  update();
}
