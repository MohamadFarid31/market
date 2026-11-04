<?php
/**
 * Market Theme — Blog Sidebar (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<aside class="blog-sidebar taj-blog-sidebar" aria-label="<?php esc_attr_e('سایدبار مقالات', 'market'); ?>">
    <?php if (is_active_sidebar('sidebar-blog')) : ?>
        <?php dynamic_sidebar('sidebar-blog'); ?>
    <?php else : ?>
        <!-- ۱. ویجت جستجو -->
        <div class="widget widget_search taj-sidebar-widget">
            <h3 class="widget-title taj-widget-title"><?php esc_html_e('جستجو', 'market'); ?></h3>
            <form role="search" method="get" class="search-form taj-sidebar-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <label class="screen-reader-text" for="blog-search-field"><?php esc_html_e('جستجو برای:', 'market'); ?></label>
                <div class="search-input-wrap">
                    <input type="search" id="blog-search-field" class="search-field" placeholder="<?php esc_attr_e('جستجو در مقالات...', 'market'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit taj-sidebar-search-btn">
                        <?php esc_html_e('جستجو', 'market'); ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- ۲. ویجت نوشته‌های تازه -->
        <div class="widget widget_recent_entries taj-sidebar-widget">
            <h3 class="widget-title taj-widget-title"><?php esc_html_e('نوشته‌های تازه', 'market'); ?></h3>
            <?php
            $recent_posts_query = new WP_Query([
                'posts_per_page'      => 5,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'no_found_rows'       => true,
            ]);

            if ($recent_posts_query->have_posts()) :
                ?>
                <ul class="taj-sidebar-list">
                    <?php while ($recent_posts_query->have_posts()) : $recent_posts_query->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>
            <?php else : ?>
                <ul class="taj-sidebar-list">
                    <li><a href="#"><?php esc_html_e('راهنمای انتخاب دوربین برای تولید محتوا؛ چه مدلی مناسب است؟', 'market'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('راهنمای نورپردازی برای عکاسی و فیلم‌برداری', 'market'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('راهنمای انتخاب گیمبال برای دوربین؛ چه گیمبالی مناسب شماست؟', 'market'); ?></a></li>
                </ul>
            <?php endif; ?>
        </div>

        <!-- ۳. ویجت آخرین دیدگاه‌ها -->
        <div class="widget widget_recent_comments taj-sidebar-widget">
            <h3 class="widget-title taj-widget-title"><?php esc_html_e('آخرین دیدگاه‌ها', 'market'); ?></h3>
            <?php
            $recent_comments = get_comments([
                'number'      => 4,
                'status'      => 'approve',
                'post_status' => 'publish',
            ]);

            if (!empty($recent_comments)) :
                ?>
                <ul class="taj-sidebar-list">
                    <?php foreach ($recent_comments as $comment) : ?>
                        <li>
                            <span class="comment-author-link"><?php echo esc_html($comment->comment_author); ?></span>
                            <?php esc_html_e('در', 'market'); ?>
                            <a href="<?php echo esc_url(get_comment_link($comment)); ?>"><?php echo esc_html(get_the_title($comment->comment_post_ID)); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <ul class="taj-sidebar-list">
                    <li>
                        <span class="comment-author-link"><?php esc_html_e('MrHossein', 'market'); ?></span>
                        <?php esc_html_e('در', 'market'); ?>
                        <a href="#"><?php esc_html_e('راهنمای انتخاب دوربین برای تولید محتوا', 'market'); ?></a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>

        <!-- ۴. ویجت بایگانی‌ها -->
        <div class="widget widget_archive taj-sidebar-widget">
            <h3 class="widget-title taj-widget-title"><?php esc_html_e('بایگانی‌ها', 'market'); ?></h3>
            <ul class="taj-sidebar-list">
                <?php
                $archives = wp_get_archives([
                    'type'            => 'monthly',
                    'echo'            => false,
                    'show_post_count' => false,
                ]);

                if (!empty($archives)) {
                    echo $archives; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                } else {
                    echo '<li><a href="#">' . esc_html__('شهریور ۱۴۰۵', 'market') . '</a></li>';
                    echo '<li><a href="#">' . esc_html__('سپتامبر 2026', 'market') . '</a></li>';
                }
                ?>
            </ul>
        </div>

        <!-- ۵. ویجت دسته‌ها -->
        <div class="widget widget_categories taj-sidebar-widget">
            <h3 class="widget-title taj-widget-title"><?php esc_html_e('دسته‌ها', 'market'); ?></h3>
            <ul class="taj-sidebar-list">
                <?php
                $categories = get_categories(['hide_empty' => false]);
                if (!empty($categories)) {
                    foreach ($categories as $cat) {
                        echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                    }
                } else {
                    echo '<li><a href="#">' . esc_html__('راهنمای خرید', 'market') . '</a></li>';
                    echo '<li><a href="#">' . esc_html__('نورپردازی', 'market') . '</a></li>';
                }
                ?>
            </ul>
        </div>
    <?php endif; ?>
</aside>

