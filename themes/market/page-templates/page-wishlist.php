<?php
/**
 * Template Name: Wishlist | علاقه‌مندی‌ها
 *
 * Faithful recreation of Taj Bazar wishlist layout and styling.
 * Supports both client-side (localStorage for guests) and server-side (user meta for authenticated users).
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

$user_id = get_current_user_id();
$initial_ids = is_user_logged_in() && function_exists('market_get_user_wishlist') ? market_get_user_wishlist($user_id) : [];
$initial_products = [];

if (!empty($initial_ids) && function_exists('wc_get_products')) {
    $initial_products = wc_get_products([
        'include' => $initial_ids,
        'limit' => -1,
        'status' => 'publish',
    ]);
}

$has_initial_items = !empty($initial_products);
$items_count = count($initial_products);
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<!-- <?php market_breadcrumbs(); ?> -->

<main id="primary" class="site-main wishlist-main taj-wishlist-main">
    <div class="container">
        <!-- ۱. هدر صفحه علاقه‌مندی‌ها طبق استایل‌های پوسته مارکت -->
        <header class="wishlist-header taj-wishlist-header">
            <div class="wishlist-badge">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
                <span><?php esc_html_e('کالاهای برگزیده شما', 'market'); ?></span>
            </div>
            <h1 class="wishlist-main-title"><?php esc_html_e('لیست علاقه‌مندی‌ها', 'market'); ?></h1>
            <p class="wishlist-subtitle">
                <?php esc_html_e('محصولاتی که پسندیده‌اید را در اینجا مشاهده و مدیریت کنید و هر زمان مایل بودید به سبد خرید انتقال دهید.', 'market'); ?>
            </p>
        </header>

        <!-- ۲. نوار ابزار بالای گرید (شمارنده و دکمه‌های کنترلی) -->
        <div id="wishlist-toolbar" class="wishlist-toolbar <?php echo $has_initial_items ? '' : 'is-hidden'; ?>">
            <div class="wishlist-toolbar-start">
                <span class="wishlist-count-chip">
                    <span class="count-num"
                        id="wishlist-items-count"><?php echo esc_html(market_to_persian_numbers($items_count)); ?></span>
                    <span class="count-label"><?php esc_html_e('کالا ذخیره شده', 'market'); ?></span>
                </span>
            </div>

            <div class="wishlist-toolbar-end">
                <button type="button" class="wishlist-clear-all-btn btn-ghost" id="wishlist-clear-all-btn"
                    aria-label="<?php esc_attr_e('حذف همه موارد از علاقه‌مندی‌ها', 'market'); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    <span><?php esc_html_e('پاک کردن همه', 'market'); ?></span>
                </button>

                <a href="<?php echo esc_url($shop_url); ?>" class="wishlist-continue-shopping-btn btn-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    <span><?php esc_html_e('مشاهده فروشگاه', 'market'); ?></span>
                </a>
            </div>
        </div>

        <!-- ۳. وضعیت لودینگ اسکلتون (برای درخواست‌های ایجکس) -->
        <div id="wishlist-skeleton-state" class="wishlist-skeleton-grid products-grid is-hidden" aria-hidden="true">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <div class="product-card skeleton-card">
                    <div class="skeleton-thumb skeleton-pulse"></div>
                    <div class="skeleton-line skeleton-title skeleton-pulse"></div>
                    <div class="skeleton-line skeleton-sub skeleton-pulse"></div>
                    <div class="skeleton-line skeleton-price skeleton-pulse"></div>
                    <div class="skeleton-btn skeleton-pulse"></div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- ۴. گرید کارت‌های محصول علاقه‌مندی‌ها (ریسپانسیو ۵ ستونه تا ۲ ستونه) -->
        <div id="wishlist-products-grid"
            class="products-grid wishlist-products-grid <?php echo $has_initial_items ? '' : 'is-hidden'; ?>">
            <?php
            if ($has_initial_items && function_exists('market_render_wishlist_card')) {
                foreach ($initial_products as $prod) {
                    echo market_render_wishlist_card($prod); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
            }
            ?>
        </div>

        <!-- ۵. وضعیت خالی (Empty State) طبق استایل اختصاصی سایت -->
        <div id="wishlist-empty-state" class="wishlist-empty-card <?php echo $has_initial_items ? 'is-hidden' : ''; ?>">
            <div class="wishlist-empty-icon-wrap">
                <svg width="68" height="68" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
            </div>

            <h2 class="wishlist-empty-title">
                <?php esc_html_e('لیست علاقه‌مندی‌های شما در حال حاضر خالی است', 'market'); ?>
            </h2>

            <p class="wishlist-empty-desc">
                <?php esc_html_e('شما هنوز هیچ محصولی را به این بخش اضافه نکرده‌اید. با گشت و گذار در فروشگاه و کلیک بر روی نماد قلب بر روی هر کالا، می‌توانید محصولات مورد نظر خود را ذخیره نمایید.', 'market'); ?>
            </p>

            <div class="wishlist-empty-actions">
                <a href="<?php echo esc_url($shop_url); ?>" class="taj-btn taj-btn-primary wishlist-return-shop-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span><?php esc_html_e('مشاهده محصولات فروشگاه', 'market'); ?></span>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();

