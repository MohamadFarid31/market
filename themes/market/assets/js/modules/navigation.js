/**
 * Market Theme — Navigation, Digikala Mega Menu & Drawer Module
 */

export function initNavigation() {
  initMobileDrawer();
  initMegaMenu();
  initMobileAccordion();
}

/**
 * ۱. مدیریت باز و بسته شدن کشوی منوی موبایل
 */
function initMobileDrawer() {
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

/**
 * ۲. مدیریت تعاملی مگامنوی سبک دیجی‌کالا
 */
function initMegaMenu() {
  const megaWrap = document.getElementById('header-mega-menu-wrap');
  const megaBtn = document.getElementById('mega-menu-btn');
  const catItems = document.querySelectorAll('.mega-menu-cat-item');
  const panels = document.querySelectorAll('.mega-menu-panel');

  // دکمه باز/بستن کلیک برای موبایل و تبلت یا کلیک کاربر
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
 * ۳. مدیریت دکمه‌های آکاردئونی زیرمنوها در کشوی موبایل
 */
function initMobileAccordion() {
  const mobileList = document.querySelector('.mobile-nav-list');
  if (!mobileList) return;

  const parentItems = mobileList.querySelectorAll('li.menu-item-has-children');

  parentItems.forEach((li) => {
    // جلوگیری از اضافه شدن دکمه تکراری
    if (li.querySelector('.mobile-submenu-toggle')) return;

    const link = li.querySelector(':scope > a');
    if (!link) return;

    // بسته‌بندی لینک در یک کانتینر برای چینش با دکمه تاگل
    const wrapper = document.createElement('div');
    wrapper.className = 'mobile-nav-item-inner';
    li.insertBefore(wrapper, link);
    wrapper.appendChild(link);

    // افزودن دکمه تاگل
    const toggleBtn = document.createElement('button');
    toggleBtn.type = 'button';
    toggleBtn.className = 'mobile-submenu-toggle';
    toggleBtn.setAttribute('aria-label', 'باز یا بسته کردن زیرمنو');
    toggleBtn.innerHTML = `
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 12 15 18 9"></polyline>
      </svg>
    `;

    wrapper.appendChild(toggleBtn);

    toggleBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      li.classList.toggle('is-expanded');
    });
  });
}
