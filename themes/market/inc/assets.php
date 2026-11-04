<?php
/**
 * Market Theme — Conditional Asset Enqueuing Engine
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_enqueue_assets')) {
    /**
     * Enqueues theme styles and scripts conditionally.
     */
    function market_enqueue_assets()
    {
        $theme_version = wp_get_theme()->get('Version');
        $uri = get_template_directory_uri();

        // 1. Core Tokens & Global Architecture
        wp_enqueue_style('market-tokens', $uri . '/assets/css/tokens/tokens.css', [], $theme_version);
        wp_enqueue_style('market-reset', $uri . '/assets/css/global/reset.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-typography', $uri . '/assets/css/global/typography.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-utilities', $uri . '/assets/css/global/utilities.css', ['market-tokens'], $theme_version);

        // 2. Global Components
        wp_enqueue_style('market-buttons', $uri . '/assets/css/components/buttons.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-forms', $uri . '/assets/css/components/forms.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-header', $uri . '/assets/css/components/header.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-nav', $uri . '/assets/css/components/navigation.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-footer', $uri . '/assets/css/components/footer.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-alerts', $uri . '/assets/css/components/alerts.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-modal', $uri . '/assets/css/components/modal-drawer.css', ['market-tokens'], $theme_version);
        wp_enqueue_style('market-empty', $uri . '/assets/css/components/empty-states.css', ['market-tokens'], $theme_version);

        // 3. Conditional Page & Template Styles
        if (is_front_page()) {
            wp_enqueue_style('market-product-card', $uri . '/assets/css/components/product-card.css', ['market-tokens'], $theme_version);
            wp_enqueue_style('market-article-card', $uri . '/assets/css/components/article-card.css', ['market-tokens'], $theme_version);
            wp_enqueue_style('market-page-home', $uri . '/assets/css/pages/home.css', ['market-tokens'], $theme_version);
        }

        if (function_exists('is_woocommerce')) {
            if (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
                wp_enqueue_style('market-product-card', $uri . '/assets/css/components/product-card.css', ['market-tokens'], $theme_version);
                wp_enqueue_style('market-pagination', $uri . '/assets/css/components/pagination.css', ['market-tokens'], $theme_version);
                wp_enqueue_style('market-page-shop', $uri . '/assets/css/pages/shop.css', ['market-tokens'], $theme_version);
            }

            if (is_product()) {
                wp_enqueue_style('market-product-card', $uri . '/assets/css/components/product-card.css', ['market-tokens'], $theme_version);
                wp_enqueue_style('market-page-single-product', $uri . '/assets/css/pages/single-product.css', ['market-tokens'], $theme_version);
            }

            if (is_cart()) {
                wp_enqueue_style('market-page-cart', $uri . '/assets/css/pages/cart.css', ['market-tokens'], $theme_version);
            }

            if (is_checkout()) {
                wp_enqueue_style('market-page-checkout', $uri . '/assets/css/pages/checkout.css', ['market-tokens'], $theme_version);
            }

            if (is_account_page()) {
                wp_enqueue_style('market-page-account', $uri . '/assets/css/pages/account.css', ['market-tokens'], $theme_version);
            }
        }

        if (is_home() || is_page(['blog', 'mag', 'articles']) || (is_archive() && !function_exists('is_woocommerce') ? true : (!is_woocommerce() && is_archive())) || is_search()) {
            wp_enqueue_style('market-article-card', $uri . '/assets/css/components/article-card.css', ['market-tokens'], $theme_version);
            wp_enqueue_style('market-pagination', $uri . '/assets/css/components/pagination.css', ['market-tokens'], $theme_version);
            wp_enqueue_style('market-page-blog', $uri . '/assets/css/pages/blog.css', ['market-tokens'], $theme_version);
        }

        if (is_singular('post')) {
            wp_enqueue_style('market-article-card', $uri . '/assets/css/components/article-card.css', ['market-tokens'], $theme_version);
            wp_enqueue_style('market-page-blog', $uri . '/assets/css/pages/blog.css', ['market-tokens'], $theme_version);
        }

        if (
            is_page_template([
                'page-templates/page-contact.php',
                'page-templates/page-faq.php',
                'page-templates/page-complaints.php',
                'page-templates/page-about.php',
                'page-templates/page-guide.php',
            ]) || is_page(['contact', 'contact-us', 'about', 'about-us', 'faq', 'guide', 'complaints'])
        ) {
            wp_enqueue_style('market-page-content', $uri . '/assets/css/pages/content-pages.css', ['market-tokens'], $theme_version);
        }

        // 4. Root Stylesheet (Metadata & RTL)
        wp_enqueue_style('market-style', get_stylesheet_uri(), ['market-tokens'], $theme_version);

        if (is_rtl()) {
            wp_enqueue_style('market-rtl', $uri . '/rtl.css', ['market-style'], $theme_version);
        }

        // 5. Core JavaScript (ES Module)
        wp_enqueue_script('market-main', $uri . '/assets/js/main.js', [], $theme_version, true);

        // Localized Data for Vanilla JS
        wp_localize_script('market-main', 'marketData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('market_ajax_nonce'),
            'isRtl' => is_rtl(),
            'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '',
        ]);
    }
}
add_action('wp_enqueue_scripts', 'market_enqueue_assets');

// Add type="module" to main.js for ES module imports
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if ('market-main' === $handle) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}, 10, 3);
