<?php
/**
 * Market Theme — Single Post Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main single-main">
    <div class="container">
        <div class="blog-layout">
            <div class="blog-content-area">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
                        <header class="single-post-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="article-card-meta">
                                <?php market_posted_on(); ?>
                                <span class="meta-separator">•</span>
                                <?php market_posted_by(); ?>
                                <span class="meta-separator">•</span>
                                <span class="article-category"><?php the_category(', '); ?></span>
                            </div>
                        </header>

                        <?php market_post_thumbnail('large'); ?>

                        <div class="single-post-content entry-content">
                            <?php
                            the_content();

                            wp_link_pages([
                                'before' => '<div class="page-links">' . esc_html__('صفحات:', 'market'),
                                'after'  => '</div>',
                            ]);
                            ?>
                        </div>

                        <footer class="entry-footer" style="margin-block-start: var(--space-8); padding-block-start: var(--space-4); border-block-start: 1px solid var(--color-border-subtle);">
                            <?php the_tags('<div class="post-tags"><span class="tags-title">' . esc_html__('برچسب‌ها: ', 'market') . '</span>', ' ', '</div>'); ?>
                        </footer>
                    </article>

                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile;
                ?>
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
