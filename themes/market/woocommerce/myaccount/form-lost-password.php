<?php
/**
 * Market Theme — Lost Password Form Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<div class="taj-auth-wrapper">
    <div class="taj-auth-card taj-lost-password-card">

        <div class="taj-auth-header">
            <div class="taj-auth-icon-badge">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h1 class="taj-auth-title"><?php esc_html_e('بازیابی گذرواژه', 'market'); ?></h1>
            <p class="taj-auth-subtitle">
                <?php echo apply_filters('woocommerce_lost_password_message', esc_html__('گذرواژه خود را فراموش کرده‌اید؟ لطفاً نام کاربری یا نشانی ایمیل خود را وارد نمایید. پیوندی برای ساخت رمز جدید دریافت خواهید کرد.', 'market')); ?>
            </p>
        </div>

        <form method="post" class="woocommerce-ResetPassword lost_reset_password taj-styled-form">

            <div class="form-group">
                <label for="user_login" class="form-label"><?php esc_html_e('نام کاربری یا نشانی ایمیل', 'market'); ?> <span class="required">*</span></label>
                <div class="input-with-icon">
                    <span class="field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <input class="form-control woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_attr_e('نام کاربری یا ایمیل ثبت‌نامی خود را وارد کنید', 'market'); ?>" required />
                </div>
            </div>

            <?php do_action('woocommerce_lostpassword_form'); ?>

            <div class="form-submit-row">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="btn btn-primary btn-block btn-lg woocommerce-Button button" value="<?php esc_attr_e('بازنشانی گذرواژه', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                    </svg>
                    <span><?php esc_html_e('ارسال لینک بازنشانی رمز عبور', 'market'); ?></span>
                </button>
            </div>

            <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>

            <div class="auth-back-link-wrap">
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="auth-back-to-login">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span><?php esc_html_e('بازگشت به صفحه ورود', 'market'); ?></span>
                </a>
            </div>

        </form>

    </div>
</div>

<?php do_action('woocommerce_after_lost_password_form'); ?>
