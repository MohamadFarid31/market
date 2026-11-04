<?php
/**
 * Market Theme — Generic Archive Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main archive-main taj-blog-main">
    <div class="container">
        <header class="blog-archive-header taj-blog-header">
            <?php
            the_archive_title('<h1 class="blog-main-title">', '</h1>');
            the_archive_description('<p class="blog-subtitle">', '</p>');
            ?>
        </header>

        <div class="blog-layout taj-blog-layout">
            <div class="blog-content-area taj-article-container">
                <?php if (have_posts()) : ?>
                    <div class="blog-posts-grid taj-posts-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/card/article-card');
                        endwhile;
                        ?>
                    </div>
                    <div class="blog-pagination-wrap">
                        <?php get_template_part('template-parts/common/pagination'); ?>
                    </div>
                <?php else : ?>
                    <?php get_template_part('template-parts/common/empty-state'); ?>
                <?php endif; ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();
