<?php
/**
 * Market Theme — Success Notice Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!$notices) {
    return;
}
?>

<?php foreach ($notices as $notice) : ?>
    <div class="alert alert-success woocommerce-message"<?php echo wc_get_notice_data_attr($notice); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> role="alert">
        <?php echo wc_kses_notice($notice['notice']); ?>
    </div>
<?php endforeach; ?>
