<?php
/**
 * Market Theme — Theme Options & Footer Settings
 *
 * Dedicated settings page in WordPress Admin under "نمایش > تنظیمات قالب"
 * for footer contact details, about text, social links, and trust badges.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/**
 * Register Admin Menu for Theme Settings
 */
function market_add_theme_settings_page()
{
    add_theme_page(
        esc_html__('تنظیمات قالب', 'market'),
        esc_html__('تنظیمات قالب', 'market'),
        'manage_options',
        'market-settings',
        'market_render_theme_settings_page'
    );
}
add_action('admin_menu', 'market_add_theme_settings_page');

/**
 * Register Settings via Settings API
 */
function market_register_theme_settings()
{
    register_setting('market_theme_options_group', 'market_theme_options', 'market_sanitize_theme_options');
}
add_action('admin_init', 'market_register_theme_settings');

/**
 * Sanitize Options
 */
function market_sanitize_theme_options($input)
{
    $output = [];
    if (!is_array($input)) {
        return $output;
    }

    $text_fields = ['phone', 'email', 'about_title', 'copyright_rights', 'copyright_credits'];
    foreach ($text_fields as $field) {
        if (isset($input[$field])) {
            $output[$field] = sanitize_text_field($input[$field]);
        }
    }

    if (isset($input['address'])) {
        $output['address'] = sanitize_textarea_field($input['address']);
    }

    if (isset($input['about_desc'])) {
        $output['about_desc'] = sanitize_textarea_field($input['about_desc']);
    }

    if (isset($input['instagram'])) {
        $output['instagram'] = esc_url_raw($input['instagram']);
    }

    if (isset($input['telegram'])) {
        $output['telegram'] = esc_url_raw($input['telegram']);
    }

    if (isset($input['enamad_code'])) {
        // Allow script/iframe/html for enamad
        $output['enamad_code'] = wp_kses_post($input['enamad_code']);
    }

    if (isset($input['samandehi_code'])) {
        $output['samandehi_code'] = wp_kses_post($input['samandehi_code']);
    }

    return $output;
}

/**
 * Helper to get a theme option with fallback
 */
function market_get_option($key, $default = '')
{
    $options = get_option('market_theme_options');
    if (is_array($options) && isset($options[$key]) && $options[$key] !== '') {
        return $options[$key];
    }
    return $default;
}

/**
 * Render Theme Settings Page
 */
