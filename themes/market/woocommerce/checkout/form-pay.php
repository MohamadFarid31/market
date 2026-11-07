<?php
/**
 * Pay for order form — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$totals = $order->get_order_item_totals();
?>

<!-- نوار پیشرفت مراحل خرید -->
<div class="taj-checkout-stepper-wrapper">
    <div class="taj-checkout-steps">
        <div class="taj-step is-completed">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('سبد خرید', 'market'); ?></span>
        </div>

        <div class="taj-step-divider is-completed"></div>

        <div class="taj-step is-active">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('پرداخت سفارش', 'market'); ?></span>
        </div>

        <div class="taj-step-divider"></div>

        <div class="taj-step is-pending">
            <span class="taj-step-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
            <span class="taj-step-label"><?php esc_html_e('ثبت نهایی', 'market'); ?></span>
        </div>
    </div>
</div>

<div class="taj-checkout-wrapper taj-pay-order-wrapper">
    <form id="order_review" method="post" class="taj-pay-order-form">
        <div class="taj-checkout-layout">
            <!-- ستون مشخصات و اقلام سفارش -->
            <div class="taj-checkout-main-col">
                <div class="taj-checkout-card">
                    <div class="taj-card-header">
                        <span class="taj-card-header-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                        </span>
                        <h2 class="taj-card-title">
                            <?php
                            $order_num = function_exists('market_to_persian_numbers') ? market_to_persian_numbers($order->get_order_number()) : $order->get_order_number();
                            printf(esc_html__('اقلام سفارش شماره #%s', 'market'), esc_html($order_num));
                            ?>
                        </h2>
                    </div>

                    <table class="shop_table taj-review-order-table">
                        <thead>
                            <tr>
                                <th class="product-name"><?php esc_html_e('محصول', 'market'); ?></th>
                                <th class="product-quantity"><?php esc_html_e('تعداد', 'market'); ?></th>
                                <th class="product-total"><?php esc_html_e('مبلغ جزء', 'market'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($order->get_items()) > 0) : ?>
                                <?php foreach ($order->get_items() as $item_id => $item) : ?>
                                    <?php
                                    if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
                                        continue;
                                    }
                                    ?>
                                    <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item taj-review-item', $item, $order)); ?>">
                                        <td class="product-name">
                                            <?php
                                            echo wp_kses_post(apply_filters('woocommerce_order_item_name', $item->get_name(), $item, false));

                                            do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);

                                            wc_display_item_meta($item);

                                            do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
                                            ?>
                                        </td>
                                        <td class="product-quantity">
                                            <?php
                                            $qty = function_exists('market_to_persian_numbers') ? market_to_persian_numbers($item->get_quantity()) : $item->get_quantity();
                                            echo '<span class="taj-review-item-qty">' . esc_html($qty) . '</span>';
                                            ?>
                                        </td>
                                        <td class="product-subtotal">
                                            <?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <?php if ($totals) : ?>
                                <?php foreach ($totals as $total) : ?>
                                    <tr class="taj-totals-row">
                                        <th scope="row" colspan="2"><?php echo $total['label']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
                                        <td class="product-total"><?php echo $total['value']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- ستون درگاه پرداخت -->
            <aside class="taj-checkout-sidebar-col">
                <div class="taj-checkout-sidebar-inner">
                    <div class="taj-checkout-card taj-order-review-card">
                        <div id="payment" class="taj-checkout-payment-box">
                            <div class="taj-payment-section-header">
                                <span class="taj-payment-header-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                </span>
                                <h3 class="taj-payment-title"><?php esc_html_e('روش پرداخت را انتخاب کنید', 'market'); ?></h3>
                            </div>

                            <?php if ($order->needs_payment()) : ?>
                                <ul class="wc_payment_methods payment_methods methods taj-payment-methods-list">
                                    <?php
                                    if (!empty($available_gateways)) {
                                        foreach ($available_gateways as $gateway) {
                                            wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
                                        }
                                    } else {
                                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . esc_html(apply_filters('woocommerce_no_available_payment_methods_message', __('هیچ روش پرداختی در دسترس نیست. لطفاً با پشتیبانی سایت تماس بگیرید.', 'market'))) . '</li>';
                                    }
                                    ?>
                                </ul>
                            <?php endif; ?>

                            <div class="form-row place-order taj-place-order-wrapper">
                                <input type="hidden" name="woocommerce_pay" value="1" />

                                <?php wc_get_template('checkout/terms.php'); ?>

                                <?php do_action('woocommerce_pay_order_before_submit'); ?>

                                <?php
                                $pay_order_button_text = apply_filters('woocommerce_pay_order_button_text', __('پرداخت سفارش', 'market'));
                                ?>
                                <button type="submit" class="button alt taj-btn-place-order" id="place_order" value="<?php echo esc_attr($pay_order_button_text); ?>" data-value="<?php echo esc_attr($pay_order_button_text); ?>">
                                    <svg class="taj-lock-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <span class="taj-btn-text"><?php echo esc_html($pay_order_button_text); ?></span>
                                    <span class="taj-btn-spinner" aria-hidden="true"></span>
                                </button>

                                <?php do_action('woocommerce_pay_order_after_submit'); ?>

                                <?php wp_nonce_field('woocommerce-pay', 'woocommerce-pay-nonce'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </form>
</div>
