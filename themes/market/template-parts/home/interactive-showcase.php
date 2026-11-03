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
<section class="home-section interactive-showcase-section" aria-label="<?php esc_attr_e('دنیای تجهیزات حرفه‌ای را کشف کنید', 'market'); ?>">
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
        <div class="interactive-banner-bg" style="<?php echo $img ? 'background-image: radial-gradient(circle at 50% 50%, rgba(39,39,42,0.4) 0%, rgba(24,24,27,0.85) 70%), url(' . esc_url($img) . '); background-size: cover; background-position: center;' : ''; ?>">
            <!-- Interactive Hotspots Container -->
            <div class="interactive-stage">
                <?php foreach ($hotspots as $point) : 
                    $x = isset($point['x']) ? floatval($point['x']) : 50;
                    $y = isset($point['y']) ? floatval($point['y']) : 50;
                    $label = isset($point['label']) ? $point['label'] : '';
                    $url = isset($point['url']) ? $point['url'] : '';
                    $has_link = !empty($url);
                    $tag = $has_link ? 'a' : 'div';
                ?>
                    <<?php echo $tag; ?> 
                        <?php if ($has_link) : ?>href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener"<?php endif; ?>
                        class="hotspot-point <?php echo $has_link ? 'has-link' : ''; ?>" 
                        style="right: <?php echo esc_attr($x); ?>%; top: <?php echo esc_attr($y); ?>%;" 
                        data-tooltip="<?php echo esc_attr($label); ?>"
                    >
                        <span class="hotspot-pulse"></span>
                        <span class="hotspot-dot"></span>
                        <?php if (!empty($label)) : ?>
                            <span class="hotspot-label"><?php echo esc_html($label); ?></span>
                        <?php endif; ?>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
