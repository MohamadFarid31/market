<?php
/**
 * Market Theme — 404 Error Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main error-404-main">
    <div class="container">
        <?php
        get_template_part('template-parts/common/empty-state', null, [
            'title'       => esc_html__('صفحه مورد نظر پیدا نشد (خطای ۴۰۴)', 'market'),
            'description' => esc_html__('صفحه‌ای که به دنبال آن بودید ممکن است حذف شده باشد یا آدرس آن تغییر کرده باشد.', 'market'),
            'cta_text'    => esc_html__('بازگشت به صفحه اصلی', 'market'),
            'cta_url'     => home_url('/'),
        ]);
        ?>
    </div>
</main>

<?php
get_footer();
