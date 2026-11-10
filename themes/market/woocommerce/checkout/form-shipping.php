<?php
/**
 * Checkout shipping information form — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-shipping-fields">
    <?php if (true === WC()->cart->needs_shipping_address()) : ?>

        <div class="taj-shipping-toggle-box">
            <h3 id="ship-to-different-address" class="taj-shipping-toggle-heading">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox taj-shipping-switch-label">
                    <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox taj-switch-input" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?> type="checkbox" name="ship-to-different-address" value="1" />
                    <span class="taj-switch-toggle"></span>
                    <span class="taj-shipping-toggle-content">
                        <span class="taj-shipping-toggle-title"><?php esc_html_e('ارسال سفارش به آدرس دیگری؟', 'market'); ?></span>
                        <span class="taj-shipping-toggle-desc"><?php esc_html_e('در صورتی که تحویل‌گیرنده فرد دیگری است، این گزینه را فعال کنید.', 'market'); ?></span>
                    </span>
                </label>
            </h3>
        </div>

        <div class="shipping_address taj-shipping-address-wrap">
            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

            <div class="woocommerce-shipping-fields__field-wrapper taj-fields-grid">
                <?php
                $fields = $checkout->get_checkout_fields('shipping');

                foreach ($fields as $key => $field) {
                    woocommerce_form_field($key, $field, $checkout->get_value($key));
                }
                ?>
            </div>

            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
        </div>

    <?php endif; ?>
</div>

<div class="woocommerce-additional-fields taj-additional-fields-wrap">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

        <div class="taj-card-header taj-additional-notes-header">
            <span class="taj-card-header-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </span>
            <div class="taj-card-header-titles">
                <h3 class="taj-card-title"><?php esc_html_e('توضیحات و یادداشت سفارش (اختیاری)', 'market'); ?></h3>
                <span class="taj-card-subtitle"><?php esc_html_e('نکات مربوط به زمان تحویل یا توضیحات مورد نظر را در این بخش بنویسید.', 'market'); ?></span>
            </div>
        </div>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>
