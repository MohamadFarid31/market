<?php
/**
 * Market Theme — Global Header Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?><!doctype html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link sr-only" href="#primary">
    <?php esc_html_e('پرش به محتوای اصلی', 'market'); ?>
</a>

<header id="masthead" class="site-header">
    <div class="header-main">
        <div class="container header-main-inner">
            <button class="mobile-menu-toggle hide-on-desktop btn btn-ghost" data-toggle="mobile-nav" aria-label="<?php esc_attr_e('منو', 'market'); ?>" aria-expanded="false">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <?php get_template_part('template-parts/header/branding'); ?>

            <div class="header-search hide-on-mobile">
                <?php get_template_part('template-parts/header/search-bar'); ?>
            </div>

            <!-- دکمه‌های دسکتاپ -->
            <div class="hide-on-mobile">
                <?php get_template_part('template-parts/header/actions'); ?>
            </div>

            <!-- دکمه‌های موبایل (تماس و حساب کاربری) -->
            <?php $contact_phone = function_exists('market_get_option') ? market_get_option('phone', '09128184981') : '09128184981'; ?>
            <div class="mobile-header-actions hide-on-desktop">
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>" class="mobile-header-action-btn" aria-label="<?php esc_attr_e('تماس با ما', 'market'); ?>">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </a>
                <?php
                $account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
                ?>
                <a href="<?php echo esc_url($account_url); ?>" class="mobile-header-action-btn" aria-label="<?php esc_attr_e('حساب کاربری', 'market'); ?>">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- فیلد جستجوی تمام‌عرض موبایل -->
    <div class="header-mobile-search-wrap hide-on-desktop">
        <div class="container">
            <?php get_template_part('template-parts/header/search-bar', null, ['input_id' => 'mobile-search-field']); ?>
        </div>
    </div>

    <div class="header-nav-wrap hide-on-mobile">
        <?php get_template_part('template-parts/header/navigation-desktop'); ?>
    </div>
</header>

<?php get_template_part('template-parts/navigation/mobile-nav-drawer'); ?>
<?php get_template_part('template-parts/modal/cart-drawer'); ?>

<?php
if (!is_front_page()) {
    market_breadcrumbs();
}
?>
