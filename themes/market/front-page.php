<?php
/**
 * Market Theme — Homepage Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main front-page-main">
    <div class="container">
        <!-- Hero Section Placeholder for Design Reference -->
        <section class="hero-slider-section" aria-label="<?php esc_attr_e('بنر اصلی', 'market'); ?>">
            <div class="card p-6" style="background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-xl); padding: var(--space-8); text-align: center;">
                <h1 style="color: var(--color-primary); margin-block-end: var(--space-2);"><?php bloginfo('name'); ?></h1>
                <p style="color: var(--color-text-secondary); max-width: 600px; margin-inline: auto;"><?php bloginfo('description'); ?></p>
            </div>
        </section>

        <!-- Featured / Latest Products Section -->
        <?php if (class_exists('WooCommerce')) : ?>
            <section class="product-carousel-section" aria-label="<?php esc_attr_e('جدیدترین محصولات', 'market'); ?>">
                <div class="section-header">
                    <h2 class="section-title"><?php esc_html_e('جدیدترین محصولات', 'market'); ?></h2>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="section-more-link">
                        <?php esc_html_e('مشاهده همه', 'market'); ?> <span class="icon-directional">&larr;</span>
                    </a>
                </div>

                <?php
                $recent_products = wc_get_products([
                    'limit'   => 4,
                    'status'  => 'publish',
                    'orderby' => 'date',
                    'order'   => 'DESC',
                ]);

                if (!empty($recent_products)) :
                    ?>
                    <div class="products-grid">
                        <?php
                        foreach ($recent_products as $product_item) :
                            $post_object = get_post($product_item->get_id());
                            setup_postdata($GLOBALS['post'] =& $post_object);
                            get_template_part('template-parts/product/card');
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php else : ?>
                    <?php
                    get_template_part('template-parts/common/empty-state', null, [
                        'title'       => esc_html__('محصولی برای نمایش وجود ندارد', 'market'),
                        'description' => esc_html__('به زودی محصولات جدید به فروشگاه اضافه خواهند شد.', 'market'),
                    ]);
                    ?>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <!-- Recent Blog Posts Section -->
        <?php
        $recent_posts = new WP_Query([
            'posts_per_page'      => 3,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'no_found_rows'       => true,
        ]);

        if ($recent_posts->have_posts()) :
            ?>
            <section class="recent-articles-section" style="margin-block-start: var(--space-12);" aria-label="<?php esc_attr_e('آخرین مقالات', 'market'); ?>">
                <div class="section-header">
                    <h2 class="section-title"><?php esc_html_e('آخرین مقالات وبلاگ', 'market'); ?></h2>
                </div>
                <div class="blog-posts-grid">
                    <?php
                    while ($recent_posts->have_posts()) :
                        $recent_posts->the_post();
                        get_template_part('template-parts/card/article-card');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