function market_render_theme_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap" dir="rtl" style="max-width: 900px; font-family: Tahoma, sans-serif;">
        <h1 style="color: #e52534; font-weight: bold; margin-bottom: 20px;">
            <?php esc_html_e('تنظیمات قالب', 'market'); ?>
        </h1>

        <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']): ?>
            <div class="notice notice-success is-dismissible" style="padding: 10px 15px;">
                <p><strong><?php esc_html_e('تنظیمات با موفقیت ذخیره شدند.', 'market'); ?></strong></p>
            </div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('market_theme_options_group');
            $opt = get_option('market_theme_options');
            if (!is_array($opt))
                $opt = [];
            ?>

            <!-- ۱. اطلاعات تماس و آدرس -->
            <div
                style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="margin-top: 0; border-bottom: 2px solid #e52534; padding-bottom: 8px; font-size: 16px;">
                    <?php esc_html_e('۱. اطلاعات تماس (هدر و بالای فوتر)', 'market'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label
                                for="market_phone"><?php esc_html_e('شماره تماس پشتیبانی', 'market'); ?></label></th>
                        <td>
                            <input name="market_theme_options[phone]" type="text" id="market_phone"
                                value="<?php echo esc_attr(isset($opt['phone']) ? $opt['phone'] : '09128184981'); ?>"
                                class="regular-text" dir="ltr">
                            <p class="description">
                                <?php esc_html_e('این شماره در هدر دسکتاپ و نوار بالای فوتر نمایش داده می‌شود.', 'market'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                for="market_email"><?php esc_html_e('ایمیل رسمی فروشگاه', 'market'); ?></label></th>
                        <td>
                            <input name="market_theme_options[email]" type="text" id="market_email"
                                value="<?php echo esc_attr(isset($opt['email']) ? $opt['email'] : 'Info@tajbazar.ir'); ?>"
                                class="regular-text" dir="ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                for="market_address"><?php esc_html_e('نشانی فیزیکی فروشگاه', 'market'); ?></label></th>
                        <td>
                            <textarea name="market_theme_options[address]" id="market_address" rows="2"
                                class="large-text"><?php echo esc_textarea(isset($opt['address']) ? $opt['address'] : 'بازار بزرگ تهران، خیابان ناصرخسرو، نبش سوراسرافیل، پلاک ۱۹۸'); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- ۲. درباره ما در فوتر -->
            <div
                style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="margin-top: 0; border-bottom: 2px solid #e52534; padding-bottom: 8px; font-size: 16px;">
                    <?php esc_html_e('۲. بخش «درباره ما» در فوتر', 'market'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label
                                for="market_about_title"><?php esc_html_e('عنوان درباره ما', 'market'); ?></label></th>
                        <td>
                            <input name="market_theme_options[about_title]" type="text" id="market_about_title"
                                value="<?php echo esc_attr(isset($opt['about_title']) ? $opt['about_title'] : 'فروشگاه تاج بازار'); ?>"
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                for="market_about_desc"><?php esc_html_e('متن توضیحات درباره ما', 'market'); ?></label></th>
                        <td>
                            <textarea name="market_theme_options[about_desc]" id="market_about_desc" rows="5"
                                class="large-text"><?php echo esc_textarea(isset($opt['about_desc']) ? $opt['about_desc'] : 'تاج بازار فروشگاه تخصصی تجهیزات عکاسی، فیلم‌برداری و تولید محتواست. با ارائه مجموعه‌ای از دوربین‌ها، لنزها، تجهیزات نورپردازی، صدا و لوازم جانبی، تلاش می‌کنیم نیاز عکاسان، فیلم‌برداران و تولیدکنندگان محتوا را به‌صورت کامل پوشش دهیم. ارائه محصولات اصل، مشاوره تخصصی پیش از خرید و پشتیبانی واقعی، این امکان را فراهم می‌کند تا با اطمینان بیشتر، تجهیزات متناسب با نیاز و بودجه خود را انتخاب کنید.'); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- ۳. شبکه‌های اجتماعی -->
            <div
                style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="margin-top: 0; border-bottom: 2px solid #e52534; padding-bottom: 8px; font-size: 16px;">
                    <?php esc_html_e('۳. لینک‌های شبکه‌های اجتماعی', 'market'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label
                                for="market_instagram"><?php esc_html_e('لینک اینستاگرام', 'market'); ?></label></th>
                        <td>
                            <input name="market_theme_options[instagram]" type="url" id="market_instagram"
                                value="<?php echo esc_url(isset($opt['instagram']) ? $opt['instagram'] : 'https://instagram.com'); ?>"
                                class="regular-text" dir="ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="market_telegram"><?php esc_html_e('لینک تلگرام', 'market'); ?></label>
                        </th>
                        <td>
                            <input name="market_theme_options[telegram]" type="url" id="market_telegram"
                                value="<?php echo esc_url(isset($opt['telegram']) ? $opt['telegram'] : 'https://t.me'); ?>"
                                class="regular-text" dir="ltr">
                        </td>
                    </tr>
                </table>
            </div>

            <!-- ۴. نمادهای اعتماد و کپی‌رایت -->
            <div
                style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="margin-top: 0; border-bottom: 2px solid #e52534; padding-bottom: 8px; font-size: 16px;">
                    <?php esc_html_e('۴. نمادهای اعتماد و کپی‌رایت', 'market'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label
                                for="market_enamad"><?php esc_html_e('کد اینماد (HTML / ای‌نماد)', 'market'); ?></label>
                        </th>
                        <td>
                            <textarea name="market_theme_options[enamad_code]" id="market_enamad" rows="3"
                                class="large-text"
                                dir="ltr"><?php echo esc_textarea(isset($opt['enamad_code']) ? $opt['enamad_code'] : ''); ?></textarea>
                            <p class="description">
                                <?php esc_html_e('کد اسکریپت یا لوگوی اینماد خود را اینجا وارد کنید.', 'market'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                for="market_samandehi"><?php esc_html_e('کد ساماندهی (HTML)', 'market'); ?></label></th>
                        <td>
                            <textarea name="market_theme_options[samandehi_code]" id="market_samandehi" rows="3"
                                class="large-text"
                                dir="ltr"><?php echo esc_textarea(isset($opt['samandehi_code']) ? $opt['samandehi_code'] : ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                for="market_rights"><?php esc_html_e('متن کپی‌رایت (سمت راست)', 'market'); ?></label></th>
                        <td>
                            <input name="market_theme_options[copyright_rights]" type="text" id="market_rights"
                                value="<?php echo esc_attr(isset($opt['copyright_rights']) ? $opt['copyright_rights'] : 'تمامی حقوق محفوظ و متعلق به تاج بازار می‌باشد.'); ?>"
                                class="large-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                for="market_credits"><?php esc_html_e('متن طراح/توسعه‌دهنده (سمت چپ)', 'market'); ?></label>
                        </th>
                        <td>
                            <input name="market_theme_options[copyright_credits]" type="text" id="market_credits"
                                value="<?php echo esc_attr(isset($opt['copyright_credits']) ? $opt['copyright_credits'] : 'طراحی و توسعه یافته توسط استودیو تکسیما'); ?>"
                                class="large-text">
                        </td>
                    </tr>
                </table>
            </div>

            <?php submit_button(esc_html__('ذخیره تغییرات تنظیمات', 'market'), 'primary button-hero', 'submit', true, ['style' => 'background: #e52534; border-color: #cf1d2b; text-shadow: none; font-weight: bold;']); ?>
        </form>
    </div>
    <?php
}

