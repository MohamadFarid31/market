<?php
/**
 * Market Theme — Product Brand Taxonomy Archive Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

$current_term = get_queried_object();
?>

<main id="primary" class="site-main brand-archive-main">
    <div class="container">
        <header class="page-header brand-header card p-6" style="background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-xl); padding: var(--space-6); margin-block-end: var(--space-6);">
            <h1 class="page-title brand-title" style="margin: 0; color: var(--color-text-primary);">
                <?php echo esc_html($current_term->name); ?>
            </h1>
            <?php if (!empty($current_term->description)) : ?>
                <div class="brand-description" style="color: var(--color-text-secondary); margin-block-start: var(--space-2);">
                    <?php echo wp_kses_post($current_term->description); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="catalog-main-content">
            <?php if (have_posts()) : ?>
                <div class="products-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/product/card');
                    endwhile;
                    ?>
                </div>
                <?php get_template_part('template-parts/common/pagination'); ?>
            <?php else : ?>
                <?php
                get_template_part('template-parts/common/empty-state', null, [
                    'title'       => esc_html__('محصولی برای این برند یافت نشد', 'market'),
                    'description' => esc_html__('در حال حاضر کالایی برای این برند ثبت نشده است.', 'market'),
                ]);
                ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
get_footer();
