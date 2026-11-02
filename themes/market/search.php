<?php
/**
 * Market Theme — Search Results Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main search-main">
    <div class="container">
        <header class="page-header" style="margin-block-end: var(--space-6);">
            <h1 class="page-title">
                <?php
                /* translators: %s: search query. */
                printf(esc_html__('نتایج جستجو برای: %s', 'market'), '<span style="color: var(--color-primary);">' . get_search_query() . '</span>');
                ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="products-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    if ('product' === get_post_type()) {
                        get_template_part('template-parts/product/card');
                    } else {
                        get_template_part('template-parts/card/article-card');
                    }
                endwhile;
                ?>
            </div>
            <?php get_template_part('template-parts/common/pagination'); ?>
        <?php else : ?>
            <?php
            get_template_part('template-parts/common/empty-state', null, [
                'title'       => esc_html__('هیچ نتیجه‌ای یافت نشد', 'market'),
                'description' => esc_html__('متأسفانه کلمه مورد نظر شما یافت نشد. لطفاً با عبارت دیگری جستجو کنید.', 'market'),
            ]);
            ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
