<?php
/**
 * Market Theme — Reset Password Form Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_reset_password_form');
?>

<div class="taj-auth-wrapper">
    <div class="taj-auth-card taj-reset-password-card">

        <div class="taj-auth-header">
            <div class="taj-auth-icon-badge">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h1 class="taj-auth-title"><?php esc_html_e('تعیین گذرواژه جدید', 'market'); ?></h1>
            <p class="taj-auth-subtitle"><?php esc_html_e('لطفاً رمز عبور جدید خود را در فیلدهای زیر وارد نمایید.', 'market'); ?></p>
        </div>

        <form method="post" class="woocommerce-ResetPassword lost_reset_password taj-styled-form">

            <div class="form-group">
                <label for="password_1" class="form-label"><?php esc_html_e('گذرواژه جدید', 'market'); ?> <span class="required">*</span></label>
                <div class="input-with-icon input-password-group">
                    <span class="field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" required />
                    <button type="button" class="btn-toggle-password" aria-label="<?php esc_attr_e('نمایش یا مخفی‌سازی رمز عبور', 'market'); ?>">
                        <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_2" class="form-label"><?php esc_html_e('تکرار گذرواژه جدید', 'market'); ?> <span class="required">*</span></label>
                <div class="input-with-icon input-password-group">
                    <span class="field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" required />
                    <button type="button" class="btn-toggle-password" aria-label="<?php esc_attr_e('نمایش یا مخفی‌سازی رمز عبور', 'market'); ?>">
                        <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>" />
            <input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>" />

            <?php do_action('woocommerce_resetpassword_form'); ?>

            <div class="form-submit-row">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="btn btn-primary btn-block btn-lg woocommerce-Button button" value="<?php esc_attr_e('ذخیره', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span><?php esc_html_e('ذخیره گذرواژه جدید', 'market'); ?></span>
                </button>
            </div>

            <?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>

        </form>

    </div>
</div>

<?php do_action('woocommerce_after_reset_password_form'); ?>
