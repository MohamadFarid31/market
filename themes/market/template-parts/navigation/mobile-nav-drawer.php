<?php
/**
 * Market Theme — Off-Canvas Mobile Navigation Drawer
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$categories_data = function_exists('market_get_categories_tree') ? market_get_categories_tree() : [];
$contact_phone   = function_exists('market_get_option') ? market_get_option('phone', '09128184981') : '09128184981';
$shop_url        = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$blog_page_id    = get_option('page_for_posts');
$blog_url        = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog/');
?>
<div id="mobile-nav-overlay" class="drawer-overlay" aria-hidden="true"></div>

<aside id="mobile-nav-drawer" class="drawer mobile-nav-drawer" aria-label="<?php esc_attr_e('منوی ناوبری موبایل', 'market'); ?>">
    <div class="drawer-header">
        <div class="drawer-header-brand">
            <span class="drawer-logo-badge">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </span>
            <h2 class="drawer-title"><?php esc_html_e('منوی دسترسی سریع', 'market'); ?></h2>
        </div>
        <button class="btn btn-ghost drawer-close-btn" data-close="mobile-nav" aria-label="<?php esc_attr_e('بستن منو', 'market'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="drawer-body">
        <!-- ۱. فیلد جستجو درون کشو -->
        <div class="mobile-search-wrapper">
            <?php get_template_part('template-parts/header/search-bar'); ?>
        </div>

        <!-- ۲. لیست یکپارچه ناوبری موبایل با آکاردئون آبشاری -->
        <nav class="mobile-nav-container" aria-label="<?php esc_attr_e('ناوبری اصلی موبایل', 'market'); ?>">
            <ul class="mobile-nav-list">

                <!-- صفحه اصلی -->
                <li class="mobile-nav-item <?php echo is_front_page() ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link">
                        <span class="mobile-nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span class="mobile-nav-label"><?php esc_html_e('صفحه اصلی', 'market'); ?></span>
                    </a>
                </li>

                <!-- دسته‌بندی کالاها (آکاردئون چندسطحی آبشاری) -->
                <li class="mobile-nav-item mobile-nav-has-children mobile-categories-accordion-item">
                    <div class="mobile-nav-item-inner">
                        <button type="button" class="mobile-nav-toggle-row mobile-cat-root-toggle" aria-expanded="false" aria-controls="mobile-cats-collapse">
                            <span class="mobile-nav-icon mobile-cat-root-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </span>
                            <span class="mobile-nav-label mobile-cat-root-label"><?php esc_html_e('دسته‌بندی کالاها', 'market'); ?></span>
                            <span class="mobile-arrow-wrap">
                                <svg class="mobile-arrow-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- محتوای آبشاری دسته‌بندی‌های سطح ۱ -->
                    <div class="mobile-accordion-content" id="mobile-cats-collapse">
                        <div class="mobile-accordion-inner">
                            <ul class="mobile-sub-menu mobile-cat-list-level-1">
                                <?php if (!empty($categories_data)) : ?>
                                    <?php foreach ($categories_data as $cat) : 
                                        $has_children = !empty($cat['children']);
                                    ?>
                                        <li class="mobile-cat-item <?php echo $has_children ? 'mobile-cat-has-children' : ''; ?>">
                                            <?php if ($has_children) : ?>
                                                <div class="mobile-nav-item-inner">
                                                    <a href="<?php echo esc_url($cat['url']); ?>" class="mobile-nav-link mobile-subcat-title-link">
                                                        <span class="mobile-bullet-dot"></span>
                                                        <span class="mobile-nav-label"><?php echo esc_html($cat['name']); ?></span>
                                                    </a>
                                                    <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="<?php printf(esc_attr__('زیردسته‌های %s', 'market'), esc_attr($cat['name'])); ?>">
                                                        <svg class="mobile-arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- محتوای آبشاری زیردسته‌های سطح ۲ -->
                                                <div class="mobile-accordion-content">
                                                    <div class="mobile-accordion-inner">
                                                        <ul class="mobile-sub-menu mobile-cat-list-level-2">
                                                            <li class="mobile-view-all-item">
                                                                <a href="<?php echo esc_url($cat['url']); ?>" class="mobile-view-all-link">
                                                                    <span><?php printf(esc_html__('مشاهده همه محصولات %s', 'market'), esc_html($cat['name'])); ?></span>
                                                                    <svg class="mobile-view-all-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <?php foreach ($cat['children'] as $child) : 
                                                                $child_has_subs = !empty($child['children']);
                                                            ?>
                                                                <li class="mobile-subcat-leaf <?php echo $child_has_subs ? 'mobile-cat-has-children' : ''; ?>">
                                                                    <?php if ($child_has_subs) : ?>
                                                                        <div class="mobile-nav-item-inner">
                                                                            <a href="<?php echo esc_url($child['url']); ?>" class="mobile-nav-link mobile-subcat-title-link">
                                                                                <span class="mobile-sub-dash">–</span>
                                                                                <span><?php echo esc_html($child['name']); ?></span>
                                                                            </a>
                                                                            <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="<?php printf(esc_attr__('زیردسته‌های %s', 'market'), esc_attr($child['name'])); ?>">
                                                                                <svg class="mobile-arrow-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                                                </svg>
                                                                            </button>
                                                                        </div>

                                                                        <!-- محتوای آبشاری سطح ۳ -->
                                                                        <div class="mobile-accordion-content">
                                                                            <div class="mobile-accordion-inner">
                                                                                <ul class="mobile-sub-menu mobile-cat-list-level-3">
                                                                                    <?php foreach ($child['children'] as $subchild) : ?>
                                                                                        <li>
                                                                                            <a href="<?php echo esc_url($subchild['url']); ?>" class="mobile-nav-link">
                                                                                                <span><?php echo esc_html($subchild['name']); ?></span>
                                                                                            </a>
                                                                                        </li>
                                                                                    <?php endforeach; ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <div class="mobile-nav-item-inner">
                                                                            <a href="<?php echo esc_url($child['url']); ?>" class="mobile-nav-link">
                                                                                <span class="mobile-sub-dash">–</span>
                                                                                <span><?php echo esc_html($child['name']); ?></span>
                                                                            </a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                            <?php else : ?>
                                                <div class="mobile-nav-item-inner">
                                                    <a href="<?php echo esc_url($cat['url']); ?>" class="mobile-nav-link">
                                                        <span class="mobile-bullet-dot"></span>
                                                        <span class="mobile-nav-label"><?php echo esc_html($cat['name']); ?></span>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- فروشگاه -->
                <li class="mobile-nav-item <?php echo (function_exists('is_shop') && is_shop()) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url($shop_url); ?>" class="mobile-nav-link">
                        <span class="mobile-nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </span>
                        <span class="mobile-nav-label"><?php esc_html_e('فروشگاه', 'market'); ?></span>
                    </a>
                </li>

                <!-- وبلاگ -->
                <li class="mobile-nav-item <?php echo (is_home() || (is_singular('post') || is_category() || is_tag())) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url($blog_url); ?>" class="mobile-nav-link">
                        <span class="mobile-nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                <line x1="9" y1="7" x2="15" y2="7"></line>
                                <line x1="9" y1="11" x2="15" y2="11"></line>
                            </svg>
                        </span>
                        <span class="mobile-nav-label"><?php esc_html_e('وبلاگ', 'market'); ?></span>
                    </a>
                </li>

                <!-- پرسش و پاسخ -->
                <li class="mobile-nav-item <?php echo is_page(['faq', 'پرسش-و-پاسخ']) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="mobile-nav-link">
                        <span class="mobile-nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </span>
                        <span class="mobile-nav-label"><?php esc_html_e('پرسش و پاسخ', 'market'); ?></span>
                    </a>
                </li>

                <!-- تماس با ما -->
                <li class="mobile-nav-item <?php echo is_page(['contact', 'contact-us', 'تماس-با-ما']) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="mobile-nav-link">
                        <span class="mobile-nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </span>
                        <span class="mobile-nav-label"><?php esc_html_e('تماس با ما', 'market'); ?></span>
                    </a>
                </li>

                <!-- پیشنهادات و انتقادات -->
                <li class="mobile-nav-item <?php echo is_page(['complaints', 'suggestions-and-criticisms', 'پیشنهادات-و-انتقادات']) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/complaints/')); ?>" class="mobile-nav-link">
                        <span class="mobile-nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                            </svg>
                        </span>
                        <span class="mobile-nav-label"><?php esc_html_e('پیشنهادات و انتقادات', 'market'); ?></span>
                    </a>
                </li>
            </ul>

            <!-- سایر پیوندهای سفارشی وردپرس در صورت تنظیم توسط مدیر سایت -->
            <?php if (has_nav_menu('mobile-menu')) : ?>
                <div class="mobile-menu-divider"></div>
                <div class="mobile-custom-menu-wrap">
                    <span class="mobile-custom-menu-heading"><?php esc_html_e('سایر بخش‌ها', 'market'); ?></span>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'mobile-menu',
                        'menu_class'     => 'mobile-nav-list mobile-custom-nav-list',
                        'container'      => false,
                        'depth'          => 2,
                        'fallback_cb'    => false,
                    ]);
                    ?>
                </div>
            <?php endif; ?>
        </nav>
    </div>

    <!-- پاورقی کشوی موبایل با اطلاعات تماس -->
    <div class="drawer-footer mobile-drawer-footer">
        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>" class="mobile-drawer-contact-btn">
            <span class="mobile-drawer-contact-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
            </span>
            <div class="mobile-drawer-contact-text">
                <span class="contact-hint"><?php esc_html_e('پشتیبانی تلفنی و سفارش', 'market'); ?></span>
                <span class="contact-number"><?php echo esc_html($contact_phone); ?></span>
            </div>
        </a>
    </div>
</aside>
