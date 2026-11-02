<?php
/**
 * Market Theme — Circular Categories Section (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$categories_data = [
    [
        'title' => esc_html__('نورپردازی', 'market'),
        'slug'  => 'lighting',
        'icon'  => 'lighting',
    ],
    [
        'title' => esc_html__('باتری و شارژرهای اصلی', 'market'),
        'slug'  => 'original-batteries-chargers',
        'icon'  => 'battery-org',
    ],
    [
        'title' => esc_html__('باتری و شارژرهای کپی', 'market'),
        'slug'  => 'copy-batteries-chargers',
        'icon'  => 'battery-copy',
    ],
    [
        'title' => esc_html__('میکروفون یقه‌ای', 'market'),
        'slug'  => 'lavalier-microphones',
        'icon'  => 'microphone',
    ],
    [
        'title' => esc_html__('لوازم جانبی دوربین', 'market'),
        'slug'  => 'camera-accessories',
        'icon'  => 'camera-acc',
    ],
    [
        'title' => esc_html__('پایه دوربین و رومیزی', 'market'),
        'slug'  => 'tripods',
        'icon'  => 'tripod',
    ],
];
?>
<section class="home-section categories-circle-section" aria-label="<?php esc_attr_e('دسته‌بندی محصولات', 'market'); ?>">
    <div class="section-title-wrap text-center">
        <span class="section-badge"><?php esc_html_e('همه تجهیزات موردنیاز شما، در یک نگاه', 'market'); ?></span>
        <h2 class="section-title"><?php esc_html_e('دسته‌بندی محصولات', 'market'); ?></h2>
    </div>

    <div class="categories-circle-grid">
        <?php foreach ($categories_data as $cat) : 
            $term = get_term_by('slug', $cat['slug'], 'product_cat');
            $term_link = ($term && !is_wp_error($term)) ? get_term_link($term) : (function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'));
            $term_title = ($term && !is_wp_error($term)) ? $term->name : $cat['title'];
            $thumbnail_id = ($term && !is_wp_error($term)) ? get_term_meta($term->term_id, 'thumbnail_id', true) : null;
            $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
        ?>
            <a href="<?php echo esc_url($term_link); ?>" class="category-circle-item">
                <div class="circle-thumb-frame">
                    <?php if (!empty($image_url)) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_title); ?>" class="circle-thumb-img">
                    <?php else : ?>
                        <div class="circle-icon-visual icon-<?php echo esc_attr($cat['icon']); ?>">
                            <?php if ($cat['icon'] === 'tripod') : ?>
                                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><line x1="12" y1="2" x2="12" y2="10"></line><circle cx="12" cy="5" r="2"></circle><line x1="12" y1="10" x2="6" y2="22"></line><line x1="12" y1="10" x2="18" y2="22"></line><line x1="12" y1="10" x2="12" y2="22"></line></svg>
                            <?php elseif ($cat['icon'] === 'lighting') : ?>
                                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="14" rx="2"></rect><circle cx="12" cy="10" r="3"></circle><line x1="12" y1="17" x2="12" y2="21"></line><line x1="8" y1="21" x2="16" y2="21"></line></svg>
                            <?php elseif ($cat['icon'] === 'microphone') : ?>
                                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                            <?php elseif ($cat['icon'] === 'camera-acc') : ?>
                                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                            <?php else : ?>
                                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="7" width="16" height="10" rx="2"></rect><line x1="22" y1="11" x2="22" y2="13"></line><line x1="6" y1="11" x2="6" y2="13"></line><line x1="10" y1="11" x2="10" y2="13"></line></svg>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <span class="category-circle-label"><?php echo esc_html($term_title); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

