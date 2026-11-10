<?php
/**
 * Checkout Payment Section — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>
<div id="payment" class="woocommerce-checkout-payment taj-checkout-payment-box">
    <div class="taj-payment-section-header">
        <span class="taj-payment-header-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
        </span>
        <h3 class="taj-payment-title"><?php esc_html_e('انتخاب روش پرداخت', 'market'); ?></h3>
    </div>

    <?php if (WC()->cart->needs_payment()) : ?>
        <ul class="wc_payment_methods payment_methods methods taj-payment-methods-list">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
                }
            } else {
                echo '<li class="taj-no-gateways-notice"><div class="taj-notice-inner"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span>' . esc_html(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __('هیچ درگاه یا روش پرداختی متناسب با آدرس شما یافت نشد.', 'market') : __('لطفاً برای مشاهده روش‌های پرداخت معتبر، فیلدهای مشخصات و آدرس خود را تکمیل کنید.', 'market'))) . '</span></div></li>';
            }
            ?>
        </ul>
    <?php endif; ?>

    <div class="form-row place-order taj-place-order-wrapper">
        <noscript>
            <?php
            /* translators: $1. link to terms page, $2. link open, $3. link close */
            printf(esc_html__('مرورگر شما جاوااسکریپت را پشتیبانی نمی‌کند یا آن را مسدود کرده است. لطفاً پیش از ثبت سفارش جاوااسکریپت را فعال نمایید.', 'market'));
            ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('به‌روزرسانی قیمت کل', 'market'); ?>"><?php esc_html_e('به‌روزرسانی قیمت کل', 'market'); ?></button>
        </noscript>

        <?php wc_get_template('checkout/terms.php'); ?>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <?php
        $order_button_text = apply_filters('woocommerce_order_button_text', __('پرداخت و ثبت نهایی سفارش', 'market'));
        ?>
        <button type="submit" class="button alt taj-btn-place-order" name="woocommerce_checkout_place_order" id="place_order" value="<?php echo esc_attr($order_button_text); ?>" data-value="<?php echo esc_attr($order_button_text); ?>">
            <svg class="taj-lock-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span class="taj-btn-text"><?php echo esc_html($order_button_text); ?></span>
            <span class="taj-btn-spinner" aria-hidden="true"></span>
        </button>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </div>
</div>
<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
