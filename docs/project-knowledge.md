# Project Knowledge Base: Market

## 1. Project Overview
- **Project Name:** Market (Internal project codename only)
- **Website Name / Brand / Domain:** *Pending user determination.* Never hardcode any brand name, domain, or business identity in theme files, templates, or documentation.
- **Project Type:** High-performance, fully custom WordPress & WooCommerce theme engineered from scratch for an existing live website.
- **Language & Region:** Persian (`fa-IR`), Iran market focus, full RTL layout, Iranian currency and format conventions.

## 2. Core Architectural Constraints
| Constraint | Policy |
| :--- | :--- |
| **Page Builders** | **Strictly Forbidden.** No Elementor, Elementor Pro, WPBakery, Divi, etc. |
| **Commercial Themes** | **Strictly Forbidden.** 100% custom codebase built from scratch. |
| **Paid Plugins / Licenses** | **Strictly Forbidden.** Zero commercial plugins or external paid subscriptions. |
| **License Compliance** | All dependencies must be free, open-source, and commercially usable (GPL compatible). |
| **Hosting / Server Access** | **No Direct Access.** Deployment is executed manually by the user via FTP/SFTP. |
| **Existing Business Data** | **None.** No legacy products, variations, orders, customers, or business copy require preservation or migration. |
| **Frontend Strategy** | **Clean Slate.** Custom theme completely replaces the existing frontend design and layout structure from scratch. |
| **Core Installation** | **Retain Existing Install.** Do not delete, wipe, or reinstall WordPress unless a proven technical necessity is justified and approved. |
| **Destructive Actions** | Never delete database tables, files, plugins, or settings without detailed explanation and explicit user approval. |
| **Content Policy** | 100% dynamic content via WordPress & WooCommerce APIs and Media Library. No hardcoded mock copy or images. |

## 3. Technology Stack & Target Environment
- **Platform:** WordPress (Core) + WooCommerce.
- **Order Storage Engine:** HPOS (High-Performance Order Storage) compatible.
- **Frontend Stack:** Modern semantic HTML5, CSS3 with CSS Custom Properties, Vanilla JavaScript (zero heavy framework runtime bloat).
- **Typography:** Persian web fonts (e.g., Vazirmatn or user-approved Persian font stack) with OpenType features.
- **Deployment Interface:** File transfer protocol (FTP/SFTP) managed by the site owner.

## 4. Existing Website Inventory & Cleanup Status
> **User-Approved Cleanup Status:** The user has explicitly approved the complete removal of the legacy commercial **Ahura** theme and the deletion of known test content. Full details and safety guardrails are recorded in [`docs/cleanup-manifest.md`](cleanup-manifest.md).

### Known Environment & Inventory Findings
- **Currently Active Theme:** **Ahura** (Approved for complete removal following custom theme activation and verification).
- **Approved Test Content for Deletion:**
  - 25 Products & 8 Variations
  - 14 Test Pages (Strictly preserving WooCommerce system pages: Shop, Cart, Checkout, My Account)
  - 9 Blog Posts
  - 186 Media Attachments (Subject to site identity and logo preservation check)
  - Legacy Elementor Templates (`elementor_library`)
- **Active Plugins Identified:**
  - **WooCommerce:** Core e-commerce engine (Preserved).
  - **Elementor:** Active visual page builder (Retained during theme development; phased out after custom theme natively replaces templates).
  - **Google for WooCommerce:** Active (Preserved).
  - **Jetpack:** Active (Preserved).
- **Backup Prerequisite:** Full database dump and `wp-content/uploads/` archive must be verified prior to live cleanup.

## 5. Phase 2 Architecture & Template Directives
- **Zero Content Hardcoding:** The user will manually create all real pages, posts, products, categories, subcategories, and brands via the WordPress dashboard later. No IDs, titles, or prices may be hardcoded.
- **Dynamic Taxonomy Routing:** Support parent category views (drill-down subcategory cards) and child category views (filtered catalog) dynamically via `taxonomy-product_cat.php` / `archive-product.php`.
- **Brand Taxonomy Strategy:** Native WooCommerce lacks a built-in brand taxonomy. Proposed registering a native, lightweight `product_brand` taxonomy with term meta for logo/banner (Option 1) to eliminate paid plugin dependencies, pending user approval.
- **Reusable Informational Page Templates:** Provide 5 specialized templates (`page-templates/page-*.php`) for Contact, FAQ, Complaints, About, and Order Guide.
- **Comprehensive Master Plan:** Detailed in [`docs/template-coverage-matrix.md`](template-coverage-matrix.md), [`docs/architecture.md`](architecture.md), and [`docs/design-system.md`](design-system.md).
