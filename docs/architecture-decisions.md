# Architecture Decision Records (ADRs)

This document tracks all significant architectural decisions made during the lifecycle of the Market project.

---

## ADR-001: Project Foundation & Baseline Architecture Principles

### Status
Accepted

### Date
2026-11-02

### Context
We are tasked with creating a high-performance, fully custom WordPress and WooCommerce theme from scratch for an existing Iranian e-commerce website. The final brand identity, store name, and domain are undecided. The production server is accessible only via manual user FTP transfers.

### Decision
1. **Zero Page Builders & Commercial Themes:** Ban Elementor, Elementor Pro, and third-party commercial themes. The theme is engineered 100% custom in `themes/market/`.
2. **Strict Free-Only Policy:** All tools, dependencies, and plugins must be free and commercially usable (GPL compatible). No paid plugins, libraries, or SaaS services.
3. **Native WordPress & WooCommerce Primacy:** Leverage core APIs (`WP_Query`, Transients, WooCommerce CRUD APIs, HPOS) rather than adding third-party plugin wrappers.
4. **HPOS Native Compliance:** Fully support WooCommerce High-Performance Order Storage (`wp_wc_orders`), eliminating legacy reliance on `wp_posts` for order handling.
5. **Persian (fa-IR) First & Complete RTL Engineering:** Build with comprehensive RTL support, logical CSS properties, Persian typography (Vazirmatn or equivalent), Iranian currency (Toman/Rial), Jalali date presentation, and Iranian phone/address formatting.
6. **Centralized CSS Token System:** Standardize colors, typography, spacing, and elevation using CSS Custom Properties in `:root`. No hardcoded design magic numbers.
7. **Decoupled Architecture:** Presentation logic resides in `themes/market/`; standalone business logic or custom table operations reside in `plugins/`.
8. **Manual FTP Deployment Workflow:** Prepare clean, structured, production-ready files in the workspace with clear path mapping (`wp-content/themes/market/`) for manual FTP deployment by the user.

### Consequences
- **Positive:** Maximum performance, minimal TTFB, clean DOM, zero annual plugin license fees, full control over security, seamless Persian user experience.
- **Negative:** Requires disciplined engineering from scratch rather than drag-and-drop page building. Every integration must be carefully planned and verified.

---

## ADR-002: Clean-Slate Frontend on Existing WordPress Installation

### Status
Accepted

### Date
2026-11-02

### Context
Project clarification confirmed that the existing website holds no critical business data (zero products, variations, customer accounts, or historical orders requiring migration). The new custom theme can completely replace the existing theme and frontend design. However, the WordPress installation itself must not be assumed to require deletion or reinstallation. A cautious, inspect-first approach is required before any cleanup.

### Decision
1. **Clean-Slate Frontend Architecture:** Engineer the custom theme (`themes/market/`) completely from scratch with zero legacy design or template constraints.
2. **Preserve Existing WordPress Installation:** Retain the current WordPress and WooCommerce core setup. Do not assume or recommend reinstallation unless a solid technical barrier is discovered and approved.
3. **Environment Inspection Before Action:** Thoroughly inspect the current WordPress version, WooCommerce configuration, active plugins, and database state before proposing any environment changes.
4. **Strict Non-Destructive Boundary:** Never delete or truncate database tables, files, plugins, or configuration options without providing explicit technical justification and receiving prior user approval.
5. **No Core Modifications:** Never modify WordPress core or WooCommerce core files under any circumstances.

### Consequences
- **Positive:** Maximum architectural freedom to build modern, semantic, high-performance templates without migration overhead or legacy data encumbrances.
- **Negative:** Requires thorough environmental inspection to identify and isolate any orphaned tables or leftover plugins from previous tests/themes.

---

## ADR-003: Decommissioning of Legacy Ahura Theme, Elementor Phasing, and Test Data Cleanup Protocol

### Status
Accepted (with explicit User Approval)

### Date
2026-11-02

### Context
The user approved the complete removal of the legacy commercial **Ahura** theme and the deletion of known test content (25 products, 8 variations, 14 pages, 9 posts, 186 media attachments, and legacy Elementor templates). The system currently runs Elementor, Google for WooCommerce, Jetpack, and WooCommerce. A safe, non-destructive, and phased order of operations is required to prevent site crashes, headless state, or loss of core WooCommerce configuration.

