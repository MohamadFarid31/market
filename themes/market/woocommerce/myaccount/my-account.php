<?php
/**
 * Market Theme — My Account Layout Wrapper
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_navigation');
?>

<div class="taj-account-wrapper account-wrapper">
    <div class="taj-account-layout account-layout">
        <aside class="taj-account-sidebar account-sidebar">
            <?php
            /**
             * My Account navigation.
             *
             * @since 2.6.0
             */
            do_action('woocommerce_account_navigation');
            ?>
        </aside>

        <main class="taj-account-content account-content">
            <div class="taj-account-content-card account-content-card">
                <?php
                /**
                 * My Account content.
                 *
                 * @since 2.6.0
                 */
                do_action('woocommerce_account_content');
                ?>
            </div>
        </main>
    </div>
</div>
