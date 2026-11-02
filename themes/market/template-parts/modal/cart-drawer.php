<?php
/**
 * Market Theme — Slide-Out Mini Cart Drawer Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!class_exists('WooCommerce')) return;
?>
<div id="cart-drawer-overlay" class="drawer-overlay" aria-hidden="true"></div>

<aside id="cart-drawer" class="drawer" aria-label="<?php esc_attr_e('سبد خرید سریع', 'market'); ?>">
    <div class="drawer-header">
        <h2 class="drawer-title"><?php esc_html_e('سبد خرید شما', 'market'); ?></h2>
        <button class="btn btn-ghost" data-close="cart-drawer" aria-label="<?php esc_attr_e('بستن سبد خرید', 'market'); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="drawer-body">
        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
</aside>
