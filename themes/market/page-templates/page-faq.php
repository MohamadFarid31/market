<?php
/**
 * Template Name: FAQ Page | سوالات متداول
 *
 * Faithful recreation of Taj Bazar's FAQ page layout, styling, and content.
 * Fully editable by admin from the "Edit Page" screen.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

$post_id      = get_the_ID();
$eyebrow      = get_post_meta($post_id, '_market_faq_eyebrow', true);
$custom_title = get_post_meta($post_id, '_market_faq_title', true);
$desc         = get_post_meta($post_id, '_market_faq_desc', true);

$banner_badge = get_post_meta($post_id, '_market_faq_banner_badge', true);
$banner_title = get_post_meta($post_id, '_market_faq_banner_title', true);
$banner_desc  = get_post_meta($post_id, '_market_faq_banner_desc', true);
$banner_btn   = get_post_meta($post_id, '_market_faq_banner_btn_text', true);
$banner_url   = get_post_meta($post_id, '_market_faq_banner_btn_url', true);

$faq_items    = get_post_meta($post_id, '_market_faq_items', true);

// Intelligent fallbacks
if (empty($eyebrow)) $eyebrow = esc_html__('رضایت شما اولویت ماست', 'market');
if (empty($custom_title)) $custom_title = esc_html__('سوالات متداول و راهنمای خرید', 'market');
if (empty($desc)) {
    $desc = "در این بخش تلاش کرده‌ایم به رایج‌ترین سوالات شما درباره فرآیند خرید، ارسال سفارش، ویژگی‌های محصولات و خدمات فروشگاه پاسخ دهیم تا تجربه خریدی ساده، سریع و مطمئن داشته باشید.\nهدف ما این است که پیش از ثبت سفارش، تمامی اطلاعات مورد نیاز در اختیار شما قرار گیرد تا با اطمینان کامل انتخاب کنید.";
}

if (empty($banner_badge)) $banner_badge = esc_html__('هنوز سوالی دارید؟', 'market');
if (empty($banner_title)) $banner_title = esc_html__('ارتباط مستقیم با پشتیبانی', 'market');
if (empty($banner_desc)) {
    $banner_desc = esc_html__('اگر پاسخ سوال خود را در بخش سوالات متداول پیدا نکردید، نگران نباشید. تیم پشتیبانی ما همیشه آماده پاسخگویی به شماست. می‌توانید از طریق صفحه تماس با ما، سوالات، پیشنهادات یا مشکلات خود را با ما در میان بگذارید تا در کوتاه‌ترین زمان ممکن بررسی و پاسخ داده شود.', 'market');
}
if (empty($banner_btn)) $banner_btn = esc_html__('راه‌های ارتباطی', 'market');
if (empty($banner_url)) $banner_url = home_url('/contact-us/');

if (!is_array($faq_items) || empty($faq_items)) {
    if (function_exists('market_get_default_faqs')) {
        $faq_items = market_get_default_faqs();
    } else {
        $faq_items = [];
    }
}

// Split items by group
$group_1 = [];
$group_2_right = [];
$group_2_left = [];
$group_3 = [];

foreach ($faq_items as $item) {
    $g = $item['group'] ?? 'group_1';
    if ($g === 'group_2_right') {
        $group_2_right[] = $item;
    } elseif ($g === 'group_2_left') {
        $group_2_left[] = $item;
    } elseif ($g === 'group_3') {
        $group_3[] = $item;
    } else {
        $group_1[] = $item;
    }
}
?>

<main id="primary" class="site-main faq-page-main">
    <div class="container faq-container">

        <!-- ۱. سربرگ صفحه سوالات متداول -->
        <header class="faq-header">
            <span class="faq-eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <h1 class="faq-main-title"><?php echo esc_html($custom_title); ?></h1>
            <p class="faq-desc"><?php echo nl2br(esc_html($desc)); ?></p>
        </header>

        <!-- ۲. گروه اول: سوالات فرآیند خرید و ارسال -->
        <?php if (!empty($group_1)) : ?>
            <div class="faq-section-block faq-group-1">
                <?php foreach ($group_1 as $idx => $item) : ?>
                    <details class="taj-faq-item" <?php echo ($idx === 0) ? 'open' : ''; ?>>
                        <summary class="faq-question">
                            <span><?php echo esc_html($item['question']); ?></span>
                            <span class="faq-chevron" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </span>
                        </summary>
                        <div class="faq-answer">
                            <p><?php echo nl2br(esc_html($item['answer'])); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- ۳. گروه دوم: اصالت، گارانتی، مشخصات (۲ ستونه در دسکتاپ) -->
        <?php if (!empty($group_2_right) || !empty($group_2_left)) : ?>
            <div class="faq-grid-2-col">
                <!-- ستون راست -->
                <div class="faq-col">
                    <?php foreach ($group_2_right as $idx => $item) : ?>
                        <details class="taj-faq-item" <?php echo ($idx === 0) ? 'open' : ''; ?>>
                            <summary class="faq-question">
                                <span><?php echo esc_html($item['question']); ?></span>
                                <span class="faq-chevron" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </span>
                            </summary>
                            <div class="faq-answer">
                                <p><?php echo nl2br(esc_html($item['answer'])); ?></p>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>

                <!-- ستون چپ -->
                <div class="faq-col">
                    <?php foreach ($group_2_left as $idx => $item) : ?>
                        <details class="taj-faq-item" <?php echo ($idx === 0) ? 'open' : ''; ?>>
                            <summary class="faq-question">
                                <span><?php echo esc_html($item['question']); ?></span>
                                <span class="faq-chevron" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </span>
                            </summary>
                            <div class="faq-answer">
                                <p><?php echo nl2br(esc_html($item['answer'])); ?></p>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ۴. بنر قرمز ارتباط مستقیم با پشتیبانی -->
        <div class="faq-support-banner">
            <span class="faq-banner-badge"><?php echo esc_html($banner_badge); ?></span>
            <h2 class="faq-banner-title"><?php echo esc_html($banner_title); ?></h2>
            <p class="faq-banner-desc"><?php echo esc_html($banner_desc); ?></p>
            <a href="<?php echo esc_url($banner_url); ?>" class="faq-banner-btn">
                <?php echo esc_html($banner_btn); ?>
            </a>
        </div>

        <!-- ۵. گروه سوم: مشاوره تخصصی عکاسی و انتخاب محصول -->
        <?php if (!empty($group_3)) : ?>
            <div class="faq-section-block faq-group-3">
                <?php foreach ($group_3 as $idx => $item) : ?>
                    <details class="taj-faq-item" <?php echo ($idx === 0) ? 'open' : ''; ?>>
                        <summary class="faq-question">
                            <span><?php echo esc_html($item['question']); ?></span>
                            <span class="faq-chevron" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </span>
                        </summary>
                        <div class="faq-answer">
                            <p><?php echo nl2br(esc_html($item['answer'])); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
