<?php
/**
 * Market Theme — Login & Registration Form Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$enable_registration = ('yes' === get_option('woocommerce_enable_myaccount_registration'));

do_action('woocommerce_before_customer_login_form');
?>

<div class="taj-auth-wrapper">
    <div class="taj-auth-card">

        <!-- هدر فرم ورود / عضویت -->
        <div class="taj-auth-header">
            <div class="taj-auth-icon-badge">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h1 class="taj-auth-title"><?php esc_html_e('ورود یا ثبت‌نام', 'market'); ?></h1>
            <p class="taj-auth-subtitle"><?php esc_html_e('برای دسترسی به سبد خرید، تاریخچه سفارش‌ها و تخفیف‌های ویژه وارد حساب خود شوید.', 'market'); ?></p>
        </div>

        <?php if ($enable_registration) : ?>
            <!-- تب‌های جابجایی بین ورود و ثبت‌نام -->
            <div class="taj-auth-tabs-nav" role="tablist">
                <button type="button" class="taj-auth-tab-btn is-active" data-auth-tab="login" role="tab" aria-selected="true" aria-controls="taj-login-panel">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    <span><?php esc_html_e('ورود به سایت', 'market'); ?></span>
                </button>
                <button type="button" class="taj-auth-tab-btn" data-auth-tab="register" role="tab" aria-selected="false" aria-controls="taj-register-panel">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    <span><?php esc_html_e('ثبت‌نام جدید', 'market'); ?></span>
                </button>
            </div>
        <?php endif; ?>

        <!-- ۱. پنل فرم ورود -->
        <div id="taj-login-panel" class="taj-auth-panel is-active" role="tabpanel">
            <form class="woocommerce-form woocommerce-form-login login taj-styled-form" method="post">

                <?php do_action('woocommerce_login_form_start'); ?>

                <div class="form-group">
                    <label for="username" class="form-label"><?php esc_html_e('نام کاربری یا نشانی ایمیل', 'market'); ?> <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <span class="field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e('نام کاربری یا ایمیل خود را وارد کنید', 'market'); ?>" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label"><?php esc_html_e('گذرواژه', 'market'); ?> <span class="required">*</span></label>
                    <div class="input-with-icon input-password-group">
                        <span class="field-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input class="form-control woocommerce-Input woocommerce-Input--password input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e('رمز عبور خود را وارد کنید', 'market'); ?>" required />
                        <button type="button" class="btn-toggle-password" aria-label="<?php esc_attr_e('نمایش یا مخفی‌سازی رمز عبور', 'market'); ?>">
                            <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <?php do_action('woocommerce_login_form'); ?>

                <div class="form-aux-row">
                    <label class="form-check woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                        <span><?php esc_html_e('مرا به خاطر بسپار', 'market'); ?></span>
                    </label>

                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="auth-lost-password-link">
                        <?php esc_html_e('فراموشی گذرواژه؟', 'market'); ?>
                    </a>
                </div>

                <div class="form-submit-row">
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" class="btn btn-primary btn-block btn-lg woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('ورود', 'market'); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        <span><?php esc_html_e('ورود به حساب کاربری', 'market'); ?></span>
                    </button>
                </div>

                <?php do_action('woocommerce_login_form_end'); ?>

            </form>
        </div>

        <?php if ($enable_registration) : ?>
            <!-- ۲. پنل فرم ثبت‌نام -->
            <div id="taj-register-panel" class="taj-auth-panel" role="tabpanel" style="display: none;">
                <form method="post" class="woocommerce-form woocommerce-form-register register taj-styled-form" <?php do_action('woocommerce_register_form_tag'); ?>>

                    <?php do_action('woocommerce_register_form_start'); ?>

                    <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                        <div class="form-group">
                            <label for="reg_username" class="form-label"><?php esc_html_e('نام کاربری', 'market'); ?> <span class="required">*</span></label>
                            <div class="input-with-icon">
                                <span class="field-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </span>
                                <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="reg_email" class="form-label"><?php esc_html_e('نشانی ایمیل', 'market'); ?> <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input type="email" class="form-control woocommerce-Input woocommerce-Input--email input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php esc_attr_e('ایمیل معتبر خود را وارد نمایید', 'market'); ?>" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required />
                        </div>
                    </div>

                    <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                        <div class="form-group">
                            <label for="reg_password" class="form-label"><?php esc_html_e('گذرواژه دلخواه', 'market'); ?> <span class="required">*</span></label>
                            <div class="input-with-icon input-password-group">
                                <span class="field-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </span>
                                <input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e('حداقل ۸ کاراکتر شامل حروف و اعداد', 'market'); ?>" required />
                                <button type="button" class="btn-toggle-password" aria-label="<?php esc_attr_e('نمایش یا مخفی‌سازی رمز عبور', 'market'); ?>">
                                    <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php else : ?>
                        <p class="form-hint"><?php esc_html_e('لینک تعیین گذرواژه به نشانی ایمیل شما فرستاده خواهد شد.', 'market'); ?></p>
                    <?php endif; ?>

                    <?php do_action('woocommerce_register_form'); ?>

                    <div class="form-submit-row">
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button type="submit" class="btn btn-primary btn-block btn-lg woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('ثبت‌نام', 'market'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            <span><?php esc_html_e('عضویت و ایجاد حساب کاربری', 'market'); ?></span>
                        </button>
                    </div>

                    <div class="auth-terms-note">
                        <?php
                        /* translators: 1: Privacy policy link */
                        printf(esc_html__('با عضویت در سایت، تمامی قوانین و شرایط استفاده و %s را می‌پذیرید.', 'market'), '<a href="' . esc_url(get_privacy_policy_url()) . '" target="_blank">' . esc_html__('حریم خصوصی', 'market') . '</a>');
                        ?>
                    </div>

                    <?php do_action('woocommerce_register_form_end'); ?>

                </form>
            </div>
        <?php endif; ?>

        <!-- نوار مزایای خرید در پایین کارت -->
        <div class="taj-auth-trust-bar">
            <div class="trust-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span><?php esc_html_e('ضمانت اصالت و سلامت', 'market'); ?></span>
            </div>
            <div class="trust-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
                <span><?php esc_html_e('ارسال سریع و مطمئن', 'market'); ?></span>
            </div>
            <div class="trust-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span><?php esc_html_e('پشتیبانی ۲۴ ساعته', 'market'); ?></span>
            </div>
        </div>

    </div>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
