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

        // If on WooCommerce pages, let WooCommerce breadcrumb handle it with our container wrap
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            echo '<nav class="breadcrumbs-nav" aria-label="' . esc_attr__('مسیر راهنما', 'market') . '"><div class="container">';
            woocommerce_breadcrumb([
                'delimiter'   => '<span class="breadcrumb-separator">/</span>',
                'wrap_before' => '<div class="breadcrumb-items">',
                'wrap_after'  => '</div>',
                'before'      => '<span class="breadcrumb-item">',
                'after'       => '</span>',
                'home'        => esc_html__('خانه', 'market'),
            ]);
            echo '</div></nav>';
            return;
        }

        echo '<nav class="breadcrumbs-nav" aria-label="' . esc_attr__('مسیر راهنما', 'market') . '"><div class="container"><div class="breadcrumb-items">';
        echo '<span class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('خانه', 'market') . '</a></span>';
        echo '<span class="breadcrumb-separator">/</span>';

        if (is_category() || is_single()) {
            $category = get_the_category();
            if (!empty($category)) {
                echo '<span class="breadcrumb-item"><a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a></span>';
                echo '<span class="breadcrumb-separator">/</span>';
            }
            if (is_single()) {
                echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</span>';
            }
        } elseif (is_page()) {
            echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</span>';
        } elseif (is_search()) {
            echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html__('نتایج جستجو', 'market') . '</span>';
        } elseif (is_404()) {
            echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html__('صفحه پیدا نشد', 'market') . '</span>';
        }

        echo '</div></div></nav>';
    }
}
