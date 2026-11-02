<?php
/**
 * Template Name: FAQ Page | سوالات متداول
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main faq-page-main">
    <div class="container container-narrow">
        <header class="page-header text-center" style="margin-block-end: var(--space-8); text-align: center;">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p style="color: var(--color-text-secondary); max-width: 520px; margin-inline: auto;">
                <?php esc_html_e('پاسخ پرسش‌های پرتکرار خود را در این بخش بیابید.', 'market'); ?>
            </p>
        </header>

        <div class="faq-list">
            <details class="faq-item">
                <summary>
                    <span><?php esc_html_e('نحوه ثبت سفارش در سایت چگونه است؟', 'market'); ?></span>
                    <span class="icon-directional">&darr;</span>
                </summary>
                <div class="faq-answer">
                    <?php esc_html_e('کالای مورد نظر خود را به سبد خرید اضافه کرده و مراحل پرداخت را طبق راهنما تکمیل فرمایید.', 'market'); ?>
                </div>
            </details>

            <details class="faq-item">
                <summary>
                    <span><?php esc_html_e('مدت زمان تحویل کالا چقدر است؟', 'market'); ?></span>
                    <span class="icon-directional">&darr;</span>
                </summary>
                <div class="faq-answer">
                    <?php esc_html_e('ارسال در تهران در همان روز یا روز بعد و برای شهرستان‌ها بین ۲ تا ۴ روز کاری از طریق پست یا تیپاکس انجام می‌شود.', 'market'); ?>
                </div>
            </details>

            <details class="faq-item">
                <summary>
                    <span><?php esc_html_e('شرایط مرجوعی کالا به چه صورت است؟', 'market'); ?></span>
                    <span class="icon-directional">&darr;</span>
                </summary>
                <div class="faq-answer">
                    <?php esc_html_e('تا ۷ روز پس از دریافت سفارش در صورت عدم استفاده و سلامت بسته‌بندی، امکان مرجوعی کالا وجود دارد.', 'market'); ?>
                </div>
            </details>
        </div>

        <?php if (have_posts()) : ?>
            <div class="page-content" style="margin-block-start: var(--space-8);">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
