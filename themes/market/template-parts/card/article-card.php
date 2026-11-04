<?php
/**
 * Market Theme — Blog Article Card Component (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$categories = get_the_category();
$category_name = !empty($categories) ? $categories[0]->name : esc_html__('راهنمای خرید', 'market');
$category_link = !empty($categories) ? get_category_link($categories[0]->term_id) : '#';
$comments_count = get_comments_number();

// Persian Day & Month for Date Badge
$post_time  = get_the_time('U');
$day_num    = function_exists('market_format_persian_date') ? market_format_persian_date($post_time, 'j') : get_the_date('j');
$month_name = function_exists('market_format_persian_date') ? market_format_persian_date($post_time, 'F') : get_the_date('F');
$author_name = get_the_author();
if (empty($author_name)) $author_name = 'MrHossein';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article-card taj-article-card'); ?>>
    <div class="article-card-thumb-wrap">
        <a href="<?php the_permalink(); ?>" class="article-thumb-link" aria-label="<?php the_title_attribute(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large', ['class' => 'article-thumb-img']); ?>
            <?php else : ?>
                <div class="article-thumb-placeholder">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                </div>
            <?php endif; ?>
        </a>

        <!-- نشان تاریخ گوشه تصویر (مطابق تاج بازار) -->
        <div class="article-date-badge">
            <span class="date-badge-day"><?php echo esc_html($day_num); ?></span>
            <span class="date-badge-month"><?php echo esc_html($month_name); ?></span>
        </div>

        <!-- نشان دسته‌بندی قرمز -->
        <a href="<?php echo esc_url($category_link); ?>" class="article-badge-pill">
            <?php echo esc_html($category_name); ?>
        </a>
    </div>

    <div class="article-card-body">
        <h3 class="article-card-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- ردیف متادیتا: آیکون دیدگاه و نویسنده -->
        <div class="article-card-meta">
            <span class="article-comments-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#ef394e" stroke="#ef394e" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span class="comments-num"><?php echo esc_html(function_exists('market_to_persian_numbers') ? market_to_persian_numbers($comments_count) : $comments_count); ?></span>
            </span>
            <span class="article-author"><?php echo esc_html($author_name); ?></span>
        </div>

        <!-- خلاصه متن -->
        <div class="article-card-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 18, ' ...'); ?>
        </div>

        <!-- دکمه ادامه مطلب -->
        <div class="article-card-action">
            <a href="<?php the_permalink(); ?>" class="article-more-link">
                <?php esc_html_e('ادامه مطلب', 'market'); ?>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
</article>
