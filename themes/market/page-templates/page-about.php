<?php
/**
 * Template Name: About Page | درباره ما
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main about-page-main">
    <div class="container container-narrow">
        <header class="page-header" style="margin-block-end: var(--space-6); text-align: center;">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <article class="page-content-card">
            <div class="entry-content">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </article>
    </div>
</main>

<?php
get_footer();
