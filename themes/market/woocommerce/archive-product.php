<?php
/**
 * Market Theme — WooCommerce Catalog, Category & Subcategory Archive
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

<header class="woocommerce-products-header card p-6" style="background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-xl); padding: var(--space-6); margin-block-end: var(--space-6);">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="woocommerce-products-header__title page-title" style="margin: 0; color: var(--color-text-primary);">
            <?php woocommerce_page_title(); ?>
        </h1>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_archive_description.
     */
    do_action('woocommerce_archive_description');
    ?>
</header>

<?php
// Dynamic Subcategories Drill-Down (if current term is a parent category with children)
if (is_product_category()) {
    $current_cat = get_queried_object();
    $subcategories = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $current_cat->term_id,
        'hide_empty' => false,
    ]);

    if (!empty($subcategories) && !is_wp_error($subcategories)) :
        ?>
        <section class="subcategories-section" style="margin-block-end: var(--space-8);" aria-label="<?php esc_attr_e('زیردسته‌ها', 'market'); ?>">
            <h2 style="font-size: var(--font-size-md); font-weight: var(--font-weight-bold); margin-block-end: var(--space-4);">
                <?php esc_html_e('زیردسته‌های این بخش', 'market'); ?>
            </h2>
            <div class="grid grid-cols-2" style="gap: var(--space-4);">
                <?php foreach ($subcategories as $subcat) : ?>
                    <a href="<?php echo esc_url(get_term_link($subcat)); ?>" class="subcat-card card p-4 flex items-center justify-between" style="background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-md); padding: var(--space-3) var(--space-4); text-decoration: none;">
                        <span style="font-weight: var(--font-weight-medium); color: var(--color-text-primary);"><?php echo esc_html($subcat->name); ?></span>
                        <span class="count" style="font-size: var(--font-size-xs); color: var(--color-text-muted);">(<?php echo esc_html(market_to_persian_numbers($subcat->count)); ?>)</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    endif;
}
?>

<div class="catalog-layout">
    <?php if (is_active_sidebar('sidebar-shop')) : ?>
        <aside class="catalog-sidebar">
            <?php dynamic_sidebar('sidebar-shop'); ?>
        </aside>
    <?php endif; ?>

    <div class="catalog-content">
        <?php if (woocommerce_product_loop()) : ?>
            <div class="catalog-toolbar">
                <div class="catalog-count">
                    <?php woocommerce_result_count(); ?>
                </div>
                <div class="catalog-sort">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>

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
        <?php endif; ?>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
