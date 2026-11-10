<?php
/**
 * Market Theme — Interactive Feature Banner Section (Dynamic Hotspots & Links)
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

$get_val = function ($key, $default = '') use ($meta) {
    return (!empty($meta[$key])) ? $meta[$key] : $default;
};

$badge = $get_val('showcase_badge', 'جزئیات بیشتر، انتخابی دقیق‌تر');
$title = $get_val('showcase_title', 'دنیای تجهیزات حرفه‌ای را کشف کنید');
$desc  = $get_val('showcase_desc', 'هر محصول برای یک هدف ساخته شده است: از ثبت تصاویر خیره‌کننده تا تولید محتوای حرفه‌ای، تجهیزات موردنیاز خود را از میان مجموعه‌ای از محصولات تخصصی پیدا کنید و با اطمینان، ابزار مناسب برای مسیر خلاقیت خود را انتخاب کنید.');
$img   = $get_val('showcase_img', '');

$hotspots = isset($meta['showcase_hotspots']) && is_array($meta['showcase_hotspots']) ? $meta['showcase_hotspots'] : [];
if (empty($hotspots)) {
    $hotspots = [
        ['x' => '18', 'y' => '48', 'label' => 'گیمبال و استابلایزر', 'url' => ''],
        ['x' => '48', 'y' => '60', 'label' => 'دوربین و لنز', 'url' => ''],
        ['x' => '54', 'y' => '32', 'label' => 'پنل نور LED', 'url' => ''],
        ['x' => '78', 'y' => '45', 'label' => 'سه‌پایه حرفه‌ای', 'url' => ''],
    ];
}
?>
<section class="home-section interactive-showcase-section" aria-label="<?php echo esc_attr($title); ?>">
    <div class="section-title-wrap text-center max-w-2xl">
        <?php if (!empty($badge)) : ?>
            <span class="section-badge"><?php echo esc_html($badge); ?></span>
        <?php endif; ?>
        <?php if (!empty($title)) : ?>
            <h2 class="section-title showcase-heading"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if (!empty($desc)) : ?>
            <p class="showcase-desc">
                <?php echo esc_html($desc); ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="interactive-banner-container">
        <div class="interactive-stage" id="interactiveStage">
            <?php if (!empty($img)) : ?>
                <img 
                    src="<?php echo esc_url($img); ?>" 
                    alt="<?php echo esc_attr($title); ?>" 
                    class="interactive-banner-img" 
                    loading="lazy"
                >
            <?php else : ?>
                <div class="interactive-banner-fallback">
                    <span><?php esc_html_e('تصویر بنر انتخاب نشده است', 'market'); ?></span>
                </div>
            <?php endif; ?>

            <!-- Interactive Hotspots Container -->
            <div class="hotspots-layer" id="hotspotsLayer">
                <?php foreach ($hotspots as $index => $point) : 
                    $x = isset($point['x']) ? floatval($point['x']) : 50;
                    $y = isset($point['y']) ? floatval($point['y']) : 50;
                    $label = isset($point['label']) ? trim($point['label']) : '';
                    $url = isset($point['url']) ? trim($point['url']) : '';
                    $has_link = !empty($url);
                ?>
                    <div 
                        class="hotspot-point" 
                        style="right: <?php echo esc_attr($x); ?>%; top: <?php echo esc_attr($y); ?>%;"
                        data-x="<?php echo esc_attr($x); ?>"
                        data-y="<?php echo esc_attr($y); ?>"
                        data-index="<?php echo esc_attr($index); ?>"
                    >
                        <button 
                            type="button" 
                            class="hotspot-trigger" 
                            aria-label="<?php echo esc_attr($label ? $label : sprintf(__('نقطه تعاملی %d', 'market'), $index + 1)); ?>"
                            aria-expanded="false"
                        >
                            <span class="hotspot-pulse"></span>
                            <span class="hotspot-dot"></span>
                        </button>

                        <div class="hotspot-tooltip" role="tooltip" aria-hidden="true">
                            <?php if (!empty($label)) : ?>
                                <h4 class="hotspot-tooltip-title"><?php echo esc_html($label); ?></h4>
                            <?php endif; ?>
                            
                            <?php if ($has_link) : ?>
                                <a href="<?php echo esc_url($url); ?>" class="hotspot-tooltip-btn">
                                    <?php esc_html_e('مشاهده محصولات', 'market'); ?>
                                </a>
                            <?php else : ?>
                                <span class="hotspot-tooltip-btn hotspot-tooltip-btn--disabled">
                                    <?php esc_html_e('مشاهده محصولات', 'market'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
