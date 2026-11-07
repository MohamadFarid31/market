<?php
/**
 * Market Theme — View Order Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id);

if (!$order) {
    return;
}

$order_status = $order->get_status();
$status_info  = function_exists('market_get_order_status_badge')
    ? market_get_order_status_badge($order_status)
    : ['label' => $order_status, 'class' => 'status-default'];

$order_date   = $order->get_date_created() ? market_format_persian_date($order->get_date_created()->getTimestamp()) : '-';
$payment_title = $order->get_payment_method_title();
$orders_url   = wc_get_account_endpoint_url('orders');

// Calculate visual steps progress
$is_cancelled = in_array($order_status, ['cancelled', 'failed', 'refunded'], true);
$step_index   = 1;
if ($order_status === 'processing') {
    $step_index = 3;
} elseif ($order_status === 'completed') {
    $step_index = 4;
} elseif (in_array($order_status, ['on-hold', 'pending'], true)) {
    $step_index = 2;
}

$notes = $order->get_customer_order_notes();
?>

<div class="taj-view-order-container">

    <!-- نوار بالا: دکمه بازگشت و شماره سفارش -->
    <div class="view-order-header-toolbar">
        <a href="<?php echo esc_url($orders_url); ?>" class="btn btn-ghost btn-sm back-to-orders-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <span><?php esc_html_e('بازگشت به سفارش‌ها', 'market'); ?></span>
        </a>

        <div class="order-header-badges">
            <span class="taj-order-badge <?php echo esc_attr($status_info['class']); ?>">
                <?php echo esc_html($status_info['label']); ?>
            </span>
        </div>
    </div>

    <!-- کارت خلاصه مشخصات سفارش -->
    <div class="taj-order-summary-card">
        <div class="order-summary-meta-grid">
            <div class="order-summary-item">
                <span class="item-label"><?php esc_html_e('شماره سفارش:', 'market'); ?></span>
                <span class="item-val order-num"><span class="order-hash">#</span><?php echo esc_html(market_to_persian_numbers($order->get_order_number())); ?></span>
            </div>
            <div class="order-summary-item">
                <span class="item-label"><?php esc_html_e('تاریخ ثبت:', 'market'); ?></span>
                <span class="item-val"><?php echo esc_html($order_date); ?></span>
            </div>
            <div class="order-summary-item">
                <span class="item-label"><?php esc_html_e('روش پرداخت:', 'market'); ?></span>
                <span class="item-val"><?php echo esc_html($payment_title ?: __('نامشخص', 'market')); ?></span>
            </div>
            <div class="order-summary-item">
                <span class="item-label"><?php esc_html_e('مبلغ کل:', 'market'); ?></span>
                <span class="item-val is-price"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
            </div>
        </div>

        <?php if (!$is_cancelled) : ?>
            <!-- خط سیر مراحل پیشرفت سفارش (استپر گرافیکی) -->
            <div class="order-tracker-stepper">
                <div class="tracker-step <?php echo $step_index >= 1 ? 'is-done' : ''; ?> <?php echo $step_index === 1 ? 'is-current' : ''; ?>">
                    <div class="step-circle">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span class="step-label"><?php esc_html_e('ثبت سفارش', 'market'); ?></span>
                </div>
                <div class="tracker-bar <?php echo $step_index >= 2 ? 'is-active' : ''; ?>"></div>

                <div class="tracker-step <?php echo $step_index >= 2 ? 'is-done' : ''; ?> <?php echo $step_index === 2 ? 'is-current' : ''; ?>">
                    <div class="step-circle">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span class="step-label"><?php esc_html_e('تأیید پرداخت', 'market'); ?></span>
                </div>
                <div class="tracker-bar <?php echo $step_index >= 3 ? 'is-active' : ''; ?>"></div>

                <div class="tracker-step <?php echo $step_index >= 3 ? 'is-done' : ''; ?> <?php echo $step_index === 3 ? 'is-current' : ''; ?>">
                    <div class="step-circle">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span class="step-label"><?php esc_html_e('آماده‌سازی سفارش', 'market'); ?></span>
                </div>
                <div class="tracker-bar <?php echo $step_index >= 4 ? 'is-active' : ''; ?>"></div>

                <div class="tracker-step <?php echo $step_index >= 4 ? 'is-done' : ''; ?> <?php echo $step_index === 4 ? 'is-current' : ''; ?>">
                    <div class="step-circle">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span class="step-label"><?php esc_html_e('تحویل داده شد', 'market'); ?></span>
                </div>
            </div>
        <?php else : ?>
            <div class="order-cancelled-alert alert-danger" style="margin-top: 18px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <span><?php printf(esc_html__('این سفارش در تاریخ %s در وضعیت «%s» قرار گرفته است.', 'market'), esc_html($order_date), esc_html($status_info['label'])); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- جدول اقلام خریداری شده -->
    <div class="view-order-items-card">
        <h2 class="view-order-card-title"><?php esc_html_e('اقلام خریداری شده در این سفارش', 'market'); ?></h2>

        <table class="taj-account-table view-order-table hide-on-mobile">
            <thead>
                <tr>
                    <th class="col-product"><?php esc_html_e('محصول', 'market'); ?></th>
                    <th class="col-price"><?php esc_html_e('قیمت واحد', 'market'); ?></th>
                    <th class="col-qty"><?php esc_html_e('تعداد', 'market'); ?></th>
                    <th class="col-total"><?php esc_html_e('مجموع جزء', 'market'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order->get_items() as $item_id => $item) :
                    $product = $item->get_product();
                    $permalink = $product ? $product->get_permalink() : '';
                    $thumbnail = $product ? $product->get_image('thumbnail') : '';
                ?>
                    <tr>
                        <td class="col-product">
                            <div class="order-item-product-flex">
                                <?php if ($thumbnail) : ?>
                                    <div class="order-item-thumb">
                                        <?php if ($permalink) : ?>
                                            <a href="<?php echo esc_url($permalink); ?>"><?php echo $thumbnail; // phpcs:ignore ?></a>
                                        <?php else : ?>
                                            <?php echo $thumbnail; // phpcs:ignore ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="order-item-info">
                                    <?php if ($permalink) : ?>
                                        <a href="<?php echo esc_url($permalink); ?>" class="order-item-title"><?php echo esc_html($item->get_name()); ?></a>
                                    <?php else : ?>
                                        <span class="order-item-title"><?php echo esc_html($item->get_name()); ?></span>
                                    <?php endif; ?>

                                    <?php wc_display_item_meta($item); ?>
                                </div>
                            </div>
                        </td>
                        <td class="col-price">
                            <?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
                        </td>
                        <td class="col-qty">
                            <?php echo esc_html(market_to_persian_numbers($item->get_quantity())); ?>
                        </td>
                        <td class="col-total">
                            <?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- نسخه موبایل اقلام -->
        <div class="view-order-items-mobile hide-on-desktop">
            <?php foreach ($order->get_items() as $item_id => $item) :
                $product = $item->get_product();
                $permalink = $product ? $product->get_permalink() : '';
                $thumbnail = $product ? $product->get_image('thumbnail') : '';
            ?>
                <div class="mobile-order-item-row">
                    <?php if ($thumbnail) : ?>
                        <div class="item-thumb"><?php echo $thumbnail; // phpcs:ignore ?></div>
                    <?php endif; ?>
                    <div class="item-details">
                        <span class="item-name"><?php echo esc_html($item->get_name()); ?></span>
                        <div class="item-sub-meta">
                            <span><?php printf(esc_html__('تعداد: %s', 'market'), esc_html(market_to_persian_numbers($item->get_quantity()))); ?></span>
                            <span class="item-line-total"><?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ردیف دو ستونه: خلاصه مبالغ فاکتور و آدرس‌ها -->
    <div class="view-order-bottom-grid">
        <!-- کارت صورتحساب و مبالغ کل -->
        <div class="order-totals-card">
            <h3 class="order-totals-title"><?php esc_html_e('خلاصه پرداخت و فاکتور', 'market'); ?></h3>
            <table class="order-totals-table">
                <tbody>
                    <?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
                        <tr class="total-row-<?php echo esc_attr($key); ?> <?php echo ('order_total' === $key) ? 'is-final-total' : ''; ?>">
                            <th><?php echo esc_html($total['label']); ?></th>
                            <td><?php echo wp_kses_post($total['value']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- کارت آدرس‌های تحویل و صورتحساب -->
        <div class="order-addresses-card">
            <h3 class="order-addresses-title"><?php esc_html_e('آدرس‌های ثبت‌شده سفارش', 'market'); ?></h3>
            <div class="order-addresses-subgrid">
                <?php if ($order->get_formatted_shipping_address()) : ?>
                    <div class="address-box">
                        <span class="address-box-heading">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span><?php esc_html_e('آدرس تحویل سفارش', 'market'); ?></span>
                        </span>
                        <address class="address-content">
                            <?php echo wp_kses_post($order->get_formatted_shipping_address()); ?>
                            <?php if ($order->get_shipping_phone()) : ?>
                                <p class="address-phone"><?php printf(esc_html__('شماره تماس: %s', 'market'), esc_html(market_to_persian_numbers($order->get_shipping_phone()))); ?></p>
                            <?php endif; ?>
                        </address>
                    </div>
                <?php endif; ?>

                <div class="address-box">
                    <span class="address-box-heading">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        <span><?php esc_html_e('آدرس و مشخصات خریدار', 'market'); ?></span>
                    </span>
                    <address class="address-content">
                        <?php echo wp_kses_post($order->get_formatted_billing_address() ?: __('همان آدرس تحویل سفارش', 'market')); ?>
                        <?php if ($order->get_billing_phone()) : ?>
                            <p class="address-phone"><?php printf(esc_html__('شماره تماس: %s', 'market'), esc_html(market_to_persian_numbers($order->get_billing_phone()))); ?></p>
                        <?php endif; ?>
                        <?php if ($order->get_billing_email()) : ?>
                            <p class="address-email"><?php printf(esc_html__('ایمیل: %s', 'market'), esc_html($order->get_billing_email())); ?></p>
                        <?php endif; ?>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <!-- یادداشت‌های سفارش و تاریخچه رویدادها (در صورت وجود) -->
    <?php if ($notes) : ?>
        <div class="view-order-notes-card">
            <h3 class="order-notes-title"><?php esc_html_e('پیام‌ها و آخرین وضعیت مرسوله', 'market'); ?></h3>
            <ol class="woocommerce-OrderUpdates commentlist notes order-notes-timeline">
                <?php foreach ($notes as $note) : ?>
                    <li class="woocommerce-OrderUpdate comment note order-note-item">
                        <div class="woocommerce-OrderUpdate-description description note-text">
                            <?php echo wpautop(wptexturize($note->content)); // phpcs:ignore ?>
                        </div>
                        <time class="woocommerce-OrderUpdate-date note-date" datetime="<?php echo esc_attr($note->date_created->date('c')); ?>">
                            <?php echo esc_html(market_format_persian_date($note->date_created->getTimestamp())); ?>
                        </time>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_view_order', $order_id); ?>

</div>