### Decision
1. **Phased Ahura Theme Removal:** The Ahura theme (and child theme, if present) will remain active and intact on the server until the custom `Market` theme is developed in the workspace, transferred via FTP, activated, and verified. A default core fallback theme (e.g., Twenty Twenty-Four) must remain installed. Ahura is deleted only as the final step.
2. **Elementor Phasing:** Elementor will remain active during custom theme development. It will only be deactivated and removed after the custom theme natively replaces all header, footer, archive, single-product, and page templates.
3. **Preservation of Core Plugins:** Google for WooCommerce, Jetpack, and WooCommerce Core are preserved. No plugin will be removed without a standalone technical justification and separate user approval.
4. **Targeted Test Content Cleanup via Manifest:** Content deletion will follow `docs/cleanup-manifest.md`. Crucial system records—including WooCommerce default pages (Shop, Cart, Checkout, My Account), site identity icons/logos, user accounts (`wp_users`), and HPOS tables—are strictly protected.
5. **No Database Structural Destruction:** Zero `DROP TABLE` or `TRUNCATE TABLE` operations. All removals will use native WordPress deletion functions (`wp_delete_post()`, `wp_delete_attachment()`) to trigger core cleanup hooks and maintain referential integrity.
6. **Mandatory Backup Gate:** A full database export and `wp-content/uploads/` archive must be confirmed before any live deletion occurs.

### Consequences
- **Positive:** Pristine database and media library without leftover bloat; zero risk of headless WordPress or broken WooCommerce dependencies; clean transition to native custom architecture.
- **Negative:** Requires strict multi-stage verification and user-gated execution.

---

## ADR-004: Modular Theme Architecture, Complete Template Matrix & Design System Token Plan

### Status
Proposed (Awaiting User Review & Approval)

### Date
2026-11-02

### Context
Phase 2 requires a comprehensive architectural plan covering all required pages, dynamic category and brand taxonomies, a centralized CSS design system, 17 reusable global components, a modular file layout, and conditional asset loading. Content creation must be left to the user via the WordPress dashboard, strictly prohibiting hardcoded page IDs, category slugs, or mock product data.

### Decision
1. **Modular Directory Architecture:** Structure `themes/market/` into clean functional domains: `page-templates/`, `template-parts/`, `woocommerce/`, `inc/`, and `assets/` (split into `tokens/`, `global/`, `components/`, `pages/`, and `modules/`).
2. **Template Coverage Across 24 Page Types:** Full specification recorded in `docs/template-coverage-matrix.md`, covering Homepage, Shop, Category/Subcategory archives, Single Product, Brand archives, Blog, Cart, Checkout, 7 Account endpoints, and 5 specialized content Page Templates (Contact, FAQ, Complaints, About, Order Guide).
3. **Dynamic Taxonomy Routing:**
   - Categories/subcategories dynamically differentiate parent views (subcategory card grid) from leaf views (filtered product catalog with facets).
   - Brand taxonomy: Propose registering a native `product_brand` taxonomy with logo/banner term meta (zero cost, zero external dependencies) rather than third-party plugins, pending user approval.
4. **Reusable Content Page Templates:** Deliver 5 distinct page templates for informational pages so the user can easily manage them via WP Admin without page builders.
5. **Centralized CSS Token System:** Standardize all visual properties into CSS Custom Properties (`docs/design-system.md`), mandating CSS Logical Properties for true RTL support.
6. **Conditional Asset Loading:** Enqueue component and page stylesheets/scripts conditionally (`is_shop()`, `is_product()`, `is_cart()`, etc.) to minimize HTTP payload and eliminate unused CSS.

### Algorithmic & Performance Impact
- Zero render-blocking bloated frameworks; sub-second TTFB potential.
- Conditional enqueuing keeps non-catalog pages ultra-lightweight ($< 50\text{kB}$ CSS/JS).
- $O(1)$ token cascades via native CSS variables without preprocessor runtime cost.

### Consequences
- **Positive:** Complete template coverage, highly maintainable codebase, zero legacy content dependency, seamless Persian/RTL user experience.
- **Negative:** Requires creating and maintaining multiple modular files rather than a single monolithic stylesheet.

---

## ADR-005: Raw Theme Foundation & Workflow for Screenshot-Driven Visual Refinement

### Status
Accepted

### Date
2026-11-02

