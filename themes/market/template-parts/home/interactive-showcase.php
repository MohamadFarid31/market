<?php
/**
 * Market Theme — Interactive Feature Banner Section (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<section class="home-section interactive-showcase-section" aria-label="<?php esc_attr_e('دنیای تجهیزات حرفه‌ای را کشف کنید', 'market'); ?>">
    <div class="section-title-wrap text-center max-w-2xl">
        <span class="section-badge"><?php esc_html_e('جزئیات بیشتر، انتخابی دقیق‌تر', 'market'); ?></span>
        <h2 class="section-title showcase-heading"><?php esc_html_e('دنیای تجهیزات حرفه‌ای را کشف کنید', 'market'); ?></h2>
        <p class="showcase-desc">
            <?php esc_html_e('هر محصول برای یک هدف ساخته شده است: از ثبت تصاویر خیره‌کننده تا تولید محتوای حرفه‌ای، تجهیزات موردنیاز خود را از میان مجموعه‌ای از محصولات تخصصی پیدا کنید و با اطمینان، ابزار مناسب برای مسیر خلاقیت خود را انتخاب کنید.', 'market'); ?>
        </p>
    </div>

    <div class="interactive-banner-container">
        <div class="interactive-banner-bg">
            <!-- Equipment Graphic Layout with SVG / CSS Shapes -->
            <div class="interactive-stage">
                <!-- Hotspot 1: گیمبال -->
                <div class="hotspot-point" style="top: 48%; right: 18%;" data-tooltip="<?php esc_attr_e('گیمبال تثبیت‌کننده ۳ محوره', 'market'); ?>">
                    <span class="hotspot-pulse"></span>
                    <span class="hotspot-dot"></span>
                    <span class="hotspot-label"><?php esc_html_e('گیمبال و استابلایزر', 'market'); ?></span>
                </div>

                <!-- Hotspot 2: لنز و دوربین -->
                <div class="hotspot-point" style="top: 60%; right: 48%;" data-tooltip="<?php esc_attr_e('لنزهای تخصصی پرایم و زوم', 'market'); ?>">
                    <span class="hotspot-pulse"></span>
                    <span class="hotspot-dot"></span>
                    <span class="hotspot-label"><?php esc_html_e('دوربین و لنز', 'market'); ?></span>
                </div>

                <!-- Hotspot 3: نور استودیویی LED -->
                <div class="hotspot-point" style="top: 32%; right: 54%;" data-tooltip="<?php esc_attr_e('پنل نور ثابت LED و رینگ‌لایت', 'market'); ?>">
                    <span class="hotspot-pulse"></span>
                    <span class="hotspot-dot"></span>
                    <span class="hotspot-label"><?php esc_html_e('پنل نور LED', 'market'); ?></span>
                </div>

                <!-- Hotspot 4: سه‌پایه حرفه‌ای -->
                <div class="hotspot-point" style="top: 45%; right: 78%;" data-tooltip="<?php esc_attr_e('سه‌پایه‌های فیبر کربن عکاسی و فیلمبرداری', 'market'); ?>">
                    <span class="hotspot-pulse"></span>
                    <span class="hotspot-dot"></span>
                    <span class="hotspot-label"><?php esc_html_e('سه‌پایه حرفه‌ای', 'market'); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

