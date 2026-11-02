# Template Coverage Matrix & Dynamic Taxonomy Architecture

## 1. Overview
This document outlines the complete template coverage, dynamic taxonomy routing, WooCommerce integration points, and reusable page templates for the **Market** custom theme.

> **Zero Content Hardcoding Mandate:**
> All templates query data dynamically using WordPress and WooCommerce core APIs (`WP_Query`, `wc_get_products()`, `get_queried_object()`, `wp_nav_menu()`). No page IDs, category IDs, brand names, product titles, or prices may be hardcoded.

---

## 2. Master Template Coverage Matrix

| Requested Page / View | WordPress / WooCommerce Template File | Query Context / Hierarchy Level | WooCommerce Integration | Reusable Page Template? | Consumed Global Components |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Homepage** | `front-page.php` | Root site front (`is_front_page()`) | Yes (Featured products, recent arrivals, promo cards) | No | Header, Hero slider, Product Card carousel, Banner Grid, Blog Card carousel, Footer |
| **WooCommerce Shop Archive** | `woocommerce/archive-product.php` | Main catalog (`is_shop()`) | Yes (Native Woo catalog loop) | No | Header, Breadcrumbs, Facet Filters, Product Card grid, Pagination, Empty State, Footer |
| **Parent Product Categories** | `woocommerce/archive-product.php` (or `taxonomy-product_cat.php`) | Top-level term (`is_product_category() && $term->parent == 0`) | Yes (Subcategory tiles + top products) | No | Header, Breadcrumbs, Subcategory Grid Cards, Top Product Grid, Facet Filters, Footer |
| **Child Product Categories** | `woocommerce/archive-product.php` (or `taxonomy-product_cat.php`) | Leaf/Child term (`is_product_category() && $term->parent > 0`) | Yes (Full filtered product catalog) | No | Header, Breadcrumbs, Active Filters, Product Card grid, Pagination, Empty State, Footer |
| **Product Brand Archive** | `taxonomy-product_brand.php` | Brand term archive (`is_tax('product_brand')`) | Yes (Brand header + brand products) | No | Header, Brand Banner/Bio Card, Breadcrumbs, Product Card grid, Pagination, Footer |
| **Single Product** | `woocommerce/single-product.php` | Product post type (`is_product()`) | Yes (Gallery, variations, price, add-to-cart, tabs, related) | No | Header, Breadcrumbs, Product Gallery, Price/Variation Box, Tabs, Related Products, Footer |
| **Blog Archive** | `home.php` / `archive.php` | Posts index (`is_home()`) | No | No | Header, Breadcrumbs, Article Card grid, Sidebar Widgets, Pagination, Footer |
| **Single Blog Post** | `single.php` | Single post (`is_singular('post')`) | No | No | Header, Breadcrumbs, Post Header, Typography content, Comments template, Related posts, Footer |
| **Blog Categories & Tags** | `category.php` / `tag.php` | Term archives (`is_category() \|\| is_tag()`) | No | No | Header, Breadcrumbs, Category header, Article Card grid, Pagination, Footer |
| **Cart** | `woocommerce/cart/cart.php` | Cart page (`is_cart()`) | Yes (Line items, quantities, coupons, shipping calculator, totals) | No | Header, Cart Table, Quantity Controls, Coupon Form, Totals Card, Empty Cart State, Footer |
| **Checkout** | `woocommerce/checkout/form-checkout.php` | Checkout page (`is_checkout() && !is_order_received_page()`) | Yes (Billing/Shipping forms, order review, payment gateway accordion) | No | Header, Two-column checkout layout, Form inputs, Order Summary, Place Order button, Footer |
| **Order Received (Thank You)**| `woocommerce/checkout/thank-you.php` | Endpoint (`is_order_received_page()`) | Yes (Order summary, payment status, bank tracking code) | No | Header, Order Success Alert, Items Table, Customer Details, Footer |
| **My Account Dashboard** | `woocommerce/myaccount/my-account.php` | Account root (`is_account_page()`) | Yes (User overview, quick links) | No | Header, Account Nav Sidebar, User Metric Cards, Recent Orders, Footer |
| **My Account: Orders** | `woocommerce/myaccount/orders.php` | Account endpoint (`orders`) | Yes (Order history table, status badges, view order trigger) | No | Header, Account Nav, Orders Table, Pagination, Empty State, Footer |
| **My Account: View Order** | `woocommerce/myaccount/view-order.php` | Account endpoint (`view-order`) | Yes (Order details, shipping status, reorder button) | No | Header, Account Nav, Order Progress Stepper, Line Items, Addresses, Footer |
| **My Account: Downloads** | `woocommerce/myaccount/downloads.php` | Account endpoint (`downloads`) | Yes (Downloadable file links, expiration) | No | Header, Account Nav, Downloads Table, Empty State, Footer |
| **My Account: Addresses** | `woocommerce/myaccount/form-edit-address.php` | Account endpoint (`edit-address`) | Yes (Iranian province/city, postal code, street address) | No | Header, Account Nav, Address Cards, Edit Address Modal/Form, Footer |
| **My Account: Account Details**| `woocommerce/myaccount/form-edit-account.php` | Account endpoint (`edit-account`) | Yes (First/Last name, mobile number, password change) | No | Header, Account Nav, Profile Form, Save button, Footer |
| **My Account: Auth / Login** | `woocommerce/myaccount/form-login.php` | Account unauthenticated state | Yes (Login form, registration form, OTP hook container) | No | Header, Auth Card, Persian Tabs (Login / Register), Form Controls, Footer |
| **Contact Us (تماس با ما)** | `page-templates/page-contact.php` | Selected via Page Template in WP Admin | No (Optional product inquiry hook) | **Yes** | Header, Breadcrumbs, Contact Details Cards, Map Embed / Branch list, Contact Form, Footer |
| **FAQ (سوالات متداول)** | `page-templates/page-faq.php` | Selected via Page Template in WP Admin | No | **Yes** | Header, Breadcrumbs, Category Tabs, Accordion Component, Search input, Footer |
| **Suggestions & Complaints** | `page-templates/page-complaints.php` | Selected via Page Template in WP Admin | No | **Yes** | Header, Breadcrumbs, Secure Form (Sanitized, Nonce, Tracking ID generation), Footer |
| **About Us (درباره ما)** | `page-templates/page-about.php` | Selected via Page Template in WP Admin | No | **Yes** | Header, Breadcrumbs, Story Section, Values/Stats Grid, Team Grid, Trust Badges, Footer |
| **Order Guide (راهنمای خرید)** | `page-templates/page-guide.php` | Selected via Page Template in WP Admin | No | **Yes** | Header, Breadcrumbs, Visual Stepper (Search -> Cart -> Pay -> Delivery), FAQ links, Footer |

