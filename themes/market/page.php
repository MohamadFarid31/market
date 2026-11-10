<?php
/**
 * Market Theme — Standard Page Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main page-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            $is_wc_page = (function_exists('is_cart') && is_cart())
                || (function_exists('is_checkout') && is_checkout())
                || (function_exists('is_account_page') && is_account_page())
                || (function_exists('is_page') && is_page(['cart', 'checkout', 'pardakht', 'پرداخت', 'تسویه-حساب', 'my-account']))
                || (is_singular() && function_exists('has_block') && (has_block('woocommerce/cart') || has_block('woocommerce/checkout') || has_block('woocommerce/customer-account')))
                || (is_singular() && get_post() && function_exists('has_shortcode') && (has_shortcode(get_post()->post_content, 'woocommerce_checkout') || has_shortcode(get_post()->post_content, 'woocommerce_cart')));
            if ($is_wc_page) :
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('woocommerce-page-container'); ?>>
                    <div class="entry-content">
                        <?php
                        the_content();
                        ?>
                    </div>
                </article>
            <?php else : ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('page-content-card'); ?>>
                    <header class="entry-header" style="margin-block-end: var(--space-6);">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages([
                            'before' => '<div class="page-links">' . esc_html__('صفحات:', 'market'),
                            'after'  => '</div>',
                        ]);
                        ?>
                    </div>
                </article>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
