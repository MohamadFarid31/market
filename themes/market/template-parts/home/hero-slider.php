<?php
/**
 * Market Theme — Homepage Hero Slider (Dynamic Visual Banner Repeater)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$home_id = (int) get_option('page_on_front');
if (!$home_id && get_the_ID()) {
    $home_id = get_the_ID();
}
$meta = get_post_meta($home_id, '_market_home_data', true);
if (!is_array($meta)) {
    $meta = [];
}

$hero_slides = isset($meta['hero_slides']) && is_array($meta['hero_slides']) ? $meta['hero_slides'] : [];

// Filter out completely empty slides
$active_slides = [];
foreach ($hero_slides as $s) {
    if (!empty($s['img'])) {
        $active_slides[] = $s;
    }
}

// Fallback sample slides if none uploaded yet
if (empty($active_slides)) {
    $active_slides = [
        [
            'img' => get_template_directory_uri() . '/assets/images/hero-mic.png',
            'url' => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            'is_fallback' => true,
        ],
    ];
}
$slides_count = count($active_slides);
?>
<section class="hero-slider-section" aria-label="<?php esc_attr_e('اسلایدر بنر اصلی', 'market'); ?>">
    <div class="hero-slider-container" id="heroSlider">
        <div class="hero-slider-track" id="heroSliderTrack">
            <?php foreach ($active_slides as $idx => $slide) : 
                $is_active = ($idx === 0) ? 'active' : '';
            ?>
                <div class="hero-slide <?php echo esc_attr($is_active); ?>" data-slide="<?php echo esc_attr($idx); ?>">
                    <?php if (!empty($slide['is_fallback'])) : ?>
                        <!-- بنر پیش‌فرض تا زمان بارگذاری بنر توسط مدیر -->
                        <div class="hero-slide-bg hero-gradient-dark">
                            <div class="hero-slide-content">
                                <span class="hero-slide-badge"><?php esc_html_e('تجهیزات تخصصی', 'market'); ?></span>
                                <span class="hero-slide-sub"><?php esc_html_e('هر کلمه را با وضوح در هر شرایطی ثبت کنید', 'market'); ?></span>
                                <h1 class="hero-slide-title"><?php esc_html_e('انواع میکروفون‌های یقه‌ای و استودیویی', 'market'); ?></h1>
                                <div class="hero-cta-wrap">
                                    <a href="<?php echo esc_url($slide['url']); ?>" class="btn-hero-cta">
                                        <span><?php esc_html_e('مشاهده و خرید', 'market'); ?></span>
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- بنر تصویری سفارشی آپلود شده -->
                        <?php if (!empty($slide['url'])) : ?>
                            <a href="<?php echo esc_url($slide['url']); ?>" class="hero-slide-link">
                                <img src="<?php echo esc_url($slide['img']); ?>" alt="<?php esc_attr_e('بنر تبلیغاتی', 'market'); ?>" class="hero-slide-img" loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>">
                            </a>
                        <?php else : ?>
                            <div class="hero-slide-link">
                                <img src="<?php echo esc_url($slide['img']); ?>" alt="<?php esc_attr_e('بنر تبلیغاتی', 'market'); ?>" class="hero-slide-img" loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>">
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($slides_count > 1) : ?>
            <!-- Slider Controls -->
            <button class="hero-arrow-btn hero-arrow-prev" type="button" aria-label="<?php esc_attr_e('اسلاید قبلی', 'market'); ?>">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <button class="hero-arrow-btn hero-arrow-next" type="button" aria-label="<?php esc_attr_e('اسلاید بعدی', 'market'); ?>">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>

            <!-- Slider Pagination Dots -->
            <div class="hero-dots" id="heroDots">
                <?php for ($d = 0; $d < $slides_count; $d++) : ?>
                    <button class="hero-dot <?php echo $d === 0 ? 'active' : ''; ?>" type="button" data-slide-target="<?php echo $d; ?>" aria-label="<?php echo sprintf(esc_attr__('اسلاید %s', 'market'), $d + 1); ?>"></button>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
