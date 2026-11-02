# System Architecture, Modular File Layout & Component Specification

## 1. Architectural Philosophy
The **Market** theme is an enterprise-grade, modular, high-performance WordPress & WooCommerce theme built from scratch:
- **Separation of Concerns:**
  - **Theme (`themes/market`):** Presentation, semantic templates, UI components, scoped CSS, modular vanilla JS, and WooCommerce overrides.
  - **Plugins (`plugins/`):** Dedicated to business logic, custom tables, or independent features that must persist across themes.
- **Native-First & Clean-Slate:** Built from scratch without page builders or commercial theme bloat. Leverages native WordPress Core and WooCommerce CRUD APIs.
- **HPOS Compatibility:** Fully native WooCommerce High-Performance Order Storage support (`wp_wc_orders`).
- **Persian-First & True RTL:** Uses CSS Logical Properties (`margin-inline`, `padding-inline`, `inset-inline`), Persian typography with Vazirmatn font stack, and automated directional icon flipping.

---

## 2. Complete Modular File Architecture

```text
themes/market/
├── style.css                          # Theme metadata & core stylesheet header
├── functions.php                      # Bootstrap & modular include loader
├── rtl.css                            # Dedicated RTL overrides & logical rules
├── index.php                          # Fallback template
├── header.php                         # HTML <head>, meta, topbar & global header
├── footer.php                         # Global footer & scripts closing
├── front-page.php                     # Homepage template
├── home.php                           # Blog posts index
├── single.php                         # Single blog post template
├── archive.php                        # Generic date/author archive
├── category.php                       # Blog category archive
├── tag.php                            # Blog tag archive
├── taxonomy-product_brand.php         # Product brand archive template
├── 404.php                            # 404 error page template
├── page.php                           # Standard page template
│
├── page-templates/                    # Reusable Content Page Templates
│   ├── page-contact.php               # Contact Us (تماس با ما)
│   ├── page-faq.php                   # FAQ Accordion (سوالات متداول)
│   ├── page-complaints.php            # Complaints & Feedback (شکایات و پیشنهادات)
│   ├── page-about.php                 # About Us (درباره ما)
│   └── page-guide.php                 # Order & Shopping Guide (راهنمای خرید)
│
├── template-parts/                    # Modular Reusable UI Partials
│   ├── header/
│   │   ├── topbar.php                 # Promo ticker, contact info, utility links
│   │   ├── branding.php               # Dynamic site logo & title
│   │   ├── search-bar.php             # Search bar with AJAX trigger
│   │   ├── actions.php                # Account link, wishlist count, cart drawer button
│   │   └── navigation-desktop.php     # Primary desktop navigation bar
│   ├── navigation/
│   │   ├── mobile-nav-drawer.php      # Off-canvas mobile navigation menu
│   │   ├── mobile-bottom-bar.php      # Sticky bottom navigation bar for mobile
│   │   └── mega-menu.php              # Multi-column dynamic category/brand mega menu
│   ├── footer/
│   │   ├── widgets.php                # Multi-column footer widget areas
│   │   ├── trust-badges.php           # e-Namad, Samandehi, and payment gateway logos
│   │   └── copyright.php              # Dynamic copyright & credits notice
│   ├── product/
│   │   ├── card.php                   # Universal product card component
│   │   ├── card-horizontal.php        # Horizontal list product card
│   │   ├── badge.php                  # Sale discount %, new, out-of-stock badges
│   │   ├── price.php                  # Localized Toman/Rial price presentation
│   │   └── quick-view-modal.php       # Fast modal preview for products
│   ├── card/
│   │   └── article-card.php           # Blog post card (image, date, author, category)
│   ├── common/
│   │   ├── breadcrumbs.php            # Semantic Schema.org JSON-LD breadcrumbs
│   │   ├── pagination.php             # Numeric pagination with RTL arrows
│   │   ├── alerts.php                 # Feedback notices (success, error, warning)
│   │   ├── empty-state.php            # Reusable empty container with icon & action CTA
│   │   └── skeleton.php               # Skeleton loader placeholders
│   └── modal/
│       ├── cart-drawer.php            # Off-canvas slide-out mini cart
│       └── search-modal.php           # Fullscreen / modal live search
│
├── woocommerce/                       # WooCommerce Template Overrides
│   ├── archive-product.php            # Shop and Category catalog layout
│   ├── single-product.php             # Single product page wrapper
│   ├── single-product/
│   │   ├── product-gallery.php        # Responsive thumbnail gallery & zoom
│   │   ├── product-meta.php           # SKU, category, brand, share buttons
│   │   └── tabs/                      # Description, specs table, reviews
│   ├── loop/
│   │   ├── loop-start.php             # Grid container wrapper
│   │   ├── loop-end.php               # Grid closing wrapper
│   │   ├── orderby.php                # Custom styled sort dropdown
│   │   └── result-count.php           # Showing X of Y products
│   ├── cart/
│   │   ├── cart.php                   # Main cart table & summary layout
│   │   ├── cart-empty.php             # Empty cart view
│   │   └── mini-cart.php              # Drawer cart contents
│   ├── checkout/
│   │   ├── form-checkout.php          # Two-column modern checkout layout
│   │   ├── review-order.php           # Order items & totals summary
│   │   └── payment.php                # Payment gateways accordion
│   ├── myaccount/
│   │   ├── my-account.php             # Account layout wrapper
│   │   ├── navigation.php             # Sidebar navigation links
│   │   ├── dashboard.php              # Welcome metrics & quick links
│   │   ├── orders.php                 # Orders history table
│   │   ├── view-order.php             # Order progress stepper & details
│   │   ├── downloads.php              # Available downloads
│   │   ├── form-edit-address.php      # Address management form
│   │   ├── form-edit-account.php      # Profile details form
│   │   └── form-login.php             # Persian login/register tabs
│   └── notices/
│       ├── error.php                  # WooCommerce error notice override
│       ├── notice.php                 # WooCommerce info notice override
│       └── success.php                # WooCommerce success notice override
│
├── inc/                               # Backend Logic & Modular Helpers
│   ├── setup.php                      # Theme supports, image sizes, nav menus
│   ├── assets.php                     # Conditional asset enqueuing engine
│   ├── template-tags.php              # Reusable display functions
│   ├── template-hooks.php             # Action and filter hook orchestrator
│   ├── woocommerce.php                # WooCommerce hooks, HPOS, badge overrides
│   ├── rtl-persian.php                # Persian numerals, Jalali dates, text helpers
│   ├── custom-taxonomies.php          # Brand taxonomy registration (upon approval)
│   ├── breadcrumbs.php                # Dynamic breadcrumbs builder
│   └── ajax-endpoints.php             # Live search & quick-view AJAX endpoints
│
└── assets/                            # Static Production Assets
    ├── css/
    │   ├── tokens/                    # Centralized Design Tokens
    │   │   └── tokens.css             # Master CSS Custom Properties (:root)
    │   ├── global/
    │   │   ├── reset.css              # Modern CSS reset & box-sizing
    │   │   ├── typography.css         # Persian font-face & type scale rules
    │   │   └── utilities.css          # Helper utility classes
    │   ├── components/                # Modular Component Stylesheets
    │   │   ├── header.css             # Header, topbar, search bar
    │   │   ├── navigation.css         # Desktop nav, mega menu, mobile drawer
    │   │   ├── footer.css             # Footer, trust badges, copyright
    │   │   ├── buttons.css            # Button variants & sizes
    │   │   ├── forms.css              # Inputs, checkboxes, radios, select
    │   │   ├── product-card.css       # Grid/list product card styles
    │   │   ├── article-card.css       # Blog post card styles
    │   │   ├── pagination.css         # Numeric pagination styling
    │   │   ├── alerts.css             # Notice boxes & banners
    │   │   ├── modal-drawer.css       # Off-canvas cart, search modal
    │   │   ├── empty-states.css       # Empty cart & catalog states
    │   │   └── skeleton.css           # Loading shimmer effects
    │   └── pages/                     # Template-Specific Scoped Styles
    │       ├── home.css               # Homepage slider & promotional blocks
    │       ├── shop.css               # Shop grid, facet sidebar, sort
    │       ├── single-product.css     # Product page layout, gallery, tabs
    │       ├── cart.css               # Cart table & calculation cards
    │       ├── checkout.css           # Two-column checkout layout
    │       ├── account.css            # Account dashboard, orders, addresses
    │       ├── blog.css               # Blog archives & single article
    │       └── content-pages.css      # Contact, FAQ, complaints, about, guide
    ├── js/
    │   ├── modules/                   # Vanilla JS Modules
    │   │   ├── navigation.js          # Mobile drawer toggle, mega menu hover
    │   │   ├── cart-drawer.js         # Slide-out cart open/close, AJAX refresh
    │   │   ├── ajax-search.js         # Debounced live search with autocomplete
    │   │   ├── facet-filters.js       # Mobile filter toggle & price slider
    │   │   ├── quick-view.js          # Modal product preview handler
    │   │   └── tabs-accordion.js      # Accessible FAQ accordions & tabs
    │   └── main.js                    # Core script bootstrap & initializer
    ├── fonts/
    │   └── vazirmatn/                 # Local Persian WOFF2 fonts (Vazirmatn)
    └── images/
        ├── icons/                     # Inline SVG symbols & directional icons
        └── placeholders/              # Optimized SVG empty-state illustrations
```

