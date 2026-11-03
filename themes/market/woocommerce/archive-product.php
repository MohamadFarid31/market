<?php
/**
 * Market Theme — WooCommerce Catalog, Category & Subcategory Archive
 *
 * Fully faithful recreation of Taj Bazar's clean catalog layout (No blog sidebar, 5-col desktop, 2-col mobile).
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');
?>

<div class="taj-catalog-wrapper">

    <?php
    // ۱. نوار زیردسته‌ها (اگر دسته والد دارای زیرمجموعه باشد، به صورت چیپ‌های افقی اسکرولی و زیبا)
    if (is_product_category()) {
        $current_cat = get_queried_object();
        $subcategories = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => $current_cat->term_id,
            'hide_empty' => false,
        ]);

        if (!empty($subcategories) && !is_wp_error($subcategories)) :
            ?>
            <div class="category-subcategories-bar" aria-label="<?php esc_attr_e('زیردسته‌ها', 'market'); ?>">
                <div class="subcategories-scroll-track">
                    <a href="<?php echo esc_url(get_term_link($current_cat)); ?>" class="subcat-chip is-active">
                        <?php esc_html_e('همه محصولات این بخش', 'market'); ?>
                    </a>
                    <?php foreach ($subcategories as $subcat) : ?>
                        <a href="<?php echo esc_url(get_term_link($subcat)); ?>" class="subcat-chip">
                            <span><?php echo esc_html($subcat->name); ?></span>
                            <?php if ($subcat->count > 0) : ?>
                                <span class="subcat-count"><?php echo esc_html(market_to_persian_numbers($subcat->count)); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        endif;
    }
    ?>

    <!-- ۲. نوار ابزار بالای فروشگاه (تعداد نتایج و دراپ‌داون مرتب‌سازی تاج‌بازار) -->
    <div class="catalog-toolbar">
        <div class="catalog-toolbar-right">
            <div class="catalog-count hide-on-desktop">
                <?php woocommerce_result_count(); ?>
            </div>
            <div class="catalog-filter-btn-wrap hide-on-desktop">
                <button type="button" class="btn-catalog-filter-mobile" id="openMobileFiltersBtn" aria-label="<?php esc_attr_e('فیلترها', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="21" x2="4" y2="14"></line>
                        <line x1="4" y1="10" x2="4" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="3"></line>
                        <line x1="20" y1="21" x2="20" y2="16"></line>
                        <line x1="20" y1="12" x2="20" y2="3"></line>
                        <line x1="1" y1="14" x2="7" y2="14"></line>
                        <line x1="9" y1="8" x2="15" y2="8"></line>
                        <line x1="17" y1="16" x2="23" y2="16"></line>
                    </svg>
                    <span><?php esc_html_e('مشاهده فیلترها', 'market'); ?></span>
                </button>
            </div>
        </div>

        <div class="catalog-toolbar-left">
            <div class="catalog-count hide-on-mobile">
                <?php woocommerce_result_count(); ?>
            </div>
            <div class="catalog-sort-wrap">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>
    </div>

    <!-- ۳. محتوای محصولات و گرید تمام‌عرض کاتالوگ (۵ ستونه دسکتاپ، ۲ ستونه موبایل) -->
    <div class="catalog-main-content">
        <?php if (woocommerce_product_loop()) : ?>

            <?php
            woocommerce_product_loop_start();

            if (wc_get_loop_prop('total')) {
                while (have_posts()) {
                    the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                }
            }

            woocommerce_product_loop_end();

            do_action('woocommerce_after_shop_loop');
            ?>

        <?php else : ?>

            <?php
            do_action('woocommerce_no_products_found');
            get_template_part('template-parts/common/empty-state', null, [
                'title'       => esc_html__('هیچ محصولی در این دسته یافت نشد', 'market'),
                'description' => esc_html__('در حال حاضر کالایی با این مشخصات موجود نیست.', 'market'),
            ]);
            ?>

            <!-- نمایش محصولات پیشنهادی تا صفحه خالی و بی‌روح نماند -->
            <?php
            $fallback_products = wc_get_products([
                'status' => 'publish',
                'limit'  => 5,
            ]);
            if (!empty($fallback_products)) :
                ?>
                <div class="catalog-fallback-recommendations" style="margin-block-start: var(--space-12);">
                    <h3 style="font-size: 1.15rem; font-weight: 800; margin-block-end: var(--space-6); color: var(--color-text-primary);">
                        <?php esc_html_e('محصولات پیشنهادی برای شما', 'market'); ?>
                    </h3>
                    <div class="products-grid">
                        <?php
                        foreach ($fallback_products as $p_obj) :
                            $post_object = get_post($p_obj->get_id());
                            setup_postdata($GLOBALS['post'] =& $post_object);
                            get_template_part('template-parts/product/card');
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