---

## 3. Dynamic Taxonomies Architecture

### A. Product Categories (`product_cat`)
Categories are structured hierarchically:
1. **Dynamic Parent vs Child Detection:**
   Inside `woocommerce/archive-product.php` (or template part `template-parts/product/category-header.php`):
   ```php
   $current_term = get_queried_object();
   $children = get_terms([
       'taxonomy'   => 'product_cat',
       'parent'     => $current_term->term_id,
       'hide_empty' => true,
   ]);
   ```
   - If `$children` exist (Parent Category view): Render an intuitive subcategory icon/card grid at the top so the user can drill down, followed by a preview of featured products.
   - If no children exist (Leaf Category view): Render the full product grid with facet filters (price, attributes, stock) and pagination.
2. **Dynamic Breadcrumb Hierarchy:**
   Automatically builds breadcrumbs: `خانه > فروشگاه > دسته اصلی > زیردسته > نام محصول` without hardcoding any slug.

### B. Product Brand Taxonomy Evaluation & Strategy
> **Critical Audit Finding:** Native WooCommerce does **NOT** include a built-in `brand` taxonomy out-of-the-box (unless using the commercial WooCommerce Brands extension, which violates our Free-Only policy, or WooCommerce 9.4+ experimental features).
> 
> **Options for Brand Management:**
> 1. **Option 1 (Recommended — Native Custom Taxonomy):**
>    Register a lightweight, custom `product_brand` taxonomy directly in `inc/custom-taxonomies.php` (or a dedicated custom plugin in `plugins/market-brands/`).
>    - 100% Free, zero third-party plugin overhead.
>    - Supports term meta for brand logos, brand banners, and SEO descriptions.
>    - Generates dynamic URLs: `/brand/{brand-slug}/`.
> 2. **Option 2 (WooCommerce Product Attributes):**
>    Use standard WooCommerce attribute `pa_brand`.
>    - Downside: Default attribute archives lack custom brand banner/logo management out-of-the-box.
> 3. **Option 3 (Free Open-Source Plugin):**
>    Use a reputable free plugin like *Perfect Brands for WooCommerce* (free on wordpress.org).
>    - Requires user review and approval prior to installation.
> 
> *Awaiting user approval on Brand approach before code implementation.*

---

## 4. Reusable Content Page Templates vs Standard Pages

To allow the user to create content pages easily through the WordPress Dashboard without page builders, we provide 5 specialized Page Templates:

1. `page-templates/page-contact.php` (Template Name: "Contact Page | تماس با ما")
   - Consumes dynamic fields or standard page content editor.
   - Includes structured markup for store address, phone, email, working hours, and a sanitized feedback form.
2. `page-templates/page-faq.php` (Template Name: "FAQ Page | سوالات متداول")
   - Semantic HTML5 `<details>` and `<summary>` accordion component.
   - Accessible keyboard navigation and zero heavy JS dependencies.
3. `page-templates/page-complaints.php` (Template Name: "Complaints & Suggestions | شکایات و پیشنهادات")
   - Legal/regulatory requirement for Iranian e-commerce (e-Namad compliance).
   - Form protected by `wp_nonce_field()`, strict field sanitization, and optional tracking code generation.
4. `page-templates/page-about.php` (Template Name: "About Us | درباره ما")
   - Structured sections for brand story, mission, core values, statistics, and organizational credentials.
5. `page-templates/page-guide.php` (Template Name: "Order Guide | راهنمای ثبت سفارش")
   - Step-by-step visual process flow explaining how to register, add products to cart, choose shipping, pay via online gateway, and track packages.
