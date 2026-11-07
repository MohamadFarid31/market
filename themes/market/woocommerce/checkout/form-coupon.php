<?php
/**
 * Checkout coupon form — Taj Bazar Theme Override
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) {
    return;
}
?>
<div class="taj-checkout-coupon-wrapper">
    <div class="woocommerce-form-coupon-toggle taj-coupon-toggle-bar">
        <div class="taj-coupon-notice">
            <span class="taj-coupon-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                </svg>
            </span>
            <span class="taj-coupon-text"><?php esc_html_e('کد تخفیف دارید؟', 'market'); ?></span>
            <a href="#" class="showcoupon taj-toggle-coupon-link"><?php esc_html_e('برای اعمال کد اینجا کلیک کنید', 'market'); ?></a>
        </div>
    </div>

    <form class="checkout_coupon woocommerce-form-coupon taj-coupon-form" method="post" style="display:none">
        <p class="taj-coupon-desc"><?php esc_html_e('اگر کوپن یا کد تخفیف فروشگاهی دارید، لطفاً آن را در کادر زیر وارد نمایید:', 'market'); ?></p>
        <div class="taj-coupon-form-inner">
            <input type="text" name="coupon_code" class="input-text taj-coupon-input" placeholder="<?php esc_attr_e('کد تخفیف را وارد کنید...', 'market'); ?>" id="coupon_code" value="" />
            <button type="submit" class="button taj-btn-apply-coupon" name="apply_coupon" value="<?php esc_attr_e('اعمال کد', 'market'); ?>"><?php esc_html_e('اعمال تخفیف', 'market'); ?></button>
        </div>
    </form>
</div>
