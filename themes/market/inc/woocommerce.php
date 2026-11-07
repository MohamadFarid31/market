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

/**
 * 7. Cart & Checkout — Prefer Classic Taj Bazar Templates over Gutenberg Cart Block
 *
 * Ensures WooCommerce renders our custom templates (cart.php and cart-totals.php)
 * matching Taj Bazar's clean 2-column desktop and responsive card mobile views.
 */
add_filter('the_content', function ($content) {
    if (function_exists('is_cart') && is_cart() && has_block('woocommerce/cart')) {
        return do_shortcode('[woocommerce_cart]');
    }
    if (function_exists('is_checkout') && is_checkout() && !is_order_received_page() && has_block('woocommerce/checkout')) {
        return do_shortcode('[woocommerce_checkout]');
    }
    if (function_exists('is_account_page') && is_account_page() && (has_block('woocommerce/customer-account') || has_block('woocommerce/classic-shortcode'))) {
        return do_shortcode('[woocommerce_my_account]');
    }
    return $content;
}, 5);

/**
 * 8. My Account — Limit Menu Items to Orders, Wishlist, and Logout
 */
add_filter('woocommerce_account_menu_items', function ($items) {
    return [
        'orders'          => __('سفارشات', 'market'),
        'wishlist'        => __('علاقه‌مندی‌ها', 'market'),
        'customer-logout' => __('خروج', 'market'),
    ];
}, 999);

add_filter('woocommerce_get_endpoint_url', function ($url, $endpoint, $value, $permalink) {
    if ('wishlist' === $endpoint) {
        return home_url('/wishlist/');
    }
    return $url;
}, 10, 4);

add_filter('woocommerce_account_menu_item_classes', function ($classes, $endpoint) {
    if ('wishlist' === $endpoint && function_exists('is_page') && is_page('wishlist')) {
        $classes[] = 'is-active';
    }
    return $classes;
}, 10, 2);

/**
 * Redirect My Account root (Dashboard) and removed endpoints to Orders
 */
add_action('template_redirect', function () {
    if (!function_exists('is_account_page') || !is_account_page() || !is_user_logged_in()) {
        return;
    }

    if (wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) {
        return;
    }

    // Never redirect active endpoints: orders, view-order, logout, or password recovery
    if (function_exists('is_wc_endpoint_url') && (
        is_wc_endpoint_url('orders') ||
        is_wc_endpoint_url('view-order') ||
        is_wc_endpoint_url('customer-logout') ||
        is_wc_endpoint_url('lost-password')
    )) {
        return;
    }

    $current_endpoint = function_exists('WC') && WC()->query ? WC()->query->get_current_endpoint() : '';
    $is_endpoint      = function_exists('is_wc_endpoint_url') && is_wc_endpoint_url();

    $disabled_endpoints = ['dashboard', 'edit-address', 'edit-account', 'downloads', 'payment-methods', 'add-payment-method'];
    $is_disabled        = in_array($current_endpoint, $disabled_endpoints, true);

    // If on root my-account (default dashboard) or on a disabled endpoint, redirect to orders
    if ((empty($current_endpoint) && !$is_endpoint) || $is_disabled) {
        wp_safe_redirect(wc_get_account_endpoint_url('orders'));
        exit;
    }
});

/**
 * Fallback: If root account content is rendered, display Orders instead of Dashboard
 */
add_action('woocommerce_account_content', function () {
    if (function_exists('is_wc_endpoint_url') && !is_wc_endpoint_url() && function_exists('woocommerce_account_orders')) {
        remove_action('woocommerce_account_content', 'woocommerce_account_dashboard');
        woocommerce_account_orders();
    }
}, 1);

/**
 * 9. My Account — Customer Order Stats Helper
 *
 * @param int $user_id
 * @return array
 */
if (!function_exists('market_get_customer_order_stats')) {
    function market_get_customer_order_stats($user_id = 0) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        if (!$user_id || !function_exists('wc_get_orders')) {
            return [
                'total'      => 0,
                'processing' => 0,
                'completed'  => 0,
            ];
        }

        $all_ids = wc_get_orders([
            'customer_id' => $user_id,
            'limit'       => -1,
            'return'      => 'ids',
        ]);
        $total = is_array($all_ids) ? count($all_ids) : 0;

        $proc_ids = wc_get_orders([
            'customer_id' => $user_id,
            'status'      => ['processing', 'pending', 'on-hold'],
            'limit'       => -1,
            'return'      => 'ids',
        ]);
        $processing = is_array($proc_ids) ? count($proc_ids) : 0;

        $comp_ids = wc_get_orders([
            'customer_id' => $user_id,
            'status'      => ['completed'],
            'limit'       => -1,
            'return'      => 'ids',
        ]);
        $completed = is_array($comp_ids) ? count($comp_ids) : 0;

        return [
            'total'      => $total,
            'processing' => $processing,
            'completed'  => $completed,
        ];
    }
}

/**
 * 10. My Account — Status Badge Formatter
 *
 * @param string $status
 * @return array{label: string, class: string}
 */
if (!function_exists('market_get_order_status_badge')) {
    function market_get_order_status_badge($status) {
        $status = str_replace('wc-', '', sanitize_key($status));
        $statuses = [
            'completed'  => ['label' => __('تکمیل شده', 'market'), 'class' => 'status-completed'],
            'processing' => ['label' => __('در حال پردازش', 'market'), 'class' => 'status-processing'],
            'pending'    => ['label' => __('در انتظار پرداخت', 'market'), 'class' => 'status-pending'],
            'on-hold'    => ['label' => __('در انتظار بررسی', 'market'), 'class' => 'status-on-hold'],
            'cancelled'  => ['label' => __('لغو شده', 'market'), 'class' => 'status-cancelled'],
            'refunded'   => ['label' => __('مسترد شده', 'market'), 'class' => 'status-refunded'],
            'failed'     => ['label' => __('ناموفق', 'market'), 'class' => 'status-failed'],
        ];

        if (isset($statuses[$status])) {
            return $statuses[$status];
        }

        $label = function_exists('wc_get_order_status_name') ? wc_get_order_status_name($status) : $status;
        return [
            'label' => $label,
            'class' => 'status-default',
        ];
    }
}

