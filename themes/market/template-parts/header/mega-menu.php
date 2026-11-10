<?php
/**
 * Market Theme — Digikala-Style Category Mega Menu Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;

// واکشی داینامیک درخت دسته‌بندی‌ها از تابع مرکزی قالب
$categories_data = function_exists('market_get_categories_tree') ? market_get_categories_tree() : [];
?>

<div class="mega-menu-dropdown" id="header-mega-menu-dropdown" role="region" aria-label="<?php esc_attr_e('مگامنوی دسته‌بندی کالاها', 'market'); ?>">
    <!-- ستون سمت راست: لیست دسته‌های اصلی -->
    <div class="mega-menu-sidebar">
        <ul class="mega-menu-cat-list" role="tablist">
            <?php foreach ($categories_data as $index => $cat) : 
                $has_children = !empty($cat['children']);
                $is_active = ($index === 0);
            ?>
                <li class="mega-menu-cat-item <?php echo $is_active ? 'is-active' : ''; ?>" 
                    data-cat-id="<?php echo esc_attr($cat['id']); ?>" 
                    role="tab" 
                    aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <a href="<?php echo esc_url($cat['url']); ?>" class="mega-menu-cat-link">
                        <span class="cat-title"><?php echo esc_html($cat['name']); ?></span>
                        <?php if ($has_children) : ?>
                            <svg class="cat-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- ستون سمت چپ: پنل‌های نمایش زیردسته‌ها یا کارت ورود به دسته -->
    <div class="mega-menu-content-panels">
        <?php foreach ($categories_data as $index => $cat) : 
            $children = $cat['children'];
            $is_active = ($index === 0);
        ?>
            <div class="mega-menu-panel <?php echo $is_active ? 'is-active' : ''; ?>" 
                 id="mega-panel-<?php echo esc_attr($cat['id']); ?>" 
                 role="tabpanel">
                
                <div class="mega-panel-header">
                    <a href="<?php echo esc_url($cat['url']); ?>" class="mega-panel-view-all">
                        <span><?php printf(esc_html__('مشاهده تمام محصولات %s', 'market'), esc_html($cat['name'])); ?></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </a>
                </div>

                <?php if (!empty($children)) : ?>
                    <div class="mega-subcats-grid">
                        <?php foreach ($children as $child) : ?>
                            <a href="<?php echo esc_url($child['url']); ?>" class="mega-subcat-card">
                                <span class="subcat-indicator"></span>
                                <span class="subcat-text"><?php echo esc_html($child['name']); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <!-- حالت اختصاصی برای دسته‌های تک‌سطحی مانند نورپردازی و عروسک -->
                    <div class="mega-single-cat-box">
                        <div class="single-cat-icon">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </div>
                        <h4 class="single-cat-title"><?php echo esc_html($cat['name']); ?></h4>
                        <p class="single-cat-desc"><?php esc_html_e('این دسته‌بندی فاقد زیرمجموعه است و تمام کالاهای مرتبط به صورت مستقیم نمایش داده می‌شوند.', 'market'); ?></p>
                        <a href="<?php echo esc_url($cat['url']); ?>" class="btn btn-primary btn-sm">
                            <?php printf(esc_html__('مشاهده کالاهای %s', 'market'), esc_html($cat['name'])); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>

