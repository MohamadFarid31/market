# Legacy Cleanup Manifest & Migration Safety Plan

## 1. Overview & Cleanup Scope
The user has granted explicit approval to retire the legacy **Ahura** commercial theme and purge existing test data from the WordPress/WooCommerce installation. 

The objective is to establish a pristine, lightweight foundation for the custom **Market** theme while strictly safeguarding WooCommerce system configurations, core pages, user accounts, and database integrity.

---

## 2. Inventory & Dependency Breakdown

### A. Test Content Targeted for Removal
| Content Type | Count | `post_type` / Table | Dependencies / Related Records to Prune | Preservation Check |
| :--- | :--- | :--- | :--- | :--- |
| **Products** | 25 | `product` | Product categories/tags relationships (`wp_term_relationships`), product lookup tables (`wp_wc_product_meta_lookup`), transients. | Ensure none are default/system placeholders. |
| **Product Variations** | 8 | `product_variation` | Variation attributes, pricing meta in `wp_postmeta`. | Automatically pruned with parent variable products. |
| **Blog Posts** | 9 | `post` | Post categories/tags, comments, postmeta. | Ensure no documentation or necessary announcements. |
| **Pages (Test Only)** | 14 | `page` | Nav menu items (`nav_menu_item`), page builder meta. | **STRICT FILTER:** Exclude WooCommerce system pages (Shop, Cart, Checkout, My Account, Privacy Policy). |
| **Elementor Templates** | Variable | `elementor_library` | Header/footer builder templates, section templates, kit options (`elementor_active_kit`). | Keep until custom theme header/footer are confirmed functional. |
| **Media Attachments** | 186 | `attachment` | Physical files in `wp-content/uploads/`, metadata (`_wp_attachment_metadata`, `_wp_attached_file`). | **AUDIT FIRST:** Must verify if site icon (`site_icon`), logo (`custom_logo`), or active assets are among them before deletion. |

### B. Essential System Data — STRICTLY PROTECTED (Never Delete)
The following records and structures are permanently protected from deletion:
1. **WooCommerce System Pages:**
   - Cart Page (`woocommerce_cart_page_id`)
   - Checkout Page (`woocommerce_checkout_page_id`)
   - My Account Page (`woocommerce_myaccount_page_id`)
   - Shop Page (`woocommerce_shop_page_id`)
   - Privacy Policy Page (`wp_page_for_privacy_policy`)
2. **User Accounts & Authentication:**
   - All rows in `wp_users` and `wp_usermeta` (Administrator, Shop Manager, Customer records).
3. **WooCommerce Core Configuration:**
   - Currency settings (Toman/Rial), tax classes, shipping zones/methods, payment gateway configurations.
   - HPOS order tables and settings.
4. **Active Third-Party Plugins:**
   - **WooCommerce Core:** Protected.
   - **Google for WooCommerce:** Protected (retained unless separate justification is approved).
   - **Jetpack:** Protected (retained unless separate justification is approved).
   - **Elementor:** Retained active during transition; decommissioned only after the custom theme is live.
5. **Database Structure:**
   - Zero `DROP TABLE` or `TRUNCATE TABLE` operations. All deletions must execute through standard WordPress API methods (`wp_delete_post()`, `wp_delete_attachment()`) to maintain relational integrity and trigger cleanup hooks.

---

## 3. Ahura Theme Phased Decommissioning Plan

The legacy Ahura theme (and any child theme) must be removed safely without leaving WordPress in a broken or headless state:

```
[Phase 1: Current State] 
  Ahura is Active ──► Workspace Theme Development (themes/market/)
                           │
[Phase 2: Parallel Deploy] │
  User uploads 'market' to wp-content/themes/market/ via FTP
  Ahura remains active and untouched on server
                           │
[Phase 3: Activation & Verification]
  User activates 'Market' in WP Admin ──► Full frontend & checkout testing
  Ahura is now inactive, acting as emergency fallback
                           │
[Phase 4: Removal]
  After Market is fully verified ──► User deletes 'ahura' folder via FTP/Admin
  Ensure at least one default WordPress theme (e.g. Twenty Twenty-Four) is installed as fallback
```

