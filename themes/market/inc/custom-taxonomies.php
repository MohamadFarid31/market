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

if (!function_exists('market_get_categories_tree')) {
    /**
     * Retrieves hierarchical product categories tree (up to 3 levels) with fallback.
     *
     * @return array
     */
    function market_get_categories_tree() {
        $categories_data = [];

        if (class_exists('WooCommerce')) {
            $parent_terms = get_terms([
                'taxonomy'   => 'product_cat',
                'parent'     => 0,
                'hide_empty' => false,
                'exclude'    => [get_option('default_product_cat')],
            ]);

            if (!empty($parent_terms) && !is_wp_error($parent_terms)) {
                foreach ($parent_terms as $parent) {
                    $child_terms = get_terms([
                        'taxonomy'   => 'product_cat',
                        'parent'     => $parent->term_id,
                        'hide_empty' => false,
                    ]);

                    $children = [];
                    if (!empty($child_terms) && !is_wp_error($child_terms)) {
                        foreach ($child_terms as $child) {
                            $sub_children_terms = get_terms([
                                'taxonomy'   => 'product_cat',
                                'parent'     => $child->term_id,
                                'hide_empty' => false,
                            ]);

                            $sub_children = [];
                            if (!empty($sub_children_terms) && !is_wp_error($sub_children_terms)) {
                                foreach ($sub_children_terms as $sub_child) {
                                    $sub_children[] = [
                                        'id'       => $sub_child->term_id,
                                        'name'     => $sub_child->name,
                                        'url'      => get_term_link($sub_child),
                                        'children' => [],
                                    ];
                                }
                            }

                            $children[] = [
                                'id'       => $child->term_id,
                                'name'     => $child->name,
                                'url'      => get_term_link($child),
                                'children' => $sub_children,
                            ];
                        }
                    }

                    $categories_data[] = [
                        'id'       => $parent->term_id,
                        'name'     => $parent->name,
                        'url'      => get_term_link($parent),
                        'children' => $children,
                    ];
                }
            }
        }

        if (empty($categories_data)) {
            $categories_data = [
                [
                    'id'       => 'spk',
                    'name'     => 'اسپیکر',
                    'url'      => home_url('/product-category/speaker/'),
                    'children' => [
                        ['id' => 'spk-15', 'name' => 'ساب ۱۵', 'url' => home_url('/product-category/sub-15/'), 'children' => []],
                        ['id' => 'spk-12', 'name' => 'ساب ۱۲', 'url' => home_url('/product-category/sub-12/'), 'children' => []],
                        ['id' => 'spk-10', 'name' => 'ساب ۱۰', 'url' => home_url('/product-category/sub-10/'), 'children' => []],
                        ['id' => 'spk-8',  'name' => 'ساب ۸',  'url' => home_url('/product-category/sub-8/'), 'children' => []],
                        ['id' => 'spk-6',  'name' => 'ساب ۶',  'url' => home_url('/product-category/sub-6/'), 'children' => []],
                        ['id' => 'spk-4',  'name' => 'ساب ۴',  'url' => home_url('/product-category/sub-4/'), 'children' => []],
                        ['id' => 'spk-m3', 'name' => 'مینی ۳', 'url' => home_url('/product-category/mini-3/'), 'children' => []],
                    ],
                ],
                [
                    'id'       => 'hdp',
                    'name'     => 'هدفون و هندزفری',
                    'url'      => home_url('/product-category/headphones/'),
                    'children' => [
                        ['id' => 'hdp-ank', 'name' => 'Anker',    'url' => home_url('/product-category/anker/'), 'children' => []],
                        ['id' => 'hdp-air', 'name' => 'airpods',  'url' => home_url('/product-category/airpods/'), 'children' => []],
                        ['id' => 'hdp-m',   'name' => 'سری m',   'url' => home_url('/product-category/m-series/'), 'children' => []],
                        ['id' => 'hdp-gam', 'name' => 'گیمینگ',   'url' => home_url('/product-category/gaming/'), 'children' => []],
                        ['id' => 'hdp-eco', 'name' => 'اقتصادی',  'url' => home_url('/product-category/budget/'), 'children' => []],
                    ],
                ],
                [
                    'id'       => 'wch',
                    'name'     => 'ساعت هوشمند-واچ',
                    'url'      => home_url('/product-category/smart-watch/'),
                    'children' => [
                        ['id' => 'wch-keq', 'name' => 'KEQIWEAR', 'url' => home_url('/product-category/keqiwear/'), 'children' => []],
                        ['id' => 'wch-tek', 'name' => 'teket',    'url' => home_url('/product-category/teket/'), 'children' => []],
                        ['id' => 'wch-dsp', 'name' => 'DSPort',   'url' => home_url('/product-category/dsport/'), 'children' => []],
                    ],
                ],
                [
                    'id'       => 'shv',
                    'name'     => 'ماشین اصلاح',
                    'url'      => home_url('/product-category/shaver/'),
                    'children' => [
                        ['id' => 'shv-god', 'name' => 'GODFERY',  'url' => home_url('/product-category/godfery/'), 'children' => []],
                    ],
                ],
                [
                    'id'       => 'lgt',
                    'name'     => 'نورپردازی',
                    'url'      => home_url('/product-category/lighting/'),
                    'children' => [],
                ],
                [
                    'id'       => 'dll',
                    'name'     => 'عروسک',
                    'url'      => home_url('/product-category/dolls/'),
                    'children' => [],
                ],
            ];
        }

        return $categories_data;
    }
}
