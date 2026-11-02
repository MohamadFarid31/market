# Database Schema & Data Models

## 1. WordPress Core Tables Reference
The theme relies primarily on standard WordPress relational tables:
- `wp_posts`: Standard posts, pages, attachments (Media Library), and products (under WooCommerce architecture).
- `wp_postmeta`: Custom attributes, product settings, metadata. *Must be queried with care to prevent unindexed table scans.*
- `wp_terms`, `wp_term_taxonomy`, `wp_term_relationships`: Product categories, tags, brands, and variation attributes.
- `wp_users`, `wp_usermeta`: Customer accounts, billing/shipping addresses, capabilities.
- `wp_options`: Site configuration, transients (`_transient_*`), theme mods, rewrite rules.

## 2. WooCommerce HPOS (High-Performance Order Storage) Tables
Under HPOS, orders are decoupled from `wp_posts` and stored in normalized, indexed transactional tables:
| Table Name | Primary Purpose | Key Indexes |
| :--- | :--- | :--- |
| `wp_wc_orders` | Order master record (status, customer, currency, totals, dates) | `id`, `customer_id`, `status`, `date_created_gmt`, `type` |
| `wp_wc_order_addresses` | Normalized billing and shipping addresses | `id`, `order_id`, `address_type` |
| `wp_wc_order_operational_data` | Internal processing metadata (payment method, shipping tax, created_via) | `id`, `order_id` |
| `wp_wc_orders_meta` | Extensible metadata for custom order fields | `id`, `order_id`, `meta_key` |
| `wp_wc_order_product_lookup` | Optimized reporting & analytics for order items | `order_item_id`, `order_id`, `product_id`, `customer_id` |
| `wp_wc_order_stats` | Order aggregation cache for analytics | `order_id`, `parent_id`, `date_created`, `status` |

## 3. Product Data Model & Performance Considerations
WooCommerce stores products as custom post types (`product` and `product_variation`):
- Simple Products: 1 row in `wp_posts`, multiple rows in `wp_postmeta`.
- Variable Products: 1 parent row in `wp_posts`, $N$ child rows in `wp_posts` (`product_variation`), each with individual prices, SKUs, and stock meta.
- **Performance Rule:** Never iterate over variable products and call `$product->get_available_variations()` inside product loops or archive pages. This causes immense memory overhead and dozens of queries per product.

## 4. Custom Database Tables Policy
- Custom database tables should only be created if:
  1. Data volume exceeds standard WordPress metadata scalability (>100,000 frequent transaction rows).
  2. Data requires high-frequency writes that would lock or fragment `wp_postmeta` or `wp_options`.
  3. Relational joins and specialized composite indexes are mandatory for acceptable query execution time ($O(\log n)$ vs $O(n)$ full scan).
- If custom tables are necessary, they must be implemented via a custom plugin in `plugins/`, registered using `dbDelta()`, and indexed properly.

## 5. Existing Site Schema Discoveries
*(Awaiting user response: Existing custom tables, table prefixes other than `wp_`, custom post types from previous plugins, and database storage engines in use.)*

## 6. Migration Status & Database Cleanup Boundary
- **Zero Migration Requirement:** The existing database contains no critical business assets (zero products, variations, customer accounts, or historical orders requiring migration).
- **Non-Destructive Protocol:** Despite the lack of business data, the existing WordPress database installation must be preserved.
- **Strict Approval Rule:** Never drop, truncate, or alter existing database tables, options, or metadata without first inspecting the environment, presenting a reasoned justification to the user, and receiving explicit written approval.
