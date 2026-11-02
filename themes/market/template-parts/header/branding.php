<?php
/**
 * Market Theme — Branding Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div class="site-branding">
    <?php
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo-link">
            <span class="taj-bazar-logo">
                <svg class="taj-bazar-emblem" width="36" height="36" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <!-- Crown with Camera Aperture Emblem -->
                    <path d="M12 9L15 15L20 7L25 15L28 9L29 18H11L12 9Z" fill="#E52534"/>
                    <circle cx="20" cy="27" r="11" stroke="#E52534" stroke-width="2.5"/>
                    <circle cx="20" cy="27" r="4.5" fill="#E52534"/>
                    <path d="M20 16.5L25.5 22M27.5 27L22 32.5M16.5 32L12.5 25.5M12.5 22.5L18 17M27 22.5L20 27" stroke="#E52534" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span class="taj-bazar-text">TAJ BAZAR</span>
            </span>
        </a>
        <?php
    }
    ?>
</div>
