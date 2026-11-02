<?php
/**
 * Market Theme — Universal Product Card Component (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$product_id = $product->get_id();
$brand_terms = get_the_terms($product_id, 'product_brand');
$brand_name  = (!empty($brand_terms) && !is_wp_error($brand_terms)) ? $brand_terms[0]->name : '';
$sku         = $product->get_sku();
?>
<div <?php wc_product_class('product-card', $product); ?>>
    <div class="product-card-top-actions">
        <button class="product-wishlist-btn" type="button" aria-label="<?php esc_attr_e('افزودن به علاقه‌مندی‌ها', 'market'); ?>" data-product-id="<?php echo esc_attr($product_id); ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
        </button>
        <?php if ($product->is_on_sale()) : ?>
            <span class="product-sale-pill"><?php esc_html_e('تخفیف', 'market'); ?></span>
        <?php endif; ?>
    </div>

    <div class="product-card-thumb">
        <a href="<?php echo esc_url($product->get_permalink()); ?>" aria-label="<?php echo esc_attr($product->get_name()); ?>">
            <?php echo $product->get_image('market-product-thumb'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </a>
    </div>

    <div class="product-card-content">
        <h3 class="product-card-title">
            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                <?php echo esc_html($product->get_name()); ?>
            </a>
        </h3>

        <?php if (!empty($sku) || !empty($brand_name)) : ?>
            <div class="product-card-subtitle">
                <?php echo esc_html(!empty($sku) ? $sku : $brand_name); ?>
            </div>
        <?php endif; ?>

        <?php
        $cats = wc_get_product_category_list($product_id, '، ');
        if ($cats) :
            ?>
            <div class="product-card-category"><?php echo wp_strip_all_tags($cats); ?></div>
        <?php endif; ?>

        <div class="product-card-pricing">
            <div class="product-price">
                <?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div>
    </div>
</div>