---

## 4. Media & Attachment Relationship Audit (186 Files)

Deleting 186 media files indiscriminately risks breaking theme logos or favicon settings:
1. **Step 1:** Extract the IDs of:
   - `get_option('site_icon')` (Favicon)
   - `get_theme_mod('custom_logo')` (Brand logo)
   - `woocommerce_placeholder_image` (Default Woo placeholder)
2. **Step 2:** Isolate attachments associated with test products/posts vs unattached/system media.
3. **Step 3:** Generate a safe deletion manifest. Only attachments explicitly confirmed as test product/post imagery will be deleted.

---

## 5. Plugin Evaluation & Phasing (Elementor, Jetpack, Google)

| Plugin | Current Status | Recommendation | Phasing Strategy |
| :--- | :--- | :--- | :--- |
| **Elementor** | Active | **Decommission Post-Theme** | Retain during theme development. Once Market theme provides native header, footer, archive, and single product templates, disable Elementor and verify zero shortcode artifacts remain before deletion. |
| **Google for WooCommerce**| Active | **Retain** | Retain configuration. No overlap with theme templates. |
| **Jetpack** | Active | **Retain** | Retain unless performance auditing proves high overhead or user requests removal. |
| **WooCommerce** | Active | **Core Requirement** | Retain and maintain full HPOS compatibility. |

---

## 6. Comprehensive Backup & Rollback Protocol

Before any data deletion or theme switching occurs on the remote server:

### Backup Procedure (User Manual Action via cPanel/Hosting/FTP):
1. **Full Database Export:**
   - Export full SQL dump via phpMyAdmin or hosting panel (`db-backup-pre-cleanup-YYYYMMDD.sql`).
2. **Uploads Directory Backup:**
   - Download or compress `wp-content/uploads/` via FTP or cPanel File Manager (`uploads-backup-YYYYMMDD.zip`).
3. **Theme Directory Backup:**
   - Compress `wp-content/themes/` before introducing changes.

### Rollback Procedure:
- If theme activation causes fatal errors: Switch back to Ahura or default WordPress theme via WP-Admin or by renaming `wp-content/themes/market/` to `market-disabled/`.
- If content deletion inadvertently removes needed pages: Restore database from `db-backup-pre-cleanup-YYYYMMDD.sql`.

---

## 7. Safe Order of Operations (Execution Sequence)

1. **Step 1: Backup Verification (User)**
   - Confirm complete DB and `wp-content/uploads/` backup is secured locally.
2. **Step 2: Install Safe Fallback Theme (User)**
   - Verify a clean default core theme (e.g., Twenty Twenty-Four) is installed in `wp-content/themes/` as a fail-safe.
3. **Step 3: Develop & Validate Market Theme (Agent Workspace)**
   - Complete core theme structure (`header.php`, `footer.php`, `archive-product.php`, `single-product.php`, `woocommerce.php`, `rtl.css`).
4. **Step 4: Deploy & Test Market Theme (User via FTP)**
   - Upload `market` folder to `wp-content/themes/`.
   - Activate Market theme in WordPress Admin.
   - Verify frontend, navigation, RTL rendering, product display, and WooCommerce cart/checkout.
5. **Step 5: Execute Approved Content Cleanup (Agent Script / Guided WP-Admin)**
   - Run safe programmatic cleanup script or guided admin deletion:
     - Delete 25 test products & 8 variations.
     - Delete 9 test posts.
     - Delete verified test pages (preserving core WC pages).
     - Delete verified test media files (preserving site icon/logo).
     - Prune orphaned navigation menu items pointing to deleted pages.
6. **Step 6: Decommission Elementor (Guided)**
   - Deactivate Elementor; verify site functionality; uninstall if no dependencies remain.
7. **Step 7: Remove Ahura Theme (User via FTP/Admin)**
   - Delete `ahura` (and child theme) folder from `wp-content/themes/`.
