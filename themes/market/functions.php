<?php
/**
 * Market Theme — Core Bootstrap & Includes Loader
 *
 * @package Market
 */

defined('ABSPATH') || exit;

// Theme constants
define('MARKET_VERSION', '1.0.1');
define('MARKET_DIR', get_template_directory());
define('MARKET_URI', get_template_directory_uri());

// 1. Theme Setup & Supports
require_once MARKET_DIR . '/inc/setup.php';

// 2. Conditional Asset Enqueuing
require_once MARKET_DIR . '/inc/assets.php';

// 3. Persian RTL & Localization Helpers
require_once MARKET_DIR . '/inc/rtl-persian.php';

// 4. Custom Template Tags & Displays
require_once MARKET_DIR . '/inc/template-tags.php';

// 5. Schema Breadcrumb Generator
require_once MARKET_DIR . '/inc/breadcrumbs.php';

// 6. Dynamic Taxonomy & Brand Utilities
require_once MARKET_DIR . '/inc/custom-taxonomies.php';

// 7. WooCommerce Integration (Only when WooCommerce is active)
if (class_exists('WooCommerce')) {
    require_once MARKET_DIR . '/inc/woocommerce.php';
    require_once MARKET_DIR . '/inc/wishlist.php';
}

// 8. Theme Settings Page (Footer, Contact, About, Trust Badges)
require_once MARKET_DIR . '/inc/theme-settings.php';

// 9. Homepage Custom Banners & Meta Boxes
require_once MARKET_DIR . '/inc/homepage-metaboxes.php';

// 10. Content Pages Custom Meta Boxes (Contact, Complaints, etc.)
require_once MARKET_DIR . '/inc/content-page-metaboxes.php';
