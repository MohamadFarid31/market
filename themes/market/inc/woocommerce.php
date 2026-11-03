<?php
/**
 * Market Theme — WooCommerce Integration & HPOS Declaration
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/**
 * 1. Declare WooCommerce High-Performance Order Storage (HPOS) Compatibility
 */
add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'custom_order_tables',
            get_template_directory() . '/style.css',
            true
        );
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'cart_checkout_blocks',
            get_template_directory() . '/style.css',
            true
        );
    }
});

/**
 * 2. Unhook Default WooCommerce Wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Custom Clean Content Wrappers
 */
add_action('woocommerce_before_main_content', function () {
    echo '<main id="primary" class="site-main woocommerce-main"><div class="container">';
}, 10);

add_action('woocommerce_after_main_content', function () {
    echo '</div></main>';
}, 10);

/**
 * 3. AJAX Fragments for Slide-Out Cart Counter & Mini-Cart
 */
if (!function_exists('market_cart_fragments')) {
    function market_cart_fragments($fragments) {
        if (!function_exists('WC')) return $fragments;

        $count = WC()->cart->get_cart_contents_count();

        ob_start();
        ?>
        <span class="cart-count-badge" id="header-cart-count">
            <?php echo esc_html(market_to_persian_numbers($count)); ?>
        </span>
        <?php
        $fragments['#header-cart-count'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'market_cart_fragments');

/**
 * 4. Refined Sale Flash Badge
 */
add_filter('woocommerce_sale_flash', function ($badge, $post, $product) {
    if (!$product) return $badge;

    if ($product->is_on_sale()) {
        $percent = 0;
        if ($product->is_type('simple')) {
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();
            if ($regular_price > 0 && $sale_price > 0) {
                $percent = round((($regular_price - $sale_price) / $regular_price) * 100);
            }
        }
        $label = $percent > 0 ? sprintf('%s٪ تخفیف', market_to_persian_numbers($percent)) : esc_html__('ویژه', 'market');
        return '<span class="product-card-badge badge-sale">' . esc_html($label) . '</span>';
    }
    return '';
}, 10, 3);

/**
 * 5. Format WooCommerce Prices with Persian Numerals
 */
add_filter('formatted_woocommerce_price', function ($formatted_price) {
    if (function_exists('market_to_persian_numbers')) {
        return market_to_persian_numbers($formatted_price);
    }
    return $formatted_price;
}, 10, 1);

/**
 * 6. Store Visibility — Disable WooCommerce 9+ "Coming Soon" Mode
 *
 * Prevents WooCommerce from intercepting product, category, and catalog pages
 * with the default "Great things are on the horizon" / "اتفاقات بزرگی در راه است" maintenance screen.
 */
add_filter('woocommerce_is_coming_soon', '__return_false', 9999);
add_filter('woocommerce_show_coming_soon_banner', '__return_false', 9999);

add_action('init', function () {
    if (get_option('woocommerce_coming_soon') === 'yes') {
        update_option('woocommerce_coming_soon', 'no');
    }
});
