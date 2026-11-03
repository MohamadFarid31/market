<?php
/**
 * Market Theme — Setup & Supports
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_theme_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function market_theme_setup() {
        // Translation support
        load_theme_textdomain('market', get_template_directory() . '/languages');

        // Document title tag management
        add_theme_support('title-tag');

        // Featured image support
        add_theme_support('post-thumbnails');

        // WooCommerce core support & gallery features
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // HTML5 markup support
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);

        // Custom logo support
        add_theme_support('custom-logo', [
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
        ]);

        // Navigation Menus
        register_nav_menus([
            'primary-menu'         => esc_html__('منوی اصلی دسکتاپ', 'market'),
            'category-menu'        => esc_html__('مگامنوی دسته‌بندی‌ها', 'market'),
            'mobile-menu'          => esc_html__('منوی کشویی موبایل', 'market'),
            'footer-quick-links'   => esc_html__('فوتر ۱ - دسترسی سریع', 'market'),
            'footer-categories'    => esc_html__('فوتر ۲ - دسته‌بندی‌ها', 'market'),
            'footer-support'       => esc_html__('فوتر ۳ - پشتیبانی و راهنمایی', 'market'),
        ]);

        // Image Sizes
        add_image_size('market-product-thumb', 400, 400, true);
        add_image_size('market-blog-thumb', 600, 340, true);
    }
}
add_action('after_setup_theme', 'market_theme_setup');

if (!function_exists('market_widgets_init')) {
    /**
     * Register widget areas.
     */
    function market_widgets_init() {
        register_sidebar([
            'name'          => esc_html__('Shop Sidebar | سایدبار فروشگاه', 'market'),
            'id'            => 'sidebar-shop',
            'description'   => esc_html__('Widgets added here will appear on catalog and category pages.', 'market'),
            'before_widget' => '<section id="%1$s" class="widget %2$s filter-group">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="filter-title">',
            'after_title'   => '</h3>',
        ]);

        register_sidebar([
            'name'          => esc_html__('Blog Sidebar | سایدبار وبلاگ', 'market'),
            'id'            => 'sidebar-blog',
            'description'   => esc_html__('Widgets for blog archive and single articles.', 'market'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s card">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
add_action('widgets_init', 'market_widgets_init');
