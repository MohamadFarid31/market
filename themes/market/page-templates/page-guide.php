<?php
/**
 * Template Name: Order Guide | راهنمای خرید و ثبت سفارش
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main guide-page-main">
    <div class="container">
        <header class="page-header text-center" style="margin-block-end: var(--space-8); text-align: center;">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p style="color: var(--color-text-secondary); max-width: 600px; margin-inline: auto;">
                <?php esc_html_e('مراحل ساده خرید آنلاین از انتخاب محصول تا تحویل درب منزل.', 'market'); ?>
            </p>
        </header>

        <div class="stepper-flow">
            <div class="stepper-card">
                <div class="stepper-number">۱</div>
                <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: var(--space-2);">
                    <?php esc_html_e('انتخاب محصول', 'market'); ?>
                </h3>
                <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;">
                    <?php esc_html_e('کالای مورد نظر خود را جستجو و بررسی کرده و به سبد خرید اضافه کنید.', 'market'); ?>
                </p>
            </div>

            <div class="stepper-card">
                <div class="stepper-number">۲</div>
                <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: var(--space-2);">
                    <?php esc_html_e('تکمیل سبد و آدرس', 'market'); ?>
                </h3>
                <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;">
                    <?php esc_html_e('نشانی تحویل گیرنده و شیوه ارسال مورد نظر خود را مشخص کنید.', 'market'); ?>
                </p>
            </div>

            <div class="stepper-card">
                <div class="stepper-number">۳</div>
                <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: var(--space-2);">
                    <?php esc_html_e('پرداخت امن اینترنتی', 'market'); ?>
                </h3>
                <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;">
                    <?php esc_html_e('از طریق درگاه‌های شاپرک بانکی هزینه سفارش را پرداخت نمایید.', 'market'); ?>
                </p>
            </div>

            <div class="stepper-card">
                <div class="stepper-number">۴</div>
                <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: var(--space-2);">
                    <?php esc_html_e('دریافت کالا', 'market'); ?>
                </h3>
                <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;">
                    <?php esc_html_e('سفارش در کوتاه‌ترین زمان ممکن بسته‌بندی و تحویل داده می‌شود.', 'market'); ?>
                </p>
            </div>
        </div>

        <?php if (have_posts()) : ?>
            <div class="page-content card p-6" style="margin-block-start: var(--space-10); background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-xl); padding: var(--space-6);">
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
