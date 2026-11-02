<?php
/**
 * Market Theme — Breadcrumb Component Generator
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_breadcrumbs')) {
    /**
     * Renders accessible Schema.org Breadcrumbs.
     */
    function market_breadcrumbs() {
        if (is_front_page()) return;

        // If on WooCommerce pages, let WooCommerce handle it or wrap it
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            woocommerce_breadcrumb([
                'delimiter'   => '<span class="breadcrumb-separator icon-directional">/</span>',
                'wrap_before' => '<nav class="breadcrumbs-nav" aria-label="' . esc_attr__('مسیر راهنما', 'market') . '"><div class="container"><ol class="breadcrumb-list">',
                'wrap_after'  => '</ol></div></nav>',
                'before'      => '<li class="breadcrumb-item">',
                'after'       => '</li>',
                'home'        => esc_html__('خانه', 'market'),
            ]);
            return;
        }

        echo '<nav class="breadcrumbs-nav" aria-label="' . esc_attr__('مسیر راهنما', 'market') . '"><div class="container"><ol class="breadcrumb-list">';
        echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('خانه', 'market') . '</a></li>';
        echo '<span class="breadcrumb-separator icon-directional">/</span>';

        if (is_category() || is_single()) {
            $category = get_the_category();
            if (!empty($category)) {
                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a></li>';
                echo '<span class="breadcrumb-separator icon-directional">/</span>';
            }
            if (is_single()) {
                echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</li>';
            }
        } elseif (is_page()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</li>';
        } elseif (is_search()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__('نتایج جستجو', 'market') . '</li>';
        } elseif (is_404()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__('صفحه پیدا نشد', 'market') . '</li>';
        }

        echo '</ol></div></nav>';
    }
}
