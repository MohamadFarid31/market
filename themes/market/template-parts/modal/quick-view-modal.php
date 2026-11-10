<?php
/**
 * Market Theme — Quick View Modal Component (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div id="quick-view-overlay" class="qv-modal-overlay" aria-hidden="true"></div>

<div id="quick-view-modal" class="qv-modal-dialog" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('نمایش سریع محصول', 'market'); ?>">
    <button type="button" class="qv-close-btn" id="quick-view-close-btn" aria-label="<?php esc_attr_e('بستن', 'market'); ?>" title="<?php esc_attr_e('بستن', 'market'); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div id="quick-view-content" class="qv-modal-content">
        <!-- Loaded dynamically via AJAX -->
    </div>
</div>
