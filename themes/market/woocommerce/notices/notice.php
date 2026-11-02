<?php
/**
 * Market Theme — Info Notice Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!$notices) {
    return;
}
?>

<?php foreach ($notices as $notice) : ?>
    <div class="alert alert-info woocommerce-info"<?php echo wc_get_notice_data_attr($notice); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
        <?php echo wc_kses_notice($notice['notice']); ?>
    </div>
<?php endforeach; ?>
