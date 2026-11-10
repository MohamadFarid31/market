/**
 * Market Theme — Core JavaScript Entry Point
 */

import { initNavigation } from './modules/navigation.js';
import { initCartDrawer } from './modules/cart-drawer.js';
import { initSliders } from './modules/slider.js';
import { initSingleProduct } from './modules/single-product.js';
import { initCart } from './modules/cart.js';
import { initWishlist } from './modules/wishlist.js';
import { initAccount } from './modules/account.js';
import { initCheckout } from './modules/checkout.js';
import { initQuickView } from './modules/quick-view.js';

document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initCartDrawer();
  initSliders();
  initSingleProduct();
  initCart();
  initWishlist();
  initAccount();
  initCheckout();
  initQuickView();
});
