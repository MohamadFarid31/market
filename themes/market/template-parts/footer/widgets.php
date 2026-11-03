<?php
/**
 * Market Theme — Taj Bazar Footer Widgets Area
 *
 * @package Market
 */

defined('ABSPATH') || exit;

// Retrieve theme options
$phone = function_exists('market_get_option') ? market_get_option('phone', '09128184981') : '09128184981';
$email = function_exists('market_get_option') ? market_get_option('email', 'Info@tajbazar.ir') : 'Info@tajbazar.ir';
$address = function_exists('market_get_option') ? market_get_option('address', 'بازار بزرگ تهران، خیابان ناصرخسرو، نبش سوراسرافیل، پلاک ۱۹۸') : 'بازار بزرگ تهران، خیابان ناصرخسرو، نبش سوراسرافیل، پلاک ۱۹۸';
$about_title = function_exists('market_get_option') ? market_get_option('about_title', 'فروشگاه تاج بازار') : 'فروشگاه تاج بازار';
$about_desc = function_exists('market_get_option') ? market_get_option('about_desc', 'تاج بازار فروشگاه تخصصی تجهیزات عکاسی، فیلم‌برداری و تولید محتواست. با ارائه مجموعه‌ای از دوربین‌ها، لنزها، تجهیزات نورپردازی، صدا و لوازم جانبی، تلاش می‌کنیم نیاز عکاسان، فیلم‌برداران و تولیدکنندگان محتوا را به‌صورت کامل پوشش دهیم. ارائه محصولات اصل، مشاوره تخصصی پیش از خرید و پشتیبانی واقعی، این امکان را فراهم می‌کند تا با اطمینان بیشتر، تجهیزات متناسب با نیاز و بودجه خود را انتخاب کنید.') : '';
$instagram = function_exists('market_get_option') ? market_get_option('instagram', 'https://instagram.com') : 'https://instagram.com';
$telegram = function_exists('market_get_option') ? market_get_option('telegram', 'https://t.me') : 'https://t.me';
$enamad = function_exists('market_get_option') ? market_get_option('enamad_code', '') : '';
$samandehi = function_exists('market_get_option') ? market_get_option('samandehi_code', '') : '';
?>

<!-- ۱. نوار اطلاعات تماس و لوگو -->
<div class="footer-top-bar">
    <div class="footer-top-logo">
        <span class="taj-bazar-logo">
            <svg class="taj-bazar-emblem" width="36" height="36" viewBox="0 0 40 40" fill="none"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 9L15 15L20 7L25 15L28 9L29 18H11L12 9Z" fill="#E52534" />
                <circle cx="20" cy="27" r="11" stroke="#E52534" stroke-width="2.5" />
                <circle cx="20" cy="27" r="4.5" fill="#E52534" />
                <path d="M20 16.5L25.5 22M27.5 27L22 32.5M16.5 32L12.5 25.5M12.5 22.5L18 17M27 22.5L20 27"
                    stroke="#E52534" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            <span class="taj-bazar-text">TAJ BAZAR</span>
        </span>
    </div>

    <div class="footer-contact-items">
        <?php if (!empty($phone)): ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="footer-contact-link">
                <span><?php echo esc_html($phone); ?></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                    </path>
                </svg>
            </a>
        <?php endif; ?>

        <?php if (!empty($email)): ?>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="footer-contact-link">
                <span><?php echo esc_html($email); ?></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </a>
        <?php endif; ?>

        <?php if (!empty($address)): ?>
            <div class="footer-contact-address">
                <span><?php echo esc_html($address); ?></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ۲. ستون‌های لینک‌ها و دسترسی‌ها (قابل انتخاب از نمایش > فهرست‌ها) -->