### Context
In Phase 3, we constructed the installable, technically functional raw theme foundation in `themes/market/`. Visual styling for individual pages must not be finalized arbitrarily, because the user will provide visual reference screenshots one by one. Each page must be styled, reviewed, and refined iteratively based on its specific reference.

### Decision
1. **Raw Foundation Delivery:** Complete the modular directory and file structure (49 PHP templates and parts, 24 modular CSS files, and ES6 JavaScript modules), making the theme fully installable and technically functional.
2. **Neutral Design System Baseline:** Enforce CSS custom properties (`tokens.css`), neutral baseline styling, Persian RTL (`rtl.css`), and responsive breakpoints without prematurely committing to a specific visual layout.
3. **Screenshot-Driven Workflow:** Halt further visual styling until the user supplies the first visual screenshot. Implement one page at a time matching the supplied reference, and wait for user review and approval before proceeding to the next page.
4. **Dynamic Data Primacy:** Preserve pure dynamic WordPress and WooCommerce queries; zero hardcoded mockup IDs, product titles, or prices.

### Consequences
- **Positive:** Pristine technical foundation, zero technical debt, verified template hierarchy, and 100% precision matching of the user's design vision page by page.
- **Negative:** Requires strict turn-by-turn discipline without jumping ahead to style secondary pages.

---

## ADR-005: 3-Item Auto-Carousel & Tailored CMS Repeater for Circular Categories

### Status
Accepted

### Date
2026-11-10

### Context
The homepage circular categories section ("همه تجهیزات موردنیاز شما، در یک نگاه") previously rendered a static 6-column / 3-column CSS grid. The client requested:
1. Converting the section into an auto-scrolling single-row carousel displaying exactly 3 items at a time with periodic smooth auto-scrolling.
2. Complete administration control from the Front Page editor in WP Admin ("ویرایش برگه"): allowing admins to select/define categories, upload images displayed inside the white circle with grey border, specify custom category destination links, and add/remove items dynamically.

### Decision
1. **Frontend Carousel Architecture:**
   - Single-row viewport with responsive item sizing: `calc((100% - 2 * gap) / 3)`.
   - Hardware-accelerated CSS `transform: translateX(...)` with RTL-aware positioning.
   - Built-in autoplay (interval: 3.5s) with pause-on-hover and pause-on-touch interaction.
   - Touch drag / swipe support for mobile RTL users.
   - Previous/Next navigation chevrons and active pagination dots.
   - Safe fallback when items <= 3 (centered display, navigation inactive).
2. **Admin Meta Box Repeater in `inc/homepage-metaboxes.php`:**
   - Added Section 2: "دسته‌بندی‌های دایره‌ای (همه تجهیزات موردنیاز شما، در یک نگاه)" to the homepage meta box.
   - Allows setting custom section badge text and main title.
   - Interactive repeater card with:
     - Live preview matching the frontend white circle with grey border (`border: 2px solid #e4e4e7`).
     - Quick-picker `<select>` populated from WooCommerce `product_cat` terms that automatically populates Title, Link, and Category Thumbnail into the card.
     - Custom Title text input, Custom Link URL input, and WordPress Media Library image uploader/clear buttons.
     - Native HTML5 `<template id="tmplCircleCategoryRow">` for clean client-side card cloning.
   - Sanitization and late-escaping adhering strictly to WordPress security standards (`sanitize_text_field`, `esc_url_raw`, `esc_html`, `esc_url`, `esc_attr`).

### Consequences
- **Positive:** Zero third-party slider dependencies (pure lightweight ES module & CSS), perfect RTL behavior, total client autonomy in WP Admin without page builders, and responsive mobile-first UX.
- **Negative:** None. Fully backwards-compatible with graceful fallback to defaults when meta is not yet saved.

---

## ADR Template for Future Decisions

```markdown
## ADR-XXX: [Title of Architectural Decision]

### Status
[Proposed | Accepted | Superseded | Deprecated]

### Date
YYYY-MM-DD

### Context
[What is the context, requirement, or performance problem being addressed?]

### Options Considered
1. [Option 1 - Pros & Cons]
2. [Option 2 - Pros & Cons]

### Decision
[Chosen approach and architectural rationale]

### Algorithmic & Performance Impact
[Complexity O(n), query count, database impact, asset size]

### Consequences
[Positive and negative tradeoffs]
```
