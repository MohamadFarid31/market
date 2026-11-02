<?php
/**
 * Market Theme — Blog Archive Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main blog-index-main">
    <div class="container">
        <header class="page-header" style="margin-block-end: var(--space-6);">
            <h1 class="page-title"><?php single_post_title(); ?></h1>
        </header>

        <div class="blog-layout">
            <div class="blog-content-area">
                <?php if (have_posts()) : ?>
                    <div class="blog-posts-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/card/article-card');
                        endwhile;
                        ?>
                    </div>
                    <?php get_template_part('template-parts/common/pagination'); ?>
                <?php else : ?>
                    <?php get_template_part('template-parts/common/empty-state'); ?>
                <?php endif; ?>
            </div>

            <?php if (is_active_sidebar('sidebar-blog')) : ?>
                <aside class="blog-sidebar">
                    <?php dynamic_sidebar('sidebar-blog'); ?>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
get_footer();
