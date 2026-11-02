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
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-title-link">
            <span class="site-title"><?php bloginfo('name'); ?></span>
        </a>
        <?php
    }
    ?>
</div>
