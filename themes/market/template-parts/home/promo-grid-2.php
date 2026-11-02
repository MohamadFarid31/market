<?php
/**
 * Market Theme — Triple Promo Banners Row 2 (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<section class="home-section promo-banners-section" aria-label="<?php esc_attr_e('بنرهای تبلیغاتی تجهیزات حرفه‌ای', 'market'); ?>">
    <div class="promo-banners-grid">
        <!-- Banner 1: سه‌پایه‌های حرفه‌ای -->
        <div class="promo-banner-card promo-dark-card promo-card-tripod-pro">
            <div class="promo-card-content">
                <span class="promo-card-sub"><?php esc_html_e('نگهداری مطمئن دوربین برای عکاسی و فیلمبرداری دقیق', 'market'); ?></span>
                <h3 class="promo-card-title"><?php esc_html_e('سه‌پایه‌های حرفه‌ای دوربین', 'market'); ?></h3>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                    <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                </a>
            </div>
            <div class="promo-card-visual">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><line x1="12" y1="2" x2="12" y2="10"></line><circle cx="12" cy="5" r="2"></circle><line x1="12" y1="10" x2="6" y2="22"></line><line x1="12" y1="10" x2="18" y2="22"></line></svg>
            </div>
        </div>

        <!-- Banner 2: تجهیزات ضبط صدا -->
        <div class="promo-banner-card promo-dark-card promo-card-audio">
            <div class="promo-card-content">
                <span class="promo-card-sub"><?php esc_html_e('میکروفون‌های حرفه‌ای برای تولید محتوای باکیفیت', 'market'); ?></span>
                <h3 class="promo-card-title"><?php esc_html_e('تجهیزات ضبط صدا', 'market'); ?></h3>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                    <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                </a>
            </div>
            <div class="promo-card-visual">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path></svg>
            </div>
        </div>

        <!-- Banner 3: گیمبال و تثبیت تصویر -->
        <div class="promo-banner-card promo-dark-card promo-card-gimbal">
            <div class="promo-card-content">
                <span class="promo-card-sub"><?php esc_html_e('ثبت ویدیوهای روان و سینمایی با موبایل', 'market'); ?></span>
                <h3 class="promo-card-title"><?php esc_html_e('گیمبال و تجهیزات تثبیت تصویر', 'market'); ?></h3>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                    <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                </a>
            </div>
            <div class="promo-card-visual">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
            </div>
        </div>
    </div>
</section>

