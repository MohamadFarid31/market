<?php
/**
 * Market Theme — Wishlist Core Engine & AJAX Handlers
 *
 * Provides backend persistence, secure AJAX endpoints, and Taj Bazar card rendering
 * for the guest & authenticated customer wishlist experience.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/**
 * 1. Retrieve user wishlist product IDs
 *
 * @param int $user_id
 * @return int[]
 */
function market_get_user_wishlist($user_id = 0) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    if (!$user_id) {
        return [];
    }

    $ids = get_user_meta($user_id, '_market_wishlist', true);
    if (!is_array($ids)) {
        return [];
    }

    return array_values(array_filter(array_unique(array_map('intval', $ids))));
}

/**
 * 2. Save user wishlist product IDs
 *
 * @param int $user_id
 * @param int[] $product_ids
 * @return bool
 */
function market_update_user_wishlist($user_id, $product_ids) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    if (!$user_id) {
        return false;
    }

    $clean_ids = array_values(array_filter(array_unique(array_map('intval', (array) $product_ids))));
    return (bool) update_user_meta($user_id, '_market_wishlist', $clean_ids);
}

/**
 * 3. Render a single Wishlist Product Card in Taj Bazar Design System
 *
 * @param WC_Product|int $product
 * @return string HTML
 */
function market_render_wishlist_card($product) {
    if (is_numeric($product)) {
        $product = wc_get_product($product);
    }

    if (!$product || !$product->is_visible()) {
        return '';
    }

    $product_id   = $product->get_id();
    $brand_terms  = get_the_terms($product_id, 'product_brand');
    $brand_name   = (!empty($brand_terms) && !is_wp_error($brand_terms)) ? $brand_terms[0]->name : '';
    $sku          = $product->get_sku();
    $price_html   = $product->get_price_html();
    $has_price    = !empty($product->get_price()) && (float) $product->get_price() > 0;
    $is_in_stock  = $product->is_in_stock();
    $is_purchasable = $product->is_purchasable() && $is_in_stock && $has_price && $product->is_type('simple');

    ob_start();
    ?>
    <div class="product-card wishlist-card" data-product-id="<?php echo esc_attr($product_id); ?>">
        <div class="wishlist-card-top-actions">
            <button type="button" class="wishlist-card-remove-btn" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php esc_attr_e('حذف از علاقه‌مندی‌ها', 'market'); ?>" title="<?php esc_attr_e('حذف از علاقه‌مندی‌ها', 'market'); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
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

            <div class="wishlist-stock-status-wrap">
                <?php if ($is_in_stock) : ?>
                    <span class="wishlist-stock-pill in-stock">
                        <span class="stock-dot"></span>
                        <?php esc_html_e('موجود در انبار', 'market'); ?>
                    </span>
                <?php else : ?>
                    <span class="wishlist-stock-pill out-of-stock">
                        <span class="stock-dot"></span>
                        <?php esc_html_e('ناموجود', 'market'); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="product-card-pricing">
                <?php if (!empty($price_html)) : ?>
                    <div class="product-price">
                        <?php echo $price_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php else : ?>
                    <span class="product-call-for-price"><?php esc_html_e('تماس بگیرید', 'market'); ?></span>
                <?php endif; ?>
            </div>

            <div class="wishlist-card-action-wrap">
                <?php if ($is_purchasable) : ?>
                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" class="product-card-btn btn-add-to-cart ajax_add_to_cart" aria-label="<?php esc_attr_e('افزودن به سبد خرید', 'market'); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span><?php esc_html_e('افزودن به سبد خرید', 'market'); ?></span>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-card-btn btn-more-info" aria-label="<?php esc_attr_e('مشاهده و انتخاب محصول', 'market'); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 16 16 12 12 8"></polyline>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        <span><?php esc_html_e('مشاهده محصول', 'market'); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * 4. AJAX: Get rendered Wishlist cards for an array of product IDs
 */
function market_ajax_get_wishlist_cards() {
    check_ajax_referer('market_ajax_nonce', 'nonce');

    $raw_ids = isset($_POST['product_ids']) ? (array) $_POST['product_ids'] : [];
    $product_ids = array_values(array_filter(array_unique(array_map('intval', $raw_ids))));

    // If user is logged in and no IDs provided by frontend, fallback to user meta
    if (empty($product_ids) && is_user_logged_in()) {
        $product_ids = market_get_user_wishlist();
    }

    if (empty($product_ids) || !function_exists('wc_get_products')) {
        wp_send_json_success([
            'count' => 0,
            'html'  => '',
        ]);
    }

    $products = wc_get_products([
        'include' => $product_ids,
        'limit'   => -1,
        'status'  => 'publish',
    ]);

    $cards_html = '';
    $valid_count = 0;

    foreach ($products as $product) {
        if ($product && $product->is_visible()) {
            $cards_html .= market_render_wishlist_card($product);
            $valid_count++;
        }
    }

    wp_send_json_success([
        'count' => $valid_count,
        'html'  => $cards_html,
    ]);
}
add_action('wp_ajax_market_get_wishlist_cards', 'market_ajax_get_wishlist_cards');
add_action('wp_ajax_nopriv_market_get_wishlist_cards', 'market_ajax_get_wishlist_cards');

/**
 * 5. AJAX: Toggle product in user's wishlist (for logged-in users)
 */
function market_ajax_toggle_wishlist() {
    check_ajax_referer('market_ajax_nonce', 'nonce');

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if (!$product_id) {
        wp_send_json_error(['message' => esc_html__('شناسه محصول نامعتبر است.', 'market')]);
    }

    $in_wishlist = false;
    $count = 0;

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist = market_get_user_wishlist($user_id);

        if (in_array($product_id, $wishlist, true)) {
            $wishlist = array_values(array_diff($wishlist, [$product_id]));
            $in_wishlist = false;
        } else {
            $wishlist[] = $product_id;
            $in_wishlist = true;
        }

        market_update_user_wishlist($user_id, $wishlist);
        $count = count($wishlist);
    } else {
        // Guest mode response: state is determined by passed action if available
        $in_wishlist = isset($_POST['current_state']) ? !filter_var($_POST['current_state'], FILTER_VALIDATE_BOOLEAN) : true;
    }

    wp_send_json_success([
        'product_id'  => $product_id,
        'in_wishlist' => $in_wishlist,
        'count'       => $count,
        'is_logged_in'=> is_user_logged_in(),
    ]);
}
add_action('wp_ajax_market_toggle_wishlist', 'market_ajax_toggle_wishlist');
add_action('wp_ajax_nopriv_market_toggle_wishlist', 'market_ajax_toggle_wishlist');

/**
 * 6. AJAX: Clear entire user wishlist
 */
function market_ajax_clear_wishlist() {
    check_ajax_referer('market_ajax_nonce', 'nonce');

    if (is_user_logged_in()) {
        market_update_user_wishlist(get_current_user_id(), []);
    }

    wp_send_json_success([
        'count' => 0,
        'message' => esc_html__('لیست علاقه‌مندی‌ها با موفقیت خالی شد.', 'market'),
    ]);
}
add_action('wp_ajax_market_clear_wishlist', 'market_ajax_clear_wishlist');
add_action('wp_ajax_nopriv_market_clear_wishlist', 'market_ajax_clear_wishlist');

