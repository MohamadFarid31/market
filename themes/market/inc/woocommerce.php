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
    if (function_exists('is_cart') && (is_cart() || has_block('woocommerce/cart'))) {
        if (has_block('woocommerce/cart')) {
            return do_shortcode('[woocommerce_cart]');
        }
    }
    if ((function_exists('is_checkout') && is_checkout() && !is_order_received_page()) || (is_singular() && has_block('woocommerce/checkout'))) {
        if (has_block('woocommerce/checkout')) {
            return do_shortcode('[woocommerce_checkout]');
        }
    }
    if (function_exists('is_account_page') && (is_account_page() || has_block('woocommerce/customer-account'))) {
        if (has_block('woocommerce/customer-account') || has_block('woocommerce/classic-shortcode')) {
            return do_shortcode('[woocommerce_my_account]');
        }
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
}, 999999);

add_filter('woocommerce_get_endpoint_url', function ($url, $endpoint, $value, $permalink) {
    if ('wishlist' === $endpoint) {
        return home_url('/wishlist/');
    }
    return $url;
}, 10, 4);

add_filter('woocommerce_account_menu_item_classes', function ($classes, $endpoint) {
    if ('orders' === $endpoint && function_exists('is_account_page') && is_account_page()) {
        if (!function_exists('is_wc_endpoint_url') || !is_wc_endpoint_url() || is_wc_endpoint_url('view-order')) {
            $classes[] = 'is-active';
        }
    }
    if ('wishlist' === $endpoint && function_exists('is_page') && is_page('wishlist')) {
        $classes[] = 'is-active';
    }
    return array_unique((array) $classes);
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

    // Never redirect active allowed endpoints: orders, view-order, logout, lost-password, pay, thankyou
    if (function_exists('is_wc_endpoint_url') && (
        is_wc_endpoint_url('orders') ||
        is_wc_endpoint_url('view-order') ||
        is_wc_endpoint_url('customer-logout') ||
        is_wc_endpoint_url('lost-password') ||
        is_wc_endpoint_url('order-pay') ||
        is_wc_endpoint_url('order-received')
    )) {
        return;
    }

    // If wishlist endpoint in account is accessed, redirect to dedicated /wishlist/ page
    if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url('wishlist')) {
        wp_safe_redirect(home_url('/wishlist/'));
        exit;
    }

    $current_endpoint = function_exists('WC') && WC()->query ? WC()->query->get_current_endpoint() : '';
    $is_endpoint      = function_exists('is_wc_endpoint_url') && is_wc_endpoint_url();

    // If on root my-account (default dashboard) or on any disabled endpoint, redirect to orders
    if ((empty($current_endpoint) && !$is_endpoint) || !in_array($current_endpoint, ['orders', 'view-order', 'customer-logout', 'lost-password'], true)) {
        wp_safe_redirect(wc_get_account_endpoint_url('orders'));
        exit;
    }
});

/**
 * Fallback: If root account content or dashboard is rendered, display Orders instead of Dashboard
 */
add_action('woocommerce_account_content', function () {
    if (function_exists('is_wc_endpoint_url') && !is_wc_endpoint_url()) {
        remove_action('woocommerce_account_content', 'woocommerce_account_content', 10);
        if (function_exists('woocommerce_account_orders')) {
            woocommerce_account_orders();
        }
    }
}, 1);

