<?php
/**
 * Market Theme — Triple Promo Banners Row 2 (Visual Image Banners)
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
?>
<section class="home-section promo-banners-section" aria-label="<?php esc_attr_e('بنرهای تبلیغاتی ردیف دوم', 'market'); ?>">
    <div class="promo-banners-grid">
        <?php for ($i = 1; $i <= 3; $i++) : 
            $img = $get_val("promo_row2_{$i}_img", '');
            $url = $get_val("promo_row2_{$i}_url", '');
        ?>
            <div class="promo-banner-item">
                <?php if (!empty($img)) : ?>
                    <?php if (!empty($url)) : ?>
                        <a href="<?php echo esc_url($url); ?>" class="promo-card-link">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo sprintf(esc_attr__('بنر تبلیغاتی %s', 'market'), $i); ?>" class="promo-card-img">
                        </a>
                    <?php else : ?>
                        <div class="promo-card-link">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo sprintf(esc_attr__('بنر تبلیغاتی %s', 'market'), $i); ?>" class="promo-card-img">
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <!-- کارت پیش‌فرض -->
                    <div class="promo-banner-card promo-dark-card promo-default-card">
                        <div class="promo-card-content">
                            <span class="promo-card-sub"><?php esc_html_e('انتخاب حرفه‌ای', 'market'); ?></span>
                            <h3 class="promo-card-title"><?php echo sprintf(esc_html__('بنر تبلیغاتی %s', 'market'), market_to_persian_numbers($i)); ?></h3>
                            <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="btn-promo-pill">
                                <?php esc_html_e('مشاهده و خرید', 'market'); ?>
                            </a>
                        </div>
                        <div class="promo-card-visual">
                            <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.15"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path></svg>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</section>