<div class="footer-nav-grid">
    <!-- ستون ۱: دسترسی سریع -->
    <div class="footer-nav-col">
        <h3 class="footer-col-title"><?php esc_html_e('دسترسی سریع', 'market'); ?></h3>
        <?php
        if (has_nav_menu('footer-quick-links')) {
            wp_nav_menu([
                'theme_location' => 'footer-quick-links',
                'menu_class' => 'footer-links-list',
                'container' => false,
                'depth' => 1,
            ]);
        } else {
            ?>
            <ul class="footer-links-list">
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'market'); ?></a></li>
                <?php if (class_exists('WooCommerce')): ?>
                    <li><a
                            href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('فروشگاه', 'market'); ?></a>
                    </li>
                <?php endif; ?>
                <li><a
                        href="<?php echo esc_url(home_url('/contact-us/')); ?>"><?php esc_html_e('تماس با ما', 'market'); ?></a>
                </li>
                <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('وبلاگ', 'market'); ?></a></li>
            </ul>
            <?php
        }
        ?>
    </div>

    <!-- ستون ۲: دسته‌بندی‌ها (فهرست دلخواه یا دسته‌بندی‌های فعال ووکامرس) -->
    <div class="footer-nav-col">
        <h3 class="footer-col-title"><?php esc_html_e('دسته‌بندی‌ها', 'market'); ?></h3>
        <?php
        if (has_nav_menu('footer-categories')) {
            wp_nav_menu([
                'theme_location' => 'footer-categories',
                'menu_class' => 'footer-links-list',
                'container' => false,
                'depth' => 1,
            ]);
        } elseif (class_exists('WooCommerce')) {
            $product_categories = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent' => 0,
                'number' => 6,
            ]);

            if (!empty($product_categories) && !is_wp_error($product_categories)) {
                echo '<ul class="footer-links-list">';
                foreach ($product_categories as $cat) {
                    echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
                }
                echo '</ul>';
            } else {
                ?>
                <ul class="footer-links-list">
                    <li><a
                            href="<?php echo esc_url(home_url('/product-category/lighting/')); ?>"><?php esc_html_e('نورپردازی', 'market'); ?></a>
                    </li>
                    <li><a
                            href="<?php echo esc_url(home_url('/product-category/original-batteries-chargers/')); ?>"><?php esc_html_e('باتری و شارژرهای اصل', 'market'); ?></a>
                    </li>
                    <li><a
                            href="<?php echo esc_url(home_url('/product-category/copy-batteries-chargers/')); ?>"><?php esc_html_e('باتری و شارژرهای کپی', 'market'); ?></a>
                    </li>
                    <li><a
                            href="<?php echo esc_url(home_url('/product-category/lavalier-microphones/')); ?>"><?php esc_html_e('میکروفون یقه‌ای', 'market'); ?></a>
                    </li>
                    <li><a
                            href="<?php echo esc_url(home_url('/product-category/camera-accessories/')); ?>"><?php esc_html_e('لوازم جانبی دوربین', 'market'); ?></a>
                    </li>
                    <li><a
                            href="<?php echo esc_url(home_url('/product-category/tripods/')); ?>"><?php esc_html_e('پایه دوربین و رومیزی', 'market'); ?></a>
                    </li>
                </ul>
                <?php
            }
        }
        ?>
    </div>

    <!-- ستون ۳: پشتیبانی و راهنمایی -->
    <div class="footer-nav-col">
        <h3 class="footer-col-title"><?php esc_html_e('پشتیبانی و راهنمایی', 'market'); ?></h3>
        <?php
        if (has_nav_menu('footer-support')) {
            wp_nav_menu([
                'theme_location' => 'footer-support',
                'menu_class' => 'footer-links-list',
                'container' => false,
                'depth' => 1,
            ]);
        } else {
            ?>
            <ul class="footer-links-list">
                <li><a
                        href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url()); ?>"><?php esc_html_e('حساب کاربری', 'market'); ?></a>
                </li>
                <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('پرسش و پاسخ', 'market'); ?></a>
                </li>
                <li><a
                        href="<?php echo esc_url(home_url('/guide/')); ?>"><?php esc_html_e('راهنمای سفارش', 'market'); ?></a>
                </li>
                <li><a
                        href="<?php echo esc_url(home_url('/complaints/')); ?>"><?php esc_html_e('پیشنهادات و انتقادات', 'market'); ?></a>
                </li>
            </ul>
            <?php
        }
        ?>
    </div>

    <!-- ستون ۴: شبکه‌های اجتماعی و خبرنامه -->
    <div class="footer-nav-col footer-social-col">
        <h3 class="footer-col-title"><?php esc_html_e('شبکه‌های اجتماعی', 'market'); ?></h3>
        <div class="footer-social-icons">
            <?php if (!empty($instagram)): ?>
                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer"
                    class="social-icon-btn" aria-label="<?php esc_attr_e('اینستاگرام', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if (!empty($telegram)): ?>
                <a href="<?php echo esc_url($telegram); ?>" target="_blank" rel="noopener noreferrer"
                    class="social-icon-btn" aria-label="<?php esc_attr_e('تلگرام', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if (!empty($email)): ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="social-icon-btn"
                    aria-label="<?php esc_attr_e('ایمیل', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <form class="footer-newsletter-form" onsubmit="event.preventDefault();">
            <div class="newsletter-input-wrap">
                <input type="tel" class="newsletter-input" placeholder="<?php esc_attr_e('شماره تماس', 'market'); ?>"
                    dir="rtl">
                <button type="submit" class="newsletter-submit-btn"><?php esc_html_e('ثبت', 'market'); ?></button>
            </div>
        </form>
    </div>
</div>

<!-- ۳. بخش درباره ما و نمادهای اعتماد (تنظیم از پیشخوان > نمایش > تنظیمات قالب) -->
<div class="footer-about-wrap">
    <div class="footer-about-content">
        <span class="footer-about-label"><?php esc_html_e('درباره ما', 'market'); ?></span>
        <h4 class="footer-about-title"><?php echo esc_html($about_title); ?></h4>
        <p class="footer-about-desc">
            <?php echo esc_html($about_desc); ?>
        </p>
    </div>

    <div class="footer-trust-badges">
        <?php if (!empty($enamad)): ?>
            <div class="trust-badge-custom">
                <?php echo $enamad; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <?php else: ?>
            <div class="trust-badge-placeholder">
                <span><?php esc_html_e('اینماد', 'market'); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($samandehi)): ?>
            <div class="trust-badge-custom">
                <?php echo $samandehi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <?php else: ?>
            <div class="trust-badge-placeholder">
                <span><?php esc_html_e('ساماندهی', 'market'); ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>