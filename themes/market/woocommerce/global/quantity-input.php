<?php
/**
 * Product quantity inputs (Taj Bazar Stepper Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/* translators: %s: Quantity. */
$label = !empty($args['product_name']) ? sprintf(esc_html__('تعداد %s', 'market'), wp_strip_all_tags($args['product_name'])) : esc_html__('تعداد', 'market');
?>
<div class="quantity taj-quantity-stepper">
    <?php do_action('woocommerce_before_quantity_input_field'); ?>
    <button type="button" class="qty-btn qty-minus" aria-label="<?php esc_attr_e('کاهش تعداد', 'market'); ?>">-</button>
    <label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_html($label); ?></label>
    <input
        type="<?php echo esc_attr($type); ?>"
        <?php echo $readonly ? 'readonly="readonly"' : ''; ?>
        id="<?php echo esc_attr($input_id); ?>"
        class="<?php echo esc_attr(join(' ', (array) $classes)); ?>"
        name="<?php echo esc_attr($input_name); ?>"
        value="<?php echo esc_attr($input_value); ?>"
        aria-label="<?php esc_attr_e('تعداد کالا', 'market'); ?>"
        size="4"
        min="<?php echo esc_attr($min_value); ?>"
        max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>"
        <?php if (!empty($step)) : ?>
            step="<?php echo esc_attr($step); ?>"
        <?php endif; ?>
        placeholder="<?php echo esc_attr($placeholder); ?>"
        inputmode="<?php echo esc_attr($inputmode); ?>"
        autocomplete="<?php echo esc_attr(!empty($autocomplete) ? $autocomplete : 'on'); ?>"
    />
    <button type="button" class="qty-btn qty-plus" aria-label="<?php esc_attr_e('افزایش تعداد', 'market'); ?>">+</button>
    <?php do_action('woocommerce_after_quantity_input_field'); ?>
</div>

