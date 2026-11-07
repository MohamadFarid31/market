<?php
/**
 * Market Theme — Orders List Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders);

$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<div class="taj-account-orders-container">

    <header class="account-page-header">
        <div class="header-title-group">
            <h1 class="account-page-title"><?php esc_html_e('تاریخچه سفارش‌ها', 'market'); ?></h1>
            <p class="account-page-subtitle"><?php esc_html_e('لیست تمام سفارش‌های ثبت‌شده و امکان پیگیری وضعیت مرسوله‌ها.', 'market'); ?></p>
        </div>
    </header>

    <?php if ($has_orders) : ?>

        <!-- جدول سفارش‌ها در دسکتاپ -->
        <div class="taj-orders-table-wrapper hide-on-mobile">
            <table class="taj-account-table taj-orders-table woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                <thead>
                    <tr>
                        <?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
                            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr($column_id); ?>">
                                <?php echo esc_html($column_name); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($customer_orders->orders as $customer_order) :
                        $order      = wc_get_order($customer_order);
                        $item_count = $order->get_item_count();
                        $status_info = function_exists('market_get_order_status_badge')
                            ? market_get_order_status_badge($order->get_status())
                            : ['label' => $order->get_status(), 'class' => 'status-default'];
                    ?>
                        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr($order->get_status()); ?> order">
                            <?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>">
                                    <?php if (has_action('woocommerce_my_account_my_orders_column_' . $column_id)) : ?>
                                        <?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

                                    <?php elseif ('order-number' === $column_id) : ?>
                                        <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="order-number-link">
                                            <span class="order-hash">#</span><?php echo esc_html(market_to_persian_numbers($order->get_order_number())); ?>
                                        </a>

                                    <?php elseif ('order-date' === $column_id) : ?>
                                        <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
                                            <?php echo esc_html(market_format_persian_date($order->get_date_created()->getTimestamp())); ?>
                                        </time>

                                    <?php elseif ('order-status' === $column_id) : ?>
                                        <span class="taj-order-badge <?php echo esc_attr($status_info['class']); ?>">
                                            <?php echo esc_html($status_info['label']); ?>
                                        </span>

                                    <?php elseif ('order-total' === $column_id) : ?>
                                        <div class="order-total-wrapper">
                                            <span class="order-total-amount">
                                                <?php echo wp_kses_post($order->get_formatted_order_total()); ?>
                                            </span>
                                            <span class="order-items-subtext">
                                                <?php printf(esc_html__('برای %s قلم', 'market'), esc_html(market_to_persian_numbers($item_count))); ?>
                                            </span>
                                        </div>

                                    <?php elseif ('order-actions' === $column_id) : ?>
                                        <?php
                                        $actions = wc_get_account_orders_actions($order);
                                        if (!empty($actions)) {
                                            foreach ($actions as $key => $action) {
                                                echo '<a href="' . esc_url($action['url']) . '" class="btn btn-outline btn-sm woocommerce-button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a> ';
                                            }
                                        } else {
                                            echo '<a href="' . esc_url($order->get_view_order_url()) . '" class="btn btn-outline btn-sm">' . esc_html__('مشاهده', 'market') . '</a>';
                                        }
                                        ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- کارت‌های مخصوص موبایل -->
        <div class="taj-orders-cards-mobile hide-on-desktop">
            <?php
            foreach ($customer_orders->orders as $customer_order) :
                $order      = wc_get_order($customer_order);
                $status_info = function_exists('market_get_order_status_badge')
                    ? market_get_order_status_badge($order->get_status())
                    : ['label' => $order->get_status(), 'class' => 'status-default'];
                $order_date = $order->get_date_created() ? market_format_persian_date($order->get_date_created()->getTimestamp()) : '-';
                $actions    = wc_get_account_orders_actions($order);
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
                            <span class="row-label"><?php esc_html_e('تاریخ ثبت سفارش:', 'market'); ?></span>
                            <span class="row-val"><?php echo esc_html($order_date); ?></span>
                        </div>
                        <div class="taj-order-card-row">
                            <span class="row-label"><?php esc_html_e('تعداد اقلام:', 'market'); ?></span>
                            <span class="row-val"><?php printf(esc_html__('%s قلم کالا', 'market'), esc_html(market_to_persian_numbers($order->get_item_count()))); ?></span>
                        </div>
                        <div class="taj-order-card-row is-total">
                            <span class="row-label"><?php esc_html_e('مبلغ کل پرداختی:', 'market'); ?></span>
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

        <?php do_action('woocommerce_before_account_orders_pagination'); ?>

        <?php if (1 < $customer_orders->max_num_pages) : ?>
            <div class="woocommerce-pagination woocommerce-pagination--without-numbers taj-orders-pagination">
                <?php if (1 !== $current_page) : ?>
                    <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous btn btn-outline btn-sm" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">
                        <?php esc_html_e('صفحه قبل', 'market'); ?>
                    </a>
                <?php endif; ?>

                <span class="pagination-page-indicator">
                    <?php
                    /* translators: 1: current page 2: total pages */
                    printf(esc_html__('صفحه %1$s از %2$s', 'market'), esc_html(market_to_persian_numbers($current_page)), esc_html(market_to_persian_numbers($customer_orders->max_num_pages)));
                    ?>
                </span>

                <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
                    <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next btn btn-outline btn-sm" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">
                        <?php esc_html_e('صفحه بعد', 'market'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="account-empty-card">
            <div class="account-empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
            <h3 class="account-empty-title"><?php esc_html_e('هنوز هیچ سفارشی ثبت نکرده‌اید!', 'market'); ?></h3>
            <p class="account-empty-desc"><?php esc_html_e('محصولات جذاب و باکیفیت ما را در فروشگاه مشاهده کنید و اولین سفارش خود را با بهترین قیمت ثبت نمایید.', 'market'); ?></p>
            <a href="<?php echo esc_url($shop_url); ?>" class="btn btn-primary">
                <?php esc_html_e('مشاهده محصولات فروشگاه', 'market'); ?>
            </a>
        </div>
    <?php endif; ?>

</div>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
