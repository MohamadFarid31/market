<?php
/**
 * Checkout Form — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

// If cart is empty, show empty state
if (function_exists('WC') && WC()->cart && WC()->cart->is_empty() && !is_customize_preview()) {
    wc_get_template('cart/cart-empty.php');
    return;
}
?>

<!-- ۱. نوار پیشرفت مراحل خرید -->
<div class="taj-checkout-stepper-wrapper">
    <div class="taj-checkout-steps">
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="taj-step is-completed">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('سبد خرید', 'market'); ?></span>
        </a>

        <div class="taj-step-divider is-completed"></div>

        <div class="taj-step is-active">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('مشخصات و تسویه حساب', 'market'); ?></span>
        </div>

        <div class="taj-step-divider"></div>

        <div class="taj-step is-pending">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('ثبت نهایی سفارش', 'market'); ?></span>
        </div>
    </div>
</div>

<div class="taj-checkout-wrapper">
    <?php
    do_action('woocommerce_before_checkout_form', $checkout);

    // If checkout registration is disabled and not logged in, the user cannot checkout.
    if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
        echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('برای تسویه حساب ابتدا باید وارد حساب کاربری خود شوید.', 'market')));
        return;
    }
    ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout taj-checkout-form" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="taj-checkout-layout">
            <!-- ستون اصلی: مشخصات مشتری، آدرس و یادداشت -->
            <div class="taj-checkout-main-col">
                <?php if ($checkout->get_checkout_fields()) : ?>

                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="col2-set taj-customer-details-grid" id="customer_details">
                        <div class="col-1 taj-checkout-card taj-billing-card">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <div class="col-2 taj-checkout-card taj-shipping-additional-card">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <?php endif; ?>
            </div>

            <!-- ستون کناری: خلاصه سفارش، فاکتور و انتخاب درگاه -->
            <aside class="taj-checkout-sidebar-col">
                <div class="taj-checkout-sidebar-inner">
                    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                    <div class="taj-checkout-card taj-order-review-card">
                        <div class="taj-card-header">
                            <span class="taj-card-header-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </span>
                            <h2 class="taj-card-title" id="order_review_heading"><?php esc_html_e('خلاصه سفارش', 'market'); ?></h2>
                        </div>

                        <div class="taj-card-body">
                            <?php do_action('woocommerce_checkout_before_order_review'); ?>

                            <div id="order_review" class="woocommerce-checkout-review-order taj-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_after_order_review'); ?>
                        </div>
                    </div>

                    <!-- بخش تضمین‌ها و نمادهای امنیت خرید -->
                    <div class="taj-checkout-trust-badges">
                        <div class="taj-trust-badge-item">
                            <div class="taj-trust-badge-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div class="taj-trust-badge-text">
                                <strong><?php esc_html_e('پرداخت امن شتابی', 'market'); ?></strong>
                                <span><?php esc_html_e('اتصال مستقیم به درگاه‌های رسمی شاپرک', 'market'); ?></span>
                            </div>
                        </div>

                        <div class="taj-trust-badge-item">
                            <div class="taj-trust-badge-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </div>
                            <div class="taj-trust-badge-text">
                                <strong><?php esc_html_e('ضمانت اصالت کالا', 'market'); ?></strong>
                                <span><?php esc_html_e('تضمین اصالت و سلامت فیزیکی سفارش', 'market'); ?></span>
                            </div>
                        </div>

                        <div class="taj-trust-badge-item">
                            <div class="taj-trust-badge-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </div>
                            <div class="taj-trust-badge-text">
                                <strong><?php esc_html_e('ارسال سریع و مطمئن', 'market'); ?></strong>
                                <span><?php esc_html_e('بسته‌بندی ایمن و کد رهگیری پستی', 'market'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

    </form>

    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
</div>
