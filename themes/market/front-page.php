<?php
/**
 * Market Theme — Taj Bazar Homepage Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main front-page-main">
    <div class="container front-page-container">
        <!-- ۱. اسلایدر اصلی (Hero Slider) -->
        <?php get_template_part('template-parts/home/hero-slider'); ?>

        <!-- ۲. تخفیف‌های ویژه تاج‌بازار (Special Discounts Carousel) -->
        <?php get_template_part('template-parts/home/special-discounts'); ?>

        <!-- ۳. دسته‌بندی محصولات (Circular Categories) -->
        <?php get_template_part('template-parts/home/categories-circle'); ?>

        <!-- ۴. ردیف اول ۳ بنر پروموشن (Triple Promo Banners Row 1) -->
        <?php get_template_part('template-parts/home/promo-grid-1'); ?>

        <!-- ۵. محصولات پیشنهادی تاج‌بازار (Recommended Products Carousel) -->
        <?php get_template_part('template-parts/home/recommended-products'); ?>

        <!-- ۶. معرفی تعاملی دنیای تجهیزات حرفه‌ای (Interactive Gear Showcase) -->
        <?php get_template_part('template-parts/home/interactive-showcase'); ?>

        <!-- ۷. نگاهی به جدیدترین محصولات (Latest Products Carousel) -->
        <?php get_template_part('template-parts/home/latest-products'); ?>

        <!-- ۸. ردیف دوم ۳ بنر پروموشن (Triple Promo Banners Row 2) -->
        <?php get_template_part('template-parts/home/promo-grid-2'); ?>

        <!-- ۹. مقالات و مطالب تخصصی (Recent Articles & Blog) -->
        <?php get_template_part('template-parts/home/recent-articles'); ?>
    </div>
</main>

<?php
get_footer();
