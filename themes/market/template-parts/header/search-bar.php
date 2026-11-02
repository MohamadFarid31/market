<?php
/**
 * Market Theme — Search Bar Component
 *
 * @package Market
 */

defined('ABSPATH') || exit;
?>
<form role="search" method="get" class="header-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="header-search-field" class="sr-only">
        <?php esc_html_e('جستجو در محصولات', 'market'); ?>
    </label>
    <input 
        type="search" 
        id="header-search-field" 
        class="form-control header-search-input" 
        placeholder="<?php esc_attr_e('جستجوی محصولات، دسته‌ها یا برندها...', 'market'); ?>" 
        value="<?php echo get_search_query(); ?>" 
        name="s" 
        autocomplete="off"
    >
    <?php if (class_exists('WooCommerce')) : ?>
        <input type="hidden" name="post_type" value="product">
    <?php endif; ?>
    <button type="submit" class="header-search-btn btn btn-ghost" aria-label="<?php esc_attr_e('جستجو', 'market'); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </button>
</form>
