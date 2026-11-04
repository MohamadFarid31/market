<?php
/**
 * Proceed to checkout button — Taj Bazar Recreation
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>

<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button button alt wc-forward taj-checkout-btn">
    <?php esc_html_e('ادامه جهت تسویه حساب', 'market'); ?>
</a>

