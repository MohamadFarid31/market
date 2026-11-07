<?php
/**
 * Market Theme — My Account Navigation Sidebar
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
$display_name = $current_user->display_name ?: $current_user->user_login;
$user_phone   = get_user_meta($user_id, 'billing_phone', true);
$user_contact = !empty($user_phone) ? market_to_persian_numbers($user_phone) : $current_user->user_email;

$wishlist_count = function_exists('market_get_user_wishlist') ? count(market_get_user_wishlist($user_id)) : 0;
$menu_items     = wc_get_account_menu_items();
?>

<nav class="taj-account-sidebar-nav account-sidebar-nav" aria-label="<?php esc_attr_e('منوی حساب کاربری', 'market'); ?>">

    <!-- ۱. کارت اطلاعات و پروفایل کاربر -->
    <div class="account-profile-summary">
        <div class="account-avatar-wrapper">
            <?php echo get_avatar($user_id, 68, '', esc_attr($display_name), ['class' => 'account-avatar-img']); ?>
            <span class="account-avatar-ring"></span>
        </div>
        <div class="account-user-meta">
            <span class="account-user-name" title="<?php echo esc_attr($display_name); ?>">
                <?php echo esc_html($display_name); ?>
            </span>
            <span class="account-user-contact">
                <?php echo esc_html($user_contact); ?>
            </span>
            <span class="account-user-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                </svg>
                <span><?php esc_html_e('کاربر فروشگاه', 'market'); ?></span>
            </span>
        </div>
    </div>

    <div class="account-nav-divider"></div>

    <!-- ۲. فهرست آیتم‌های منو با آیکون‌های استاندارد -->
    <ul class="taj-account-nav-list account-nav-list">
        <?php foreach ($menu_items as $endpoint => $label) :
            $classes = wc_get_account_menu_item_classes($endpoint);
            $url     = wc_get_account_endpoint_url($endpoint);
            $is_wishlist = ('wishlist' === $endpoint);
        ?>
            <li class="taj-account-nav-item account-nav-item <?php echo esc_attr($classes); ?>">
                <a href="<?php echo esc_url($url); ?>" class="account-nav-link">
                    <span class="account-nav-icon">
                        <?php if ('dashboard' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        <?php elseif ('orders' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        <?php elseif ('downloads' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        <?php elseif ('edit-address' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        <?php elseif ('payment-methods' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        <?php elseif ('edit-account' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        <?php elseif ($is_wishlist) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        <?php elseif ('customer-logout' === $endpoint) : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        <?php else : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        <?php endif; ?>
                    </span>

                    <span class="account-nav-label"><?php echo esc_html($label); ?></span>

                    <?php if ($is_wishlist && $wishlist_count > 0) : ?>
                        <span class="account-nav-count"><?php echo esc_html(market_to_persian_numbers($wishlist_count)); ?></span>
                    <?php endif; ?>

                    <span class="account-nav-arrow" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php
    /**
     * My Account after navigation hook.
     */
    do_action('woocommerce_after_account_navigation');
    ?>

</nav>