add_action('woocommerce_account_dashboard', function () {
    if (function_exists('woocommerce_account_orders')) {
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

/**
 * 11. Quick View AJAX Handler (Taj Bazar Style Modal — Matching Image 1)
 */
function market_ajax_quick_view() {
    check_ajax_referer('market_ajax_nonce', 'nonce');

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if (!$product_id) {
        wp_send_json_error(['message' => __('شناسه محصول نامعتبر است.', 'market')]);
    }

    $product = wc_get_product($product_id);
    if (!$product || !$product->is_visible()) {
        wp_send_json_error(['message' => __('محصول یافت نشد.', 'market')]);
    }

    $product_name   = $product->get_name();
    $permalink      = $product->get_permalink();
    $sku            = $product->get_sku();
    $brand_terms    = get_the_terms($product_id, 'product_brand');
    $brand_name     = (!empty($brand_terms) && !is_wp_error($brand_terms)) ? $brand_terms[0]->name : '';
    $price_html     = $product->get_price_html();
    $has_price      = !empty($product->get_price()) && (float) $product->get_price() > 0;
    $is_in_stock    = $product->is_in_stock();
    $is_purchasable = $product->is_purchasable() && $is_in_stock && $has_price && $product->is_type('simple');

    // Main image
    $main_image_id  = $product->get_image_id();
    $main_image_url = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'large') : wc_placeholder_img_src('large');

    // Gallery images
    $gallery_ids = (array) $product->get_gallery_image_ids();
    if ($main_image_id && !in_array($main_image_id, $gallery_ids)) {
        array_unshift($gallery_ids, $main_image_id);
    }

    // Categories
    $categories_html = wc_get_product_category_list($product_id, '، ');

    // Attributes & Specifications list
    $attributes_data = [];
    $attributes = $product->get_attributes();
    if (!empty($attributes)) {
        foreach ($attributes as $attr) {
            $label = wc_attribute_label($attr->get_name());
            $values = [];
            if ($attr->is_taxonomy()) {
                $terms = wc_get_product_terms($product_id, $attr->get_name(), ['fields' => 'names']);
                $values = !is_wp_error($terms) ? $terms : [];
            } else {
                $values = $attr->get_options();
            }
            if (!empty($values)) {
                $attributes_data[] = [
                    'label' => $label,
                    'value' => implode('، ', (array) $values),
                ];
            }
        }
    }

    if ($product->has_weight()) {
        $weight_unit = get_option('woocommerce_weight_unit', 'کیلوگرم');
        $attributes_data[] = [
            'label' => __('وزن', 'market'),
            'value' => market_to_persian_numbers($product->get_weight()) . ' ' . $weight_unit,
        ];
    }

    if ($product->has_dimensions()) {
        $attributes_data[] = [
            'label' => __('ابعاد', 'market'),
            'value' => market_to_persian_numbers($product->get_dimensions(false)),
        ];
    }

    $short_desc = $product->get_short_description();

    ob_start();
    ?>
    <div class="qv-modal-grid">
        <!-- ستون اطلاعات و خرید محصول (سمت راست در RTL) -->
        <div class="qv-details-col">
            <h2 class="qv-title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($product_name); ?></a>
            </h2>

            <?php if (!empty($sku)) : ?>
                <div class="qv-subtitle"><?php echo esc_html($sku); ?></div>
            <?php endif; ?>

            <?php if (!empty($brand_name)) : ?>
                <div class="qv-brand"><?php echo esc_html($brand_name); ?></div>
            <?php endif; ?>

            <div class="qv-price-wrap">
                <?php if (!empty($price_html)) : ?>
                    <div class="qv-price"><?php echo $price_html; ?></div>
                <?php else : ?>
                    <span class="qv-call-price"><?php esc_html_e('تماس بگیرید', 'market'); ?></span>
                <?php endif; ?>
            </div>

            <?php if (!empty($attributes_data)) : ?>
                <ul class="qv-attributes-list">
                    <?php foreach ($attributes_data as $attr) : ?>
                        <li>
                            <span class="qv-attr-dot">•</span>
                            <span class="qv-attr-label"><?php echo esc_html($attr['label']); ?>:</span>
                            <span class="qv-attr-value"><?php echo esc_html($attr['value']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif (!empty($short_desc)) : ?>
                <div class="qv-short-desc">
                    <?php echo wp_kses_post($short_desc); ?>
                </div>
            <?php endif; ?>

            <div class="qv-actions-row">
                <?php if ($is_purchasable) : ?>
                    <button type="button" class="btn-taj-red qv-add-to-cart-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
                        <span class="qv-btn-text"><?php esc_html_e('افزودن به سبد خرید', 'market'); ?></span>
                        <span class="qv-btn-spinner" style="display: none;">
                            <svg class="spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-linecap="round"></circle></svg>
                        </span>
                    </button>
                    <div class="qv-quantity-wrap">
                        <button type="button" class="qv-qty-btn qv-qty-plus" aria-label="<?php esc_attr_e('افزایش', 'market'); ?>">+</button>
                        <input type="number" class="qv-qty-input" value="1" min="1" max="99" readonly>
                        <button type="button" class="qv-qty-btn qv-qty-minus" aria-label="<?php esc_attr_e('کاهش', 'market'); ?>">-</button>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url($permalink); ?>" class="btn-taj-red qv-more-info-btn">
                        <?php esc_html_e('اطلاعات بیشتر', 'market'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="qv-divider"></div>

            <?php if (!empty($categories_html)) : ?>
                <div class="qv-meta-categories">
                    <span class="qv-meta-label"><?php esc_html_e('دسته:', 'market'); ?></span>
                    <span class="qv-meta-links"><?php echo $categories_html; ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- ستون گالری و عکس محصول (سمت چپ در RTL) -->
        <div class="qv-gallery-col">
            <div class="qv-main-image-frame">
                <a href="<?php echo esc_url($permalink); ?>">
                    <img id="qv-active-img" src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr($product_name); ?>">
                </a>
            </div>
            <?php if (!empty($gallery_ids) && count($gallery_ids) > 1) : ?>
                <div class="qv-gallery-thumbs-row">
                    <?php foreach ($gallery_ids as $gid) :
                        $thumb_url = wp_get_attachment_image_url($gid, 'medium');
                        $full_url  = wp_get_attachment_image_url($gid, 'large');
                        if ($thumb_url && $full_url) : ?>
                            <button type="button" class="qv-gallery-thumb-btn <?php echo ($full_url === $main_image_url) ? 'is-active' : ''; ?>" data-full-src="<?php echo esc_url($full_url); ?>" aria-label="<?php esc_attr_e('تصویر محصول', 'market'); ?>">
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="">
                            </button>
                        <?php endif;
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_market_quick_view', 'market_ajax_quick_view');
add_action('wp_ajax_nopriv_market_quick_view', 'market_ajax_quick_view');

/**
 * 12. Quick View AJAX Add to Cart (with quantity support)
 */
function market_ajax_quick_add_to_cart() {
    check_ajax_referer('market_ajax_nonce', 'nonce');

    if (!function_exists('WC')) {
        wp_send_json_error(['message' => __('ووکامرس فعال نیست.', 'market')]);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity   = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

    if (!$product_id) {
        wp_send_json_error(['message' => __('محصول نامعتبر است.', 'market')]);
    }

    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity)) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        $count = WC()->cart->get_cart_contents_count();

        // Get updated mini cart
        ob_start();
        woocommerce_mini_cart();
        $mini_cart_html = ob_get_clean();

        wp_send_json_success([
            'count'     => market_to_persian_numbers($count),
            'mini_cart' => $mini_cart_html,
            'message'   => __('محصول با موفقیت به سبد خرید افزوده شد.', 'market'),
        ]);
    } else {
        wp_send_json_error(['message' => __('خطا در افزودن محصول به سبد خرید.', 'market')]);
    }
}
add_action('wp_ajax_market_quick_add_to_cart', 'market_ajax_quick_add_to_cart');
add_action('wp_ajax_nopriv_market_quick_add_to_cart', 'market_ajax_quick_add_to_cart');

