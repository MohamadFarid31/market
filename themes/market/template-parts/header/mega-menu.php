<?php
/**
 * Market Theme — Digikala-Style Category Mega Menu Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;

// ۱. واکشی داینامیک دسته‌ها و زیردسته‌ها از ووکامرس
$categories_data = [];

if (class_exists('WooCommerce')) {
    $parent_terms = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => 0,
        'hide_empty' => false,
        'exclude'    => [get_option('default_product_cat')],
    ]);

    if (!empty($parent_terms) && !is_wp_error($parent_terms)) {
        foreach ($parent_terms as $parent) {
            $child_terms = get_terms([
                'taxonomy'   => 'product_cat',
                'parent'     => $parent->term_id,
                'hide_empty' => false,
            ]);

            $children = [];
            if (!empty($child_terms) && !is_wp_error($child_terms)) {
                foreach ($child_terms as $child) {
                    $children[] = [
                        'id'   => $child->term_id,
                        'name' => $child->name,
                        'url'  => get_term_link($child),
                    ];
                }
            }

            $categories_data[] = [
                'id'       => $parent->term_id,
                'name'     => $parent->name,
                'url'      => get_term_link($parent),
                'children' => $children,
            ];
        }
    }
}

// ۲. ساختار پیش‌فرض ۶ دسته درخواستی (جهت نمایش فوری پیش از اجرای اسکریپت دیتابیس)
if (empty($categories_data)) {
    $categories_data = [
        [
            'id'       => 'spk',
            'name'     => 'اسپیکر',
            'url'      => home_url('/product-category/speaker/'),
            'children' => [
                ['name' => 'ساب ۱۵', 'url' => home_url('/product-category/sub-15/')],
                ['name' => 'ساب ۱۲', 'url' => home_url('/product-category/sub-12/')],
                ['name' => 'ساب ۱۰', 'url' => home_url('/product-category/sub-10/')],
                ['name' => 'ساب ۸',  'url' => home_url('/product-category/sub-8/')],
                ['name' => 'ساب ۶',  'url' => home_url('/product-category/sub-6/')],
                ['name' => 'ساب ۴',  'url' => home_url('/product-category/sub-4/')],
                ['name' => 'مینی ۳', 'url' => home_url('/product-category/mini-3/')],
            ],
        ],
        [
            'id'       => 'hdp',
            'name'     => 'هدفون و هندزفری',
            'url'      => home_url('/product-category/headphones/'),
            'children' => [
                ['name' => 'Anker',    'url' => home_url('/product-category/anker/')],
                ['name' => 'airpods',  'url' => home_url('/product-category/airpods/')],
                ['name' => 'سری m',   'url' => home_url('/product-category/m-series/')],
                ['name' => 'گیمینگ',   'url' => home_url('/product-category/gaming/')],
                ['name' => 'اقتصادی',  'url' => home_url('/product-category/budget/')],
            ],
        ],
        [
            'id'       => 'wch',
            'name'     => 'ساعت هوشمند-واچ',
            'url'      => home_url('/product-category/smart-watch/'),
            'children' => [
                ['name' => 'KEQIWEAR', 'url' => home_url('/product-category/keqiwear/')],
                ['name' => 'teket',    'url' => home_url('/product-category/teket/')],
                ['name' => 'DSPort',   'url' => home_url('/product-category/dsport/')],
            ],
        ],
        [
            'id'       => 'shv',
            'name'     => 'ماشین اصلاح',
            'url'      => home_url('/product-category/shaver/'),
            'children' => [
                ['name' => 'GODFERY',  'url' => home_url('/product-category/godfery/')],
            ],
        ],
        [
            'id'       => 'lgt',
            'name'     => 'نورپردازی',
            'url'      => home_url('/product-category/lighting/'),
            'children' => [], // دسته تک‌سطحی
        ],
        [
            'id'       => 'dll',
            'name'     => 'عروسک',
            'url'      => home_url('/product-category/dolls/'),
            'children' => [], // دسته تک‌سطحی
        ],
    ];
}
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

