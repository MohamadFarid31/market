<?php
/**
 * Market Theme — Footer Widgets Area
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div class="footer-widgets-grid">
    <div class="footer-widget-col">
        <h3 class="footer-widget-title"><?php bloginfo('name'); ?></h3>
        <p class="footer-widget-text">
            <?php bloginfo('description'); ?>
        </p>
    </div>

    <div class="footer-widget-col">
        <h3 class="footer-widget-title"><?php esc_html_e('دسترسی سریع', 'market'); ?></h3>
        <?php
        if (has_nav_menu('footer-col-1')) {
            wp_nav_menu([
                'theme_location' => 'footer-col-1',
                'menu_class'     => 'footer-menu',
                'container'      => false,
                'depth'          => 1,
            ]);
        }
        ?>
    </div>

    <div class="footer-widget-col">
        <h3 class="footer-widget-title"><?php esc_html_e('خدمات مشتریان', 'market'); ?></h3>
        <?php
        if (has_nav_menu('footer-col-2')) {
            wp_nav_menu([
                'theme_location' => 'footer-col-2',
                'menu_class'     => 'footer-menu',
                'container'      => false,
                'depth'          => 1,
            ]);
        }
        ?>
    </div>

    <div class="footer-widget-col">
        <h3 class="footer-widget-title"><?php esc_html_e('مجوزها و نمادها', 'market'); ?></h3>
        <div class="footer-trust-badges">
            <div class="trust-badge-card" aria-label="<?php esc_attr_e('نماد اعتماد الکترونیکی', 'market'); ?>">
                <span>اینماد</span>
            </div>
            <div class="trust-badge-card" aria-label="<?php esc_attr_e('ساماندهی', 'market'); ?>">
                <span>ساماندهی</span>
            </div>
        </div>
    </div>
</div>
