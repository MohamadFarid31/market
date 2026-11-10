/**
 * Market Theme — Navigation, Digikala Mega Menu & Mobile Drawer Module
 *
 * @package Market
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
