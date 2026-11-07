/**
 * Market Theme — Checkout Interactive Module
 *
 * Handles client-side behaviors for the WooCommerce checkout page:
 * - Payment method card selection and active styling
 * - Login & Coupon accordion toggle fail-safe
 * - Place order button loading indicator on form submission
 * - Smooth scroll to validation error notices on checkout_error
 * - Re-binding active states on WooCommerce AJAX `updated_checkout`
 *
 * @package Market
 */

export function initCheckout() {
  const checkoutForm = document.querySelector('form.checkout, form.taj-pay-order-form');
  if (!checkoutForm && !document.getElementById('order_review')) return;

  initPaymentMethodSelection();
  initToggleForms();
  if (checkoutForm) {
    initSubmitButtonState(checkoutForm);
  }
  initAjaxListener();
}

/**
 * 1. Payment Method Card Active State
 */
function initPaymentMethodSelection() {
  const paymentContainer = document.getElementById('payment');
  if (!paymentContainer) return;

  function updateActivePaymentCard() {
    const radioInputs = paymentContainer.querySelectorAll('input[name="payment_method"]');
    radioInputs.forEach((radio) => {
      const card = radio.closest('.taj-payment-method-item');
      if (!card) return;

      if (radio.checked) {
        card.classList.add('is-selected');
      } else {
        card.classList.remove('is-selected');
      }
    });
  }

  // Update on initial load
  updateActivePaymentCard();

  // Listen to change events using event delegation
  paymentContainer.addEventListener('change', (e) => {
    if (e.target.matches('input[name="payment_method"]')) {
      updateActivePaymentCard();
    }
  });

  // Handle clicking on the entire card area outside the label
  paymentContainer.addEventListener('click', (e) => {
    const card = e.target.closest('.taj-payment-method-item');
    if (!card) return;

    // If the click is directly on the label or input, the browser already handles it
    if (e.target.closest('label') || e.target.matches('input[name="payment_method"]')) {
      return;
    }

    const radio = card.querySelector('input[name="payment_method"]');
    if (radio && !radio.checked) {
      radio.checked = true;
      if (typeof jQuery !== 'undefined') {
        jQuery(radio).trigger('change');
      } else {
        radio.dispatchEvent(new Event('change', { bubbles: true }));
      }
      updateActivePaymentCard();
    }
  });
}

/**
 * 2. Login & Coupon Forms Toggle Fail-safe
 */
function initToggleForms() {
  // If jQuery is NOT loaded, provide vanilla toggle behavior
  if (typeof jQuery === 'undefined') {
    document.addEventListener('click', (e) => {
      // Coupon Toggle
      const couponToggle = e.target.closest('.showcoupon');
      if (couponToggle) {
        e.preventDefault();
        const form = document.querySelector('form.checkout_coupon');
        if (form) {
          const isHidden = window.getComputedStyle(form).display === 'none';
          form.style.display = isHidden ? 'block' : 'none';
          if (isHidden) {
            const input = form.querySelector('input[name="coupon_code"]');
            if (input) input.focus();
          }
        }
      }

      // Login Toggle
      const loginToggle = e.target.closest('.showlogin');
      if (loginToggle) {
        e.preventDefault();
        const form = document.querySelector('form.woocommerce-form-login');
        if (form) {
          const isHidden = window.getComputedStyle(form).display === 'none';
          form.style.display = isHidden ? 'block' : 'none';
          if (isHidden) {
            const input = form.querySelector('input[name="username"]');
            if (input) input.focus();
          }
        }
      }
    });
  }
}

/**
 * 3. Place Order Button Loading State & Smooth Error Scroll
 */
function initSubmitButtonState(form) {
  const placeOrderBtn = document.getElementById('place_order');

  form.addEventListener('submit', () => {
    if (placeOrderBtn) {
      placeOrderBtn.classList.add('is-loading');
    }
  });

  if (typeof jQuery !== 'undefined') {
    // When WooCommerce checkout error occurs
    jQuery(document.body).on('checkout_error', () => {
      if (placeOrderBtn) {
        placeOrderBtn.classList.remove('is-loading');
      }

      // Smooth scroll to notices
      const noticeBox = document.querySelector('.woocommerce-NoticeGroup-checkout, .woocommerce-error');
      if (noticeBox) {
        const top = noticeBox.getBoundingClientRect().top + window.pageYOffset - 80;
        window.scrollTo({
          top: Math.max(0, top),
          behavior: 'smooth'
        });
      }
    });
  }
}

/**
 * 4. Re-bind on WooCommerce AJAX `updated_checkout`
 */
function initAjaxListener() {
  if (typeof jQuery !== 'undefined') {
    jQuery(document.body).on('updated_checkout', () => {
      initPaymentMethodSelection();
    });
  }
}
