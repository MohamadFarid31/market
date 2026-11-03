<?php
/**
 * Market Theme — Content Pages Meta Boxes (Contact, Complaints, etc.)
 *
 * Allows administrators to customize texts, labels, hours, subjects, and images
 * directly from WordPress "Edit Page" screen without touching code.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/**
 * 1. Register Meta Box for Contact Page
 */
function market_register_content_page_metaboxes() {
    global $post;
    if (!$post) return;

    $template = get_post_meta($post->ID, '_wp_page_template', true);
    $slug     = $post->post_name;
    $title    = $post->post_title;

    $is_contact = ($template === 'page-templates/page-contact.php' 
                   || in_array($slug, ['contact', 'contact-us'], true) 
                   || mb_strpos($title, 'تماس') !== false);

    if ($is_contact) {
        add_meta_box(
            'market_contact_page_metabox',
            esc_html__('تنظیمات متون و محتوای صفحه تماس با ما', 'market'),
            'market_render_contact_page_metabox',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'market_register_content_page_metaboxes');

/**
 * 2. Enqueue Media Uploader for Contact Page
 */
function market_admin_enqueue_contact_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'market_admin_enqueue_contact_scripts');

/**
 * 3. Render Contact Page Meta Box
 */
function market_render_contact_page_metabox($post) {
    wp_nonce_field('market_save_content_page_meta', 'market_content_page_nonce');

    $eyebrow        = get_post_meta($post->ID, '_market_contact_eyebrow', true);
    $custom_title   = get_post_meta($post->ID, '_market_contact_title', true);
    $desc           = get_post_meta($post->ID, '_market_contact_desc', true);
    $telegram_label = get_post_meta($post->ID, '_market_contact_telegram_label', true);
    $telegram_url   = get_post_meta($post->ID, '_market_contact_telegram_url', true);
    $working_hours  = get_post_meta($post->ID, '_market_contact_working_hours', true);
    $custom_image   = get_post_meta($post->ID, '_market_contact_image', true);
    $subjects       = get_post_meta($post->ID, '_market_contact_subjects', true);
    $submit_text    = get_post_meta($post->ID, '_market_contact_submit_text', true);

    // Fallbacks
    if ($eyebrow === '') $eyebrow = 'همیشه آماده پاسخگویی و همراهی با شما هستیم';
    if ($custom_title === '') $custom_title = 'تماس با ما';
    if ($desc === '') $desc = 'اگر درباره محصولات، ثبت سفارش، انتخاب تجهیزات عکاسی و فیلم‌برداری یا خدمات فروشگاه سؤال یا ابهامی دارید، تیم پشتیبانی ما آماده پاسخگویی به شماست. همچنین می‌توانید پیشنهادات، انتقادات یا درخواست‌های خود را از طریق فرم تماس برای ما ارسال کنید. کارشناسان ما در کوتاه‌ترین زمان ممکن پیام شما را بررسی کرده و پاسخ خواهند داد.';
    if ($telegram_label === '') $telegram_label = 'پشتیبانی تلگرام';
    if ($working_hours === '') $working_hours = 'ساعات پاسخگویی: شنبه الی پنجشنبه ساعت 09:00 الی 21:00';
    if ($submit_text === '') $submit_text = 'ارسال';
    if ($subjects === '') {
        $subjects = "پیگیری سفارش\nمشاوره قبل از خرید\nخدمات پس از فروش و گارانتی\nپیشنهادات و انتقادات\nسایر موضوعات";
    }
    ?>

    <style>
        .market-meta-field-group {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f0f1;
        }
        .market-meta-field-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .market-meta-field-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 6px;
            color: #1d2327;
            font-size: 13px;
        }
        .market-meta-field-group .description {
            font-size: 12px;
            color: #646970;
            margin-top: 4px;
            display: block;
        }
        .market-meta-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 6px;
            font-size: 13px;
        }
        .market-meta-textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.7;
        }
        .market-meta-image-preview {
            max-width: 160px;
            height: auto;
            display: block;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #dcdcde;
            background: #f6f7f7;
            padding: 4px;
        }
    </style>

    <div class="market-contact-metabox-wrapper" dir="rtl">

        <!-- پیش‌عنوان بالای تیتر -->
        <div class="market-meta-field-group">
            <label for="market_contact_eyebrow"><?php esc_html_e('پیش‌عنوان بالای تیتر تماس با ما:', 'market'); ?></label>
            <input type="text" id="market_contact_eyebrow" name="_market_contact_eyebrow" value="<?php echo esc_attr($eyebrow); ?>" class="market-meta-input">
            <span class="description"><?php esc_html_e('متن کوچکی که در بالای عنوان اصلی نمایش داده می‌شود.', 'market'); ?></span>
        </div>

        <!-- عنوان اصلی برگه -->
        <div class="market-meta-field-group">
            <label for="market_contact_title"><?php esc_html_e('عنوان اصلی صفحه تماس:', 'market'); ?></label>
            <input type="text" id="market_contact_title" name="_market_contact_title" value="<?php echo esc_attr($custom_title); ?>" class="market-meta-input">
            <span class="description"><?php esc_html_e('پیش‌فرض: تماس با ما', 'market'); ?></span>
        </div>

        <!-- متن توضیحات و معرفی -->
        <div class="market-meta-field-group">
            <label for="market_contact_desc"><?php esc_html_e('متن توضیحات و معرفی پشتیبانی:', 'market'); ?></label>
            <textarea id="market_contact_desc" name="_market_contact_desc" rows="4" class="market-meta-textarea"><?php echo esc_textarea($desc); ?></textarea>
            <span class="description"><?php esc_html_e('پاراگراف معرفی خدمات و پشتیبانی فروشگاه که در زیر عنوان اصلی قرار می‌گیرد.', 'market'); ?></span>
        </div>

        <!-- دکمه پشتیبانی تلگرام -->
        <div class="market-meta-field-group">
            <label><?php esc_html_e('دکمه پشتیبانی تلگرام:', 'market'); ?></label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 6px;">
                <div>
                    <span style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('عنوان دکمه:', 'market'); ?></span>
                    <input type="text" name="_market_contact_telegram_label" value="<?php echo esc_attr($telegram_label); ?>" class="market-meta-input" placeholder="پشتیبانی تلگرام">
                </div>
                <div>
                    <span style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('لینک تلگرام (URL):', 'market'); ?></span>
                    <input type="url" name="_market_contact_telegram_url" value="<?php echo esc_attr($telegram_url); ?>" class="market-meta-input" placeholder="https://t.me/yourid" dir="ltr">
                </div>
            </div>
            <span class="description"><?php esc_html_e('در صورت خالی گذاشتن لینک تلگرام، از لینک عمومی ذخیره‌شده در تنظیمات قالب استفاده خواهد شد.', 'market'); ?></span>
        </div>

        <!-- ساعات پاسخگویی -->
        <div class="market-meta-field-group">
            <label for="market_contact_working_hours"><?php esc_html_e('متن ساعات پاسخگویی:', 'market'); ?></label>
            <input type="text" id="market_contact_working_hours" name="_market_contact_working_hours" value="<?php echo esc_attr($working_hours); ?>" class="market-meta-input">
            <span class="description"><?php esc_html_e('متنی که در کنار نشانگر قرمز رنگ ساعات کاری نمایش داده می‌شود.', 'market'); ?></span>
        </div>

        <!-- تصویر دلخواه / وکتور پشتیبانی -->
        <div class="market-meta-field-group">
            <label><?php esc_html_e('تصویر دلخواه برای ستون پشتیبانی (اختیاری):', 'market'); ?></label>
            <input type="hidden" id="market_contact_image" name="_market_contact_image" value="<?php echo esc_attr($custom_image); ?>">
            <div style="margin-top: 6px;">
                <button type="button" class="button button-secondary" id="market_upload_contact_img_btn">
                    <?php echo !empty($custom_image) ? esc_html__('تغییر تصویر', 'market') : esc_html__('انتخاب تصویر از رسانه', 'market'); ?>
                </button>
                <button type="button" class="button button-link-delete" id="market_remove_contact_img_btn" style="<?php echo empty($custom_image) ? 'display:none;' : ''; ?>">
                    <?php esc_html_e('حذف تصویر', 'market'); ?>
                </button>
            </div>
            <img id="market_contact_img_preview" src="<?php echo esc_url($custom_image); ?>" class="market-meta-image-preview" style="<?php echo empty($custom_image) ? 'display:none;' : ''; ?>">
            <span class="description"><?php esc_html_e('اگر تصویری انتخاب نشود، تصویر وکتور کارتونی زیبای کارشناس پشتیبانی تاج‌بازار نمایش داده خواهد شد.', 'market'); ?></span>
        </div>

        <!-- گزینه‌های موضوع فرم تماس -->
        <div class="market-meta-field-group">
            <label for="market_contact_subjects"><?php esc_html_e('گزینه‌های فیلد «موضوع» در فرم تماس (هر گزینه در یک سطر):', 'market'); ?></label>
            <textarea id="market_contact_subjects" name="_market_contact_subjects" rows="5" class="market-meta-textarea"><?php echo esc_textarea($subjects); ?></textarea>
            <span class="description"><?php esc_html_e('هر موضوعی که در یک سطر وارد کنید به عنوان یک گزینه در دراپ‌داون موضوع فرم قرار خواهد گرفت.', 'market'); ?></span>
        </div>

        <!-- متن دکمه ارسال -->
        <div class="market-meta-field-group">
            <label for="market_contact_submit_text"><?php esc_html_e('متن دکمه ارسال فرم:', 'market'); ?></label>
            <input type="text" id="market_contact_submit_text" name="_market_contact_submit_text" value="<?php echo esc_attr($submit_text); ?>" class="market-meta-input" style="max-width: 200px;">
        </div>

    </div>

    <script>
    jQuery(document).ready(function($){
        var frame;
        $('#market_upload_contact_img_btn').on('click', function(e){
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title: 'انتخاب تصویر صفحه تماس',
                button: { text: 'استفاده از این تصویر' },
                multiple: false
            });
            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $('#market_contact_image').val(attachment.url);
                $('#market_contact_img_preview').attr('src', attachment.url).show();
                $('#market_remove_contact_img_btn').show();
            });
            frame.open();
        });

        $('#market_remove_contact_img_btn').on('click', function(e){
            e.preventDefault();
            $('#market_contact_image').val('');
            $('#market_contact_img_preview').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * 4. Save Content Page Meta Box Data
 */
function market_save_content_page_metaboxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['market_content_page_nonce']) || !wp_verify_nonce($_POST['market_content_page_nonce'], 'market_save_content_page_meta')) return;
    if (!current_user_can('edit_page', $post_id)) return;

    $fields = [
        '_market_contact_eyebrow'        => 'sanitize_text_field',
        '_market_contact_title'          => 'sanitize_text_field',
        '_market_contact_desc'           => 'sanitize_textarea_field',
        '_market_contact_telegram_label' => 'sanitize_text_field',
        '_market_contact_telegram_url'   => 'esc_url_raw',
        '_market_contact_working_hours'  => 'sanitize_text_field',
        '_market_contact_image'          => 'esc_url_raw',
        '_market_contact_subjects'       => 'sanitize_textarea_field',
        '_market_contact_submit_text'    => 'sanitize_text_field',
    ];

    foreach ($fields as $key => $sanitizer) {
        if (isset($_POST[$key])) {
            $val = call_user_func($sanitizer, $_POST[$key]);
            update_post_meta($post_id, $key, $val);
        } else {
            delete_post_meta($post_id, $key);
        }
    }
}
add_action('save_post_page', 'market_save_content_page_metaboxes');

