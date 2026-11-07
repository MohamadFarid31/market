<?php
/**
 * Thankyou page — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>

<!-- نوار پیشرفت مراحل خرید -->
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

        <div class="taj-step is-completed">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('مشخصات و تسویه حساب', 'market'); ?></span>
        </div>

        <div class="taj-step-divider is-completed"></div>

        <div class="taj-step is-active <?php echo ($order && $order->has_status('failed')) ? 'is-failed' : 'is-completed'; ?>">
            <span class="taj-step-icon">
                <?php if ($order && $order->has_status('failed')) : ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                <?php else : ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                <?php endif; ?>
            </span>
            <span class="taj-step-label"><?php esc_html_e('ثبت نهایی سفارش', 'market'); ?></span>
        </div>
    </div>
</div>

<div class="taj-thankyou-wrapper woocommerce-order">

    <?php if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
        ?>

        <?php if ($order->has_status('failed')) : ?>

            <div class="taj-order-status-card is-failed">
                <div class="taj-status-icon-wrap is-failed">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h1 class="taj-status-title"><?php esc_html_e('متأسفانه پرداخت انجام نشد', 'market'); ?></h1>
                <p class="taj-status-desc"><?php esc_html_e('تراکنش ناموفق بود یا توسط کاربر لغو گردید. لطفاً مجدداً تلاش کنید یا از روش پرداخت دیگری استفاده نمایید.', 'market'); ?></p>

                <div class="taj-status-actions">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay taj-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10"></polyline>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                        </svg>
                        <span><?php esc_html_e('تلاش مجدد برای پرداخت', 'market'); ?></span>
                    </a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button taj-btn-outline">
                            <?php esc_html_e('حساب کاربری من', 'market'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        <?php else : ?>

            <div class="taj-order-status-card is-success">
                <div class="taj-status-icon-wrap is-success">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h1 class="taj-status-title"><?php esc_html_e('سفارش شما با موفقیت ثبت شد!', 'market'); ?></h1>
                <p class="taj-status-desc"><?php esc_html_e('از خرید شما سپاسگزاریم. جزئیات سفارش برای شما ثبت شده و آماده پردازش و بسته‌بندی می‌باشد.', 'market'); ?></p>

                <!-- ۴ باکس کلیدی اطلاعات سفارش -->
                <div class="taj-order-metrics-grid">
                    <div class="taj-metric-card">
                        <span class="taj-metric-label"><?php esc_html_e('شماره سفارش', 'market'); ?></span>
                        <strong class="taj-metric-value">#<?php echo esc_html(function_exists('market_to_persian_numbers') ? market_to_persian_numbers($order->get_order_number()) : $order->get_order_number()); ?></strong>
                    </div>

                    <div class="taj-metric-card">
                        <span class="taj-metric-label"><?php esc_html_e('تاریخ ثبت', 'market'); ?></span>
                        <strong class="taj-metric-value">
                            <?php
                            $timestamp = $order->get_date_created() ? $order->get_date_created()->getTimestamp() : time();
                            echo esc_html(function_exists('market_format_persian_date') ? market_format_persian_date($timestamp) : date_i18n(get_option('date_format'), $timestamp));
                            ?>
                        </strong>
                    </div>

                    <div class="taj-metric-card">
                        <span class="taj-metric-label"><?php esc_html_e('روش پرداخت', 'market'); ?></span>
                        <strong class="taj-metric-value"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </div>

                    <div class="taj-metric-card is-total">
                        <span class="taj-metric-label"><?php esc_html_e('مبلغ پرداخت شده', 'market'); ?></span>
                        <strong class="taj-metric-value taj-text-price"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                    </div>
                </div>

                <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
                <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

                <div class="taj-thankyou-actions">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="taj-btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <span><?php esc_html_e('مشاهده سفارش در پنل کاربری', 'market'); ?></span>
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="taj-btn-outline">
                        <span><?php esc_html_e('بازگشت به فروشگاه و ادامه خرید', 'market'); ?></span>
                    </a>
                </div>
            </div>

        <?php endif; ?>

    <?php else : ?>

        <div class="taj-order-status-card is-success">
            <h1 class="taj-status-title"><?php esc_html_e('با تشکر، سفارش شما ثبت شد.', 'market'); ?></h1>
            <p class="taj-status-desc"><?php esc_html_e('جزئیات سفارش به زودی برای شما ارسال خواهد شد.', 'market'); ?></p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="taj-btn-primary">
                <?php esc_html_e('بازگشت به فروشگاه', 'market'); ?>
            </a>
        </div>

    <?php endif; ?>

</div>
