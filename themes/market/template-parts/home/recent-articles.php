<?php
/**
 * Market Theme — Recent Articles Section (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$recent_posts = new WP_Query([
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'no_found_rows'       => true,
]);
?>
<section class="home-section recent-articles-section" aria-label="<?php esc_attr_e('مقالات و مطالب تخصصی', 'market'); ?>">
    <div class="section-title-wrap text-center">
        <span class="section-badge"><?php esc_html_e('دانش و بینش در مسیر رشد دیجیتال', 'market'); ?></span>
        <h2 class="section-title"><?php esc_html_e('مقالات و مطالب تخصصی', 'market'); ?></h2>
    </div>

    <div class="articles-grid">
        <?php
        if ($recent_posts->have_posts()) :
            while ($recent_posts->have_posts()) :
                $recent_posts->the_post();
                get_template_part('template-parts/card/article-card');
            endwhile;
            wp_reset_postdata();
        else :
            // Fallback sample mock articles matching the design
            $sample_articles = [
                [
                    'title'    => esc_html__('راهنمای انتخاب دوربین برای تولید محتوا؛ چه مدلی مناسب است؟', 'market'),
                    'category' => esc_html__('راهنمای خرید', 'market'),
                    'date'     => '۱۴۰۵-۰۶-۲۵',
                ],
                [
                    'title'    => esc_html__('راهنمای نورپردازی برای عکاسی و فیلم‌برداری', 'market'),
                    'category' => esc_html__('نورپردازی', 'market'),
                    'date'     => '۱۴۰۵-۰۶-۲۵',
                ],
                [
                    'title'    => esc_html__('راهنمای انتخاب گیمبال برای دوربین؛ چه گیمبالی مناسب شماست؟', 'market'),
                    'category' => esc_html__('راهنمای خرید', 'market'),
                    'date'     => '۱۴۰۵-۰۶-۲۵',
                ],
            ];

            foreach ($sample_articles as $sample) :
                ?>
                <article class="article-card">
                    <div class="article-card-thumb-wrap">
                        <div class="article-thumb-placeholder"></div>
                        <span class="article-badge-pill"><?php echo esc_html($sample['category']); ?></span>
                    </div>
                    <div class="article-card-body">
                        <h3 class="article-card-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html($sample['title']); ?></a>
                        </h3>
                        <div class="article-card-action">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="article-more-link">
                                <?php esc_html_e('ادامه مطلب ...', 'market'); ?>
                            </a>
                        </div>
                        <div class="article-card-meta">
                            <span class="article-date"><?php echo esc_html($sample['date']); ?></span>
                            <span class="meta-dot">•</span>
                            <span class="article-comments"><?php esc_html_e('بدون دیدگاه', 'market'); ?></span>
                        </div>
                    </div>
                </article>
                <?php
            endforeach;
        endif;
        ?>
    </div>
</section>

