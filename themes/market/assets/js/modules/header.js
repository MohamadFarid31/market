/**
 * Market Theme — Sticky Header & Direction-Aware Mobile Search
 *
 * @package Market
 */

export function initHeader() {
  const siteHeader = document.getElementById('masthead');
  if (!siteHeader) return;

  const mobileSearchWrap = siteHeader.querySelector('.header-mobile-search-wrap');
  const mobileSearchInput = mobileSearchWrap ? mobileSearchWrap.querySelector('input[type="search"]') : null;
  const bottomSearchTrigger = document.getElementById('mobile-bottom-search-trigger');

  if (!mobileSearchWrap) return;

  let lastScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
  let ticking = false;
  let isMobileFocused = false;

  if (mobileSearchInput) {
    mobileSearchInput.addEventListener('focus', () => {
      isMobileFocused = true;
      revealMobileSearch();
    });
    mobileSearchInput.addEventListener('blur', () => {
      isMobileFocused = false;
    });
  }

  function revealMobileSearch() {
    mobileSearchWrap.classList.remove('is-hidden');
    mobileSearchWrap.classList.add('is-sticky-shown');
  }

  function hideMobileSearch() {
    if (isMobileFocused) return;
    mobileSearchWrap.classList.remove('is-sticky-shown');
    mobileSearchWrap.classList.add('is-hidden');
  }

  function onScroll() {
    const currentScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
    const deltaY = currentScrollY - lastScrollY;

    // Header shadow on scroll
    if (currentScrollY > 10) {
      siteHeader.classList.add('is-scrolled');
    } else {
      siteHeader.classList.remove('is-scrolled');
    }

    // Only mobile search bar animates (< 1024px)
    if (window.innerWidth < 1024) {
      if (currentScrollY <= 10) {
        // At top of page: always visible
        revealMobileSearch();
      } else if (isMobileFocused) {
        revealMobileSearch();
      } else if (Math.abs(deltaY) >= 3) {
        if (deltaY > 0 && currentScrollY > 50) {
          // Scroll DOWN: Mobile search collapses and hides
          hideMobileSearch();
        } else if (deltaY < -2) {
          // Scroll UP (even slightest): Mobile search smoothly slides down
          revealMobileSearch();
        }
      }
    }

    lastScrollY = currentScrollY;
    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });

  // Mobile bottom bar search trigger
  if (bottomSearchTrigger) {
    bottomSearchTrigger.addEventListener('click', (e) => {
      e.preventDefault();
      revealMobileSearch();
      if (mobileSearchInput) {
        setTimeout(() => mobileSearchInput.focus(), 150);
      }
    });
  }

  window.addEventListener('resize', () => {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });

  // Initial state check
  onScroll();
}
