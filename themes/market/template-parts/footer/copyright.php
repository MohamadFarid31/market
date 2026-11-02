<?php
/**
 * Market Theme — Footer Copyright Notice
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div class="footer-bottom">
    <div class="copyright-text">
        <p>
            &copy; <?php echo esc_html(market_to_persian_numbers(date_i18n('Y'))); ?> 
            <?php bloginfo('name'); ?>. 
            <?php esc_html_e('تمامی حقوق محفوظ است.', 'market'); ?>
        </p>
    </div>
    <div class="footer-bottom-links">
        <a href="#primary" class="back-to-top btn-ghost">
            <?php esc_html_e('بازگشت به بالا ↑', 'market'); ?>
        </a>
    </div>
</div>
