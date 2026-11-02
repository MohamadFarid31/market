<?php
/**
 * Market Theme — Empty State Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;

$title       = isset($args['title']) ? $args['title'] : esc_html__('موردی یافت نشد', 'market');
$description = isset($args['description']) ? $args['description'] : esc_html__('متأسفانه هیچ نتیجه‌ای با مشخصات درخواستی پیدا نشد.', 'market');
$cta_text    = isset($args['cta_text']) ? $args['cta_text'] : esc_html__('مشاهده همه محصولات', 'market');
$cta_url     = isset($args['cta_url']) ? $args['cta_url'] : (function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/'));
?>
<div class="empty-state">
    <div class="empty-state-icon" aria-hidden="true">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
    </div>
    <h3 class="empty-state-title"><?php echo esc_html($title); ?></h3>
    <p class="empty-state-desc"><?php echo esc_html($description); ?></p>
    <?php if (!empty($cta_text) && !empty($cta_url)) : ?>
        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary">
            <?php echo esc_html($cta_text); ?>
        </a>
    <?php endif; ?>
</div>
