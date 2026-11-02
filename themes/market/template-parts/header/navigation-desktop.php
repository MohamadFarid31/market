<?php
/**
 * Market Theme — Desktop Navigation Bar with Digikala-Style Mega Menu
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<nav class="desktop-nav" aria-label="<?php esc_attr_e('منوی اصلی', 'market'); ?>">
    <div class="container desktop-nav-container">
        
        <!-- ۱. دکمه و مگامنوی دسته‌بندی کالاها (طراحی سبک دیجی‌کالا) -->
        <div class="header-mega-menu-wrap" id="header-mega-menu-wrap">
            <button class="header-mega-menu-btn" id="mega-menu-btn" type="button" aria-expanded="false" aria-haspopup="true">
                <svg class="mega-menu-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <span class="mega-menu-title"><?php esc_html_e('دسته‌بندی کالاها', 'market'); ?></span>
                <svg class="mega-menu-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <?php get_template_part('template-parts/header/mega-menu'); ?>
        </div>

        <!-- خط جداکننده عمودی بین مگامنو و سایر لینک‌ها -->
        <span class="nav-v-divider" aria-hidden="true"></span>

        <!-- ۲. پیوندهای ناوبری اصلی (صفحه اصلی، فروشگاه، و...) -->
        <div class="header-nav-links">
            <?php
            if (has_nav_menu('primary-menu')) {
                wp_nav_menu([
                    'theme_location' => 'primary-menu',
                    'menu_class'     => 'desktop-nav-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => false,
                ]);
            } else {
                ?>
                <ul class="desktop-nav-menu">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'market'); ?></a></li>
                    <?php if (class_exists('WooCommerce')) : ?>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('فروشگاه', 'market'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('تماس با ما', 'market'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('پرسش و پاسخ', 'market'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/complaints/')); ?>"><?php esc_html_e('پیشنهادات و انتقادات', 'market'); ?></a></li>
                </ul>
                <?php
            }
            ?>
        </div>

        <!-- پشتیبانی و تلفن در سمت چپ ردیف ناوبری -->
        <div class="header-nav-phone">
            <a href="tel:09128184981" class="header-phone-link">
                <span>09128184981</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
            </a>
        </div>

    </div>
</nav>
