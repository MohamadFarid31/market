<?php
/**
 * Market Theme — Global Footer Template (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>

<footer id="colophon" class="site-footer">
    <div class="container footer-main-container">
        <?php get_template_part('template-parts/footer/widgets'); ?>
    </div>
    <?php get_template_part('template-parts/footer/copyright'); ?>
</footer>

<?php get_template_part('template-parts/navigation/mobile-bottom-bar'); ?>

<?php wp_footer(); ?>
</body>
</html>
