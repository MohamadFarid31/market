/**
 * Market Theme — Cart Page Interactivity & Quantity Stepper
 */

export function initCart() {
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.taj-quantity-stepper .qty-btn');
    if (!btn) return;

    e.preventDefault();
    const stepper = btn.closest('.taj-quantity-stepper');
    const input = stepper ? stepper.querySelector('input.qty') : null;
    if (!input) return;

    const isMinus = btn.classList.contains('qty-minus');
    const isPlus = btn.classList.contains('qty-plus');
    const step = parseFloat(input.getAttribute('step')) || 1;
    const min = input.getAttribute('min') !== null && input.getAttribute('min') !== '' ? parseFloat(input.getAttribute('min')) : 1;
    const max = input.getAttribute('max') !== null && input.getAttribute('max') !== '' ? parseFloat(input.getAttribute('max')) : Infinity;
    let currentVal = parseFloat(input.value) || min;

    if (isMinus) {
      currentVal = Math.max(min, currentVal - step);
    } else if (isPlus) {
      currentVal = Math.min(max, currentVal + step);
    }

    input.value = currentVal;
    input.dispatchEvent(new Event('input', { bubbles: true }));
    input.dispatchEvent(new Event('change', { bubbles: true }));

    // Enable update cart button if present
    const form = input.closest('form.woocommerce-cart-form');
    if (form) {
      const updateBtn = form.querySelector('button[name="update_cart"]');
      if (updateBtn) {
        updateBtn.disabled = false;
        updateBtn.removeAttribute('aria-disabled');
      }
    }
  });

  // Automatically update cart after typing or changing quantity with a debounced delay
  let debounceTimer = null;
  document.addEventListener('change', (e) => {
    if (e.target.matches('input.qty')) {
      const form = e.target.closest('form.woocommerce-cart-form');
      if (form) {
        const updateBtn = form.querySelector('button[name="update_cart"]');
        if (updateBtn) {
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => {
            // Trigger cart update
            updateBtn.disabled = false;
            updateBtn.click();
          }, 800);
        }
      }
    }
  });
}

