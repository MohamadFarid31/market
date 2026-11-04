<?php
/**
 * Empty cart page — Taj Bazar Recreation
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart_empty');
?>

<div class="cart-empty-state">
    <div class="cart-empty-icon-wrap">
        <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#d4d4d8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
    </div>
    <h2 class="cart-empty-title"><?php esc_html_e('سبد خرید شما در حال حاضر خالی است.', 'market'); ?></h2>
    <p class="cart-empty-desc"><?php esc_html_e('می‌توانید برای مشاهده و انتخاب کالاها به صفحه فروشگاه مراجعه کنید.', 'market'); ?></p>
    <?php if (wc_get_page_id('shop') > 0) : ?>
        <p class="return-to-shop">
            <a class="button wc-backward taj-return-shop-btn" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                <?php esc_html_e('بازگشت به فروشگاه', 'market'); ?>
            </a>
        </p>
    <?php endif; ?>
</div>

<?php
do_action('woocommerce_cart_is_empty');

