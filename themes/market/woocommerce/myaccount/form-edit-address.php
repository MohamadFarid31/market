<?php
/**
 * Market Theme — Edit Address Form Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$page_title = ('billing' === $load_address) ? esc_html__('آدرس صورتحساب', 'market') : esc_html__('آدرس تحویل کالا', 'market');
$address_url = wc_get_account_endpoint_url('edit-address');

do_action("woocommerce_before_edit_address_form_{$load_address}");
?>

<div class="taj-edit-address-form-container">

    <div class="account-page-header form-header-with-back">
        <a href="<?php echo esc_url($address_url); ?>" class="btn btn-ghost btn-sm back-to-addresses-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <span><?php esc_html_e('بازگشت به لیست آدرس‌ها', 'market'); ?></span>
        </a>
        <h1 class="account-page-title"><?php printf(esc_html__('ویرایش %s', 'market'), esc_html($page_title)); ?></h1>
    </div>

    <form method="post" class="taj-styled-form taj-edit-address-form">

        <div class="woocommerce-address-fields">
            <?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

            <div class="woocommerce-address-fields__field-wrapper taj-form-grid">
                <?php
                foreach ($address as $key => $field) {
                    woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                }
                ?>
            </div>

            <?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>

            <div class="form-submit-row">
                <button type="submit" class="btn btn-primary btn-lg save-address-btn" name="save_address" value="<?php esc_attr_e('ذخیره آدرس', 'market'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span><?php esc_html_e('ذخیره و ثبت آدرس', 'market'); ?></span>
                </button>
                <?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
                <input type="hidden" name="action" value="edit_address" />
            </div>
        </div>

    </form>

</div>

<?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>
