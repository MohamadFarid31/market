<?php
/**
 * Market Theme — Header Action Buttons (Account, Wishlist & Cart)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$cart_count  = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
$wishlist_url = home_url('/wishlist/');
?>
<div class="header-actions">
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

    <?php
    $wishlist_count = (is_user_logged_in() && function_exists('market_get_user_wishlist')) ? count(market_get_user_wishlist()) : 0;
    ?>
    <a href="<?php echo esc_url($wishlist_url); ?>" class="header-action-btn btn-ghost" aria-label="<?php esc_attr_e('علاقه‌مندی‌ها', 'market'); ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
        </svg>
        <span class="wishlist-count-badge" id="header-wishlist-count" style="<?php echo $wishlist_count > 0 ? '' : 'display: none;'; ?>">
            <?php echo esc_html(market_to_persian_numbers($wishlist_count)); ?>
        </span>
    </a>

    <a href="<?php echo esc_url($account_url); ?>" class="header-action-btn btn-ghost" aria-label="<?php esc_attr_e('حساب کاربری', 'market'); ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
    </a>
</div>
