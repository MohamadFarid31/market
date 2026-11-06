/**
 * Market Theme — Wishlist Core Module (Taj Bazar Style)
 *
 * Handles client-side persistence (localStorage), DOM syncing of heart buttons across the store,
 * header count badges, floating toast feedback, and full /wishlist/ page interactivity.
 *
 * @package Market
 */

const STORAGE_KEY = 'market_wishlist_product_ids';

/**
 * Converts English digits to Persian digits.
 */
export function toPersianDigits(num) {
  const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  return String(num).replace(/[0-9]/g, (w) => persianDigits[+w]);
}

/**
 * Reads list of product IDs from localStorage.
 * @returns {number[]}
 */
export function getWishlistIds() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) return [];
    const parsed = JSON.parse(raw);
    if (Array.isArray(parsed)) {
      return parsed.map((id) => parseInt(id, 10)).filter((id) => !isNaN(id) && id > 0);
    }
  } catch (err) {
    console.warn('Market Wishlist: Error reading from localStorage', err);
  }
  return [];
}

/**
 * Saves product IDs to localStorage and triggers UI updates.
 * @param {number[]} ids
 */
export function saveWishlistIds(ids) {
  const clean = Array.from(new Set(ids.map((id) => parseInt(id, 10)).filter((id) => !isNaN(id) && id > 0)));
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(clean));
  } catch (err) {
    console.warn('Market Wishlist: Error saving to localStorage', err);
  }

  updateHeaderWishlistCount(clean.length);
  updateWishlistButtons(clean);
  window.dispatchEvent(new CustomEvent('market:wishlist-updated', { detail: { count: clean.length, ids: clean } }));
}

/**
 * Updates the header counter badge.
 * @param {number} count
 */
export function updateHeaderWishlistCount(count) {
  const badges = document.querySelectorAll('#header-wishlist-count, .wishlist-count-badge');
  badges.forEach((badge) => {
    if (count > 0) {
      badge.textContent = toPersianDigits(count);
      badge.style.display = 'inline-flex';
    } else {
      badge.textContent = '۰';
      badge.style.display = 'none';
    }
  });
}

/**
 * Updates all heart icons across current DOM (cards, single product buybox, etc.).
 * @param {number[]} currentIds
 */
export function updateWishlistButtons(currentIds = null) {
  const ids = currentIds || getWishlistIds();
  const idSet = new Set(ids);

  const buttons = document.querySelectorAll('.product-wishlist-btn');
  buttons.forEach((btn) => {
    const pid = parseInt(btn.getAttribute('data-product-id'), 10);
    if (isNaN(pid)) return;

    if (idSet.has(pid)) {
      btn.classList.add('is-active');
      btn.setAttribute('aria-label', 'حذف از علاقه‌مندی‌ها');
      btn.setAttribute('title', 'حذف از علاقه‌مندی‌ها');
    } else {
      btn.classList.remove('is-active');
      btn.setAttribute('aria-label', 'افزودن به علاقه‌مندی‌ها');
      btn.setAttribute('title', 'افزودن به علاقه‌مندی‌ها');
    }
  });
}

/**
 * Displays an elegant floating toast notification.
 * @param {string} message
 * @param {'add'|'remove'|'info'} type
 */
