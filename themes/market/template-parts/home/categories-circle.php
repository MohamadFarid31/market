<?php
/**
 * Market Theme — Circular Categories Section & 3-Item Auto-Carousel (Taj Bazar Style)
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

$badge_text = !empty($meta['circle_badge']) ? $meta['circle_badge'] : esc_html__('همه تجهیزات موردنیاز شما، در یک نگاه', 'market');
$section_title = !empty($meta['circle_title']) ? $meta['circle_title'] : esc_html__('دسته‌بندی محصولات', 'market');

$circle_categories = isset($meta['circle_categories']) && is_array($meta['circle_categories']) ? $meta['circle_categories'] : [];

// Fallback to default categories if not yet configured
if (empty($circle_categories)) {
    $default_cats = [
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

    $circle_categories = [];
    foreach ($default_cats as $cat) {
        $term = get_term_by('slug', $cat['slug'], 'product_cat');
        $url = ($term && !is_wp_error($term)) ? get_term_link($term) : (function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'));
        $title = ($term && !is_wp_error($term)) ? $term->name : $cat['title'];
        $thumbnail_id = ($term && !is_wp_error($term)) ? get_term_meta($term->term_id, 'thumbnail_id', true) : null;
        $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';

        $circle_categories[] = [
            'title' => $title,
            'url'   => $url,
            'img'   => $image_url,
            'icon'  => $cat['icon'],
        ];
    }
}

$total_items = count($circle_categories);
if ($total_items === 0) {
    return;
}
?>
<section class="home-section categories-circle-section" aria-label="<?php echo esc_attr($section_title); ?>">
    <div class="section-title-wrap text-center">
        <span class="section-badge"><?php echo esc_html($badge_text); ?></span>
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
    </div>

    <div class="categories-carousel-container" id="categoriesCircleCarousel" data-autoplay-interval="3500">
        <?php if ($total_items > 3) : ?>
            <button type="button" class="categories-nav-btn categories-nav-prev" aria-label="<?php esc_attr_e('دسته قبلی', 'market'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <button type="button" class="categories-nav-btn categories-nav-next" aria-label="<?php esc_attr_e('دسته بعدی', 'market'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
        <?php endif; ?>

        <div class="categories-carousel-viewport">
            <div class="categories-carousel-track">
                <?php foreach ($circle_categories as $cat) : 
                    $term_title = !empty($cat['title']) ? $cat['title'] : '';
                    $cat_link = !empty($cat['url']) ? $cat['url'] : home_url('/');
                    $image_url = !empty($cat['img']) ? $cat['img'] : '';
                    $cat_icon = isset($cat['icon']) ? $cat['icon'] : 'gear';
                ?>
                    <div class="category-carousel-slide">
                        <a href="<?php echo esc_url($cat_link); ?>" class="category-circle-item">
                            <div class="circle-thumb-frame">
                                <?php if (!empty($image_url)) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_title); ?>" class="circle-thumb-img" loading="lazy">
                                <?php else : ?>
                                    <div class="circle-icon-visual icon-<?php echo esc_attr($cat_icon); ?>">
                                        <?php if ($cat_icon === 'tripod') : ?>
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><line x1="12" y1="2" x2="12" y2="10"></line><circle cx="12" cy="5" r="2"></circle><line x1="12" y1="10" x2="6" y2="22"></line><line x1="12" y1="10" x2="18" y2="22"></line><line x1="12" y1="10" x2="12" y2="22"></line></svg>
                                        <?php elseif ($cat_icon === 'lighting') : ?>
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="14" rx="2"></rect><circle cx="12" cy="10" r="3"></circle><line x1="12" y1="17" x2="12" y2="21"></line><line x1="8" y1="21" x2="16" y2="21"></line></svg>
                                        <?php elseif ($cat_icon === 'microphone') : ?>
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                                        <?php elseif ($cat_icon === 'camera-acc') : ?>
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                                        <?php elseif ($cat_icon === 'battery-org' || $cat_icon === 'battery-copy') : ?>
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="7" width="16" height="10" rx="2"></rect><line x1="22" y1="11" x2="22" y2="13"></line><line x1="6" y1="11" x2="6" y2="13"></line><line x1="10" y1="11" x2="10" y2="13"></line></svg>
                                        <?php else : ?>
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"></circle><path d="M12 8v8"></path><path d="M8 12h8"></path></svg>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <span class="category-circle-label"><?php echo esc_html($term_title); ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($total_items > 3) : ?>
            <div class="categories-carousel-dots">
                <?php 
                $dots_count = $total_items - 3 + 1;
                for ($d = 0; $d < $dots_count; $d++) : ?>
                    <button type="button" class="categories-dot <?php echo $d === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $d; ?>" aria-label="<?php echo sprintf(esc_attr__('بخش %s', 'market'), $d + 1); ?>"></button>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
