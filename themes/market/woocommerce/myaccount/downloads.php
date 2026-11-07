<?php
/**
 * Market Theme — Downloads List Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$downloads = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');

do_action('woocommerce_before_account_downloads', $has_downloads);
?>

<div class="taj-account-downloads-container">

    <header class="account-page-header">
        <div class="header-title-group">
            <h1 class="account-page-title"><?php esc_html_e('فایل‌های دانلودی', 'market'); ?></h1>
            <p class="account-page-subtitle">
                <?php esc_html_e('فهرست فایل‌های دانلودی، تعداد دفعات مجاز دانلود و تاریخ انقضا.', 'market'); ?></p>
        </div>
    </header>

    <?php if ($has_downloads): ?>
        <?php do_action('woocommerce_before_available_downloads'); ?>

        <div class="taj-downloads-table-wrapper hide-on-mobile">
            <table
                class="taj-account-table taj-downloads-table woocommerce-MyAccount-downloads shop_table shop_table_responsive">
                <thead>
                    <tr>
                        <th class="download-product"><?php esc_html_e('محصول', 'market'); ?></th>
                        <th class="download-remaining"><?php esc_html_e('تعداد دانلود باقیمانده', 'market'); ?></th>
                        <th class="download-expires"><?php esc_html_e('تاریخ انقضا', 'market'); ?></th>
                        <th class="download-file"><?php esc_html_e('دریافت فایل', 'market'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($downloads as $download): ?>
                        <tr>
                            <td class="download-product">
                                <a href="<?php echo esc_url(get_permalink($download['product_id'])); ?>"
                                    class="download-product-link">
                                    <?php echo esc_html($download['product_name']); ?>
                                </a>
                            </td>
                            <td class="download-remaining">
                                <?php
                                if (is_numeric($download['downloads_remaining'])) {
                                    echo esc_html(market_to_persian_numbers($download['downloads_remaining']));
                                } else {
                                    esc_html_e('نامحدود', 'market');
                                }
                                ?>
                            </td>
                            <td class="download-expires">
                                <?php if (!empty($download['access_expires'])): ?>
                                    <time datetime="<?php echo esc_attr(date('Y-m-d', strtotime($download['access_expires']))); ?>">
                                        <?php echo esc_html(market_format_persian_date(strtotime($download['access_expires']))); ?>
                                    </time>
                                <?php else: ?>
                                    <?php esc_html_e('هرگز', 'market'); ?>
                                <?php endif; ?>
                            </td>
                            <td class="download-file">
                                <a href="<?php echo esc_url($download['download_url']); ?>"
                                    class="btn btn-primary btn-sm woocommerce-MyAccount-downloads-file">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    <span><?php echo esc_html($download['download_name']); ?></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- کارت‌های مخصوص موبایل برای دانلودها -->
        <div class="taj-downloads-cards-mobile hide-on-desktop">
            <?php foreach ($downloads as $download): ?>
                <div class="taj-download-card">
                    <h3 class="download-card-title"><?php echo esc_html($download['product_name']); ?></h3>
                    <div class="download-card-meta">
                        <div class="meta-row">
                            <span class="meta-label"><?php esc_html_e('تعداد باقیمانده:', 'market'); ?></span>
                            <span class="meta-val">
                                <?php
                                if (is_numeric($download['downloads_remaining'])) {
                                    echo esc_html(market_to_persian_numbers($download['downloads_remaining']));
                                } else {
                                    esc_html_e('نامحدود', 'market');
                                }
                                ?>
                            </span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label"><?php esc_html_e('تاریخ انقضا:', 'market'); ?></span>
                            <span class="meta-val">
                                <?php if (!empty($download['access_expires'])): ?>
                                    <?php echo esc_html(market_format_persian_date(strtotime($download['access_expires']))); ?>
                                <?php else: ?>
                                    <?php esc_html_e('هرگز', 'market'); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="download-card-action">
                        <a href="<?php echo esc_url($download['download_url']); ?>" class="btn btn-primary btn-block btn-sm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            <span><?php echo esc_html($download['download_name']); ?></span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php do_action('woocommerce_after_available_downloads'); ?>

    <?php else: ?>
        <div class="account-empty-card">
            <div class="account-empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
            </div>
            <h3 class="account-empty-title"><?php esc_html_e('هیچ فایل دانلودی فعالی ندارید', 'market'); ?></h3>
            <p class="account-empty-desc">
                <?php esc_html_e('پس از خرید محصولات دانلودی، فایل‌های مربوطه در این بخش برای دریافت مستقیم در دسترس شما خواهند بود.', 'market'); ?>
            </p>
            <a href="<?php echo esc_url($shop_url); ?>" class="btn btn-primary">
                <?php esc_html_e('مشاهده فروشگاه', 'market'); ?>
            </a>
        </div>
    <?php endif; ?>

</div>

<?php do_action('woocommerce_after_account_downloads', $has_downloads); ?>