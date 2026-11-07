/**
 * Market Theme — My Account Interactive Module
 *
 * Handles client-side behaviors for the My Account page:
 * - Login & Register tab switching
 * - Password visibility toggle (eye icon)
 *
 * @package Market
 */

export function initAccount() {
  initAuthTabs();
  initPasswordToggles();
}

/**
 * 1. Initialize Login / Register Tab Switching
 */
function initAuthTabs() {
  const tabBtns = document.querySelectorAll('.taj-auth-tab-btn');
  if (!tabBtns.length) return;

  tabBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();

      const targetTab = btn.getAttribute('data-auth-tab');
      if (!targetTab) return;

      // Update buttons
      tabBtns.forEach((b) => {
        b.classList.remove('is-active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('is-active');
      btn.setAttribute('aria-selected', 'true');

      // Update panels
      const loginPanel = document.getElementById('taj-login-panel');
      const registerPanel = document.getElementById('taj-register-panel');

      if (targetTab === 'login') {
        if (loginPanel) {
          loginPanel.style.display = 'block';
          loginPanel.classList.add('is-active');
        }
        if (registerPanel) {
          registerPanel.style.display = 'none';
          registerPanel.classList.remove('is-active');
        }
      } else if (targetTab === 'register') {
        if (loginPanel) {
          loginPanel.style.display = 'none';
          loginPanel.classList.remove('is-active');
        }
        if (registerPanel) {
          registerPanel.style.display = 'block';
          registerPanel.classList.add('is-active');
        }
      }
    });
  });
}

/**
 * 2. Initialize Password Show/Hide Toggles
 */
function initPasswordToggles() {
  const toggleBtns = document.querySelectorAll('.btn-toggle-password');
  if (!toggleBtns.length) return;

  toggleBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const parent = btn.closest('.input-password-group');
      if (!parent) return;

      const input = parent.querySelector('input');
      if (!input) return;

      const isPassword = input.getAttribute('type') === 'password';
      input.setAttribute('type', isPassword ? 'text' : 'password');

      if (isPassword) {
        btn.classList.add('is-visible');
        btn.innerHTML = `
          <svg class="icon-eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
          </svg>
        `;
      } else {
        btn.classList.remove('is-visible');
        btn.innerHTML = `
          <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        `;
      }
    });
  });
}
