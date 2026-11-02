<?php
/**
 * Market Theme — Topbar Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div class="topbar">
    <div class="container">
        <div class="topbar-start">
            <span class="topbar-notice">
                <?php esc_html_e('به فروشگاه ما خوش آمدید!', 'market'); ?>
            </span>
        </div>
        <div class="topbar-end flex items-center gap-4">
            <span class="topbar-phone">
                <?php esc_html_e('پشتیبانی ۲۴ ساعته', 'market'); ?>
            </span>
        </div>
    </div>
</div>
