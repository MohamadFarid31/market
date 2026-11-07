<?php
/**
 * Checkout login form — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder')) {
    return;
}
?>
<div class="taj-checkout-login-wrapper">
    <div class="woocommerce-form-login-toggle taj-login-toggle-bar">
        <div class="taj-login-notice">
            <span class="taj-login-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </span>
            <span class="taj-login-text"><?php esc_html_e('قبلاً از ما خرید کرده‌اید؟', 'market'); ?></span>
            <a href="#" class="showlogin taj-toggle-login-link"><?php esc_html_e('برای ورود به حساب کاربری کلیک کنید', 'market'); ?></a>
        </div>
    </div>

    <form class="woocommerce-form woocommerce-form-login login taj-checkout-login-form" method="post" style="display:none;">
        <p class="taj-login-desc"><?php esc_html_e('اگر قبلاً در سایت حساب کاربری ساخته‌اید، با وارد کردن مشخصات خود سریع‌تر خرید کنید:', 'market'); ?></p>

        <div class="taj-login-fields-grid">
            <p class="form-row form-row-first">
                <label for="username"><?php esc_html_e('نام کاربری، شماره موبایل یا ایمیل', 'market'); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="input-text taj-form-input" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e('نام کاربری یا ایمیل...', 'market'); ?>" />
            </p>
            <p class="form-row form-row-last">
                <label for="password"><?php esc_html_e('رمز عبور', 'market'); ?>&nbsp;<span class="required">*</span></label>
                <input class="input-text taj-form-input" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e('رمز عبور حساب کاربری...', 'market'); ?>" />
            </p>
        </div>

        <div class="taj-login-form-footer">
            <div class="taj-login-actions">
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <input type="hidden" name="redirect" value="<?php echo esc_url(wc_get_checkout_url()); ?>" />
                <button type="submit" class="button taj-btn-login-submit" name="login" value="<?php esc_attr_e('ورود به حساب', 'market'); ?>">
                    <?php esc_html_e('ورود به حساب', 'market'); ?>
                </button>
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme taj-checkbox-label">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                    <span><?php esc_html_e('مرا به خاطر بسپار', 'market'); ?></span>
                </label>
            </div>
            <p class="lost_password">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="taj-link-lost-password"><?php esc_html_e('رمز عبور خود را فراموش کرده‌اید؟', 'market'); ?></a>
            </p>
        </div>
    </form>
</div>
