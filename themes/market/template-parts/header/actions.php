<?php
/**
 * Market Theme — Header Action Buttons (Account & Cart)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
?>
<div class="header-actions">
    <a href="<?php echo esc_url($account_url); ?>" class="header-action-btn btn-ghost" aria-label="<?php esc_attr_e('حساب کاربری', 'market'); ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span class="hide-on-mobile"><?php esc_html_e('حساب کاربری', 'market'); ?></span>
    </a>

    <?php if (class_exists('WooCommerce')) : ?>
        <button class="header-action-btn btn-ghost" data-toggle="cart-drawer" aria-label="<?php esc_attr_e('سبد خرید', 'market'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="cart-count-badge" id="header-cart-count">
                <?php echo esc_html(market_to_persian_numbers($cart_count)); ?>
            </span>
        </button>
    <?php endif; ?>
</div>
