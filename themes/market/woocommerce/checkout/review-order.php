<?php
/**
 * Review order table — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table taj-review-order-table">
    <thead>
        <tr>
            <th class="product-name"><?php esc_html_e('محصول', 'market'); ?></th>
            <th class="product-total"><?php esc_html_e('جمع جزء', 'market'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        do_action('woocommerce_review_order_before_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $thumbnail = $_product->get_image([52, 52]);
                ?>
                <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item taj-review-item', $cart_item, $cart_item_key)); ?>">
                    <td class="product-name">
                        <div class="taj-review-item-content">
                            <?php if ($thumbnail) : ?>
                                <div class="taj-review-item-thumb">
                                    <?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </div>
                            <?php endif; ?>
                            <div class="taj-review-item-info">
                                <span class="taj-review-item-title">
                                    <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?>
                                </span>
                                <div class="taj-review-item-meta">
                                    <span class="taj-review-item-qty">
                                        <?php
                                        $qty_str = function_exists('market_to_persian_numbers') ? market_to_persian_numbers($cart_item['quantity']) : $cart_item['quantity'];
                                        printf(esc_html__('تعداد: %s', 'market'), '<strong class="product-quantity">' . esc_html($qty_str) . '</strong>');
                                        ?>
                                    </span>
                                    <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="product-total">
                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                </tr>
                <?php
            }
        }

        do_action('woocommerce_review_order_after_cart_contents');
        ?>
    </tbody>
    <tfoot>
        <tr class="cart-subtotal taj-totals-row">
            <th><?php esc_html_e('جمع جزء', 'market'); ?></th>
            <td><?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> taj-totals-row taj-discount-row">
                <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
                <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <?php do_action('woocommerce_review_order_before_shipping'); ?>
            <?php wc_cart_totals_shipping_html(); ?>
            <?php do_action('woocommerce_review_order_after_shipping'); ?>
        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <tr class="fee taj-totals-row">
                <th><?php echo esc_html($fee->name); ?></th>
                <td><?php wc_cart_totals_fee_html($fee); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
            <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
                <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                    <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> taj-totals-row">
                        <th><?php echo esc_html($tax->label); ?></th>
                        <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="tax-total taj-totals-row">
                    <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
                    <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action('woocommerce_review_order_before_order_total'); ?>

        <tr class="order-total taj-totals-row taj-final-total-row">
            <th><?php esc_html_e('مبلغ قابل پرداخت', 'market'); ?></th>
            <td data-title="<?php esc_attr_e('مبلغ قابل پرداخت', 'market'); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

        <?php do_action('woocommerce_review_order_after_order_total'); ?>
    </tfoot>
</table>
