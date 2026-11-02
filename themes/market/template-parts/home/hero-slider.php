<?php
/**
 * Market Theme — Homepage Hero Slider (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<section class="hero-slider-section" aria-label="<?php esc_attr_e('اسلایدر بنر اصلی', 'market'); ?>">
    <div class="hero-slider-container" id="heroSlider">
        <!-- Slide 1: میکروفون‌های یقه‌ای -->
        <div class="hero-slide active" data-slide="0">
            <div class="hero-slide-bg hero-gradient-dark">
                <div class="hero-slide-content">
                    <span class="hero-slide-badge"><?php esc_html_e('تولید محتوای حرفه‌ای', 'market'); ?></span>
                    <span class="hero-slide-sub"><?php esc_html_e('هر کلمه را با وضوح در هر شرایطی ثبت کنید', 'market'); ?></span>
                    <h1 class="hero-slide-title"><?php esc_html_e('انواع میکروفون‌های یقه‌ای', 'market'); ?></h1>
                    
                    <ul class="hero-features-list">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span><?php esc_html_e('صدای شفاف و حرفه‌ای', 'market'); ?></span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span><?php esc_html_e('بی‌سیم و پایدار', 'market'); ?></span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span><?php esc_html_e('سبک و قابل حمل', 'market'); ?></span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span><?php esc_html_e('مناسب موبایل و دوربین', 'market'); ?></span>
                        </li>
                    </ul>

                    <div class="hero-cta-wrap">
                        <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-hero-cta">
                            <span><?php esc_html_e('مشاهده و خرید', 'market'); ?></span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </a>
                    </div>
                </div>
                <div class="hero-slide-visual">
                    <div class="hero-image-glow"></div>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-mic.png'); ?>" alt="<?php esc_attr_e('میکروفون یقه‌ای', 'market'); ?>" class="hero-img" onerror="this.style.display='none';">
                </div>
            </div>
        </div>

        <!-- Slide 2: خرید اقساطی -->
        <div class="hero-slide" data-slide="1">
            <div class="hero-slide-bg hero-gradient-blue">
                <div class="hero-slide-content">
                    <span class="hero-slide-badge"><?php esc_html_e('تسهیلات ویژه', 'market'); ?></span>
                    <span class="hero-slide-sub"><?php esc_html_e('تجهیزات موردنیازتان را آسان‌تر از همیشه انتخاب کنید', 'market'); ?></span>
                    <h2 class="hero-slide-title"><?php esc_html_e('خرید به صورت اقساطی', 'market'); ?></h2>
                    <p class="hero-slide-desc"><?php esc_html_e('بدون ضامن، با بازپرداخت منعطف برای عکاسان و سازندگان محتوا', 'market'); ?></p>
                    <div class="hero-cta-wrap">
                        <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-hero-cta">
                            <span><?php esc_html_e('مشاهده محصولات', 'market'); ?></span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <button class="hero-arrow-btn hero-arrow-prev" type="button" aria-label="<?php esc_attr_e('اسلاید قبلی', 'market'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
        <button class="hero-arrow-btn hero-arrow-next" type="button" aria-label="<?php esc_attr_e('اسلاید بعدی', 'market'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>

        <!-- Slider Pagination Dots -->
        <div class="hero-dots" id="heroDots">
            <button class="hero-dot active" type="button" data-slide-target="0" aria-label="<?php esc_attr_e('اسلاید ۱', 'market'); ?>"></button>
            <button class="hero-dot" type="button" data-slide-target="1" aria-label="<?php esc_attr_e('اسلاید ۲', 'market'); ?>"></button>
        </div>
    </div>
</section>

