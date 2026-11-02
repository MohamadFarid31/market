<?php
/**
 * Market Theme — Taj Bazar Footer Widgets Area
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>

<!-- ۱. نوار اطلاعات تماس و لوگو -->
<div class="footer-top-bar">
    <div class="footer-top-logo">
        <span class="taj-bazar-logo">
            <svg class="taj-bazar-emblem" width="36" height="36" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 9L15 15L20 7L25 15L28 9L29 18H11L12 9Z" fill="#E52534"/>
                <circle cx="20" cy="27" r="11" stroke="#E52534" stroke-width="2.5"/>
                <circle cx="20" cy="27" r="4.5" fill="#E52534"/>
                <path d="M20 16.5L25.5 22M27.5 27L22 32.5M16.5 32L12.5 25.5M12.5 22.5L18 17M27 22.5L20 27" stroke="#E52534" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span class="taj-bazar-text">TAJ BAZAR</span>
        </span>
    </div>

    <div class="footer-contact-items">
        <a href="tel:09128184981" class="footer-contact-link">
            <span>09128184981</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
        </a>

        <a href="mailto:Info@tajbazar.ir" class="footer-contact-link">
            <span>Info@tajbazar.ir</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        </a>

        <div class="footer-contact-address">
            <span><?php esc_html_e('بازار بزرگ تهران، خیابان ناصرخسرو، نبش سوراسرافیل، پلاک ۱۹۸', 'market'); ?></span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        </div>
    </div>
</div>

<!-- ۲. ستون‌های لینک‌ها و دسترسی‌ها -->
<div class="footer-nav-grid">
    <!-- ستون ۱: دسترسی سریع -->
    <div class="footer-nav-col">
        <h3 class="footer-col-title"><?php esc_html_e('دسترسی سریع', 'market'); ?></h3>
        <ul class="footer-links-list">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'market'); ?></a></li>
            <?php if (class_exists('WooCommerce')) : ?>
                <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('فروشگاه', 'market'); ?></a></li>
            <?php endif; ?>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('تماس با ما', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('وبلاگ', 'market'); ?></a></li>
        </ul>
    </div>

    <!-- ستون ۲: دسته‌بندی‌ها -->
    <div class="footer-nav-col">
        <h3 class="footer-col-title"><?php esc_html_e('دسته‌بندی‌ها', 'market'); ?></h3>
        <ul class="footer-links-list">
            <li><a href="<?php echo esc_url(home_url('/product-category/lighting/')); ?>"><?php esc_html_e('نورپردازی', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/product-category/original-batteries-chargers/')); ?>"><?php esc_html_e('باتری و شارژرهای اصل', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/product-category/copy-batteries-chargers/')); ?>"><?php esc_html_e('باتری و شارژرهای کپی', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/product-category/lavalier-microphones/')); ?>"><?php esc_html_e('میکروفون یقه‌ای', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/product-category/camera-accessories/')); ?>"><?php esc_html_e('لوازم جانبی دوربین', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/product-category/tripods/')); ?>"><?php esc_html_e('پایه دوربین و رومیزی', 'market'); ?></a></li>
        </ul>
    </div>

    <!-- ستون ۳: پشتیبانی و راهنمایی -->
    <div class="footer-nav-col">
        <h3 class="footer-col-title"><?php esc_html_e('پشتیبانی و راهنمایی', 'market'); ?></h3>
        <ul class="footer-links-list">
            <li><a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url()); ?>"><?php esc_html_e('حساب کاربری', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('پرسش و پاسخ', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/guide/')); ?>"><?php esc_html_e('راهنمای سفارش', 'market'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/complaints/')); ?>"><?php esc_html_e('پیشنهادات و انتقادات', 'market'); ?></a></li>
        </ul>
    </div>

    <!-- ستون ۴: شبکه‌های اجتماعی و خبرنامه -->
    <div class="footer-nav-col footer-social-col">
        <h3 class="footer-col-title"><?php esc_html_e('شبکه‌های اجتماعی', 'market'); ?></h3>
        <div class="footer-social-icons">
            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?php esc_attr_e('اینستاگرام', 'market'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
            <a href="https://t.me" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?php esc_attr_e('تلگرام', 'market'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
            </a>
            <a href="mailto:Info@tajbazar.ir" class="social-icon-btn" aria-label="<?php esc_attr_e('ایمیل', 'market'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </a>
        </div>

        <form class="footer-newsletter-form" onsubmit="event.preventDefault();">
            <div class="newsletter-input-wrap">
                <input type="tel" class="newsletter-input" placeholder="<?php esc_attr_e('شماره تماس', 'market'); ?>" dir="rtl">
                <button type="submit" class="newsletter-submit-btn"><?php esc_html_e('ثبت', 'market'); ?></button>
            </div>
        </form>
    </div>
</div>

<!-- ۳. بخش درباره ما و نمادهای اعتماد -->
<div class="footer-about-wrap">
    <div class="footer-about-content">
        <span class="footer-about-label"><?php esc_html_e('درباره ما', 'market'); ?></span>
        <h4 class="footer-about-title"><?php esc_html_e('فروشگاه تاج بازار', 'market'); ?></h4>
        <p class="footer-about-desc">
            <?php esc_html_e('تاج بازار فروشگاه تخصصی تجهیزات عکاسی، فیلم‌برداری و تولید محتواست. با ارائه مجموعه‌ای از دوربین‌ها، لنزها، تجهیزات نورپردازی، صدا و لوازم جانبی، تلاش می‌کنیم نیاز عکاسان، فیلم‌برداران و تولیدکنندگان محتوا را به‌صورت کامل پوشش دهیم. ارائه محصولات اصل، مشاوره تخصصی پیش از خرید و پشتیبانی واقعی، این امکان را فراهم می‌کند تا با اطمینان بیشتر، تجهیزات متناسب با نیاز و بودجه خود را انتخاب کنید.', 'market'); ?>
        </p>
    </div>

    <div class="footer-trust-badges">
        <div class="trust-badge-placeholder">
            <span>اینماد</span>
        </div>
        <div class="trust-badge-placeholder">
            <span>ساماندهی</span>
        </div>
    </div>
</div>
