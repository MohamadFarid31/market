<?php
/**
 * Market Theme — Desktop Navigation Bar
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<nav class="desktop-nav" aria-label="<?php esc_attr_e('منوی اصلی', 'market'); ?>">
    <div class="container">
        <?php
        if (has_nav_menu('primary-menu')) {
            wp_nav_menu([
                'theme_location' => 'primary-menu',
                'menu_class'     => 'desktop-nav-menu',
                'container'      => false,
                'depth'          => 3,
                'fallback_cb'    => false,
            ]);
        } else {
            ?>
            <ul class="desktop-nav-menu">
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'market'); ?></a></li>
                <?php if (class_exists('WooCommerce')) : ?>
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('فروشگاه', 'market'); ?></a></li>
                <?php endif; ?>
            </ul>
            <?php
        }
        ?>
    </div>
</nav>
