<?php
/**
 * Market Theme — Single Article Template (Taj Bazar Recreation)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();

    $post_id        = get_the_ID();
    $categories     = get_the_category();
    $category_name  = !empty($categories) ? $categories[0]->name : esc_html__('راهنمای خرید', 'market');
    $category_link  = !empty($categories) ? get_category_link($categories[0]->term_id) : '#';
    $comments_count = get_comments_number();

    $post_time   = get_the_time('U');
    $persian_date= function_exists('market_format_persian_date') ? market_format_persian_date($post_time, 'd-m-Y') : get_the_date('Y-m-d');
    $author_name = get_the_author();
    if (empty($author_name)) $author_name = 'MrHossein';

    // Query Related Posts
    $cat_ids = wp_list_pluck($categories, 'term_id');
    $related_query = new WP_Query([
        'post_type'           => 'post',
        'posts_per_page'      => 2,
        'post__not_in'        => [$post_id],
        'category__in'        => $cat_ids,
        'ignore_sticky_posts' => 1,
        'no_found_rows'       => true,
    ]);

    // Previous & Next Posts
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    $blog_url  = get_post_type_archive_link('post') ? get_post_type_archive_link('post') : home_url('/blog/');
    ?>

    <main id="primary" class="site-main single-main taj-single-main">
        <div class="container">
            <div class="blog-layout taj-blog-layout">

                <!-- ستون اصلی مقاله (سمت چپ در RTL) -->
                <div class="blog-content-area taj-article-container">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article taj-single-article'); ?>>

                        <!-- سربرگ مقاله: بج دسته‌بندی، تیتر، متادیتا -->
                        <header class="single-post-header taj-article-header">
                            <div class="article-badge-wrap">
                                <a href="<?php echo esc_url($category_link); ?>" class="article-badge-pill">
                                    <?php echo esc_html($category_name); ?>
                                </a>
                            </div>

                            <h1 class="entry-title taj-single-title"><?php the_title(); ?></h1>

                            <div class="taj-single-meta">
                                <span class="meta-comments-badge">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="#ef394e" stroke="#ef394e" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    <span class="count-num"><?php echo esc_html(function_exists('market_to_persian_numbers') ? market_to_persian_numbers($comments_count) : $comments_count); ?></span>
                                </span>

                                <span class="meta-author-date">
                                    <?php
                                    printf(
                                        /* translators: 1: author name, 2: date */
                                        esc_html__('ارسال توسط %1$s در %2$s', 'market'),
                                        '<strong class="author-name">' . esc_html($author_name) . '</strong>',
                                        '<span class="post-date">' . esc_html($persian_date) . '</span>'
                                    );
                                    ?>
                                </span>
                            </div>
                        </header>

                        <!-- تصویر شاخص -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="taj-single-thumb-wrap">
                                <?php the_post_thumbnail('large', ['class' => 'taj-single-thumb-img']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- متن اصلی مقاله -->
                        <div class="single-post-content entry-content taj-entry-content">
                            <?php
                            the_content();

                            wp_link_pages([
                                'before' => '<div class="page-links">' . esc_html__('صفحات:', 'market'),
                                'after'  => '</div>',
                            ]);
                            ?>
                        </div>

                        <!-- برچسب‌ها -->
                        <footer class="entry-footer taj-article-footer">
                            <div class="taj-post-tags">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="taj-tag-pill">' . esc_html($tag->name) . '</a>';
                                    }
                                } else {
                                    // Tag pills fallback
                                    echo '<span class="taj-tag-pill">' . esc_html__('تولید محتوا', 'market') . '</span>';
                                    echo '<span class="taj-tag-pill">' . esc_html__('دوربین عکاسی', 'market') . '</span>';
                                    echo '<span class="taj-tag-pill">' . esc_html__('دوربین فیلمبرداری', 'market') . '</span>';
                                    echo '<span class="taj-tag-pill">' . esc_html__('راهنمای خرید', 'market') . '</span>';
                                }
                                ?>
                            </div>

                            <!-- نوار ناوبری نوشته قبلی / بعدی و بازگشت به وبلاگ -->
                            <div class="taj-post-nav-bar">
                                <div class="nav-prev-link">
                                    <?php if (!empty($prev_post)) : ?>
                                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="taj-nav-arrow-btn" title="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                            <span><?php esc_html_e('قدیمی‌تر', 'market'); ?></span>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url($blog_url); ?>" class="taj-nav-arrow-btn">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                            <span><?php esc_html_e('قدیمی‌تر', 'market'); ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <div class="nav-grid-icon">
                                    <a href="<?php echo esc_url($blog_url); ?>" class="taj-grid-link-btn" aria-label="<?php esc_attr_e('بازگشت به وبلاگ', 'market'); ?>">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                    </a>
                                </div>

                                <div class="nav-next-link">
                                    <?php if (!empty($next_post)) : ?>
                                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="taj-nav-arrow-btn" title="<?php echo esc_attr(get_the_title($next_post->ID)); ?>">
                                            <span><?php esc_html_e('جدیدتر', 'market'); ?></span>
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </footer>

                    </article>

                    <!-- نوشته‌های مشابه -->
                    <section class="taj-related-posts-section" aria-label="<?php esc_attr_e('نوشته‌های مشابه', 'market'); ?>">
                        <div class="taj-section-header">
                            <h2 class="taj-section-title">
                                <span class="title-indicator-dot"></span>
                                <span><?php esc_html_e('نوشته های مشابه', 'market'); ?></span>
                            </h2>
                        </div>

                        <div class="taj-related-grid">
                            <?php
                            if ($related_query->have_posts()) :
                                while ($related_query->have_posts()) : $related_query->the_post();
                                    get_template_part('template-parts/card/article-card');
                                endwhile;
                                wp_reset_postdata();
                            else :
                                ?>
                                <article class="article-card taj-article-card">
                                    <div class="article-card-thumb-wrap">
                                        <a href="#" class="article-thumb-link">
                                            <div class="article-thumb-placeholder">
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                            </div>
                                        </a>
                                        <div class="article-date-badge">
                                            <span class="date-badge-day"><?php echo esc_html(market_to_persian_numbers('25')); ?></span>
                                            <span class="date-badge-month"><?php esc_html_e('شهریور', 'market'); ?></span>
                                        </div>
                                        <span class="article-badge-pill"><?php esc_html_e('راهنمای خرید', 'market'); ?></span>
                                    </div>
                                    <div class="article-card-body">
                                        <h3 class="article-card-title">
                                            <a href="#"><?php esc_html_e('راهنمای انتخاب گیمبال برای دوربین؛ چه گیمبالی مناسب شماست؟', 'market'); ?></a>
                                        </h3>
                                        <div class="article-card-meta">
                                            <span class="article-comments-badge">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#ef394e" stroke="#ef394e" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                                <span class="comments-num"><?php echo esc_html(market_to_persian_numbers('0')); ?></span>
                                            </span>
                                            <span class="article-author"><?php esc_html_e('MrHossein', 'market'); ?></span>
                                        </div>
                                        <div class="article-card-excerpt">
                                            <?php esc_html_e('راهنمای انتخاب گیمبال برای دوربین؛ چه گیمبالی مناسب شماست؟ گیمبال یکی از کاربردی‌ترین تجهیزات برای ...', 'market'); ?>
                                        </div>
                                        <div class="article-card-action">
                                            <a href="#" class="article-more-link">
                                                <?php esc_html_e('ادامه مطلب', 'market'); ?>
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- بخش دیدگاه‌ها -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>

                <!-- سایدبار وبلاگ (سمت راست در RTL) -->
                <?php get_sidebar(); ?>

            </div>
        </div>
    </main>

    <?php
endwhile;

get_footer();
