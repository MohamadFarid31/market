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
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link sr-only" href="#primary">
    <?php esc_html_e('پرش به محتوای اصلی', 'market'); ?>
</a>

<header id="masthead" class="site-header">
    <?php get_template_part('template-parts/header/topbar'); ?>

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

            <?php get_template_part('template-parts/header/actions'); ?>
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
