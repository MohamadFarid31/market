<?php
/**
 * Market Theme — Taxonomy & Brand Utilities
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_get_active_brand_taxonomy')) {
    /**
     * Dynamically detects whether a brand taxonomy exists in the environment.
     * Checks for native 'product_brand', Perfect Brands 'pwb-brand', or WooCommerce attribute 'pa_brand'.
     *
     * @return string|false Active taxonomy name or false if none exists.
     */
    function market_get_active_brand_taxonomy() {
        if (taxonomy_exists('product_brand')) {
            return 'product_brand';
        }
        if (taxonomy_exists('pwb-brand')) {
            return 'pwb-brand';
        }
        if (taxonomy_exists('pa_brand')) {
            return 'pa_brand';
        }
        return false;
    }
}

if (!function_exists('market_get_product_brands')) {
    /**
     * Retrieves product brand terms dynamically without assuming taxonomy slug.
     *
     * @param int $product_id
     * @return WP_Term[]|false
     */
    function market_get_product_brands($product_id = null) {
        if (!$product_id) {
            $product_id = get_the_ID();
        }

        $brand_tax = market_get_active_brand_taxonomy();
        if (!$brand_tax) {
            return false;
        }

        $terms = get_the_terms($product_id, $brand_tax);
        return (!empty($terms) && !is_wp_error($terms)) ? $terms : false;
    }
}
