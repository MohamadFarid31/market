<?php
/**
 * Market Theme — Off-Canvas Mobile Navigation Drawer
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<div id="mobile-nav-overlay" class="drawer-overlay" aria-hidden="true"></div>

<aside id="mobile-nav-drawer" class="drawer" aria-label="<?php esc_attr_e('منوی ناوبری موبایل', 'market'); ?>">
    <div class="drawer-header">
        <h2 class="drawer-title"><?php esc_html_e('منوی دسترسی', 'market'); ?></h2>
        <button class="btn btn-ghost" data-close="mobile-nav" aria-label="<?php esc_attr_e('بستن منو', 'market'); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="drawer-body">
        <div class="mobile-search-wrapper" style="margin-block-end: var(--space-4);">
            <?php get_template_part('template-parts/header/search-bar'); ?>
        </div>

        <!-- بخش آکاردئونی دسته‌بندی کالاها در موبایل -->
        <div class="mobile-categories-wrapper" style="margin-block-end: var(--space-4);">
            <details class="mobile-cat-accordion" open>
                <summary class="mobile-cat-summary" style="display: flex; align-items: center; justify-content: space-between; padding: var(--space-3); background-color: var(--color-bg-subtle); border-radius: var(--radius-md); font-weight: var(--font-weight-bold); font-size: var(--font-size-sm); cursor: pointer; list-style: none;">
                    <span style="display: flex; align-items: center; gap: var(--space-2);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <?php esc_html_e('دسته‌بندی کالاها', 'market'); ?>
                    </span>
                    <svg class="summary-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <div class="mobile-cat-content" style="padding-block-start: var(--space-2);">
                    <?php
                    $mobile_cats = [];
                    if (class_exists('WooCommerce')) {
                        $mobile_cats = get_terms([
                            'taxonomy'   => 'product_cat',
                            'parent'     => 0,
                            'hide_empty' => false,
                            'exclude'    => [get_option('default_product_cat')],
                        ]);
                    }

                    if (!empty($mobile_cats) && !is_wp_error($mobile_cats)) :
                    ?>
                        <ul class="mobile-nav-list">
                            <?php foreach ($mobile_cats as $m_cat) : 
                                $m_children = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $m_cat->term_id,
                                    'hide_empty' => false,
                                ]);
                                $has_subs = !empty($m_children) && !is_wp_error($m_children);
                            ?>
                                <li class="<?php echo $has_subs ? 'menu-item-has-children' : ''; ?>">
                                    <a href="<?php echo esc_url(get_term_link($m_cat)); ?>"><?php echo esc_html($m_cat->name); ?></a>
                                    <?php if ($has_subs) : ?>
                                        <ul class="sub-menu">
                                            <?php foreach ($m_children as $m_sub) : ?>
                                                <li>
                                                    <a href="<?php echo esc_url(get_term_link($m_sub)); ?>"><?php echo esc_html($m_sub->name); ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </details>
        </div>

        <div class="mobile-menu-divider" style="height: 1px; background-color: var(--color-border-subtle); margin-block: var(--space-4);"></div>

        <!-- پیوندهای اصلی سایت -->
        <?php
        if (has_nav_menu('mobile-menu')) {
            wp_nav_menu([
                'theme_location' => 'mobile-menu',
                'menu_class'     => 'mobile-nav-list',
                'container'      => 'nav',
                'depth'          => 3,
            ]);
        } elseif (has_nav_menu('primary-menu')) {
            wp_nav_menu([
                'theme_location' => 'primary-menu',
                'menu_class'     => 'mobile-nav-list',
                'container'      => 'nav',
                'depth'          => 3,
            ]);
        }
        ?>
    </div>
</aside>
