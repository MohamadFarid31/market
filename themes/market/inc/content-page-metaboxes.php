<?php
/**
 * Market Theme — Content Pages Meta Boxes (Contact, FAQ, Complaints, etc.)
 *
 * Allows administrators to customize texts, labels, questions, and banners
 * directly from WordPress "Edit Page" screen without touching code.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/**
 * 1. Register Meta Boxes for Content Pages (Contact & FAQ)
 */
function market_register_content_page_metaboxes() {
    global $post;
    if (!$post) return;

    $template = get_post_meta($post->ID, '_wp_page_template', true);
    $slug     = $post->post_name;
    $title    = $post->post_title;

    // Contact Page
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

    // FAQ Page
    $is_faq = ($template === 'page-templates/page-faq.php' 
               || in_array($slug, ['faq', 'questions', 'frequently-asked-questions'], true) 
               || mb_strpos($title, 'پرسش') !== false 
               || mb_strpos($title, 'سوالات') !== false);

    if ($is_faq) {
        add_meta_box(
            'market_faq_page_metabox',
            esc_html__('تنظیمات و پرسش و پاسخ‌های صفحه سوالات متداول', 'market'),
            'market_render_faq_page_metabox',
            'page',
            'normal',
            'high'
        );
    }

    // Complaints & Suggestions Page
    $is_complaints = ($template === 'page-templates/page-complaints.php' 
                     || in_array($slug, ['complaints', 'suggestions-and-criticisms', 'suggestions', 'criticisms'], true) 
                     || mb_strpos($title, 'پیشنهاد') !== false 
                     || mb_strpos($title, 'انتقاد') !== false 
                     || mb_strpos($title, 'شکایت') !== false);

    if ($is_complaints) {
        add_meta_box(
            'market_complaints_page_metabox',
            esc_html__('تنظیمات متون و فرم صفحه پیشنهادات و انتقادات', 'market'),
            'market_render_complaints_page_metabox',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'market_register_content_page_metaboxes');

/**
 * 2. Enqueue Media Uploader for Pages
 */
function market_admin_enqueue_contact_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'market_admin_enqueue_contact_scripts');

/**
 * 3. Default FAQ Items Data (Taj Bazar Reference)
 */
function market_get_default_faqs() {
    return [
        // گروه اول: فرآیند خرید و ارسال
        [
            'group'    => 'group_1',
            'question' => 'آیا کالاها موجود هستند؟',
            'answer'   => 'بله، تمام کالاهایی که امکان ثبت سفارش دارند، موجود بوده و پس از ثبت سفارش وارد فرآیند آماده‌سازی و ارسال می‌شوند. در صورت بروز هرگونه تغییر در موجودی، کارشناسان فروش پیش از ارسال با شما هماهنگ خواهند کرد.',
        ],
        [
            'group'    => 'group_1',
            'question' => 'سفارش من چه زمانی ارسال می‌شود؟',
            'answer'   => 'سفارش‌های ثبت شده در روزهای کاری معمولاً بین ۲۴ تا ۴۸ ساعت کاری آماده‌سازی و به شرکت‌های پستی یا پیک تحویل داده می‌شوند. زمان دقیق رسیدن کالا به مقصد به شهر و شیوه ارسال بستگی دارد.',
        ],
        [
            'group'    => 'group_1',
            'question' => 'چگونه می‌توانم وضعیت سفارش خود را پیگیری کنم؟',
            'answer'   => 'پس از ثبت سفارش، کد رهگیری از طریق پیامک برای شما ارسال می‌شود. همچنین می‌توانید با مراجعه به بخش حساب کاربری > سفارش‌ها، وضعیت لحظه‌ای مرسوله خود را مشاهده فرمایید.',
        ],

        // گروه دوم - ستون راست: اصالت، مشخصات و مشاوره
        [
            'group'    => 'group_2_right',
            'question' => 'آیا تمامی کالاها اصل هستند؟',
            'answer'   => 'بله، تمامی محصولات ارائه شده اصل بوده و از تأمین‌کنندگان معتبر تهیه می‌شوند.',
        ],
        [
            'group'    => 'group_2_right',
            'question' => 'آیا مشخصات درج شده در سایت دقیق هستند؟',
            'answer'   => 'بله، تمامی مشخصات و ویژگی‌های فنی بر اساس کاتالوگ رسمی شرکت سازنده و بررسی‌های تخصصی کارشناسان ثبت شده‌اند.',
        ],
        [
            'group'    => 'group_2_right',
            'question' => 'اگر برای انتخاب دوربین یا لنز نیاز به مشاوره داشته باشم چه کنیم؟',
            'answer'   => 'شما می‌توانید در ساعات کاری با تیم مشاوره تخصصی ما از طریق تماس تلفنی یا تلگرام در ارتباط باشید تا متناسب با بودجه و نیازتان راهنمایی شوید.',
        ],
        [
            'group'    => 'group_2_right',
            'question' => 'آیا لوازم جانبی با دوربین سازگار هستند؟',
            'answer'   => 'در توضیحات هر محصول سازگاری دقیق با مدل‌های مختلف درج شده است؛ با این حال در صورت داشتن هرگونه ابهام می‌توانید با پشتیبانی هماهنگ نمایید.',
        ],

        // گروه دوم - ستون چپ: گارانتی، سلامت و تعویض
        [
            'group'    => 'group_2_left',
            'question' => 'آیا محصولات دارای گارانتی هستند؟',
            'answer'   => 'بسته به نوع کالا، محصولات ممکن است دارای گارانتی شرکتی، گارانتی رسمی یا ضمانت سلامت فیزیکی باشند. نوع گارانتی هر محصول در صفحه همان کالا درج شده است.',
        ],
        [
            'group'    => 'group_2_left',
            'question' => 'اگر کالای دریافتی آسیب‌دیده باشد چه باید کرد؟',
            'answer'   => 'لطفاً حداکثر تا ۲۴ ساعت پس از تحویل کالا، موضوع را به همراه تصاویر آسیب‌دیدگی به پشتیبانی اطلاع دهید تا فرآیند بررسی و تعویض آغاز شود.',
        ],
        [
            'group'    => 'group_2_left',
            'question' => 'آیا امکان تعویض کالا وجود دارد؟',
            'answer'   => 'در صورت سلامت کامل بسته‌بندی و پلمپ محصول و عدم استفاده از آن، طبق قوانین مرجوعی امکان بررسی تعویض کالا وجود دارد.',
        ],

        // گروه سوم: شروع عکاسی و انتخاب تخصصی
        [
            'group'    => 'group_3',
            'question' => 'برای شروع عکاسی چه دوربینی مناسب است؟',
            'answer'   => 'انتخاب دوربین به بودجه، نوع عکاسی و سطح تجربه شما بستگی دارد. اگر تازه کار هستید، کارشناسان ما می‌توانند بهترین گزینه را متناسب با نیازتان معرفی کنند.',
        ],
        [
            'group'    => 'group_3',
            'question' => 'آیا خرید دوربین دست دوم را پیشنهاد می‌کنید؟',
            'answer'   => 'برای شروع یا صرفه‌جویی در هزینه، دوربین‌های دست دوم تست‌شده و دارای مهلت تست گزینه‌های بسیار مناسبی هستند، اما خرید دوربین آکبند اطمینان بالاتری از نظر گارانتی دارد.',
        ],
        [
            'group'    => 'group_3',
            'question' => 'آیا قبل از خرید می‌توانم مشاوره تخصصی دریافت کنم؟',
            'answer'   => 'بله، مشاوره تخصصی کاملاً رایگان است و کارشناسان ما به شما کمک می‌کنند مناسب‌ترین تجهیزات را انتخاب کنید.',
        ],
        [
            'group'    => 'group_3',
            'question' => 'اگر بین دو مدل دوربین مردد باشم، کمک می‌کنید؟',
            'answer'   => 'قطعاً؛ ما با مقایسه دقیق مشخصات فنی، نقاط قوت و ضعف هر مدل و متناسب با سبک کاری شما، به انتخابی مطمئن کمک خواهیم کرد.',
        ],
    ];
}

/**
 * 4. Render Contact Page Meta Box
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
    <div class="market-content-metabox-wrapper" dir="rtl" style="max-width: 900px;">
        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('پیش‌عنوان بالای تیتر تماس:', 'market'); ?></label>
            <input type="text" name="_market_contact_eyebrow" value="<?php echo esc_attr($eyebrow); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('عنوان اصلی صفحه تماس:', 'market'); ?></label>
            <input type="text" name="_market_contact_title" value="<?php echo esc_attr($custom_title); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن توضیحات و معرفی پشتیبانی:', 'market'); ?></label>
            <textarea name="_market_contact_desc" rows="4" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($desc); ?></textarea>
        </div>

        <div style="margin-bottom: 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('عنوان دکمه تلگرام:', 'market'); ?></label>
                <input type="text" name="_market_contact_telegram_label" value="<?php echo esc_attr($telegram_label); ?>" style="width:100%; padding:8px;">
            </div>
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('لینک تلگرام (URL):', 'market'); ?></label>
                <input type="url" name="_market_contact_telegram_url" value="<?php echo esc_attr($telegram_url); ?>" style="width:100%; padding:8px;" dir="ltr">
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن ساعات پاسخگویی:', 'market'); ?></label>
            <input type="text" name="_market_contact_working_hours" value="<?php echo esc_attr($working_hours); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('تصویر دلخواه برای ستون پشتیبانی (اختیاری):', 'market'); ?></label>
            <input type="hidden" id="market_contact_image" name="_market_contact_image" value="<?php echo esc_attr($custom_image); ?>">
            <button type="button" class="button" id="market_upload_contact_img_btn"><?php esc_html_e('انتخاب تصویر از رسانه', 'market'); ?></button>
            <button type="button" class="button" id="market_remove_contact_img_btn" style="<?php echo empty($custom_image) ? 'display:none;' : ''; ?>"><?php esc_html_e('حذف تصویر', 'market'); ?></button>
            <img id="market_contact_img_preview" src="<?php echo esc_url($custom_image); ?>" style="max-width:140px; display:<?php echo empty($custom_image) ? 'none' : 'block'; ?>; margin-top:8px; border:1px solid #ccc; padding:4px; border-radius:6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('موضوعات فرم تماس (هر سطر یک مورد):', 'market'); ?></label>
            <textarea name="_market_contact_subjects" rows="4" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($subjects); ?></textarea>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن دکمه ارسال فرم:', 'market'); ?></label>
            <input type="text" name="_market_contact_submit_text" value="<?php echo esc_attr($submit_text); ?>" style="width:200px; padding:8px;">
        </div>
    </div>

    <script>
    jQuery(document).ready(function($){
        var frame;
        $('#market_upload_contact_img_btn').on('click', function(e){
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'انتخاب تصویر صفحه تماس', button: { text: 'استفاده از این تصویر' }, multiple: false });
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
 * 5. Render FAQ Page Meta Box (Questions & Answers Repeater)
 */
function market_render_faq_page_metabox($post) {
    wp_nonce_field('market_save_faq_page_meta', 'market_faq_page_nonce');

    $eyebrow      = get_post_meta($post->ID, '_market_faq_eyebrow', true);
    $custom_title = get_post_meta($post->ID, '_market_faq_title', true);
    $desc         = get_post_meta($post->ID, '_market_faq_desc', true);

    $banner_badge = get_post_meta($post->ID, '_market_faq_banner_badge', true);
    $banner_title = get_post_meta($post->ID, '_market_faq_banner_title', true);
    $banner_desc  = get_post_meta($post->ID, '_market_faq_banner_desc', true);
    $banner_btn   = get_post_meta($post->ID, '_market_faq_banner_btn_text', true);
    $banner_url   = get_post_meta($post->ID, '_market_faq_banner_btn_url', true);

    $faq_items    = get_post_meta($post->ID, '_market_faq_items', true);

    // Default Fallbacks
    if ($eyebrow === '') $eyebrow = 'رضایت شما اولویت ماست';
    if ($custom_title === '') $custom_title = 'سوالات متداول و راهنمای خرید';
    if ($desc === '') {
        $desc = "در این بخش تلاش کرده‌ایم به رایج‌ترین سوالات شما درباره فرآیند خرید، ارسال سفارش، ویژگی‌های محصولات و خدمات فروشگاه پاسخ دهیم تا تجربه خریدی ساده، سریع و مطمئن داشته باشید.\nهدف ما این است که پیش از ثبت سفارش، تمامی اطلاعات مورد نیاز در اختیار شما قرار گیرد تا با اطمینان کامل انتخاب کنید.";
    }

    if ($banner_badge === '') $banner_badge = 'هنوز سوالی دارید؟';
    if ($banner_title === '') $banner_title = 'ارتباط مستقیم با پشتیبانی';
    if ($banner_desc === '') {
        $banner_desc = 'اگر پاسخ سوال خود را در بخش سوالات متداول پیدا نکردید، نگران نباشید. تیم پشتیبانی ما همیشه آماده پاسخگویی به شماست. می‌توانید از طریق صفحه تماس با ما، سوالات، پیشنهادات یا مشکلات خود را با ما در میان بگذارید تا در کوتاه‌ترین زمان ممکن بررسی و پاسخ داده شود.';
    }
    if ($banner_btn === '') $banner_btn = 'راه‌های ارتباطی';
    if ($banner_url === '') $banner_url = home_url('/contact-us/');

    // Fallback items if none saved yet
    if (!is_array($faq_items) || empty($faq_items)) {
        $faq_items = market_get_default_faqs();
    }
    ?>
    <div class="market-faq-metabox-wrapper" dir="rtl" style="max-width: 960px;">

        <!-- تنظیمات سربرگ -->
        <h3 style="margin-top:0; border-bottom:2px solid #e52534; padding-bottom:8px; color:#18181b;">
            <?php esc_html_e('۱. متون سربرگ صفحه سوالات متداول', 'market'); ?>
        </h3>
        
        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('پیش‌عنوان بالای تیتر:', 'market'); ?></label>
            <input type="text" name="_market_faq_eyebrow" value="<?php echo esc_attr($eyebrow); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('عنوان اصلی صفحه:', 'market'); ?></label>
            <input type="text" name="_market_faq_title" value="<?php echo esc_attr($custom_title); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('توضیحات معرفی صفحه:', 'market'); ?></label>
            <textarea name="_market_faq_desc" rows="4" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($desc); ?></textarea>
        </div>

        <!-- بنر ارتباط مستقیم با پشتیبانی -->
        <h3 style="border-bottom:2px solid #e52534; padding-bottom:8px; color:#18181b;">
            <?php esc_html_e('۲. بنر میانی «ارتباط مستقیم با پشتیبانی»', 'market'); ?>
        </h3>

        <div style="margin-bottom: 16px; display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن نشان بالای بنر:', 'market'); ?></label>
                <input type="text" name="_market_faq_banner_badge" value="<?php echo esc_attr($banner_badge); ?>" style="width:100%; padding:8px;">
            </div>
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('تیتر اصلی بنر:', 'market'); ?></label>
                <input type="text" name="_market_faq_banner_title" value="<?php echo esc_attr($banner_title); ?>" style="width:100%; padding:8px;">
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن توضیحات بنر:', 'market'); ?></label>
            <textarea name="_market_faq_banner_desc" rows="3" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($banner_desc); ?></textarea>
        </div>

        <div style="margin-bottom: 24px; display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن دکمه بنر:', 'market'); ?></label>
                <input type="text" name="_market_faq_banner_btn_text" value="<?php echo esc_attr($banner_btn); ?>" style="width:100%; padding:8px;">
            </div>
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('لینک دکمه بنر (URL):', 'market'); ?></label>
                <input type="text" name="_market_faq_banner_btn_url" value="<?php echo esc_attr($banner_url); ?>" style="width:100%; padding:8px;" dir="ltr">
            </div>
        </div>

        <!-- مدیریت سوال و جواب‌ها -->
        <h3 style="border-bottom:2px solid #e52534; padding-bottom:8px; color:#18181b; display:flex; justify-content:space-between; align-items:center;">
            <span><?php esc_html_e('۳. لیست پرسش‌ها و پاسخ‌ها', 'market'); ?></span>
            <button type="button" class="button button-primary" id="market_add_faq_row_btn">
                <?php esc_html_e('+ افزودن پرسش جدید', 'market'); ?>
            </button>
        </h3>

        <div id="market_faq_repeater_container" style="display:flex; flex-direction:column; gap:16px;">
            <?php foreach ($faq_items as $index => $item) : ?>
                <div class="market-faq-row" style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:16px; position:relative;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                        <span style="font-weight:700; color:#4b5563;">
                            <?php echo sprintf(esc_html__('پرسش شماره %d', 'market'), $index + 1); ?>
                        </span>
                        <div>
                            <label style="font-size:12px; font-weight:600; margin-left:8px;"><?php esc_html_e('بخش نمایش:', 'market'); ?></label>
                            <select name="_market_faq_group[]" style="font-size:12px; padding:4px 8px;">
                                <option value="group_1" <?php selected($item['group'] ?? '', 'group_1'); ?>><?php esc_html_e('گروه اول (سفارش و ارسال)', 'market'); ?></option>
                                <option value="group_2_right" <?php selected($item['group'] ?? '', 'group_2_right'); ?>><?php esc_html_e('گروه دوم - راست (اصالت و مشخصات)', 'market'); ?></option>
                                <option value="group_2_left" <?php selected($item['group'] ?? '', 'group_2_left'); ?>><?php esc_html_e('گروه دوم - چپ (گارانتی و خدمات)', 'market'); ?></option>
                                <option value="group_3" <?php selected($item['group'] ?? '', 'group_3'); ?>><?php esc_html_e('گروه سوم (مشاوره عکاسی و انتخاب)', 'market'); ?></option>
                            </select>
                            <button type="button" class="button button-link-delete market-remove-faq-btn" style="margin-right:12px; color:#dc2626;">
                                <?php esc_html_e('حذف', 'market'); ?>
                            </button>
                        </div>
                    </div>

                    <div style="margin-bottom:8px;">
                        <input type="text" name="_market_faq_question[]" value="<?php echo esc_attr($item['question'] ?? ''); ?>" placeholder="<?php esc_attr_e('متن پرسش را وارد کنید...', 'market'); ?>" style="width:100%; font-weight:700; padding:8px;">
                    </div>

                    <div>
                        <textarea name="_market_faq_answer[]" rows="3" placeholder="<?php esc_attr_e('متن پاسخ را وارد کنید...', 'market'); ?>" style="width:100%; padding:8px; line-height:1.6;"><?php echo esc_textarea($item['answer'] ?? ''); ?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Template for new row -->
    <script type="text/html" id="tmpl-market-faq-row">
        <div class="market-faq-row" style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:16px; position:relative;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="font-weight:700; color:#4b5563;"><?php esc_html_e('پرسش جدید', 'market'); ?></span>
                <div>
                    <label style="font-size:12px; font-weight:600; margin-left:8px;"><?php esc_html_e('بخش نمایش:', 'market'); ?></label>
                    <select name="_market_faq_group[]" style="font-size:12px; padding:4px 8px;">
                        <option value="group_1"><?php esc_html_e('گروه اول (سفارش و ارسال)', 'market'); ?></option>
                        <option value="group_2_right"><?php esc_html_e('گروه دوم - راست (اصالت و مشخصات)', 'market'); ?></option>
                        <option value="group_2_left"><?php esc_html_e('گروه دوم - چپ (گارانتی و خدمات)', 'market'); ?></option>
                        <option value="group_3"><?php esc_html_e('گروه سوم (مشاوره عکاسی و انتخاب)', 'market'); ?></option>
                    </select>
                    <button type="button" class="button button-link-delete market-remove-faq-btn" style="margin-right:12px; color:#dc2626;">
                        <?php esc_html_e('حذف', 'market'); ?>
                    </button>
                </div>
            </div>

            <div style="margin-bottom:8px;">
                <input type="text" name="_market_faq_question[]" value="" placeholder="<?php esc_attr_e('متن پرسش را وارد کنید...', 'market'); ?>" style="width:100%; font-weight:700; padding:8px;">
            </div>

            <div>
                <textarea name="_market_faq_answer[]" rows="3" placeholder="<?php esc_attr_e('متن پاسخ را وارد کنید...', 'market'); ?>" style="width:100%; padding:8px; line-height:1.6;"></textarea>
            </div>
        </div>
    </script>

    <script>
    jQuery(document).ready(function($){
        $('#market_add_faq_row_btn').on('click', function(){
            var template = $('#tmpl-market-faq-row').html();
            $('#market_faq_repeater_container').append(template);
        });

        $(document).on('click', '.market-remove-faq-btn', function(){
            $(this).closest('.market-faq-row').fadeOut(200, function(){
                $(this).remove();
            });
        });
    });
    </script>
    <?php
}

/**
 * 6. Render Complaints & Suggestions Page Meta Box
 */
function market_render_complaints_page_metabox($post) {
    wp_nonce_field('market_save_complaints_page_meta', 'market_complaints_page_nonce');

    $eyebrow        = get_post_meta($post->ID, '_market_complaints_eyebrow', true);
    $custom_title   = get_post_meta($post->ID, '_market_complaints_title', true);
    $desc           = get_post_meta($post->ID, '_market_complaints_desc', true);
    $subjects       = get_post_meta($post->ID, '_market_complaints_subjects', true);
    $referral_title = get_post_meta($post->ID, '_market_complaints_referral_title', true);
    $referrals      = get_post_meta($post->ID, '_market_complaints_referrals', true);
    $submit_text    = get_post_meta($post->ID, '_market_complaints_submit_text', true);
    $success_msg    = get_post_meta($post->ID, '_market_complaints_success_msg', true);

    if ($eyebrow === '') $eyebrow = 'نظرات شما، مسیر پیشرفت ما را روشن‌تر می‌کند.';
    if ($custom_title === '') $custom_title = 'پیشنهادات و انتقادات';
    if ($desc === '') $desc = 'از اینکه دیدگاه خود را با ما به اشتراک می‌گذارید، سپاسگزاریم. اگر پیشنهادی برای بهبود خدمات، تجربه خرید یا عملکرد وب‌سایت دارید، یا در هر مرحله‌ای از خرید با مشکلی مواجه شده‌اید، خوشحال می‌شویم آن را با ما در میان بگذارید. نظرات شما به ما کمک می‌کند تا هر روز خدمات بهتری به شما ارائه دهیم.';
    if ($subjects === '') {
        $subjects = "پیشنهاد برای بهبود خدمات\nانتقاد از نحوه ارسال یا بسته‌بندی\nانتقاد از عملکرد وب‌سایت یا اپلیکیشن\nکیفیت یا قیمت محصولات\nسایر موضوعات و پیشنهادات";
    }
    if ($referral_title === '') $referral_title = 'چگونه با ما آشنا شدید؟';
    if ($referrals === '') {
        $referrals = "موتورهای جستجو (Google)\nشبکه‌های اجتماعی\nمعرفی مشتریان قبلی\nسایر";
    }
    if ($submit_text === '') $submit_text = 'ارسال';
    if ($success_msg === '') $success_msg = 'پیام و دیدگاه ارزشمند شما با موفقیت ثبت شد و در اسرع وقت بررسی خواهد شد. سپاس از همراهی شما.';
    ?>
    <div class="market-content-metabox-wrapper" dir="rtl" style="max-width: 900px;">
        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('پیش‌عنوان بالای تیتر صفحه:', 'market'); ?></label>
            <input type="text" name="_market_complaints_eyebrow" value="<?php echo esc_attr($eyebrow); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('عنوان اصلی صفحه:', 'market'); ?></label>
            <input type="text" name="_market_complaints_title" value="<?php echo esc_attr($custom_title); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن توضیحات معرفی و مقدمه:', 'market'); ?></label>
            <textarea name="_market_complaints_desc" rows="4" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($desc); ?></textarea>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('گزینه‌های موضوع فرم (هر گزینه در یک سطر):', 'market'); ?></label>
            <textarea name="_market_complaints_subjects" rows="5" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($subjects); ?></textarea>
            <p class="description" style="margin-top:4px; color:#71717a;"><?php esc_html_e('این موارد در لیست کشویی انتخاب موضوع به کاربر نمایش داده می‌شوند.', 'market'); ?></p>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('عنوان سوال نحوه آشنایی:', 'market'); ?></label>
            <input type="text" name="_market_complaints_referral_title" value="<?php echo esc_attr($referral_title); ?>" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('گزینه‌های سوال نحوه آشنایی (هر گزینه در یک سطر برای دکمه‌های رادیویی):', 'market'); ?></label>
            <textarea name="_market_complaints_referrals" rows="4" style="width:100%; padding:8px; line-height:1.7;"><?php echo esc_textarea($referrals); ?></textarea>
        </div>

        <div style="margin-bottom: 16px; display:grid; grid-template-columns: 200px 1fr; gap: 16px;">
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('متن دکمه ارسال فرم:', 'market'); ?></label>
                <input type="text" name="_market_complaints_submit_text" value="<?php echo esc_attr($submit_text); ?>" style="width:100%; padding:8px;">
            </div>
            <div>
                <label style="display:block; font-weight:700; margin-bottom:4px;"><?php esc_html_e('پیام موفقیت پس از ثبت فرم:', 'market'); ?></label>
                <input type="text" name="_market_complaints_success_msg" value="<?php echo esc_attr($success_msg); ?>" style="width:100%; padding:8px;">
            </div>
        </div>
    </div>
    <?php
}

/**
 * 7. Save Content Page Meta Box Data (Contact, FAQ & Complaints)
 */
function market_save_content_page_metaboxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_page', $post_id)) return;

    // 1. Save Contact Meta
    if (isset($_POST['market_content_page_nonce']) && wp_verify_nonce($_POST['market_content_page_nonce'], 'market_save_content_page_meta')) {
        $contact_fields = [
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

        foreach ($contact_fields as $key => $sanitizer) {
            if (isset($_POST[$key])) {
                $val = call_user_func($sanitizer, $_POST[$key]);
                update_post_meta($post_id, $key, $val);
            } else {
                delete_post_meta($post_id, $key);
            }
        }
    }

    // 2. Save FAQ Meta
    if (isset($_POST['market_faq_page_nonce']) && wp_verify_nonce($_POST['market_faq_page_nonce'], 'market_save_faq_page_meta')) {
        $faq_fields = [
            '_market_faq_eyebrow'         => 'sanitize_text_field',
            '_market_faq_title'           => 'sanitize_text_field',
            '_market_faq_desc'            => 'sanitize_textarea_field',
            '_market_faq_banner_badge'    => 'sanitize_text_field',
            '_market_faq_banner_title'    => 'sanitize_text_field',
            '_market_faq_banner_desc'     => 'sanitize_textarea_field',
            '_market_faq_banner_btn_text' => 'sanitize_text_field',
            '_market_faq_banner_btn_url'  => 'esc_url_raw',
        ];

        foreach ($faq_fields as $key => $sanitizer) {
            if (isset($_POST[$key])) {
                $val = call_user_func($sanitizer, $_POST[$key]);
                update_post_meta($post_id, $key, $val);
            } else {
                delete_post_meta($post_id, $key);
            }
        }

        // Save FAQ items array
        if (isset($_POST['_market_faq_question']) && is_array($_POST['_market_faq_question'])) {
            $questions = $_POST['_market_faq_question'];
            $answers   = $_POST['_market_faq_answer'] ?? [];
            $groups    = $_POST['_market_faq_group'] ?? [];

            $saved_items = [];
            for ($i = 0; $i < count($questions); $i++) {
                $q = sanitize_text_field($questions[$i]);
                $a = sanitize_textarea_field($answers[$i] ?? '');
                $g = sanitize_text_field($groups[$i] ?? 'group_1');

                if (!empty($q)) {
                    $saved_items[] = [
                        'question' => $q,
                        'answer'   => $a,
                        'group'    => $g,
                    ];
                }
            }
            update_post_meta($post_id, '_market_faq_items', $saved_items);
        } else {
            delete_post_meta($post_id, '_market_faq_items');
        }
    }

    // 3. Save Complaints & Suggestions Meta
    if (isset($_POST['market_complaints_page_nonce']) && wp_verify_nonce($_POST['market_complaints_page_nonce'], 'market_save_complaints_page_meta')) {
        $complaint_fields = [
            '_market_complaints_eyebrow'        => 'sanitize_text_field',
            '_market_complaints_title'          => 'sanitize_text_field',
            '_market_complaints_desc'           => 'sanitize_textarea_field',
            '_market_complaints_subjects'       => 'sanitize_textarea_field',
            '_market_complaints_referral_title' => 'sanitize_text_field',
            '_market_complaints_referrals'      => 'sanitize_textarea_field',
            '_market_complaints_submit_text'    => 'sanitize_text_field',
            '_market_complaints_success_msg'    => 'sanitize_text_field',
        ];

        foreach ($complaint_fields as $key => $sanitizer) {
            if (isset($_POST[$key])) {
                $val = call_user_func($sanitizer, $_POST[$key]);
                update_post_meta($post_id, $key, $val);
            } else {
                delete_post_meta($post_id, $key);
            }
        }
    }
}
add_action('save_post_page', 'market_save_content_page_metaboxes');
