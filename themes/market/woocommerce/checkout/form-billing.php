<?php
/**
 * Checkout billing information form — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-billing-fields">
    <div class="taj-card-header">
        <span class="taj-card-header-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </span>
        <h3 class="taj-card-title"><?php echo esc_html(apply_filters('woocommerce_billing_fields_heading', __('اطلاعات صورت‌حساب و تحویل‌گیرنده', 'market'))); ?></h3>
    </div>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper taj-fields-grid">
        <?php
        $fields = $checkout->get_checkout_fields('billing');

        foreach ($fields as $key => $field) {
            woocommerce_form_field($key, $field, $checkout->get_value($key));
        }
        ?>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields taj-account-create-fields">
        <?php if (!$checkout->is_registration_required()) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox taj-checkbox-label">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" />
                    <span><?php esc_html_e('می‌خواهم حساب کاربری ایجاد شود', 'market'); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>

            <div class="create-account taj-account-fields-wrap taj-fields-grid">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
