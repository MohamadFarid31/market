<?php
/**
 * Market Theme — Triple Promo Banners Row 1 (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<section class="home-section promo-banners-section" aria-label="<?php esc_attr_e('بنرهای تبلیغاتی تجهیزات', 'market'); ?>">
    <div class="promo-banners-grid">
        <!-- Banner 1: نورپردازی -->
        <div class="promo-banner-card promo-dark-card promo-card-lighting">
            <div class="promo-card-content">
                <span class="promo-card-sub"><?php esc_html_e('نورپردازی دقیق برای ثبت جزئیات و ساخت محتوای چشمگیر', 'market'); ?></span>
                <h3 class="promo-card-title"><?php esc_html_e('تجهیزات نورپردازی حرفه‌ای', 'market'); ?></h3>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                    <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                </a>
            </div>
            <div class="promo-card-visual">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><rect x="3" y="3" width="18" height="14" rx="2"></rect><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
        </div>

        <!-- Banner 2: باتری دوربین -->
        <div class="promo-banner-card promo-dark-card promo-card-battery">
            <div class="promo-card-content">
                <span class="promo-card-sub"><?php esc_html_e('انرژی مطمئن برای لحظه‌های مهم', 'market'); ?></span>
                <h3 class="promo-card-title"><?php esc_html_e('باتری دوربین', 'market'); ?></h3>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                    <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                </a>
            </div>
            <div class="promo-card-visual">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><rect x="2" y="7" width="16" height="10" rx="2"></rect><line x1="22" y1="11" x2="22" y2="13"></line></svg>
            </div>
        </div>

        <!-- Banner 3: سه‌پایه رومیزی -->
        <div class="promo-banner-card promo-dark-card promo-card-tripod">
            <div class="promo-card-content">
                <span class="promo-card-sub"><?php esc_html_e('راهکاری ساده برای تولید محتوای روزمره و حرفه‌ای', 'market'); ?></span>
                <h3 class="promo-card-title"><?php esc_html_e('سه‌پایه رومیزی موبایل', 'market'); ?></h3>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                    <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                </a>
            </div>
            <div class="promo-card-visual">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><circle cx="12" cy="5" r="2"></circle><line x1="12" y1="10" x2="6" y2="22"></line><line x1="12" y1="10" x2="18" y2="22"></line></svg>
            </div>
        </div>
    </div>
</section>

