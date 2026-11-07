<?php
/**
 * Market Theme — My Addresses Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        [
            'billing'  => __('آدرس صورتحساب', 'market'),
            'shipping' => __('آدرس تحویل سفارش', 'market'),
        ],
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        [
            'billing' => __('آدرس صورتحساب', 'market'),
        ],
        $customer_id
    );
}

$oldcol = 1;
$col    = 1;
?>

<div class="taj-account-addresses-container">

    <header class="account-page-header">
        <div class="header-title-group">
            <h1 class="account-page-title"><?php esc_html_e('آدرس‌های ثبت شده', 'market'); ?></h1>
            <p class="account-page-subtitle"><?php esc_html_e('آدرس‌های زیر به صورت پیش‌فرض در برگه تسویه‌حساب برای ثبت فاکتور و ارسال کالا مورد استفاده قرار می‌گیرند.', 'market'); ?></p>
        </div>
    </header>

    <div class="taj-addresses-grid">
        <?php foreach ($get_addresses as $name => $address_title) :
            $address = wc_get_account_formatted_address($name);
            $edit_url = wc_get_endpoint_url('edit-address', $name);
        ?>
            <div class="taj-address-card address-card-<?php echo esc_attr($name); ?>">
                <div class="taj-address-card-header">
                    <div class="address-title-flex">
                        <span class="address-card-icon">
                            <?php if ('shipping' === $name) : ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            <?php else : ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            <?php endif; ?>
                        </span>
                        <h3 class="address-card-title"><?php echo esc_html($address_title); ?></h3>
                    </div>

                    <a href="<?php echo esc_url($edit_url); ?>" class="btn btn-outline btn-sm edit-address-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                        <span><?php echo $address ? esc_html__('ویرایش آدرس', 'market') : esc_html__('افزودن آدرس', 'market'); ?></span>
                    </a>
                </div>

                <div class="taj-address-card-body">
                    <?php if ($address) : ?>
                        <address class="taj-address-content">
                            <?php echo wp_kses_post($address); ?>
                        </address>
                    <?php else : ?>
                        <div class="address-empty-state">
                            <p class="address-empty-msg"><?php esc_html_e('هنوز آدرسی در این بخش ثبت نکرده‌اید.', 'market'); ?></p>
                            <a href="<?php echo esc_url($edit_url); ?>" class="btn btn-ghost btn-sm">
                                <span><?php esc_html_e('+ ثبت آدرس جدید', 'market'); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
