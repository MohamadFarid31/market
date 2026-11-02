<?php
/**
 * Market Theme — Numeric Pagination Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;

global $wp_query;

if ($wp_query->max_num_pages <= 1) {
    return;
}

$links = paginate_links([
    'base'      => esc_url_raw(str_replace(999999999, '%#%', get_pagenum_link(999999999))),
    'format'    => '?paged=%#%',
    'current'   => max(1, get_query_var('paged')),
    'total'     => $wp_query->max_num_pages,
    'type'      => 'array',
    'prev_text' => '<span class="icon-directional">&rarr;</span> ' . esc_html__('قبلی', 'market'),
    'next_text' => esc_html__('بعدی', 'market') . ' <span class="icon-directional">&larr;</span>',
]);

if (!empty($links)) :
    ?>
    <nav class="pagination-wrapper" aria-label="<?php esc_attr_e('ناوبری صفحات', 'market'); ?>">
        <ul class="pagination">
            <?php foreach ($links as $link) : ?>
                <li class="pagination-item">
                    <?php echo market_to_persian_numbers($link); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php endif; ?>
