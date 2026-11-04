<?php
/**
 * Market Theme — Blog Archive Template (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();

// Subtitle fallback or from customizer/meta
$blog_title    = get_the_title(get_option('page_for_posts')) ? get_the_title(get_option('page_for_posts')) : esc_html__('وبلاگ', 'market');
$blog_subtitle = esc_html__('جدیدترین مقالات تخصصی، اخبار دنیای فناوری و راهنماهای خرید کالا', 'market');
?>

<main id="primary" class="site-main blog-index-main taj-blog-main">
    <div class="container">

        <!-- سربرگ وبلاگ -->
        <header class="blog-archive-header taj-blog-header">
            <h1 class="blog-main-title"><?php echo esc_html($blog_title); ?></h1>
            <p class="blog-subtitle"><?php echo esc_html($blog_subtitle); ?></p>
        </header>

        <div class="blog-layout taj-blog-layout">

            <!-- ناحیه مقالات -->
            <div class="blog-content-area taj-article-container">
                <?php if (have_posts()) : ?>
                    <div class="blog-posts-grid taj-posts-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/card/article-card');
                        endwhile;
                        ?>
                    </div>

                    <div class="blog-pagination-wrap">
                        <?php get_template_part('template-parts/common/pagination'); ?>
                    </div>
                <?php else : ?>
                    <!-- نمونه مقالات پیش‌فرض مطابق طراحی تاج بازار در صورت عدم ثبت مقاله در وردپرس -->
                    <div class="blog-posts-grid taj-posts-grid">
                        <?php
                        $sample_articles = [
                            [
                                'title'    => esc_html__('راهنمای انتخاب دوربین برای تولید محتوا؛ چه مدلی مناسب است؟', 'market'),
                                'category' => esc_html__('راهنمای خرید', 'market'),
                                'day'      => '۲۵',
                                'month'    => 'شهریور',
                                'author'   => 'MrHossein',
                                'comments' => '۰',
                                'excerpt'  => esc_html__('تولید محتوای تصویری به یکی از بخش‌های مهم فعالیت بسیاری از کسب‌وکارها و تولیدکنندگان محتوا تبدیل شده است. انتخاب دوربین مناسب...', 'market'),
                            ],
                            [
                                'title'    => esc_html__('راهنمای نورپردازی برای عکاسی و فیلم‌برداری', 'market'),
                                'category' => esc_html__('نورپردازی', 'market'),
                                'day'      => '۲۵',
                                'month'    => 'شهریور',
                                'author'   => 'MrHossein',
                                'comments' => '۰',
                                'excerpt'  => esc_html__('نورپردازی اصولی نقشی تعیین‌کننده در کیفیت نهایی ویدیوها و تصاویر دارد. در این راهنما به بررسی اصول چیدمان نور و تجهیزات ضروری می‌پردازیم...', 'market'),
                            ],
                            [
                                'title'    => esc_html__('راهنمای انتخاب گیمبال برای دوربین؛ چه گیمبالی مناسب شماست؟', 'market'),
                                'category' => esc_html__('راهنمای خرید', 'market'),
                                'day'      => '۲۵',
                                'month'    => 'شهریور',
                                'author'   => 'MrHossein',
                                'comments' => '۰',
                                'excerpt'  => esc_html__('گیمبال یکی از کاربردی‌ترین تجهیزات برای لرزش‌گیری تصاویر متحرک است. در این مقاله مدل‌های برتر سازگار با دوربین‌های مختلف را مقایسه می‌کنیم...', 'market'),
                            ],
                            [
                                'title'    => esc_html__('بهترین میکروفون‌ها برای ضبط پادکست و تولید محتوا', 'market'),
                                'category' => esc_html__('راهنمای خرید', 'market'),
                                'day'      => '۲۴',
                                'month'    => 'شهریور',
                                'author'   => 'MrHossein',
                                'comments' => '۰',
                                'excerpt'  => esc_html__('صدای باکیفیت نصف جذابیت هر ویدیوی آموزشی یا مصاحبه است. با انواع میکروفون‌های یقه‌ای، شات‌گان و کاندنسر آشنا شوید...', 'market'),
                            ],
                            [
                                'title'    => esc_html__('نکات کلیدی برای انتخاب لنز مناسب دوربین عکاسی', 'market'),
                                'category' => esc_html__('راهنمای خرید', 'market'),
                                'day'      => '۲۲',
                                'month'    => 'شهریور',
                                'author'   => 'MrHossein',
                                'comments' => '۰',
                                'excerpt'  => esc_html__('آیا لنز از بدنه دوربین مهم‌تر است؟ بررسی فاصله کانونی، دیافراگم و کاربرد هر لنز برای پرتره، منظره و عکاسی خیابانی...', 'market'),
                            ],
                            [
                                'title'    => esc_html__('راهنمای خرید سه‌پایه دوربین و تجهیزات پایدارسازی', 'market'),
                                'category' => esc_html__('نورپردازی', 'market'),
                                'day'      => '۲۰',
                                'month'    => 'شهریور',
                                'author'   => 'MrHossein',
                                'comments' => '۰',
                                'excerpt'  => esc_html__('چگونه یک سه‌پایه محکم و در عین حال سبک وزن انتخاب کنیم؟ مقایسه جنس آلومینیوم و کربن فایبر برای عکاسان در سفر...', 'market'),
                            ],
                        ];

                        foreach ($sample_articles as $sample) :
                            ?>
                            <article class="article-card taj-article-card">
                                <div class="article-card-thumb-wrap">
                                    <a href="#" class="article-thumb-link">
                                        <div class="article-thumb-placeholder">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                        </div>
                                    </a>
                                    <div class="article-date-badge">
                                        <span class="date-badge-day"><?php echo esc_html($sample['day']); ?></span>
                                        <span class="date-badge-month"><?php echo esc_html($sample['month']); ?></span>
                                    </div>
                                    <span class="article-badge-pill"><?php echo esc_html($sample['category']); ?></span>
                                </div>
                                <div class="article-card-body">
                                    <h3 class="article-card-title">
                                        <a href="#"><?php echo esc_html($sample['title']); ?></a>
                                    </h3>
                                    <div class="article-card-meta">
                                        <span class="article-comments-badge">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#ef394e" stroke="#ef394e" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                            <span class="comments-num"><?php echo esc_html($sample['comments']); ?></span>
                                        </span>
                                        <span class="article-author"><?php echo esc_html($sample['author']); ?></span>
                                    </div>
                                    <div class="article-card-excerpt">
                                        <?php echo esc_html($sample['excerpt']); ?>
                                    </div>
                                    <div class="article-card-action">
                                        <a href="#" class="article-more-link">
                                            <?php esc_html_e('ادامه مطلب', 'market'); ?>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- سایدبار وبلاگ (سمت راست در RTL) -->
            <?php get_sidebar(); ?>

        </div>
    </div>
</main>

<?php
get_footer();
