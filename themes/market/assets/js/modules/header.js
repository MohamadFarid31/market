/**
 * Market Theme — Sticky Header & Direction-Aware Smart Search
 *
 * @package Market
 */

export function initHeader() {
  const siteHeader = document.getElementById('masthead');
  if (!siteHeader) return;

  const headerMain = siteHeader.querySelector('.header-main');
  const desktopSearch = siteHeader.querySelector('.header-search');
  const mobileSearchWrap = siteHeader.querySelector('.header-mobile-search-wrap');
  const mobileSearchInput = mobileSearchWrap ? mobileSearchWrap.querySelector('input[type="search"]') : null;
  const desktopSearchInput = desktopSearch ? desktopSearch.querySelector('input[type="search"]') : null;
  const bottomSearchTrigger = document.getElementById('mobile-bottom-search-trigger');

  let lastScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
  let ticking = false;
  let isMobileFocused = false;
  let isDesktopFocused = false;

  if (mobileSearchInput) {
    mobileSearchInput.addEventListener('focus', () => {
      isMobileFocused = true;
      revealMobileSearch();
    });
    mobileSearchInput.addEventListener('blur', () => {
      isMobileFocused = false;
    });
  }

  if (desktopSearchInput) {
    desktopSearchInput.addEventListener('focus', () => {
      isDesktopFocused = true;
      revealDesktopSearch();
    });
    desktopSearchInput.addEventListener('blur', () => {
      isDesktopFocused = false;
    });
  }

  function getMobileSearchHeight() {
    return mobileSearchWrap ? (mobileSearchWrap.offsetHeight || 52) : 52;
  }

  // --- Mobile Search State Helpers ---
  function revealMobileSearch() {
    if (!mobileSearchWrap) return;
    mobileSearchWrap.classList.add('is-transitioning');
    mobileSearchWrap.classList.remove('is-hidden');
    mobileSearchWrap.classList.add('is-sticky-shown');
    mobileSearchWrap.style.transform = '';
    siteHeader.classList.add('has-search-shown');
  }

  function hideMobileSearch() {
    if (!mobileSearchWrap || isMobileFocused) return;
    mobileSearchWrap.classList.add('is-transitioning');
    mobileSearchWrap.classList.remove('is-sticky-shown');
    mobileSearchWrap.classList.add('is-hidden');
    mobileSearchWrap.style.transform = '';
    siteHeader.classList.remove('has-search-shown');
  }

  // --- Desktop Search State Helpers ---
  function revealDesktopSearch() {
    if (!desktopSearch) return;
    desktopSearch.classList.add('is-sticky-shown');
    desktopSearch.classList.remove('is-hidden');
  }

  function hideDesktopSearch() {
    if (!desktopSearch || isDesktopFocused) return;
    desktopSearch.classList.add('is-hidden');
    desktopSearch.classList.remove('is-sticky-shown');
  }

  function onScroll() {
    const currentScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
    const isDesktop = window.innerWidth >= 1024;
    const deltaY = currentScrollY - lastScrollY;

    // Header shadow on scroll
    if (currentScrollY > 10) {
      siteHeader.classList.add('is-scrolled');
      if (headerMain) headerMain.classList.add('is-scrolled');
    } else {
      siteHeader.classList.remove('is-scrolled');
      if (headerMain) headerMain.classList.remove('is-scrolled');
    }

    if (isDesktop) {
      // ===== DESKTOP SEARCH LOGIC (.header-search) =====
      if (desktopSearch) {
        if (currentScrollY <= 40) {
          // At top of page: resting position
          desktopSearch.classList.remove('is-hidden', 'is-sticky-shown');
        } else if (isDesktopFocused) {
          revealDesktopSearch();
        } else if (Math.abs(deltaY) >= 3) {
          if (deltaY > 0) {
            // Scroll DOWN: Desktop search slides up and hides
            hideDesktopSearch();
          } else {
            // Scroll UP: Desktop search slides down into header and displays
            revealDesktopSearch();
          }
        }
      }
    } else {
      // ===== MOBILE SEARCH LOGIC (.header-mobile-search-wrap) =====
      if (mobileSearchWrap) {
        const mobileSearchHeight = getMobileSearchHeight();

        if (currentScrollY <= 0) {
          // At top of page: resting position
          mobileSearchWrap.classList.remove('is-transitioning', 'is-hidden', 'is-sticky-shown');
          mobileSearchWrap.style.transform = 'translateY(0px)';
          siteHeader.classList.remove('has-search-shown');
        } else if (isMobileFocused) {
          revealMobileSearch();
        } else if (deltaY > 0) {
          // Scroll DOWN:
          if (currentScrollY <= mobileSearchHeight) {
            // Initial scroll: moves up simultaneously with scroll
            mobileSearchWrap.classList.remove('is-transitioning', 'is-sticky-shown', 'is-hidden');
            mobileSearchWrap.style.transform = `translateY(${-currentScrollY}px)`;
            siteHeader.classList.remove('has-search-shown');
          } else if (deltaY >= 3) {
            // Deeper scroll down: smoothly hidden
            hideMobileSearch();
          }
        } else if (deltaY < -2) {
          // Scroll UP: slides down and displays
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

  // Run on initial load/refresh
  onScroll();
}
