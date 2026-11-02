/**
 * Market Theme — Core JavaScript Entry Point
 */

import { initNavigation } from './modules/navigation.js';
import { initCartDrawer } from './modules/cart-drawer.js';
import { initSliders } from './modules/slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initCartDrawer();
  initSliders();
});
