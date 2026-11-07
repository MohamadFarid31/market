<?php
/**
 * Market Theme — Edit Account Form Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$user = wp_get_current_user();

do_action('woocommerce_before_edit_account_form');
?>

<div class="taj-edit-account-container">

    <header class="account-page-header">
        <div class="header-title-group">
            <h1 class="account-page-title"><?php esc_html_e('اطلاعات حساب کاربری', 'market'); ?></h1>
            <p class="account-page-subtitle"><?php esc_html_e('اطلاعات هویتی و گذرواژه امنیتی حساب خود را ویرایش و به‌روزرسانی نمایید.', 'market'); ?></p>
        </div>
    </header>

    <form class="woocommerce-EditAccountForm edit-account taj-styled-form taj-edit-account-form" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

        <?php do_action('woocommerce_edit_account_form_start'); ?>

        <!-- بخش اول: اطلاعات فردی -->
        <div class="taj-form-card">
            <div class="taj-form-card-header">
                <span class="card-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span>
                <h2 class="card-title"><?php esc_html_e('مشخصات فردی', 'market'); ?></h2>
            </div>

            <div class="taj-form-grid-2">
                <p class="form-group woocommerce-form-row woocommerce-form-row--first">
                    <label for="account_first_name" class="form-label"><?php esc_html_e('نام', 'market'); ?> <span class="required">*</span></label>
                    <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" required />
                </p>

                <p class="form-group woocommerce-form-row woocommerce-form-row--last">
                    <label for="account_last_name" class="form-label"><?php esc_html_e('نام خانوادگی', 'market'); ?> <span class="required">*</span></label>
                    <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" required />
                </p>
            </div>

            <p class="form-group woocommerce-form-row woocommerce-form-row--wide">
                <label for="account_display_name" class="form-label"><?php esc_html_e('نام نمایشی در سایت', 'market'); ?> <span class="required">*</span></label>
                <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" required />
                <span class="form-hint"><?php esc_html_e('این نام در دیدگاه‌ها، فاکتورها و نوار بالای سایت نمایش داده می‌شود.', 'market'); ?></span>
            </p>

            <p class="form-group woocommerce-form-row woocommerce-form-row--wide">
                <label for="account_email" class="form-label"><?php esc_html_e('نشانی ایمیل', 'market'); ?> <span class="required">*</span></label>
                <input type="email" class="form-control woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" required />
            </p>
        </div>

        <!-- بخش دوم: تغییر گذرواژه -->
        <fieldset class="taj-form-card taj-password-card">
            <div class="taj-form-card-header">
                <span class="card-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </span>
                <legend class="card-title"><?php esc_html_e('تغییر گذرواژه (اختیاری)', 'market'); ?></legend>
            </div>

            <p class="form-notice">
                <?php esc_html_e('تنها در صورتی که تمایل به تغییر رمز عبور حساب خود دارید فیلدهای زیر را پر کنید؛ در غیر این صورت آنها را خالی بگذارید.', 'market'); ?>
            </p>

            <p class="form-group woocommerce-form-row woocommerce-form-row--wide">
                <label for="password_current" class="form-label"><?php esc_html_e('گذرواژه پیشین (فعلی)', 'market'); ?></label>
                <input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="current-password" />
            </p>

            <div class="taj-form-grid-2">
                <p class="form-group woocommerce-form-row">
                    <label for="password_1" class="form-label"><?php esc_html_e('گذرواژه جدید', 'market'); ?></label>
                    <input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="new-password" />
                </p>

                <p class="form-group woocommerce-form-row">
                    <label for="password_2" class="form-label"><?php esc_html_e('تکرار گذرواژه جدید', 'market'); ?></label>
                    <input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="new-password" />
                </p>
            </div>
        </fieldset>

        <?php do_action('woocommerce_edit_account_form'); ?>

        <div class="form-submit-row">
            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
            <button type="submit" class="btn btn-primary btn-lg save-account-btn woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e('ذخیره تغییرات', 'market'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <span><?php esc_html_e('ذخیره تغییرات اطلاعات حساب', 'market'); ?></span>
            </button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>

        <?php do_action('woocommerce_edit_account_form_end'); ?>

    </form>

</div>

<?php do_action('woocommerce_after_edit_account_form'); ?>
