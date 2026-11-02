<?php
/**
 * Market Theme — Special Discounts Section (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!class_exists('WooCommerce')) {
    return;
}

// Fetch on sale products or fallback to recent products
$sale_products = wc_get_products([
    'limit'   => 8,
    'status'  => 'publish',
    'on_sale' => true,
]);

if (empty($sale_products)) {
    $sale_products = wc_get_products([
        'limit'   => 8,
        'status'  => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
    ]);
}
?>
<section class="home-section special-discounts-section" aria-label="<?php esc_attr_e('تخفیف‌های ویژه تاج‌بازار', 'market'); ?>">
    <div class="section-title-wrap">
        <div class="section-heading-col">
            <span class="section-badge"><?php esc_html_e('فرصت ویژه برای یک انتخاب حرفه‌ای', 'market'); ?></span>
            <h2 class="section-title"><?php esc_html_e('تخفیف‌های ویژه تاج‌بازار', 'market'); ?></h2>
        </div>
        <div class="section-action-col">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-taj-red">
                <?php esc_html_e('مشاهده همه محصولات', 'market'); ?>
            </a>
        </div>
    </div>

    <?php if (!empty($sale_products)) : ?>
        <div class="product-carousel-wrap">
            <div class="product-carousel-track" data-carousel="special-discounts">
                <?php
                foreach ($sale_products as $product_item) :
                    $post_object = get_post($product_item->get_id());
                    setup_postdata($GLOBALS['post'] =& $post_object);
                    echo '<div class="carousel-slide-item">';
                    get_template_part('template-parts/product/card');
                    echo '</div>';
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
            
            <div class="carousel-dots-wrap">
                <span class="carousel-dot active"></span>
                <span class="carousel-dot"></span>
                <span class="carousel-dot"></span>
                <span class="carousel-dot"></span>
                <span class="carousel-dot"></span>
            </div>
        </div>
    <?php endif; ?>
</section>

