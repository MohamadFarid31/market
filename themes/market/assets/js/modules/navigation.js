/**
 * Market Theme — Navigation, Digikala Mega Menu & Mobile Drawer Module
 *
 * @package Market
 */

export function initNavigation() {
  initMobileDrawer();
  initMegaMenu();
  initMobileAccordion();
  initStickyHeaderAndSearch();
}

/**
 * ۱. مدیریت باز و بسته شدن کشوی منوی موبایل
 */
function initMobileDrawer() {
  const toggleBtns = document.querySelectorAll('[data-toggle="mobile-nav"]');
  const drawer = document.getElementById('mobile-nav-drawer');
  const overlay = document.getElementById('mobile-nav-overlay');
  const closeBtns = document.querySelectorAll('[data-close="mobile-nav"]');

  if (!drawer || !overlay) return;

  function openNav() {
    drawer.classList.add('is-open');
    overlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';
    toggleBtns.forEach((btn) => btn.setAttribute('aria-expanded', 'true'));
  }

  function closeNav() {
    drawer.classList.remove('is-open');
    overlay.classList.remove('is-active');
    document.body.style.overflow = '';
    toggleBtns.forEach((btn) => btn.setAttribute('aria-expanded', 'false'));
  }

  toggleBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openNav();
    });
  });

  overlay.addEventListener('click', closeNav);
  closeBtns.forEach((btn) => btn.addEventListener('click', closeNav));

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
      closeNav();
    }
  });
}

/**
 * ۲. مدیریت تعاملی مگامنوی سبک دیجی‌کالا (دسکتاپ)
 */
