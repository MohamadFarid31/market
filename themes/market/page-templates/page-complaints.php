<?php
/**
 * Template Name: Complaints Page | پیشنهادات و انتقادات
 *
 * Faithful reproduction of Taj Bazar Suggestions & Criticisms page layout and styling.
 * All texts, labels, subject options, and referral options are fully editable from WordPress "Edit Page" screen.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

$post_id        = get_the_ID();
$eyebrow        = get_post_meta($post_id, '_market_complaints_eyebrow', true);
$custom_title   = get_post_meta($post_id, '_market_complaints_title', true);
$desc           = get_post_meta($post_id, '_market_complaints_desc', true);
$subjects_raw   = get_post_meta($post_id, '_market_complaints_subjects', true);
$referral_title = get_post_meta($post_id, '_market_complaints_referral_title', true);
$referrals_raw  = get_post_meta($post_id, '_market_complaints_referrals', true);
$submit_text    = get_post_meta($post_id, '_market_complaints_submit_text', true);
$success_msg    = get_post_meta($post_id, '_market_complaints_success_msg', true);

// Intelligent fallbacks
if (empty($eyebrow)) $eyebrow = esc_html__('نظرات شما، مسیر پیشرفت ما را روشن‌تر می‌کند.', 'market');
if (empty($custom_title)) $custom_title = get_the_title() ? get_the_title() : esc_html__('پیشنهادات و انتقادات', 'market');
if (empty($desc)) $desc = esc_html__('از اینکه دیدگاه خود را با ما به اشتراک می‌گذارید، سپاسگزاریم. اگر پیشنهادی برای بهبود خدمات، تجربه خرید یا عملکرد وب‌سایت دارید، یا در هر مرحله‌ای از خرید با مشکلی مواجه شده‌اید، خوشحال می‌شویم آن را با ما در میان بگذارید. نظرات شما به ما کمک می‌کند تا هر روز خدمات بهتری به شما ارائه دهیم.', 'market');
if (empty($referral_title)) $referral_title = esc_html__('چگونه با ما آشنا شدید؟', 'market');
if (empty($submit_text)) $submit_text = esc_html__('ارسال', 'market');
if (empty($success_msg)) $success_msg = esc_html__('پیام و دیدگاه ارزشمند شما با موفقیت ثبت شد و در اسرع وقت بررسی خواهد شد. سپاس از همراهی شما.', 'market');

// Parse subjects list
$subjects_list = [];
if (!empty($subjects_raw)) {
    $lines = preg_split('/\r\n|\r|\n/', $subjects_raw);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (!empty($trimmed)) {
            $subjects_list[] = $trimmed;
        }
    }
}
if (empty($subjects_list)) {
    $subjects_list = [
        'پیشنهاد برای بهبود خدمات',
        'انتقاد از نحوه ارسال یا بسته‌بندی',
        'انتقاد از عملکرد وب‌سایت یا اپلیکیشن',
        'کیفیت یا قیمت محصولات',
        'سایر موضوعات و پیشنهادات',
    ];
}

// Parse referral radio options
$referrals_list = [];
if (!empty($referrals_raw)) {
    $lines = preg_split('/\r\n|\r|\n/', $referrals_raw);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (!empty($trimmed)) {
            $referrals_list[] = $trimmed;
        }
    }
}
if (empty($referrals_list)) {
    $referrals_list = [
        'موتورهای جستجو (Google)',
        'شبکه‌های اجتماعی',
        'معرفی مشتریان قبلی',
        'سایر',
    ];
}

$is_success = isset($_GET['complaint']) && $_GET['complaint'] === 'success';
?>

<main id="primary" class="site-main complaints-page-main">
    <div class="container complaints-container">

        <!-- بخش سربرگ (Eyebrow + عنوان + توضیحات) -->
        <header class="complaints-header">
            <span class="complaints-eyebrow">
                <?php echo esc_html($eyebrow); ?>
            </span>

            <h1 class="complaints-main-title">
                <?php echo esc_html($custom_title); ?>
            </h1>

            <p class="complaints-desc">
                <?php echo nl2br(esc_html($desc)); ?>
            </p>
        </header>

        <!-- فرم پیشنهادات و انتقادات -->
        <div class="complaints-form-container">
            <?php if ($is_success) : ?>
                <div class="contact-alert-success" role="alert">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span><?php echo esc_html($success_msg); ?></span>
                </div>
            <?php endif; ?>

            <form class="taj-complaints-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('market_complaint_form', 'market_complaint_nonce'); ?>
                <input type="hidden" name="action" value="market_complaint_submit">

                <!-- ردیف ۱: نام و نام خانوادگی + ایمیل -->
                <div class="taj-form-row">
                    <div class="taj-form-col">
                        <div class="taj-form-group">
                            <label class="taj-form-label" for="complaint-name"><?php esc_html_e('نام و نام خانوادگی', 'market'); ?> *</label>
                            <input type="text" id="complaint-name" name="complaint_name" class="taj-contact-input" required>
                        </div>
                    </div>
                    <div class="taj-form-col">
                        <div class="taj-form-group">
                            <label class="taj-form-label" for="complaint-email"><?php esc_html_e('ایمیل', 'market'); ?> *</label>
                            <input type="email" id="complaint-email" name="complaint_email" class="taj-contact-input ltr-input" required dir="ltr">
                        </div>
                    </div>
                </div>

                <!-- ردیف ۲: شماره تماس + موضوع -->
                <div class="taj-form-row">
                    <div class="taj-form-col">
                        <div class="taj-form-group">
                            <label class="taj-form-label" for="complaint-phone"><?php esc_html_e('شماره تماس', 'market'); ?> *</label>
                            <input type="tel" id="complaint-phone" name="complaint_phone" class="taj-contact-input ltr-input" placeholder="09xxxxxxxxx" required dir="ltr">
                        </div>
                    </div>
                    <div class="taj-form-col">
                        <div class="taj-form-group">
                            <label class="taj-form-label" for="complaint-subject"><?php esc_html_e('موضوع', 'market'); ?> *</label>
                            <div class="taj-select-wrap">
                                <select id="complaint-subject" name="complaint_subject" class="taj-contact-select" required>
                                    <option value="" disabled selected><?php esc_html_e('انتخاب موضوع', 'market'); ?></option>
                                    <?php foreach ($subjects_list as $subject_opt) : ?>
                                        <option value="<?php echo esc_attr($subject_opt); ?>"><?php echo esc_html($subject_opt); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ردیف ۳: چگونه با ما آشنا شدید؟ (رادیو باتن‌های تاج بازار) -->
                <div class="taj-form-group taj-radio-group-wrap">
                    <label class="taj-form-label"><?php echo esc_html($referral_title); ?></label>
                    <div class="taj-radio-options-row">
                        <?php foreach ($referrals_list as $index => $ref_opt) : 
                            $ref_id = 'complaint-ref-' . $index;
                        ?>
                            <label class="taj-radio-label" for="<?php echo esc_attr($ref_id); ?>">
                                <input type="radio" id="<?php echo esc_attr($ref_id); ?>" name="complaint_referral" value="<?php echo esc_attr($ref_opt); ?>" class="taj-radio-input" <?php checked($index, 0); ?>>
                                <span class="taj-radio-custom" aria-hidden="true"></span>
                                <span class="taj-radio-text"><?php echo esc_html($ref_opt); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ردیف ۴: توضیحات کامل -->
                <div class="taj-form-group">
                    <label class="taj-form-label" for="complaint-details"><?php esc_html_e('توضیحات', 'market'); ?> *</label>
                    <textarea id="complaint-details" name="complaint_details" class="taj-contact-textarea" rows="6" placeholder="<?php esc_attr_e('توضیحات خود را در این قسمت وارد کنید', 'market'); ?>" required></textarea>
                </div>

                <!-- ردیف ۵: دکمه ارسال تمام‌عرض قرمز -->
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
