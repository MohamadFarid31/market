<?php
/**
 * Market Theme — Taj Bazar Footer Copyright Notice
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$rights  = function_exists('market_get_option') ? market_get_option('copyright_rights', 'تمامی حقوق محفوظ و متعلق به تاج بازار می‌باشد.') : 'تمامی حقوق محفوظ و متعلق به تاج بازار می‌باشد.';
$credits = function_exists('market_get_option') ? market_get_option('copyright_credits', 'طراحی و توسعه یافته توسط استودیو تکسیما') : 'طراحی و توسعه یافته توسط استودیو تکسیما';
?>
<div class="footer-copyright-bar">
    <div class="container footer-copyright-inner">
        <p class="copyright-rights">
            <?php echo esc_html($rights); ?>
        </p>
        <p class="copyright-credits">
            <?php echo esc_html($credits); ?>
        </p>
    </div>
</div>
