<?php
/**
 * Market Theme — Global Footer Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>

<footer id="colophon" class="site-footer">
    <div class="container">
        <?php get_template_part('template-parts/footer/widgets'); ?>
        <?php get_template_part('template-parts/footer/copyright'); ?>
    </div>
</footer>

<?php get_template_part('template-parts/navigation/mobile-bottom-bar'); ?>

<?php wp_footer(); ?>
</body>
</html>
