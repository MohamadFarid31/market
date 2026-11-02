<?php
/**
 * Market Theme — Blog Article Card Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article-card'); ?>>
    <?php market_post_thumbnail(); ?>

    <div class="article-card-body">
        <div class="article-card-meta">
            <?php market_posted_on(); ?>
            <span class="meta-separator">•</span>
            <span class="article-category"><?php the_category(', '); ?></span>
        </div>

        <h3 class="article-card-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="article-card-excerpt">
            <?php the_excerpt(); ?>
        </div>

        <div class="article-card-footer" style="margin-block-start: auto;">
            <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm">
                <?php esc_html_e('ادامه مطلب ←', 'market'); ?>
            </a>
        </div>
    </div>
</article>
