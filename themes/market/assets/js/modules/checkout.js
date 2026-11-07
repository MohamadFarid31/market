/**
 * Market Theme — Checkout Interactive Module
 *
 * Handles client-side behaviors for the WooCommerce checkout page:
 * - Payment method card selection and active styling
 * - Coupon accordion toggle
 * - Order button loading indicator on form submission
 * - Re-binding active states on WooCommerce AJAX `updated_checkout`
 *
 * @package Market
 */

export function initCheckout() {
  const checkoutForm = document.querySelector('form.checkout');
  if (!checkoutForm) return;

  initPaymentMethodSelection();
  initCouponToggle();
  initSubmitButtonState(checkoutForm);
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

  // Also handle click on the entire card item
  paymentContainer.addEventListener('click', (e) => {
    const card = e.target.closest('.taj-payment-method-item');
    if (!card) return;

    const radio = card.querySelector('input[name="payment_method"]');
    if (radio && !radio.checked && e.target !== radio) {
      radio.checked = true;
      radio.dispatchEvent(new Event('change', { bubbles: true }));
    }
  });
}

/**
 * 2. Coupon Form Toggle
 */
function initCouponToggle() {
  document.addEventListener('click', (e) => {
    const toggleLink = e.target.closest('.showcoupon');
    if (!toggleLink) return;

    e.preventDefault();
    const couponForm = document.querySelector('form.checkout_coupon');
    if (!couponForm) return;

    const isHidden = window.getComputedStyle(couponForm).display === 'none';
    if (isHidden) {
      couponForm.style.display = 'block';
      const input = couponForm.querySelector('input[name="coupon_code"]');
      if (input) input.focus();
    } else {
      couponForm.style.display = 'none';
    }
  });
}

/**
 * 3. Place Order Button Loading State
 */
function initSubmitButtonState(form) {
  const placeOrderBtn = document.getElementById('place_order');
  if (!placeOrderBtn) return;

  form.addEventListener('submit', () => {
    // If form is valid and submitting, display loading indicator
    placeOrderBtn.classList.add('is-loading');
  });

  // When WooCommerce checkout error occurs, remove loading
  if (typeof jQuery !== 'undefined') {
    jQuery(document.body).on('checkout_error', () => {
      placeOrderBtn.classList.remove('is-loading');
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
