# Query Optimization & Caching Strategy

## 1. Algorithmic Complexity in WordPress / WooCommerce
Every data retrieval operation in the theme must be bounded by predictable computational complexity:
- Single Object by Primary Key (ID): $O(1)$ memory lookup via object cache; $O(\log n)$ B-tree index lookup in database.
- Paginated Queries with Index: $O(\log n + k)$ where $k$ is the page size (`posts_per_page`).
- Full Table Scans / Unindexed `meta_query`: $O(n)$ where $n$ is total rows in `wp_postmeta`. **Unacceptable in production.**
- Unbounded Post Meta / Variation Loops (N+1 queries): $O(n \cdot m)$ database trips. **Must be eliminated.**

## 2. Preventing N+1 Query Antipatterns
### The Problem:
A template loops over 24 products on an archive page. Inside the loop, it invokes `get_post_meta()` or term fetching functions individually, generating $24 \times 3 = 72$ additional SQL queries.

### The Solutions:
1. **Bulk Pre-warming Caches:**
   WordPress provides core cache warmers:
   - `update_post_meta_cache($post_ids)`: Prefetches all postmeta for all retrieved IDs in a single `SELECT ... WHERE post_id IN (...)` query ($O(1)$ database trip).
   - `update_object_term_cache($post_ids, 'product_cat')`: Prefetches all assigned taxonomy terms.
2. **Selective Query Flags:**
   When running custom `WP_Query`:
   ```php
   $args = [
       'post_type'              => 'product',
       'posts_per_page'         => 12,
       'no_found_rows'          => false, // Set to true if pagination is not needed!
       'update_post_meta_cache' => true,  // Pre-load all metadata in 1 query
       'update_post_term_cache' => true,  // Pre-load all terms in 1 query
       'fields'                 => 'ids',  // Retrieve only IDs when full post objects are not required
   ];
   ```
3. **Never Query Unbounded Sets:**
   Never set `'posts_per_page' => -1` on a live WooCommerce catalog. Always enforce pagination and limit query horizons.

## 3. High-Performance Caching Architecture
### Layer 1: In-Memory Runtime Cache (Non-Persistent)
- Native PHP static variables and object cache during a single request lifecycle to prevent redundant function executions.

### Layer 2: Persistent Object Caching (Redis / Memcached)
- Use standard WordPress caching functions:
  ```php
  $cache_key   = 'market_featured_categories_' . $locale;
  $cache_group = 'market_theme';
  $data        = wp_cache_get($cache_key, $cache_group);

  if (false === $data) {
      $data = market_compute_heavy_data();
      wp_cache_set($cache_key, $data, $cache_group, HOUR_IN_SECONDS);
  }
  ```

### Layer 3: WordPress Transients API (Fallback Object Storage)
- For heavy aggregated data (e.g., mega menu structures, sales statistics summaries):
  ```php
  $transient_key = 'market_mega_menu_tree';
  $menu_tree = get_transient($transient_key);

  if (false === $menu_tree) {
      $menu_tree = market_build_mega_menu_tree();
      set_transient($transient_key, $menu_tree, DAY_IN_SECONDS);
  }
  ```
- **Deterministic Invalidation:**
  Always invalidate transients on relevant events:
  ```php
  add_action('wp_update_nav_menu', function () {
      delete_transient('market_mega_menu_tree');
  });
  add_action('woocommerce_update_product', function () {
      delete_transient('market_product_aggregates');
  });
  ```

## 4. WooCommerce Specific Query Guidelines
- **Products:** Use `wc_get_products()` with typed parameters instead of raw `WP_Query` where possible.
- **Orders:** Always use `wc_get_orders()` to ensure HPOS compatibility and leverage indexed order tables.
- **Cart Calculations:** Never invoke `WC()->cart->calculate_totals()` in layout templates; allow WooCommerce lifecycle hooks to handle calculations naturally.
