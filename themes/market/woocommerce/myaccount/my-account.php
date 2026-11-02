<?php
/**
 * Market Theme — My Account Layout Wrapper
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>

<div class="account-layout">
    <nav class="account-sidebar-nav" aria-label="<?php esc_attr_e('منوی حساب کاربری', 'market'); ?>">
        <?php
        /**
         * My Account navigation.
         *
         * @since 2.6.0
         */
        do_action('woocommerce_account_navigation');
        ?>
    </nav>

    <div class="account-content-card">
        <?php
        /**
         * My Account content.
         *
         * @since 2.6.0
         */
        do_action('woocommerce_account_content');
        ?>
    </div>
</div>
