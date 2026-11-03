/**
 * Market Theme — Single Product Page Interactions
 *
 * Handles stepper (+ / -), tabs, gallery swap, reviews toggle, and mobile sticky bar.
 */

export function initSingleProduct() {
  const container = document.querySelector('.taj-single-product-container');
  if (!container) return;

  initQuantityStepper();
  initProductTabs();
  initGalleryThumbnails();
  initRelatedProductsSlider();
  initReviewFormToggle();
  initMobileStickyBuyButton();
}

/**
 * 1. Quantity Stepper (+ / - buttons)
 * In RTL: prepend(+) renders on the right, append(-) renders on the left => [+  1  -]
 */
function initQuantityStepper() {
  const quantityWrap = document.querySelector('.buybox-cart-form-wrap .quantity');
  if (!quantityWrap) return;

  const qtyInput = quantityWrap.querySelector('input.qty');
  if (!qtyInput) return;

  // Add plus and minus buttons if not already present
  if (!quantityWrap.querySelector('.qty-stepper-btn')) {
    const plusBtn = document.createElement('button');
    plusBtn.type = 'button';
    plusBtn.className = 'qty-stepper-btn qty-plus';
    plusBtn.textContent = '+';
    plusBtn.setAttribute('aria-label', 'افزایش تعداد');

    const minusBtn = document.createElement('button');
    minusBtn.type = 'button';
    minusBtn.className = 'qty-stepper-btn qty-minus';
    minusBtn.textContent = '-';
    minusBtn.setAttribute('aria-label', 'کاهش تعداد');

    quantityWrap.prepend(plusBtn);
    quantityWrap.append(minusBtn);

    plusBtn.addEventListener('click', () => {
      const current = parseInt(qtyInput.value, 10) || 1;
      const max = parseInt(qtyInput.max, 10) || 999;
      if (current < max) {
        qtyInput.value = current + 1;
        qtyInput.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });

    minusBtn.addEventListener('click', () => {
      const current = parseInt(qtyInput.value, 10) || 1;
      const min = parseInt(qtyInput.min, 10) || 1;
      if (current > min) {
        qtyInput.value = current - 1;
        qtyInput.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });
  }
}

/**
 * 2. Product Tabs Switching
 */
function initProductTabs() {
  const tabBtns = document.querySelectorAll('.single-product-tabs-section .tab-pill-btn');
  const panels = document.querySelectorAll('.single-product-tabs-section .product-tab-panel');

  tabBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-tab-target');
      if (!targetId) return;

      tabBtns.forEach((b) => b.classList.remove('active'));
      panels.forEach((p) => p.classList.remove('active'));

      btn.classList.add('active');
      const targetPanel = document.querySelector(targetId);
      if (targetPanel) {
        targetPanel.classList.add('active');
      }
    });
  });
}

/**
 * 3. Gallery Thumbnail Swap
 */
function initGalleryThumbnails() {
  const thumbs = document.querySelectorAll('.product-thumb-item');
  const mainImg = document.getElementById('tajProductMainImage');
  const zoomLink = document.querySelector('.product-image-zoom-btn');

  if (!thumbs.length || !mainImg) return;

  thumbs.forEach((thumb) => {
    thumb.addEventListener('click', () => {
      thumbs.forEach((t) => t.classList.remove('active'));
      thumb.classList.add('active');

      const newSrc = thumb.getAttribute('data-img-src');
      if (newSrc) {
        mainImg.src = newSrc;
        if (mainImg.srcset) mainImg.removeAttribute('srcset');
        if (zoomLink) zoomLink.href = newSrc;
      }
    });
  });
}

/**
 * 4. Related Products Slider Arrows
 */
function initRelatedProductsSlider() {
  const track = document.getElementById('relatedProductsTrack');
  const prevBtn = document.querySelector('.related-arrow-prev');
  const nextBtn = document.querySelector('.related-arrow-next');

  if (!track || !prevBtn || !nextBtn) return;

  const scrollAmount = 280;

  prevBtn.addEventListener('click', () => {
    track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  });

  nextBtn.addEventListener('click', () => {
    track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  });
}

/**
 * 5. Review Form Toggle
 */
function initReviewFormToggle() {
  const desktopBtn = document.getElementById('openReviewFormBtn');
  const mobileBtn = document.getElementById('openReviewFormBtnMobile');
  const formWrap = document.getElementById('tajProductReviewForm');

  if (!formWrap) return;

  const toggleHandler = () => {
    formWrap.style.display = 'block';
    formWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
    const textarea = formWrap.querySelector('textarea');
    if (textarea) {
      setTimeout(() => textarea.focus(), 400);
    }
  };

  if (desktopBtn) desktopBtn.addEventListener('click', toggleHandler);
  if (mobileBtn) mobileBtn.addEventListener('click', toggleHandler);
}

/**
 * 6. Mobile Sticky Add-to-Cart Bar
 */
function initMobileStickyBuyButton() {
  const stickyBtn = document.getElementById('mobileStickyAddToCartBtn');
  const realSubmitBtn = document.querySelector('.buybox-cart-form-wrap button.single_add_to_cart_button');

  if (!stickyBtn || !realSubmitBtn) return;

  stickyBtn.addEventListener('click', () => {
    realSubmitBtn.click();
  });
}
