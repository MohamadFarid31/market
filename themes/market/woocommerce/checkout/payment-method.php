<?php
/**
 * Output a single payment method — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?> taj-payment-method-item <?php echo $gateway->chosen ? 'is-selected' : ''; ?>">
    <label class="taj-payment-method-label" for="payment_method_<?php echo esc_attr($gateway->id); ?>">
        <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio taj-radio-input" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />
        <span class="taj-radio-custom"></span>
        <span class="taj-payment-method-title"><?php echo $gateway->get_title(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></span>
        <?php if ($gateway->get_icon()) : ?>
            <span class="taj-payment-gateway-icon"><?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></span>
        <?php endif; ?>
    </label>
    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?> taj-payment-box" <?php if (!$gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