function initMegaMenu() {
  const megaWrap = document.getElementById('header-mega-menu-wrap');
  const megaBtn = document.getElementById('mega-menu-btn');
  const catItems = document.querySelectorAll('.mega-menu-cat-item');
  const panels = document.querySelectorAll('.mega-menu-panel');

  if (megaWrap && megaBtn) {
    megaBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = megaWrap.classList.toggle('is-open');
      megaBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', (e) => {
      if (!megaWrap.contains(e.target)) {
        megaWrap.classList.remove('is-open');
        megaBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // تغییر فوری محتوای ستون چپ با حرکت ماوس روی دسته‌های ستون راست (کاملاً مشابه دیجی‌کالا)
  if (catItems.length && panels.length) {
    catItems.forEach((item) => {
      item.addEventListener('mouseenter', () => {
        const catId = item.getAttribute('data-cat-id');
        if (!catId) return;

        // غیرفعال کردن سایر دسته‌ها
        catItems.forEach((el) => {
          el.classList.remove('is-active');
          el.setAttribute('aria-selected', 'false');
        });
        item.classList.add('is-active');
        item.setAttribute('aria-selected', 'true');

        // مخفی‌سازی تمام پنل‌ها و نمایش پنل متناظر
        panels.forEach((panel) => {
          panel.classList.remove('is-active');
        });

        const targetPanel = document.getElementById(`mega-panel-${catId}`);
        if (targetPanel) {
          targetPanel.classList.add('is-active');
        }
      });
    });
  }
}

/**
 * ۳. مدیریت دکمه‌های آکاردئونی آبشاری چندسطحی در کشوی موبایل
 */
function initMobileAccordion() {
  const drawer = document.getElementById('mobile-nav-drawer');
  if (!drawer) return;

  // الف) تاگل بخش اصلی دسته‌بندی‌ها (Root Category Accordion)
  const rootToggles = drawer.querySelectorAll('.mobile-cat-root-toggle');
  rootToggles.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const parentItem = btn.closest('.mobile-categories-accordion-item');
      if (!parentItem) return;

      const isExpanded = parentItem.classList.toggle('is-expanded');
      btn.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');

      const content = parentItem.querySelector(':scope > .mobile-accordion-content');
      if (content) {
        content.classList.toggle('is-open', isExpanded);
      }
    });
  });

  // ب) تاگل زیردسته‌های چندسطحی کالاها
  const catParentItems = drawer.querySelectorAll('.mobile-cat-has-children');
  catParentItems.forEach((li) => {
    const toggleBtn = li.querySelector(':scope > .mobile-nav-item-inner > .mobile-submenu-toggle');
    const titleLink = li.querySelector(':scope > .mobile-nav-item-inner > .mobile-subcat-title-link');
    const content = li.querySelector(':scope > .mobile-accordion-content');

    function toggleSubmenu(e) {
      if (e) {
        e.preventDefault();
        e.stopPropagation();
      }
      const isExpanded = li.classList.toggle('is-expanded');
      if (toggleBtn) {
        toggleBtn.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
      }
      if (content) {
        content.classList.toggle('is-open', isExpanded);
      }
    }

    if (toggleBtn) {
      toggleBtn.addEventListener('click', toggleSubmenu);
    }

    // اگر روی عنوان دسته دارای زیردسته هم کلیک شد، زیردسته‌ها به شکل آبشاری باز/بسته شوند
    if (titleLink) {
      titleLink.addEventListener('click', toggleSubmenu);
    }
  });

  // ج) پشتیبانی از منوهای استاندارد سفارشی وردپرس (در صورت تعریف منوی جانبی در wp-admin)
  const wpParentItems = drawer.querySelectorAll('.mobile-custom-nav-list li.menu-item-has-children');
  wpParentItems.forEach((li) => {
    if (li.dataset.accordionInit === 'true') return;
    li.dataset.accordionInit = 'true';

    const link = li.querySelector(':scope > a');
    const subMenu = li.querySelector(':scope > .sub-menu');
    if (!link || !subMenu) return;

    // بسته‌بندی در کانتینر ردیف
    const wrapper = document.createElement('div');
    wrapper.className = 'mobile-nav-item-inner';
    li.insertBefore(wrapper, link);
    wrapper.appendChild(link);

    // دکمه تاگل با آیکون فلش آبشاری
    const toggleBtn = document.createElement('button');
    toggleBtn.type = 'button';
    toggleBtn.className = 'mobile-submenu-toggle';
    toggleBtn.setAttribute('aria-label', 'باز یا بسته کردن زیرمنو');
    toggleBtn.setAttribute('aria-expanded', 'false');
    toggleBtn.innerHTML = `
      <svg class="mobile-arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 12 15 18 9"></polyline>
      </svg>
    `;
    wrapper.appendChild(toggleBtn);

    // بسته‌بندی sub-menu در ساختار انیمیشنی CSS Grid
    const accordionContent = document.createElement('div');
    accordionContent.className = 'mobile-accordion-content';
    const accordionInner = document.createElement('div');
    accordionInner.className = 'mobile-accordion-inner';

    li.insertBefore(accordionContent, subMenu);
    accordionInner.appendChild(subMenu);
    accordionContent.appendChild(accordionInner);

    function toggleWpSubmenu(e) {
      e.preventDefault();
      e.stopPropagation();
      const isExpanded = li.classList.toggle('is-expanded');
      toggleBtn.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
      accordionContent.classList.toggle('is-open', isExpanded);
    }

    toggleBtn.addEventListener('click', toggleWpSubmenu);
    link.addEventListener('click', toggleWpSubmenu);
  });
}

/**
 * ۴. مدیریت هدر چسبان و جستجوی هوشمند استیکی با اسکرول بالا/پایین
 * هدر اصلی در بالای صفحه فیکس می‌ماند؛
 * فیلد جستجوی موبایل هنگام اسکرول رو به پایین، همزمان با اسکرول بالا رفته و پنهان می‌شود؛
 * و با کوچک‌ترین اسکرول رو به بالا، از بالا به پایین انیمیت شده و نمایش داده می‌شود.
 */
