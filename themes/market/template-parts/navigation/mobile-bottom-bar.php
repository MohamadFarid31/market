<?php
/**
 * Market Theme — Mobile Sticky Bottom Navigation Bar
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$cart_count  = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
$shop_url    = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/');
?>
<nav class="mobile-bottom-bar" aria-label="<?php esc_attr_e('ناوبری سریع موبایل', 'market'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-bottom-item <?php echo is_front_page() ? 'active' : ''; ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <span><?php esc_html_e('خانه', 'market'); ?></span>
    </a>

    <a href="<?php echo esc_url($shop_url); ?>" class="mobile-bottom-item <?php echo (function_exists('is_shop') && is_shop()) ? 'active' : ''; ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
        </svg>
        <span><?php esc_html_e('دسته‌ها', 'market'); ?></span>
    </a>

    <?php if (class_exists('WooCommerce')) : ?>
        <a href="#" class="mobile-bottom-item" data-toggle="cart-drawer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <?php if ($cart_count > 0) : ?>
                <span class="cart-count-badge badge"><?php echo esc_html(market_to_persian_numbers($cart_count)); ?></span>
            <?php endif; ?>
            <span><?php esc_html_e('سبد خرید', 'market'); ?></span>
        </a>
    <?php endif; ?>

    <a href="<?php echo esc_url($account_url); ?>" class="mobile-bottom-item <?php echo (function_exists('is_account_page') && is_account_page()) ? 'active' : ''; ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span><?php esc_html_e('حساب کاربری', 'market'); ?></span>
    </a>
</nav>
