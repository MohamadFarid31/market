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

$product_id   = $product->get_id();
$brand_terms  = get_the_terms($product_id, 'product_brand');
$brand_name   = (!empty($brand_terms) && !is_wp_error($brand_terms)) ? $brand_terms[0]->name : '';
$sku          = $product->get_sku();
$price_html   = $product->get_price_html();
$has_price    = !empty($product->get_price()) && (float) $product->get_price() > 0;
$is_in_stock  = $product->is_in_stock();
$is_purchasable = $product->is_purchasable() && $is_in_stock && $has_price && $product->is_type('simple');
?>
<div <?php wc_product_class('product-card', $product); ?>>
    <div class="product-card-top-actions">
        <button class="product-wishlist-btn" type="button" aria-label="<?php esc_attr_e('افزودن به علاقه‌مندی‌ها', 'market'); ?>" data-product-id="<?php echo esc_attr($product_id); ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
        <div class="product-card-info-wrap">
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

            <div class="product-card-pricing">
                <?php if (!empty($price_html)) : ?>
                    <div class="product-price">
                        <?php echo $price_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php else : ?>
                    <span class="product-call-for-price"><?php esc_html_e('تماس بگیرید', 'market'); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- دکمه خرید، نمایش سریع و اقدامات کارت (هاور دسکتاپ و موبایل) -->
        <div class="product-card-action-wrap">
            <?php if ($is_purchasable) : ?>
                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" class="product-card-btn btn-add-to-cart ajax_add_to_cart" aria-label="<?php esc_attr_e('افزودن به سبد خرید', 'market'); ?>">
                    <?php esc_html_e('افزودن به سبد خرید', 'market'); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-card-btn btn-more-info" aria-label="<?php esc_attr_e('اطلاعات بیشتر', 'market'); ?>">
                    <?php esc_html_e('اطلاعات بیشتر', 'market'); ?>
                </a>
            <?php endif; ?>

            <div class="product-action-icons-group">
                <button type="button" class="product-action-icon-btn product-quick-view-btn" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php esc_attr_e('نمایش سریع', 'market'); ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <span class="taj-tooltip"><?php esc_html_e('نمایش سریع', 'market'); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>
