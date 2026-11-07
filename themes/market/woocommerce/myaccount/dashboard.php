<?php
/**
 * Market Theme — My Account Dashboard
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
$display_name = $current_user->display_name ?: $current_user->user_login;

// Order Stats
$stats = function_exists('market_get_customer_order_stats')
    ? market_get_customer_order_stats($user_id)
    : ['total' => 0, 'processing' => 0, 'completed' => 0];

// Wishlist count
$wishlist_count = function_exists('market_get_user_wishlist')
    ? count(market_get_user_wishlist($user_id))
    : 0;

// Recent Orders (Limit 3)
$recent_orders = function_exists('wc_get_orders') ? wc_get_orders([
    'customer_id' => $user_id,
    'limit'       => 3,
    'orderby'     => 'date',
    'order'       => 'DESC',
]) : [];

// Customer Addresses Preview
$customer = new WC_Customer($user_id);
$billing_address  = $customer->get_billing_address_1();
$billing_city     = $customer->get_billing_city();
$billing_phone    = $customer->get_billing_phone();
$has_address      = !empty($billing_address) || !empty($billing_city);

$support_phone = function_exists('market_get_option') ? market_get_option('phone', '09128184981') : '09128184981';
$shop_url      = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$orders_url    = wc_get_account_endpoint_url('orders');
$address_url   = wc_get_account_endpoint_url('edit-address');
$contact_url   = home_url('/contact-us/');

do_action('woocommerce_before_my_account');
?>

<div class="taj-account-dashboard account-dashboard">

    <!-- ۱. بنر خوش‌آمدگویی کاربر -->
    <header class="account-welcome-banner">
        <div class="account-welcome-content">
            <span class="account-welcome-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
                <span><?php esc_html_e('پیشخوان کاربری', 'market'); ?></span>
            </span>
            <h1 class="account-welcome-title">
                <?php
                /* translators: %s: User display name */
                printf(esc_html__('سلام، %s عزیز!', 'market'), '<strong>' . esc_html($display_name) . '</strong>');
                ?>
            </h1>
            <p class="account-welcome-desc">
                <?php esc_html_e('خوش آمدید! در این بخش می‌توانید آخرین وضعیت سفارش‌ها، آدرس‌های ثبت‌شده و اطلاعات حساب کاربری خود را مدیریت کنید.', 'market'); ?>
            </p>
        </div>
        <div class="account-welcome-actions">
            <a href="<?php echo esc_url(wc_logout_url()); ?>" class="btn btn-outline btn-sm account-quick-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span><?php esc_html_e('خروج از حساب', 'market'); ?></span>
            </a>
        </div>
    </header>

    <!-- ۲. کارت‌های آمار و گزارش‌های سریع (۴ کارت) -->
    <div class="account-stats-grid">
        <!-- کارت ۱: کل سفارش‌ها -->
        <a href="<?php echo esc_url($orders_url); ?>" class="account-stat-card">
            <div class="account-stat-icon is-total">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
            <div class="account-stat-info">
                <span class="account-stat-num"><?php echo esc_html(market_to_persian_numbers($stats['total'])); ?></span>
                <span class="account-stat-label"><?php esc_html_e('کل سفارش‌ها', 'market'); ?></span>
            </div>
        </a>

        <!-- کارت ۲: در حال پردازش / جاری -->
        <a href="<?php echo esc_url($orders_url); ?>" class="account-stat-card">
            <div class="account-stat-icon is-processing">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="account-stat-info">
                <span class="account-stat-num"><?php echo esc_html(market_to_persian_numbers($stats['processing'])); ?></span>
                <span class="account-stat-label"><?php esc_html_e('سفارش‌های جاری', 'market'); ?></span>
            </div>
        </a>

        <!-- کارت ۳: تحویل شده -->
        <a href="<?php echo esc_url($orders_url); ?>" class="account-stat-card">
            <div class="account-stat-icon is-completed">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="account-stat-info">
                <span class="account-stat-num"><?php echo esc_html(market_to_persian_numbers($stats['completed'])); ?></span>
                <span class="account-stat-label"><?php esc_html_e('تحویل شده', 'market'); ?></span>
            </div>
        </a>

        <!-- کارت ۴: علاقه‌مندی‌ها -->
        <a href="<?php echo esc_url(home_url('/wishlist/')); ?>" class="account-stat-card">
            <div class="account-stat-icon is-wishlist">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
            </div>
            <div class="account-stat-info">
                <span class="account-stat-num"><?php echo esc_html(market_to_persian_numbers($wishlist_count)); ?></span>
                <span class="account-stat-label"><?php esc_html_e('علاقه‌مندی‌ها', 'market'); ?></span>
            </div>
        </a>
    </div>

    <!-- ۳. بخش آخرین سفارش‌های مشتری -->
    <section class="account-section dashboard-recent-orders-section">
        <div class="account-section-header">
            <div class="account-section-title-wrap">
                <span class="account-section-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </span>
                <h2 class="account-section-title"><?php esc_html_e('آخرین سفارش‌ها', 'market'); ?></h2>
            </div>
            <?php if (!empty($recent_orders)) : ?>
                <a href="<?php echo esc_url($orders_url); ?>" class="account-section-more-link">
                    <span><?php esc_html_e('مشاهده همه سفارش‌ها', 'market'); ?></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($recent_orders)) : ?>
            <div class="taj-orders-table-wrapper hide-on-mobile">
                <table class="taj-account-table taj-orders-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('شماره سفارش', 'market'); ?></th>
                            <th><?php esc_html_e('تاریخ ثبت', 'market'); ?></th>
                            <th><?php esc_html_e('وضعیت', 'market'); ?></th>
                            <th><?php esc_html_e('تعداد اقلام', 'market'); ?></th>
                            <th><?php esc_html_e('مبلغ کل', 'market'); ?></th>
                            <th><?php esc_html_e('عملیات', 'market'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order) :
                            $order_id = $order->get_id();
                            $status_info = function_exists('market_get_order_status_badge')
                                ? market_get_order_status_badge($order->get_status())
                                : ['label' => $order->get_status(), 'class' => 'status-default'];
                            $order_date = $order->get_date_created() ? market_format_persian_date($order->get_date_created()->getTimestamp()) : '-';
                            $item_count = $order->get_item_count();
                        ?>
                            <tr>
                                <td class="order-number-cell">
                                    <span class="order-hash">#</span><?php echo esc_html(market_to_persian_numbers($order->get_order_number())); ?>
                                </td>
                                <td class="order-date-cell">
                                    <?php echo esc_html($order_date); ?>
                                </td>
                                <td class="order-status-cell">
                                    <span class="taj-order-badge <?php echo esc_attr($status_info['class']); ?>">
                                        <?php echo esc_html($status_info['label']); ?>
                                    </span>
                                </td>
                                <td class="order-count-cell">
                                    <?php printf(esc_html__('%s قلم', 'market'), esc_html(market_to_persian_numbers($item_count))); ?>
                                </td>
                                <td class="order-total-cell">
                                    <?php echo wp_kses_post($order->get_formatted_order_total()); ?>
                                </td>
                                <td class="order-action-cell">
                                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="btn btn-outline btn-sm order-view-btn">
                                        <span><?php esc_html_e('مشاهده', 'market'); ?></span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="15 18 9 12 15 6"></polyline>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- کارت‌های ریسپانسیو سفارش مخصوص موبایل -->
            <div class="taj-orders-cards-mobile hide-on-desktop">
                <?php foreach ($recent_orders as $order) :
                    $status_info = function_exists('market_get_order_status_badge')
                        ? market_get_order_status_badge($order->get_status())
                        : ['label' => $order->get_status(), 'class' => 'status-default'];
                    $order_date = $order->get_date_created() ? market_format_persian_date($order->get_date_created()->getTimestamp()) : '-';
                ?>
                    <div class="taj-order-card">
                        <div class="taj-order-card-header">
                            <span class="taj-order-card-id">
                                <span class="order-hash">#</span><?php echo esc_html(market_to_persian_numbers($order->get_order_number())); ?>
                            </span>
                            <span class="taj-order-badge <?php echo esc_attr($status_info['class']); ?>">
                                <?php echo esc_html($status_info['label']); ?>
                            </span>
                        </div>
                        <div class="taj-order-card-body">
                            <div class="taj-order-card-row">
                                <span class="row-label"><?php esc_html_e('تاریخ ثبت:', 'market'); ?></span>
                                <span class="row-val"><?php echo esc_html($order_date); ?></span>
                            </div>
                            <div class="taj-order-card-row">
                                <span class="row-label"><?php esc_html_e('تعداد اقلام:', 'market'); ?></span>
                                <span class="row-val"><?php printf(esc_html__('%s قلم کالا', 'market'), esc_html(market_to_persian_numbers($order->get_item_count()))); ?></span>
                            </div>
                            <div class="taj-order-card-row is-total">
                                <span class="row-label"><?php esc_html_e('مبلغ کل:', 'market'); ?></span>
                                <span class="row-val"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                            </div>
                        </div>
                        <div class="taj-order-card-footer">
                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="btn btn-outline btn-block btn-sm">
                                <span><?php esc_html_e('مشاهده جزئیات سفارش', 'market'); ?></span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="account-empty-card">
                <div class="account-empty-icon">
                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                </div>
                <h3 class="account-empty-title"><?php esc_html_e('هنوز هیچ سفارشی ثبت نکرده‌اید', 'market'); ?></h3>
                <p class="account-empty-desc"><?php esc_html_e('محصولات مورد علاقه خود را انتخاب کنید و اولین سفارش خود را ثبت نمایید.', 'market'); ?></p>
                <a href="<?php echo esc_url($shop_url); ?>" class="btn btn-primary btn-sm">
                    <?php esc_html_e('مشاهده محصولات فروشگاه', 'market'); ?>
                </a>
            </div>
        <?php endif; ?>
    </section>

    <!-- ۴. شبکه دسترسی سریع (آدرس و پشتیبانی) -->
    <div class="account-quick-cards-grid">
        <!-- کارت پیش‌نمایش آدرس -->
        <div class="account-info-box">
            <div class="account-info-box-header">
                <div class="box-header-title-wrap">
                    <span class="box-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </span>
                    <h3 class="box-title"><?php esc_html_e('آدرس پیش‌فرض شما', 'market'); ?></h3>
                </div>
                <a href="<?php echo esc_url($address_url); ?>" class="box-link">
                    <?php esc_html_e('ویرایش آدرس‌ها', 'market'); ?>
                </a>
            </div>
            <div class="account-info-box-body">
                <?php if ($has_address) : ?>
                    <p class="address-preview-text">
                        <?php if ($billing_city) : ?>
                            <strong><?php echo esc_html($billing_city); ?></strong> - 
                        <?php endif; ?>
                        <?php echo esc_html($billing_address); ?>
                    </p>
                    <?php if ($billing_phone) : ?>
                        <span class="address-phone-preview">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <span><?php echo esc_html(market_to_persian_numbers($billing_phone)); ?></span>
                        </span>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="address-empty-text"><?php esc_html_e('هنوز هیچ آدرسی ثبت نکرده‌اید. با افزودن آدرس، مراحل خرید سریع‌تر انجام می‌شود.', 'market'); ?></p>
                    <a href="<?php echo esc_url($address_url); ?>" class="btn btn-outline btn-sm">
                        <?php esc_html_e('+ افزودن آدرس جدید', 'market'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- کارت پشتیبانی و راهنمایی -->
        <div class="account-info-box">
            <div class="account-info-box-header">
                <div class="box-header-title-wrap">
                    <span class="box-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </span>
                    <h3 class="box-title"><?php esc_html_e('نیاز به پشتیبانی دارید؟', 'market'); ?></h3>
                </div>
                <a href="<?php echo esc_url($contact_url); ?>" class="box-link">
                    <?php esc_html_e('تماس با ما', 'market'); ?>
                </a>
            </div>
            <div class="account-info-box-body">
                <p class="support-text"><?php esc_html_e('تیم پشتیبانی ما در تمامی ساعات کاری آماده پاسخگویی به سوالات و پیگیری سفارش‌های شماست.', 'market'); ?></p>
                <div class="support-contact-row">
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $support_phone)); ?>" class="support-phone-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span><?php echo esc_html(market_to_persian_numbers($support_phone)); ?></span>
                    </a>
                    <span class="support-hours"><?php esc_html_e('شنبه تا پنجشنبه: ۹ الی ۱۸', 'market'); ?></span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
/**
 * My Account dashboard actions.
 */
do_action('woocommerce_account_dashboard');
do_action('woocommerce_after_my_account');