---

## 3. Global Components Breakdown (17 Key Reusable Components)

1. **Header:** Topbar with dynamic ticker, primary navbar, search input, wishlist/account triggers, and cart drawer counter.
2. **Desktop Navigation:** Multi-level dropdowns with keyboard accessibility (`aria-expanded`) and mega menu support.
3. **Mobile Navigation:** High-speed off-canvas slide-out drawer containing category accordion trees and account links.
4. **Mobile Bottom Navigation Bar:** Fixed-position bottom bar (Home, Categories, Cart with badge, Account, Search) designed for single-thumb mobile UX.
5. **Mega Menu:** Multi-column grid showcasing product categories with child links and featured brand badges.
6. **Footer:** 4-column widget area, trust seal containers (e-Namad / Samandehi placeholders), contact info, and copyright.
7. **Breadcrumbs:** Fully accessible, Schema.org compliant breadcrumbs with RTL auto-flipped directional chevrons.
8. **Buttons:** Primary, secondary, outline, ghost, danger, and icon-only buttons with built-in loading spinner states.
9. **Form Controls:** Clean input fields, textareas, custom styled `<select>`, checkboxes, radios, and floating labels.
10. **Product Card:** Hover-activated secondary image, sale badge (-X%), rating stars, Persian price (Toman), quick-view, and add-to-cart.
11. **Article Card:** High-contrast blog card with featured image, Persian Jalali date, author name, category pill, and excerpt.
12. **Pagination:** Accessible numeric pagination with RTL-aware next/previous buttons.
13. **Alerts & Notices:** Floating and inline dismissible notifications (success, warning, error, info) mapping directly to WooCommerce notices.
14. **Empty States:** Meaningful graphics and friendly Persian text for empty cart, empty wishlist, zero search results, and empty order history with primary CTAs.
15. **Loading States & Skeletons:** Zero-layout-shift CSS shimmer skeletons for product grids and content loaders.
16. **Search Component:** Debounced live search input with keyboard navigation (`Esc` to close, arrow keys to navigate suggestions).
17. **Filters Component (Facets):** Desktop sidebar and mobile slide-out drawer featuring price range slider, category tree, brand filters, and stock toggles.

