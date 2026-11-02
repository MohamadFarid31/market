<?php
/**
 * Market Theme — Custom Template Tags & Helpers
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_posted_on')) {
    /**
     * Prints HTML with meta information for the current post date/time.
     */
    function market_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(market_format_persian_date(get_the_time('U')))
        );

        echo '<span class="posted-on">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

if (!function_exists('market_posted_by')) {
    /**
     * Prints HTML with meta information about the author.
     */
    function market_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('توسط %s', 'post author', 'market'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

if (!function_exists('market_post_thumbnail')) {
    /**
     * Displays an optional post thumbnail.
     *
     * @param string $size
     * @param array $attr
     */
    function market_post_thumbnail($size = 'market-blog-thumb', $attr = []) {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) {
            ?>
            <div class="post-thumbnail single-post-thumb">
                <?php the_post_thumbnail($size, $attr); ?>
            </div>
            <?php
        } else {
            ?>
            <a class="post-thumbnail article-card-thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail($size, $attr); ?>
            </a>
            <?php
        }
    }
}
