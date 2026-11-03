<?php
/**
 * Template Name: Contact Page | تماس با ما
 *
 * Faithful recreation of Taj Bazar's contact page layout and styling.
 * All texts, labels, working hours, and subjects are fully editable from WordPress "Edit Page" screen.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

$post_id        = get_the_ID();
$eyebrow        = get_post_meta($post_id, '_market_contact_eyebrow', true);
$custom_title   = get_post_meta($post_id, '_market_contact_title', true);
$desc           = get_post_meta($post_id, '_market_contact_desc', true);
$telegram_label = get_post_meta($post_id, '_market_contact_telegram_label', true);
$telegram_url   = get_post_meta($post_id, '_market_contact_telegram_url', true);
$working_hours  = get_post_meta($post_id, '_market_contact_working_hours', true);
$custom_image   = get_post_meta($post_id, '_market_contact_image', true);
$subjects_raw   = get_post_meta($post_id, '_market_contact_subjects', true);
$submit_text    = get_post_meta($post_id, '_market_contact_submit_text', true);

// Intelligent fallbacks
if (empty($eyebrow)) $eyebrow = esc_html__('همیشه آماده پاسخگویی و همراهی با شما هستیم', 'market');
if (empty($custom_title)) $custom_title = get_the_title() ? get_the_title() : esc_html__('تماس با ما', 'market');
if (empty($desc)) $desc = esc_html__('اگر درباره محصولات، ثبت سفارش، انتخاب تجهیزات عکاسی و فیلم‌برداری یا خدمات فروشگاه سؤال یا ابهامی دارید، تیم پشتیبانی ما آماده پاسخگویی به شماست. همچنین می‌توانید پیشنهادات، انتقادات یا درخواست‌های خود را از طریق فرم تماس برای ما ارسال کنید. کارشناسان ما در کوتاه‌ترین زمان ممکن پیام شما را بررسی کرده و پاسخ خواهند داد.', 'market');
if (empty($telegram_label)) $telegram_label = esc_html__('پشتیبانی تلگرام', 'market');
if (empty($telegram_url)) {
    $telegram_url = function_exists('market_get_option') ? market_get_option('telegram', 'https://t.me') : 'https://t.me';
}
if (empty($working_hours)) $working_hours = esc_html__('ساعات پاسخگویی: شنبه الی پنجشنبه ساعت 09:00 الی 21:00', 'market');
if (empty($submit_text)) $submit_text = esc_html__('ارسال', 'market');

// Parse subjects list
$subject_options = [];
if (!empty($subjects_raw)) {
    $lines = preg_split('/\r\n|\r|\n/', $subjects_raw);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (!empty($trimmed)) {
            $subject_options[] = $trimmed;
        }
    }
}
if (empty($subject_options)) {
    $subject_options = [
        'پیگیری سفارش',
        'مشاوره قبل از خرید',
        'خدمات پس از فروش و گارانتی',
        'پیشنهادات و انتقادات',
        'سایر موضوعات',
    ];
}

$is_success = isset($_GET['contact']) && $_GET['contact'] === 'success';
?>

<main id="primary" class="site-main contact-page-main">
    <div class="container contact-container">

        <!-- ۱. بخش معرفی و اطلاعات تماس بالا (متن در راست، تصویر برداری در چپ دسکتاپ) -->
        <div class="contact-intro-grid">
            
            <div class="contact-intro-content">
                <span class="contact-eyebrow">
                    <?php echo esc_html($eyebrow); ?>
                </span>

                <h1 class="contact-main-title">
                    <?php echo esc_html($custom_title); ?>
                </h1>

                <p class="contact-intro-desc">
                    <?php echo nl2br(esc_html($desc)); ?>
                </p>

                <!-- باکس پشتیبانی تلگرام -->
                <div class="contact-telegram-wrap">
                    <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener noreferrer" class="contact-telegram-card" aria-label="<?php echo esc_attr($telegram_label); ?>">
                        <div class="telegram-icon-box">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </div>
                        <span class="telegram-title"><?php echo esc_html($telegram_label); ?></span>
                    </a>
                </div>

                <!-- ساعات پاسخگویی -->
                <div class="contact-hours-row">
                    <span class="hours-dot"></span>
                    <span class="hours-text">
                        <?php echo esc_html($working_hours); ?>
                    </span>
                </div>
            </div>

            <!-- تصویر پشتیبانی (تصویر آپلود شده یا وکتور اختصاصی SVG) -->
            <div class="contact-intro-illustration">
                <?php if (!empty($custom_image)) : ?>
                    <img src="<?php echo esc_url($custom_image); ?>" alt="<?php echo esc_attr($custom_title); ?>" class="contact-illustration-img">
                <?php else : ?>
                    <svg viewBox="0 0 400 340" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-illustration-svg" aria-hidden="true">
                        <!-- پس‌زمینه دایره‌ای ملایم -->
                        <circle cx="200" cy="170" r="140" fill="#e0f2fe" opacity="0.6"/>
                        <circle cx="120" cy="100" r="28" fill="#bae6fd" opacity="0.5"/>
                        <circle cx="290" cy="220" r="18" fill="#bae6fd" opacity="0.5"/>

                        <!-- حباب گفت‌وگو چپ (علامت سوال) -->
                        <g transform="translate(70, 45)">
                            <rect width="48" height="38" rx="14" fill="#ffffff" filter="drop-shadow(0 4px 10px rgba(0,0,0,0.06))"/>
                            <path d="M14 38L22 46V38H14Z" fill="#ffffff"/>
                            <text x="24" y="26" font-family="sans-serif" font-size="20" font-weight="bold" fill="#0284c7" text-anchor="middle">?</text>
                        </g>

                        <!-- حباب گفت‌وگو بالا (سه نقطه) -->
                        <g transform="translate(190, 20)">
                            <rect width="44" height="32" rx="12" fill="#ffffff" filter="drop-shadow(0 4px 10px rgba(0,0,0,0.06))"/>
                            <circle cx="14" cy="16" r="3" fill="#38bdf8"/>
                            <circle cx="22" cy="16" r="3" fill="#38bdf8"/>
                            <circle cx="30" cy="16" r="3" fill="#38bdf8"/>
                        </g>

                        <!-- حباب گفت‌وگو راست (تلفن) -->
                        <g transform="translate(255, 60)">
                            <circle cx="20" cy="20" r="20" fill="#ffffff" filter="drop-shadow(0 4px 10px rgba(0,0,0,0.06))"/>
                            <path d="M26 23v2a1.5 1.5 0 0 1-1.6 1.5 14 14 0 0 1-6.1-2.2 13.8 13.8 0 0 1-4.2-4.2 14 14 0 0 1-2.2-6.1A1.5 1.5 0 0 1 13.4 12h2a1.5 1.5 0 0 1 1.5 1.3c.1.7.3 1.4.6 2a1.5 1.5 0 0 1-.3 1.5l-.8.8a11.3 11.3 0 0 0 4.2 4.2l.8-.8a1.5 1.5 0 0 1 1.5-.3c.6.3 1.3.5 2 .6a1.5 1.5 0 0 1 1.3 1.5z" stroke="#0284c7" stroke-width="1.6" fill="none"/>
                        </g>

                        <!-- کاراکتر پشتیبان با هدفون -->
                        <path d="M120 220C110 180 120 120 180 100C240 80 270 130 260 190C240 195 230 230 230 250C190 260 140 250 120 220Z" fill="#1e293b"/>
                        <path d="M185 185V215H215V185H185Z" fill="#fed7aa"/>
                        <path d="M170 145C170 175 180 195 200 195C220 195 230 175 230 145C230 120 220 110 200 110C180 110 170 120 170 145Z" fill="#ffedd5"/>
                        <circle cx="170" cy="155" r="7" fill="#fed7aa"/>
                        
                        <!-- هدست -->
                        <path d="M166 145C166 115 180 100 200 100C220 100 234 115 234 145" stroke="#38bdf8" stroke-width="5" fill="none" stroke-linecap="round"/>
                        <rect x="162" y="145" width="8" height="20" rx="4" fill="#0284c7"/>
                        <rect x="230" y="145" width="8" height="20" rx="4" fill="#0284c7"/>
                        <path d="M166 160Q175 180 195 180" stroke="#0284c7" stroke-width="3" fill="none" stroke-linecap="round"/>
                        <circle cx="196" cy="180" r="3.5" fill="#1e293b"/>

                        <!-- لباس و شانه -->
                        <path d="M140 310C140 260 160 230 190 225C195 225 205 225 210 225C240 230 260 260 260 310H140Z" fill="#0284c7"/>
                        <path d="M185 225L200 265L215 225Z" fill="#ffffff"/>

                        <!-- گلدان سمت راست -->
                        <g transform="translate(265, 175)">
                            <path d="M18 60L10 105H46L38 60H18Z" fill="#f87171"/>
                            <circle cx="28" cy="40" r="16" fill="#34d399"/>
                            <circle cx="18" cy="25" r="14" fill="#10b981"/>
                            <circle cx="40" cy="28" r="15" fill="#059669"/>
                        </g>
                    </svg>
                <?php endif; ?>
            </div>

        </div>

        <!-- ۲. بخش فرم تماس با ما (فرم زیبا و شکیل زیر اطلاعات) -->
        <div class="contact-form-container">
            <?php if ($is_success) : ?>
                <div class="contact-alert-success">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span><?php esc_html_e('پیام شما با موفقیت ارسال شد. کارشناسان ما به زودی با شما تماس خواهند گرفت.', 'market'); ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="taj-contact-form">
                <?php wp_nonce_field('market_contact_form', 'market_contact_nonce'); ?>
                <input type="hidden" name="action" value="market_contact_submit">

                <!-- ردیف ۱: نام و نام خانوادگی -->
                <div class="taj-form-row">
                    <div class="taj-form-col">
                        <input type="text" name="contact_first_name" class="taj-contact-input" placeholder="<?php esc_attr_e('نام', 'market'); ?>" required>
                    </div>
                    <div class="taj-form-col">
                        <input type="text" name="contact_last_name" class="taj-contact-input" placeholder="<?php esc_attr_e('نام خانوادگی', 'market'); ?>" required>
                    </div>
                </div>

                <!-- ردیف ۲: شماره تماس و ایمیل -->
                <div class="taj-form-row">
                    <div class="taj-form-col">
                        <input type="tel" name="contact_phone" class="taj-contact-input" placeholder="<?php esc_attr_e('شماره تماس', 'market'); ?>" required>
                    </div>
                    <div class="taj-form-col">
                        <input type="email" name="contact_email" class="taj-contact-input" placeholder="<?php esc_attr_e('ایمیل', 'market'); ?>">
                    </div>
                </div>

                <!-- ردیف ۳: موضوع -->
                <div class="taj-form-group">
                    <label class="taj-form-label"><?php esc_html_e('موضوع', 'market'); ?></label>
                    <div class="taj-select-wrap">
                        <select name="contact_subject" class="taj-contact-select">
                            <?php foreach ($subject_options as $idx => $opt) : ?>
                                <option value="<?php echo esc_attr($opt); ?>" <?php selected($idx, 0); ?>>
                                    <?php echo esc_html($opt); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- ردیف ۴: توضیحات اضافی -->
                <div class="taj-form-group">
                    <textarea name="contact_message" class="taj-contact-textarea" rows="5" placeholder="<?php esc_attr_e('توضیحات اضافی', 'market'); ?>" required></textarea>
                </div>

                <!-- ردیف ۵: دکمه قرمز ارسال -->
                <div class="taj-form-submit-wrap">
                    <button type="submit" class="taj-contact-submit-btn">
                        <?php echo esc_html($submit_text); ?>
                    </button>
                </div>
            </form>
        </div>

    </div>
</main>

<?php
get_footer();
