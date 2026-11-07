<?php
/**
 * Market Theme — My Account Dashboard (Fallback to Orders)
 *
 * In Market Theme, the account dashboard is replaced with the Orders list.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_my_account');

if (function_exists('woocommerce_account_orders')) {
    woocommerce_account_orders();
}

do_action('woocommerce_after_my_account');
