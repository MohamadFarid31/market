<?php
/**
 * Market Theme — WooCommerce Mock Products Generator (PHP / WP-CLI / Standalone)
 *
 * اسکریپت ساخت محصولات تستی ماک در محیط PHP یا WP-CLI:
 * نحوه اجرا با WP-CLI در ریشه وردپرس:
 *   wp eval-file scripts/create-mock-products.php
 *
 * @package Market
 */

// بررسی لود بودن محیط وردپرس
if (!defined('ABSPATH')) {
    // تلاش برای یافتن و لود wp-load.php در صورت اجرای مستقل
    $possible_paths = [
        __DIR__ . '/../../wp-load.php',
        __DIR__ . '/../../../wp-load.php',
        dirname(__DIR__, 2) . '/wp-load.php',
    ];
    $loaded = false;
    foreach ($possible_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $loaded = true;
            break;
        }
    }
    if (!$loaded && !function_exists('wc_get_products')) {
        echo "❌ این اسکریپت نیاز به هسته وردپرس و ووکامرس دارد.\n";
        echo "💡 نحوه اجرا با WP-CLI:\n  wp eval-file " . basename(__FILE__) . "\n";
        exit(1);
    }
}

if (!class_exists('WooCommerce')) {
    echo "❌ افزونه ووکامرس فعال نیست.\n";
    exit(1);
}

$count_per_category = 3;
echo "======================================================================\n";
echo "🛍️  اسکریپت ساخت محصولات ماک ووکامرس (نسخه PHP)\n";
echo "📦 تعداد محصول به ازای هر دسته: {$count_per_category}\n";
echo "======================================================================\n\n";

$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
]);

if (empty($categories) || is_wp_error($categories)) {
    echo "❌ هیچ دسته‌بندی در فروشگاه یافت نشد.\n";
    exit(1);
}

$palettes = [
    ['bg' => '2563eb', 'fg' => 'ffffff'],
    ['bg' => '059669', 'fg' => 'ffffff'],
    ['bg' => '7c3aed', 'fg' => 'ffffff'],
    ['bg' => 'd97706', 'fg' => 'ffffff'],
    ['bg' => 'dc2626', 'fg' => 'ffffff'],
    ['bg' => '0891b2', 'fg' => 'ffffff'],
];

$total_created = 0;

foreach ($categories as $cat) {
    if ($cat->slug === 'uncategorized') continue;

    // بررسی آیا این دسته زیردسته دارد؟
    $children = get_term_children($cat->term_id, 'product_cat');
    if (!empty($children)) {
        // برای دسته‌هایی که زیردسته دارند، محصولات در زیردسته‌ها ساخته می‌شوند
        continue;
    }

    $title_prefix = $cat->name;
    $term_ids = [$cat->term_id];

    if ($cat->parent > 0) {
        $parent = get_term($cat->parent, 'product_cat');
        if ($parent && !is_wp_error($parent)) {
            $term_ids[] = $parent->term_id;
            if (mb_strpos($title_prefix, $parent->name) === false) {
                $title_prefix = $parent->name . ' ' . $title_prefix;
            }
        }
    }

    echo "📂 پردازش دسته: \"{$title_prefix}\" (ID: {$cat->term_id})\n";

    for ($i = 1; $i <= $count_per_category; $i++) {
        $product_name = "{$title_prefix} شماره {$i}";

        // قیمت تصادفی (بین ۱۵۰ هزار تا ۴.۵ میلیون تومان)
        $base_price = (rand(15, 450) * 10) * 1000;
        $has_sale = (rand(1, 10) <= 4);
        $sale_price = '';

        if ($has_sale) {
            $discount_pct = rand(10, 30);
            $sale_price = (string) (round(($base_price * (1 - $discount_pct / 100)) / 10000) * 10000);
        }

        // موجودی تصادفی (۸۵٪ موجود)
        $is_instock = (rand(1, 100) <= 85);
        $stock_status = $is_instock ? 'instock' : 'outofstock';
        $stock_qty = $is_instock ? rand(3, 25) : 0;

        $product = new WC_Product_Simple();
        $product->set_name($product_name);
        $product->set_status('publish');
        $product->set_regular_price((string) $base_price);
        if ($sale_price) {
            $product->set_sale_price($sale_price);
        }
        $product->set_manage_stock(true);
        $product->set_stock_status($stock_status);
        $product->set_stock_quantity($stock_qty);
        $product->set_category_ids($term_ids);
        $product->set_short_description("<p>{$product_name} — محصول تستی با کیفیت عالی و گارانتی اصالت کالا.</p>");
        $product->set_description("<p>این یک محصول تستی ماک جهت بررسی ظاهر فروشگاه و چیدمان قالب است.</p>");

        $product_id = $product->save();

        if ($product_id) {
            $total_created++;
            $price_fmt = number_format($base_price) . ' ت';
            $sale_fmt = $sale_price ? ' (تخفیف: ' . number_format((int)$sale_price) . ' ت)' : '';
            echo "  ✅ محصول ایجاد شد: \"{$product_name}\" (ID: {$product_id}) | {$price_fmt}{$sale_fmt} | {$stock_status}\n";
        }
    }
}

echo "\n======================================================================\n";
echo "🎉 عملیات به پایان رسید! مجموعاً {$total_created} محصول ماک ثبت گردید.\n";
echo "======================================================================\n";

