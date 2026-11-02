<?php
/**
 * Market Theme — Universal Product Card Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<div <?php wc_product_class('product-card', $product); ?>>
    <div class="product-card-thumb">
        <?php woocommerce_show_product_loop_sale_flash(); ?>
        <a href="<?php echo esc_url($product->get_permalink()); ?>" aria-label="<?php echo esc_attr($product->get_name()); ?>">
            <?php echo $product->get_image('market-product-thumb'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </a>
    </div>

    <div class="product-card-content">
        <?php
        $cats = wc_get_product_category_list($product->get_id(), ', ');
        if ($cats) :
            ?>
            <span class="product-card-category"><?php echo $cats; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
        <?php endif; ?>

        <h3 class="product-card-title">
            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                <?php echo esc_html($product->get_name()); ?>
            </a>
        </h3>

        <div class="product-card-pricing">
            <div class="product-price">
                <?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <div class="product-card-action">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>
    </div>
</div>