---

## 4. Intentional Responsive Design Strategy

| Breakpoint Range | Device Class | Distinct Architectural Adaptations |
| :--- | :--- | :--- |
| **$< 768\text{px}$** | **Mobile** | - Sticky bottom navigation bar for primary actions.<br>- Off-canvas slide-out cart drawer instead of inline cart popup.<br>- Facet filters collapse into a bottom sheet drawer.<br>- Single product action bar (Price + Add to Cart) sticks to the bottom viewport on scroll.<br>- Horizontal touch-swiped category pills instead of vertical mega menus. |
| **$768\text{px} - 1023\text{px}$** | **Tablet** | - 2 to 3 column product grid.<br>- Compact header layout with collapsible search bar.<br>- Collapsible sidebar filters with quick-apply buttons. |
| **$\ge 1024\text{px}$** | **Desktop** | - Full mega menu multi-column category browser on hover.<br>- Persistent sidebar filter column on shop/category pages.<br>- 4-column product grid with hover-preview states.<br>- Side-by-side product gallery and buy-box with sticky scrolling. |

---

## 5. Performance & Asset Loading Strategy

To ensure sub-second Time to First Byte (TTFB) and high Core Web Vitals:
1. **Conditional Enqueuing (`inc/assets.php`):**
   - Stylesheets and scripts are enqueued **only** on matching templates:
     - `shop.css` and `facet-filters.js` load only on `is_shop() || is_product_taxonomy()`.
     - `single-product.css` loads only on `is_product()`.
     - `cart.css` loads only on `is_cart()`.
     - `checkout.css` loads only on `is_checkout()`.
     - `account.css` loads only on `is_account_page()`.
2. **Vanilla JavaScript:**
   - 0kB jQuery dependencies on custom components; pure Vanilla ES6+ modules.
   - Defer script loading via `wp_script_add_data($handle, 'defer', true)`.
3. **Local WOFF2 Persian Fonts:**
   - Preloaded in `<head>` (`<link rel="preload" as="font" type="font/woff2">`) to prevent Flash of Unstyled Text (FOUT) or layout shifts (CLS).
