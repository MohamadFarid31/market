<?php
/**
 * Market Theme — Mobile Sticky Bottom Navigation Bar (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$cart_count  = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
$shop_url    = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<!-- دکمه شناور تماس با ما در موبایل -->
<div class="mobile-floating-contact hide-on-desktop">
    <div class="contact-pill-label"><?php esc_html_e('تماس با ما', 'market'); ?></div>
    <a href="tel:09128184981" class="contact-floating-btn" aria-label="<?php esc_attr_e('تماس با پشتیبانی', 'market'); ?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
        </svg>
    </a>
</div>

<!-- نوار ناوبری چسبان پایین موبایل -->
<nav class="mobile-bottom-bar hide-on-desktop" aria-label="<?php esc_attr_e('ناوبری سریع موبایل', 'market'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-bottom-item <?php echo is_front_page() ? 'active' : ''; ?>">
        <svg class="mobile-bottom-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <span class="mobile-bottom-label"><?php esc_html_e('خانه', 'market'); ?></span>
    </a>

    <a href="<?php echo esc_url($shop_url); ?>" class="mobile-bottom-item <?php echo (function_exists('is_shop') && is_shop()) ? 'active' : ''; ?>">
        <svg class="mobile-bottom-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 3h18v18H3z"></path>
            <path d="M3 9h18"></path>
            <path d="M9 21V9"></path>
        </svg>
        <span class="mobile-bottom-label"><?php esc_html_e('محصولات', 'market'); ?></span>
    </a>

    <?php if (class_exists('WooCommerce')) : ?>
        <a href="#" class="mobile-bottom-item" data-toggle="cart-drawer">
            <div class="mobile-bottom-cart-wrap">
                <svg class="mobile-bottom-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <?php if ($cart_count > 0) : ?>
                    <span class="cart-count-badge"><?php echo esc_html(market_to_persian_numbers($cart_count)); ?></span>
                <?php endif; ?>
            </div>
            <span class="mobile-bottom-label"><?php esc_html_e('سبد خرید', 'market'); ?></span>
        </a>
    <?php endif; ?>

    <a href="#mobile-search-field" class="mobile-bottom-item" id="mobile-bottom-search-trigger">
        <svg class="mobile-bottom-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <span class="mobile-bottom-label"><?php esc_html_e('جستجو', 'market'); ?></span>
    </a>

    <a href="<?php echo esc_url($account_url); ?>" class="mobile-bottom-item <?php echo (function_exists('is_account_page') && is_account_page()) ? 'active' : ''; ?>">
        <svg class="mobile-bottom-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span class="mobile-bottom-label"><?php esc_html_e('حساب کاربری', 'market'); ?></span>
    </a>
</nav>
