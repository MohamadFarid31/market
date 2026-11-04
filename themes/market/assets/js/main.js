/**
 * Market Theme — Core JavaScript Entry Point
 */

import { initNavigation } from './modules/navigation.js';
import { initCartDrawer } from './modules/cart-drawer.js';
import { initSliders } from './modules/slider.js';
import { initSingleProduct } from './modules/single-product.js';
import { initCart } from './modules/cart.js';

document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initCartDrawer();
  initSliders();
  initSingleProduct();
  initCart();
});
