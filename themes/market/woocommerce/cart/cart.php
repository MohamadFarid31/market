<?php
/**
 * Cart Page — Taj Bazar Recreation
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="taj-cart-page-wrapper">
    <form class="woocommerce-cart-form taj-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>

        <div class="taj-cart-card">
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents taj-cart-table" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-name"><?php esc_html_e('محصول', 'market'); ?></th>
                        <th class="product-price"><?php esc_html_e('قیمت', 'market'); ?></th>
                        <th class="product-quantity"><?php esc_html_e('تعداد', 'market'); ?></th>
                        <th class="product-subtotal"><?php esc_html_e('جمع جزء', 'market'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php do_action('woocommerce_before_cart_contents'); ?>

                    <?php
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                            <tr class="woocommerce-cart-form__cart-item cart_item" data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>">

                                <td class="product-name" data-title="<?php esc_attr_e('محصول', 'market'); ?>">
                                    <div class="taj-cart-item-header">
                                        <div class="product-remove">
                                            <?php
                                            echo apply_filters(
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove taj-cart-remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                    /* translators: %s is the product name */
                                                    esc_attr(sprintf(__('حذف %s از سبد خرید', 'market'), wp_strip_all_tags($_product->get_name()))),
                                                    esc_attr($product_id),
                                                    esc_attr($_product->get_sku())
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                        </div>

                                        <div class="product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key);

                                            if (!$product_permalink) {
                                                echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            } else {
                                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            }
                                            ?>
                                        </div>

                                        <div class="product-info-col">
                                            <?php
                                            if (!$product_permalink) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                            } else {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="taj-product-cart-title">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                            }

                                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                            // Meta data.
                                            echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

                                            // Backorder notification.
                                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('موجود در انبار، اما به عنوان پیش‌سفارش ثبت می‌شود.', 'market') . '</p>', $product_id));
                                            }
                                            ?>
                                            <div class="taj-mobile-unit-price hide-on-desktop">
                                                <span class="taj-mobile-label"><?php esc_html_e('قیمت واحد:', 'market'); ?></span>
                                                <span class="taj-mobile-val"><?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="product-price hide-on-mobile" data-title="<?php esc_attr_e('قیمت', 'market'); ?>">
                                    <?php
                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    ?>
                                </td>

                                <td class="product-quantity" data-title="<?php esc_attr_e('تعداد', 'market'); ?>">
                                    <div class="taj-mobile-qty-wrap">
                                        <span class="taj-mobile-label hide-on-desktop"><?php esc_html_e('تعداد', 'market'); ?></span>
                                        <?php
                                        if ($_product->is_sold_individually()) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            [
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $_product->get_name(),
                                            ],
                                            $_product,
                                            false
                                        );

                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        ?>
                                    </div>
                                </td>

                                <td class="product-subtotal" data-title="<?php esc_attr_e('جمع جزء', 'market'); ?>">
                                    <span class="taj-mobile-label hide-on-desktop"><?php esc_html_e('جمع:', 'market'); ?></span>
                                    <span class="taj-subtotal-val">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                    <?php do_action('woocommerce_cart_contents'); ?>
                </tbody>
            </table>

            <!-- بخش کوپن و به‌روزرسانی سبد خرید -->
            <div class="taj-cart-actions-row">
                <?php if (wc_coupons_enabled()) { ?>
                    <div class="coupon taj-coupon-box">
                        <input type="text" name="coupon_code" class="input-text taj-coupon-input" id="coupon_code" value="" placeholder="<?php esc_attr_e('کد تخفیف', 'market'); ?>" />
                        <button type="submit" class="button taj-apply-coupon-btn" name="apply_coupon" value="<?php esc_attr_e('اعمال کد تخفیف', 'market'); ?>">
                            <?php esc_html_e('اعمال کد تخفیف', 'market'); ?>
                        </button>
                        <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>
                <?php } ?>

                <button type="submit" class="button button-update-cart taj-update-cart-btn" name="update_cart" value="<?php esc_attr_e('به‌روزرسانی سبد خرید', 'market'); ?>">
                    <?php esc_html_e('به‌روزرسانی سبد خرید', 'market'); ?>
                </button>

                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </div>
        </div>

        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>

    <div class="cart-collaterals taj-cart-collaterals">
        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
        ?>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>