export function showToast(message, type = 'add') {
  let container = document.getElementById('market-toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'market-toast-container';
    container.className = 'market-toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'market-toast';

  const iconWrap = document.createElement('span');
  iconWrap.className = `market-toast-icon ${type === 'add' ? 'icon-add' : 'icon-remove'}`;

  if (type === 'add') {
    iconWrap.innerHTML = `
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
      </svg>
    `;
  } else {
    iconWrap.innerHTML = `
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
      </svg>
    `;
  }

  const textNode = document.createElement('span');
  textNode.textContent = message;

  toast.appendChild(iconWrap);
  toast.appendChild(textNode);
  container.appendChild(toast);

  setTimeout(() => {
    toast.classList.add('is-hiding');
    setTimeout(() => {
      toast.remove();
      if (container.children.length === 0) {
        container.remove();
      }
    }, 260);
  }, 2600);
}

/**
 * Toggles a product in the wishlist.
 * @param {number} productId
 * @param {HTMLElement|null} triggerBtn
 */
export function toggleWishlist(productId, triggerBtn = null) {
  const pid = parseInt(productId, 10);
  if (isNaN(pid) || pid <= 0) return;

  const currentIds = getWishlistIds();
  const exists = currentIds.includes(pid);
  let nextIds = [];

  if (exists) {
    nextIds = currentIds.filter((id) => id !== pid);
    showToast('محصول از لیست علاقه‌مندی‌ها حذف شد.', 'remove');
  } else {
    nextIds = [...currentIds, pid];
    showToast('محصول به لیست علاقه‌مندی‌ها افزوده شد.', 'add');
  }

  saveWishlistIds(nextIds);

  // Background AJAX call to sync with WordPress if logged-in
  if (window.marketData && window.marketData.ajaxUrl && window.marketData.nonce) {
    const formData = new FormData();
    formData.append('action', 'market_toggle_wishlist');
    formData.append('nonce', window.marketData.nonce);
    formData.append('product_id', pid);
    formData.append('current_state', exists ? 'true' : 'false');

    fetch(window.marketData.ajaxUrl, {
      method: 'POST',
      body: formData,
    }).catch((e) => console.warn('Wishlist sync error', e));
  }
}

/**
 * Initializes Wishlist page template interactions.
 */
function initWishlistPage() {
  const grid = document.getElementById('wishlist-products-grid');
  const toolbar = document.getElementById('wishlist-toolbar');
  const emptyState = document.getElementById('wishlist-empty-state');
  const skeleton = document.getElementById('wishlist-skeleton-state');
  const countNum = document.getElementById('wishlist-items-count');
  const clearBtn = document.getElementById('wishlist-clear-all-btn');

  if (!grid || !emptyState) return;

  const storedIds = getWishlistIds();
  const serverRenderedCards = grid.querySelectorAll('.wishlist-card');

  // Check if we need to load cards via AJAX for guests or localStorage sync
  if (serverRenderedCards.length === 0 && storedIds.length > 0) {
    if (skeleton) skeleton.classList.remove('is-hidden');
    emptyState.classList.add('is-hidden');
    if (toolbar) toolbar.classList.add('is-hidden');

    const formData = new FormData();
    formData.append('action', 'market_get_wishlist_cards');
    formData.append('nonce', window.marketData?.nonce || '');
    storedIds.forEach((id) => formData.append('product_ids[]', id));

    fetch(window.marketData.ajaxUrl, {
      method: 'POST',
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (skeleton) skeleton.classList.add('is-hidden');

        if (data.success && data.data && data.data.count > 0 && data.data.html) {
          grid.innerHTML = data.data.html;
          grid.classList.remove('is-hidden');
          if (toolbar) toolbar.classList.remove('is-hidden');
          emptyState.classList.add('is-hidden');
          if (countNum) countNum.textContent = toPersianDigits(data.data.count);
        } else {
          // If none returned
          grid.classList.add('is-hidden');
          if (toolbar) toolbar.classList.add('is-hidden');
          emptyState.classList.remove('is-hidden');
          saveWishlistIds([]);
        }
      })
      .catch((err) => {
        console.error('Error fetching wishlist cards:', err);
        if (skeleton) skeleton.classList.add('is-hidden');
        emptyState.classList.remove('is-hidden');
      });
  } else if (serverRenderedCards.length === 0 && storedIds.length === 0) {
    // Both server & client empty
    grid.classList.add('is-hidden');
    if (toolbar) toolbar.classList.add('is-hidden');
    emptyState.classList.remove('is-hidden');
  } else if (serverRenderedCards.length > 0) {
    // Synchronize localStorage with server rendered IDs
    const renderedIds = Array.from(serverRenderedCards)
      .map((card) => parseInt(card.getAttribute('data-product-id'), 10))
      .filter((id) => !isNaN(id) && id > 0);
    saveWishlistIds(renderedIds);
    if (countNum) countNum.textContent = toPersianDigits(renderedIds.length);
  }

  // Handle single card removal
  grid.addEventListener('click', (e) => {
    const removeBtn = e.target.closest('.wishlist-card-remove-btn');
    if (!removeBtn) return;

    e.preventDefault();
    const pid = parseInt(removeBtn.getAttribute('data-product-id'), 10);
    const card = removeBtn.closest('.wishlist-card');
    if (!card || isNaN(pid)) return;

    // Animate removal
    card.classList.add('is-removing');

    setTimeout(() => {
      card.remove();

      const remainingIds = getWishlistIds().filter((id) => id !== pid);
      saveWishlistIds(remainingIds);

      // Update count in toolbar
      if (countNum) {
        countNum.textContent = toPersianDigits(remainingIds.length);
      }

      showToast('محصول از لیست علاقه‌مندی‌ها حذف شد.', 'remove');

      // Sync backend
      if (window.marketData && window.marketData.ajaxUrl && window.marketData.nonce) {
        const formData = new FormData();
        formData.append('action', 'market_toggle_wishlist');
        formData.append('nonce', window.marketData.nonce);
        formData.append('product_id', pid);
        formData.append('current_state', 'true');
        fetch(window.marketData.ajaxUrl, { method: 'POST', body: formData }).catch(() => {});
      }

      // Check if grid is now empty
      const remainingCards = grid.querySelectorAll('.wishlist-card');
      if (remainingCards.length === 0) {
        grid.classList.add('is-hidden');
        if (toolbar) toolbar.classList.add('is-hidden');
        emptyState.classList.remove('is-hidden');
      }
    }, 280);
  });

  // Handle Clear All button
  if (clearBtn) {
    clearBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const allCards = grid.querySelectorAll('.wishlist-card');
      allCards.forEach((c) => c.classList.add('is-removing'));

      setTimeout(() => {
        grid.innerHTML = '';
        grid.classList.add('is-hidden');
        if (toolbar) toolbar.classList.add('is-hidden');
        emptyState.classList.remove('is-hidden');
        saveWishlistIds([]);
        showToast('تمام کالاها از لیست علاقه‌مندی‌ها حذف شدند.', 'remove');

        if (window.marketData && window.marketData.ajaxUrl && window.marketData.nonce) {
          const formData = new FormData();
          formData.append('action', 'market_clear_wishlist');
          formData.append('nonce', window.marketData.nonce);
          fetch(window.marketData.ajaxUrl, { method: 'POST', body: formData }).catch(() => {});
        }
      }, 280);
    });
  }
}

/**
 * Main initialization entry point.
 */
export function initWishlist() {
  const currentIds = getWishlistIds();
  updateHeaderWishlistCount(currentIds.length);
  updateWishlistButtons(currentIds);

  // Global delegation for all product wishlist heart buttons
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.product-wishlist-btn');
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();

    const pid = parseInt(btn.getAttribute('data-product-id'), 10);
    if (!isNaN(pid)) {
      toggleWishlist(pid, btn);
    }
  });

  // Check if current page is the wishlist page
  initWishlistPage();
}

