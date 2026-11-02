<?php
/**
 * Market Theme — Blog Article Card Component (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$categories = get_the_category();
$category_name = !empty($categories) ? $categories[0]->name : esc_html__('مقالات', 'market');
$comments_count = get_comments_number();
$comments_text = ($comments_count == 0) ? esc_html__('بدون دیدگاه', 'market') : sprintf(esc_html__('%s دیدگاه', 'market'), market_to_persian_numbers($comments_count));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article-card'); ?>>
    <div class="article-card-thumb-wrap">
        <a href="<?php the_permalink(); ?>" class="article-thumb-link" aria-label="<?php the_title_attribute(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large', ['class' => 'article-thumb-img']); ?>
            <?php else : ?>
                <div class="article-thumb-placeholder"></div>
            <?php endif; ?>
        </a>
        <span class="article-badge-pill"><?php echo esc_html($category_name); ?></span>
    </div>

    <div class="article-card-body">
        <h3 class="article-card-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="article-card-action">
            <a href="<?php the_permalink(); ?>" class="article-more-link">
                <?php esc_html_e('ادامه مطلب ...', 'market'); ?>
            </a>
        </div>

        <div class="article-card-meta">
            <span class="article-date"><?php echo esc_html(market_to_persian_numbers(get_the_date('Y-m-d'))); ?></span>
            <span class="meta-dot">•</span>
            <span class="article-comments"><?php echo esc_html($comments_text); ?></span>
        </div>
    </div>
</article>