function initStickyHeaderAndSearch() {
  const siteHeader = document.getElementById('masthead');
  if (!siteHeader) return;

  const headerMain = siteHeader.querySelector('.header-main');
  const searchWrap = siteHeader.querySelector('.header-mobile-search-wrap');
  const searchInput = searchWrap ? searchWrap.querySelector('input[type="search"]') : null;
  const bottomSearchTrigger = document.getElementById('mobile-bottom-search-trigger');

  if (!headerMain || !searchWrap) return;

  let lastScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
  let ticking = false;
  let isInputFocused = false;

  if (searchInput) {
    searchInput.addEventListener('focus', () => {
      isInputFocused = true;
      revealSearch();
    });
    searchInput.addEventListener('blur', () => {
      isInputFocused = false;
    });
  }

  function getSearchHeight() {
    return searchWrap.offsetHeight || 52;
  }

  function revealSearch() {
    searchWrap.classList.add('is-transitioning');
    searchWrap.classList.remove('is-hidden');
    searchWrap.classList.add('is-sticky-shown');
    searchWrap.style.transform = '';
    siteHeader.classList.add('has-search-shown');
  }

  function hideSearch() {
    if (isInputFocused) return;
    searchWrap.classList.add('is-transitioning');
    searchWrap.classList.remove('is-sticky-shown');
    searchWrap.classList.add('is-hidden');
    searchWrap.style.transform = '';
    siteHeader.classList.remove('has-search-shown');
  }

  function onScroll() {
    const currentScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
    const searchHeight = getSearchHeight();

    // فعال‌سازی سایه ملایم هدر در اسکرول
    if (currentScrollY > 10) {
      siteHeader.classList.add('is-scrolled');
    } else {
      siteHeader.classList.remove('is-scrolled');
    }

    // در ابعاد دسکتاپ (۱۰۲۴ به بالا) جستجو داخل ردیف اصلی قرار دارد
    if (window.innerWidth >= 1024) {
      searchWrap.classList.remove('is-transitioning', 'is-hidden', 'is-sticky-shown');
      searchWrap.style.transform = '';
      siteHeader.classList.remove('has-search-shown');
      lastScrollY = currentScrollY;
      ticking = false;
      return;
    }

    if (isInputFocused) {
      revealSearch();
      lastScrollY = currentScrollY;
      ticking = false;
      return;
    }

    const deltaY = currentScrollY - lastScrollY;

    // ۱. اگر در بالاترین نقطه صفحه هستیم
    if (currentScrollY <= 0) {
      searchWrap.classList.remove('is-transitioning', 'is-hidden', 'is-sticky-shown');
      searchWrap.style.transform = 'translateY(0px)';
      siteHeader.classList.remove('has-search-shown');
    }
    // ۲. اسکرول به سمت پایین
    else if (deltaY > 0) {
      // الف) در ابتدای صفحه (فاصله کمتر از ارتفاع فیلد جستجو): حرکت همزمان با اسکرول
      if (currentScrollY <= searchHeight) {
        searchWrap.classList.remove('is-transitioning', 'is-sticky-shown', 'is-hidden');
        searchWrap.style.transform = `translateY(${-currentScrollY}px)`;
        siteHeader.classList.remove('has-search-shown');
      } else if (deltaY >= 3) {
        // ب) در ادامه اسکرول رو به پایین، جستجو به نرمی به بالا رفته و پنهان می‌شود
        hideSearch();
      }
    }
    // ۳. کوچک‌ترین اسکرول به سمت بالا
    else if (deltaY < -2) {
      // جستجو به نرمی از بالا پایین آمده و نمایش داده می‌شود
      revealSearch();
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

  // کلیک روی دکمه جستجو در نوار چسبان پایین موبایل
  if (bottomSearchTrigger) {
    bottomSearchTrigger.addEventListener('click', (e) => {
      e.preventDefault();
      revealSearch();
      if (searchInput) {
        setTimeout(() => searchInput.focus(), 150);
      }
    });
  }

  // به‌روزرسانی در تغییر اندازه یا چرخش موبایل
  window.addEventListener('resize', () => {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });

  // اجرای اولیه برای هماهنگی وضعیت در لود یا رفرش صفحه
  onScroll();
}
