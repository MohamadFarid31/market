<?php
/**
 * Market Theme — Off-Canvas Mobile Navigation Drawer
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div id="mobile-nav-overlay" class="drawer-overlay" aria-hidden="true"></div>

<aside id="mobile-nav-drawer" class="drawer" aria-label="<?php esc_attr_e('منوی ناوبری موبایل', 'market'); ?>">
    <div class="drawer-header">
        <h2 class="drawer-title"><?php esc_html_e('منوی دسترسی', 'market'); ?></h2>
        <button class="btn btn-ghost" data-close="mobile-nav" aria-label="<?php esc_attr_e('بستن منو', 'market'); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="drawer-body">
        <div class="mobile-search-wrapper" style="margin-block-end: var(--space-4);">
            <?php get_template_part('template-parts/header/search-bar'); ?>
        </div>

        <?php
        if (has_nav_menu('mobile-menu')) {
            wp_nav_menu([
                'theme_location' => 'mobile-menu',
                'menu_class'     => 'mobile-nav-list',
                'container'      => 'nav',
                'depth'          => 2,
            ]);
        } elseif (has_nav_menu('primary-menu')) {
            wp_nav_menu([
                'theme_location' => 'primary-menu',
                'menu_class'     => 'mobile-nav-list',
                'container'      => 'nav',
                'depth'          => 2,
            ]);
        }
        ?>
    </div>
</aside>
