<?php
/**
 * Market Theme — Error Notice Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!$notices) {
    return;
}
?>
<ul class="woocommerce-error alert alert-danger" role="alert">
    <?php foreach ($notices as $notice) : ?>
        <li<?php echo wc_get_notice_data_attr($notice); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php echo wc_kses_notice($notice['notice']); ?>
        </li>
    <?php endforeach; ?>
</ul>
