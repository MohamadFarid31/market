<?php
/**
 * Market Theme — Taj Bazar Single Product Template
 *
 * Fully faithful recreation of Taj Bazar's 3-column desktop and responsive mobile layout.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || post_password_required()) {
    if (post_password_required()) {
        echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    return;
}

$product_id   = $product->get_id();
$brand_terms  = get_the_terms($product_id, 'product_brand');
$brand_name   = (!empty($brand_terms) && !is_wp_error($brand_terms)) ? $brand_terms[0]->name : '';
$sku          = $product->get_sku();
$short_desc   = $product->get_short_description();
$gallery_ids  = $product->get_gallery_image_ids();
$main_img_id  = $product->get_image_id();
$main_img_url = $main_img_id ? wp_get_attachment_image_url($main_img_id, 'full') : '';
$review_count = $product->get_review_count();

do_action('woocommerce_before_single_product');
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('taj-single-product-container', $product); ?>>

    <!-- عنوان مخصوص موبایل (در بالای تصویر) -->
    <h1 class="single-product-title hide-on-desktop product-mobile-title">
        <?php the_title(); ?>
    </h1>

    <!-- گرید اصلی ۳ ستونه دسکتاپ (راست: مشخصات، وسط: تصویر، چپ: جعبه خرید) -->
    <div class="taj-single-product-grid">

        <!-- ستون اول (راست در RTL): عنوان دسکتاپ، ویژگی‌ها/بولت پوینت‌ها، دسته‌بندی و برند -->
        <div class="single-product-info-col">
            <h1 class="single-product-title hide-on-mobile product-desktop-title">
                <?php the_title(); ?>
            </h1>

            <?php if (!empty($short_desc)) : ?>
                <div class="product-short-description">
                    <?php
                    // If plain text or lines without <ul>, split into clean bullet points
                    if (strpos($short_desc, '<li') === false) {
                        $lines = preg_split('/\r\n|\r|\n/', strip_tags($short_desc));
                        $output_items = [];
                        foreach ($lines as $line) {
                            $line = trim($line, " \t\n\r\0\x0B•-–*");
                            if (!empty($line)) {
                                $output_items[] = '<li>' . esc_html($line) . '</li>';
                            }
                        }
                        if (!empty($output_items)) {
                            echo '<ul>' . implode('', $output_items) . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        } else {
                            echo '<p>' . esc_html($short_desc) . '</p>';
                        }
                    } else {
                        echo wp_kses_post($short_desc);
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="product-meta-details">
                <?php
                $cats = wc_get_product_category_list($product_id, '، ');
                if ($cats) :
                    ?>
                    <div class="product-meta-row">
                        <span class="meta-label"><?php esc_html_e('دسته:', 'market'); ?></span>
                        <span class="meta-value"><?php echo $cats; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($brand_name)) : ?>
                    <div class="product-meta-row">
                        <span class="meta-label"><?php esc_html_e('برند:', 'market'); ?></span>
                        <span class="meta-value"><?php echo esc_html($brand_name); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($sku)) : ?>
                    <div class="product-meta-row">
                        <span class="meta-label"><?php esc_html_e('شناسه محصول:', 'market'); ?></span>
                        <span class="meta-value" dir="ltr"><?php echo esc_html($sku); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ستون دوم (وسط در RTL): تصویر اصلی محصول و گالری بندانگشتی -->
        <div class="single-product-gallery-col">
            <div class="product-main-image-wrap">
                <?php if ($main_img_id) : ?>
                    <?php echo wp_get_attachment_image($main_img_id, 'large', false, [
                        'class' => 'product-main-img',
                        'id'    => 'tajProductMainImage',
                    ]); ?>
                <?php else : ?>
                    <div class="product-image-placeholder">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                <?php endif; ?>

                <?php if (!empty($main_img_url)) : ?>
                    <a href="<?php echo esc_url($main_img_url); ?>" class="product-image-zoom-btn" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('بزرگنمایی تصویر', 'market'); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <polyline points="9 21 3 21 3 15"></polyline>
                            <line x1="21" y1="3" x2="14" y2="10"></line>
                            <line x1="3" y1="21" x2="10" y2="14"></line>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($gallery_ids)) : ?>
                <div class="product-thumbnails-list">
                    <?php if ($main_img_id) : ?>
                        <div class="product-thumb-item active" data-img-src="<?php echo esc_url(wp_get_attachment_image_url($main_img_id, 'large')); ?>">
                            <?php echo wp_get_attachment_image($main_img_id, 'thumbnail'); ?>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($gallery_ids as $g_id) : ?>
                        <div class="product-thumb-item" data-img-src="<?php echo esc_url(wp_get_attachment_image_url($g_id, 'large')); ?>">
                            <?php echo wp_get_attachment_image($g_id, 'thumbnail'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ستون سوم (چپ در RTL): جعبه خرید و ضمانت‌ها (Buy Box) -->
        <div class="single-product-buybox-col">
            <div class="product-buybox-card">
                <!-- ضمانت‌های اصالت و ارسال -->
                <div class="buybox-guarantees">
                    <div class="guarantee-item">
                        <div class="guarantee-icon-wrap">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="16 10 11 15 8 12"></polyline>
                            </svg>
                        </div>
                        <div class="guarantee-text">
                            <strong><?php esc_html_e('تضمین اصالت', 'market'); ?></strong>
                            <span><?php esc_html_e('ارائه محصولات اصل و معتبر', 'market'); ?></span>
                        </div>
                    </div>

                    <div class="guarantee-item">
                        <div class="guarantee-icon-wrap">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <div class="guarantee-text">
                            <strong><?php esc_html_e('ارسال سریع', 'market'); ?></strong>
                            <span><?php esc_html_e('ارسال کالا تا ۱ روز کاری', 'market'); ?></span>
                        </div>
                    </div>
                </div>

                <hr class="buybox-divider">

                <!-- قیمت و دکمه‌های کنترلی (علاقه‌مندی و مقایسه) -->
                <div class="buybox-price-actions-row">
                    <div class="buybox-price-wrap">
                        <div class="single-product-price">
                            <?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>

                    <div class="buybox-quick-actions">
                        <button type="button" class="buybox-action-icon-btn product-compare-btn" aria-label="<?php esc_attr_e('مقایسه', 'market'); ?>" title="<?php esc_attr_e('مقایسه محصول', 'market'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </button>
                        <button type="button" class="buybox-action-icon-btn product-wishlist-btn" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php esc_attr_e('علاقه‌مندی‌ها', 'market'); ?>" title="<?php esc_attr_e('افزودن به علاقه‌مندی‌ها', 'market'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- فرم افزودن به سبد خرید ووکامرس -->
                <div class="buybox-cart-form-wrap">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ۲. تب‌های محصول (توضیحات محصول / مشخصات فنی) -->
    <div class="single-product-tabs-section">
        <div class="product-tabs-nav">
            <button type="button" class="tab-pill-btn active" data-tab-target="#tab-description">
                <?php esc_html_e('توضیحات محصول', 'market'); ?>
            </button>
            <button type="button" class="tab-pill-btn tab-pill-dark" data-tab-target="#tab-specifications">
                <?php esc_html_e('مشخصات فنی', 'market'); ?>
            </button>
        </div>

        <div class="product-tabs-content">
            <!-- پنل ۱: توضیحات -->
            <div class="product-tab-panel active" id="tab-description">
                <div class="entry-content">
                    <?php
                    $content = get_the_content();
                    if (!empty($content)) {
                        the_content();
                    } else {
                        echo '<p>' . esc_html__('توضیحات کاملی برای این کالا ثبت نشده است.', 'market') . '</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- پنل ۲: مشخصات فنی -->
            <div class="product-tab-panel" id="tab-specifications">
                <div class="product-attributes-wrap">
                    <?php
                    $attributes = $product->get_attributes();
                    if (!empty($attributes)) {
                        wc_display_product_attributes($product);
                    } else {
                        echo '<p>' . esc_html__('مشخصات فنی برای این کالا ثبت نشده است.', 'market') . '</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ۳. بخش دیدگاه‌ها و امتیاز کاربران -->
    <div class="single-product-reviews-section" id="product-reviews-area">
        <div class="section-title-wrap">
            <h2 class="section-title reviews-heading">
                <span class="reviews-indicator-dot"></span>
                <span><?php esc_html_e('امتیاز و دیدگاه کاربران', 'market'); ?></span>
            </h2>
        </div>

        <?php if ($review_count == 0) : ?>
            <div class="empty-reviews-card">
                <div class="empty-reviews-icon">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <p class="empty-reviews-text"><?php esc_html_e('هنوز دیدگاهی ثبت نشده است.', 'market'); ?></p>

                <!-- دکمه دسکتاپ: ارسال دیدگاه -->
                <button type="button" class="btn-write-review hide-on-mobile" id="openReviewFormBtn">
                    <?php esc_html_e('ارسال دیدگاه', 'market'); ?>
                </button>

                <!-- نوار کلیک موبایل: دیدگاه خود را درباره این کالا بنویسید -->
                <button type="button" class="mobile-review-trigger-bar hide-on-desktop" id="openReviewFormBtnMobile">
                    <div class="mobile-review-inner">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span><?php esc_html_e('دیدگاه خود را درباره این کالا بنویسید', 'market'); ?></span>
                    </div>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <!-- فرم ثبت دیدگاه (پیش‌فرض بسته/مخفی تا زمان کلیک) -->
        <div class="product-review-form-wrap" id="tajProductReviewForm" style="display: <?php echo ($review_count > 0) ? 'block' : 'none'; ?>;">
            <?php
            if (comments_open()) {
                comments_template();
            }
            ?>
        </div>
    </div>

    <!-- ۴. اسلایدر محصولات مرتبط (با فال‌بک به جدیدترین‌ها در صورت خالی بودن) -->
    <?php
    $related_ids = wc_get_related_products($product_id, 8);
    if (empty($related_ids)) {
        $related_ids = wc_get_products([
            'status'  => 'publish',
            'limit'   => 8,
            'exclude' => [$product_id],
            'return'  => 'ids',
        ]);
    }

    if (!empty($related_ids)) :
        ?>
        <div class="single-product-related-section">
            <div class="section-title-wrap">
                <h2 class="section-title"><?php esc_html_e('محصولات مرتبط', 'market'); ?></h2>
                <div class="related-slider-arrows">
                    <button type="button" class="slider-arrow-btn related-arrow-prev" aria-label="<?php esc_attr_e('قبلی', 'market'); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                    <button type="button" class="slider-arrow-btn related-arrow-next" aria-label="<?php esc_attr_e('بعدی', 'market'); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                </div>
            </div>

            <div class="product-carousel-track" id="relatedProductsTrack">
                <?php
                foreach ($related_ids as $r_id) :
                    $post_object = get_post($r_id);
                    setup_postdata($GLOBALS['post'] =& $post_object);
                    echo '<div class="carousel-slide-item">';
                    get_template_part('template-parts/product/card');
                    echo '</div>';
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ۵. نوار خرید چسبان مخصوص موبایل (Sticky Buy Bar) -->
    <div class="mobile-sticky-buy-bar hide-on-desktop">
        <div class="sticky-buy-price">
            <?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
        <button type="button" class="btn-taj-red mobile-sticky-cart-btn" id="mobileStickyAddToCartBtn">
            <?php esc_html_e('افزودن به سبد خرید', 'market'); ?>
        </button>
    </div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>
