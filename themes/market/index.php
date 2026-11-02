<?php
/**
 * Market Theme — Main Template Fallback
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
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
</main>

<?php
get_footer();
