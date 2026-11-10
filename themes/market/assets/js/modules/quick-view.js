/**
 * Market Theme — Taj Bazar Style Quick View Modal Module
 */

export function initQuickView() {
  const modal = document.getElementById('quick-view-modal');
  const overlay = document.getElementById('quick-view-overlay');
  const content = document.getElementById('quick-view-content');
  const closeBtn = document.getElementById('quick-view-close-btn');

  if (!modal || !overlay || !content) return;

  function openModal() {
    modal.classList.add('is-open');
    overlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('is-open');
    overlay.classList.remove('is-active');
    document.body.style.overflow = '';
  }

  function showLoading() {
    content.innerHTML = `
      <div class="qv-loading-placeholder">
        <div class="qv-details-col">
          <div class="qv-skel-line qv-skel-title"></div>
          <div class="qv-skel-line" style="width: 50%;"></div>
          <div class="qv-skel-line" style="width: 30%;"></div>
          <div class="qv-skel-line qv-skel-price"></div>
          <div class="qv-skel-line" style="width: 90%;"></div>
          <div class="qv-skel-line" style="width: 80%;"></div>
          <div class="qv-skel-line" style="width: 85%;"></div>
          <div class="qv-skel-line" style="width: 60%; height: 38px; margin-top: 15px;"></div>
        </div>
        <div class="qv-skel-box"></div>
      </div>
    `;
  }

  // Delegated event listener for opening Quick View from ANY product card
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.product-quick-view-btn');
    if (!trigger) return;

    e.preventDefault();
    e.stopPropagation();

    const productId = trigger.dataset.productId;
    if (!productId) return;

    openModal();
    showLoading();

    const formData = new FormData();
    formData.append('action', 'market_quick_view');
    formData.append('product_id', productId);
    if (window.marketData && window.marketData.nonce) {
      formData.append('nonce', window.marketData.nonce);
    }

    const ajaxUrl = (window.marketData && window.marketData.ajaxUrl) ? window.marketData.ajaxUrl : '/wp-admin/admin-ajax.php';

    fetch(ajaxUrl, {
      method: 'POST',
      body: formData,
    })
      .then((res) => res.json())
      .then((response) => {
        if (response.success && response.data && response.data.html) {
          content.innerHTML = response.data.html;
          bindModalEvents();
        } else {
          content.innerHTML = `
            <div style="text-align: center; padding: 40px 20px; color: #71717a;">
              <p>${response.data?.message || 'خطا در بارگذاری اطلاعات محصول.'}</p>
            </div>
          `;
        }
      })
      .catch(() => {
        content.innerHTML = `
          <div style="text-align: center; padding: 40px 20px; color: #ef4444;">
            <p>خطا در برقراری ارتباط با سرور. لطفاً مجدداً تلاش کنید.</p>
          </div>
        `;
      });
  });

  // Bind interactive events inside the loaded modal content
  function bindModalEvents() {
    // 1. Gallery Thumbnails switcher
    const mainImg = content.querySelector('#qv-active-img');
    const thumbBtns = content.querySelectorAll('.qv-gallery-thumb-btn');

    thumbBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        const fullSrc = btn.dataset.fullSrc;
        if (!fullSrc || !mainImg) return;

        mainImg.src = fullSrc;
        thumbBtns.forEach((b) => b.classList.remove('is-active'));
        btn.classList.add('is-active');
      });
    });

    // 2. Quantity selector (+ / -)
    const qtyInput = content.querySelector('.qv-qty-input');
    const plusBtn = content.querySelector('.qv-qty-plus');
    const minusBtn = content.querySelector('.qv-qty-minus');

    if (qtyInput && plusBtn && minusBtn) {
      plusBtn.addEventListener('click', () => {
        let val = parseInt(qtyInput.value, 10) || 1;
        if (val < 99) {
          qtyInput.value = val + 1;
        }
      });

      minusBtn.addEventListener('click', () => {
        let val = parseInt(qtyInput.value, 10) || 1;
        if (val > 1) {
          qtyInput.value = val - 1;
        }
      });
    }

    // 3. AJAX Add to Cart inside Quick View
    const addBtn = content.querySelector('.qv-add-to-cart-btn');
    if (addBtn) {
      addBtn.addEventListener('click', () => {
        const productId = addBtn.dataset.productId;
        const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;
        const btnText = addBtn.querySelector('.qv-btn-text');
        const spinner = addBtn.querySelector('.qv-btn-spinner');

        if (addBtn.classList.contains('is-loading')) return;

        addBtn.classList.add('is-loading');
        if (btnText) btnText.style.display = 'none';
        if (spinner) spinner.style.display = 'inline-block';

        const formData = new FormData();
        formData.append('action', 'market_quick_add_to_cart');
        formData.append('product_id', productId);
        formData.append('quantity', qty);
        if (window.marketData && window.marketData.nonce) {
          formData.append('nonce', window.marketData.nonce);
        }

        const ajaxUrl = (window.marketData && window.marketData.ajaxUrl) ? window.marketData.ajaxUrl : '/wp-admin/admin-ajax.php';

        fetch(ajaxUrl, {
          method: 'POST',
          body: formData,
        })
          .then((res) => res.json())
          .then((res) => {
            addBtn.classList.remove('is-loading');
            if (spinner) spinner.style.display = 'none';
            if (btnText) btnText.style.display = 'inline';

            if (res.success) {
              addBtn.classList.add('is-success');
              if (btnText) btnText.textContent = 'به سبد خرید افزوده شد ✓';

              // Update cart count badge in header
              const countBadge = document.getElementById('header-cart-count');
              if (countBadge && res.data && res.data.count) {
                countBadge.textContent = res.data.count;
              }

              // Update mini-cart content
              const miniCart = document.querySelector('.widget_shopping_cart_content');
              if (miniCart && res.data && res.data.mini_cart) {
                miniCart.innerHTML = res.data.mini_cart;
              }

              // Trigger WooCommerce added_to_cart event so cart-drawer opens
              if (window.jQuery) {
                window.jQuery(document.body).trigger('added_to_cart', [[], '', jQuery(addBtn)]);
              } else {
                const drawer = document.getElementById('cart-drawer');
                const cartOverlay = document.getElementById('cart-drawer-overlay');
                if (drawer && cartOverlay) {
                  drawer.classList.add('is-open');
                  cartOverlay.classList.add('is-active');
                }
              }

              setTimeout(() => {
                if (btnText) btnText.textContent = 'افزودن به سبد خرید';
                addBtn.classList.remove('is-success');
              }, 2500);
            } else {
              alert(res.data?.message || 'خطا در افزودن به سبد خرید.');
            }
          })
          .catch(() => {
            addBtn.classList.remove('is-loading');
            if (spinner) spinner.style.display = 'none';
            if (btnText) {
              btnText.style.display = 'inline';
              btnText.textContent = 'خطا در ثبت';
            }
          });
      });
    }
  }

  // Close handlers
  overlay.addEventListener('click', closeModal);
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('is-open')) {
      closeModal();
    }
  });
}
