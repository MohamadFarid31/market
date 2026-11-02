# System Architecture & Theme Structure

## 1. Architectural Philosophy
The "Market" theme follows modern software engineering principles tailored for the WordPress and WooCommerce ecosystems:
- **Separation of Concerns:**
  - **Theme (`themes/market`):** Solely responsible for presentation, layouts, UI components, assets, template overrides, and user experience.
  - **Plugins (`plugins/`):** Responsible for business logic, custom post types, custom database tables, external API integrations, or standalone functional modules that should survive theme switches.
- **Native-First Design:** Maximum utilization of WordPress Core APIs (`WP_Query`, Transients, Customizer/Site Editor, Nav Menus, Media Library) and WooCommerce CRUD APIs (`WC_Product`, `WC_Order`, `WC_Customer`, `WC_Cart`).
- **HPOS Compatibility:** Native support for WooCommerce High-Performance Order Storage with zero assumptions regarding `wp_posts` order storage.
- **Clean-Slate Frontend on Preserved Core:** The custom theme completely replaces the existing theme and frontend design from scratch. No legacy business data or page structures constrain the architecture, but the existing WordPress installation is preserved without core tampering.

## 2. Directory Layout: Workspace vs Server Deployment

```text
market/                          [Workspace Root]
├── themes/
│   └── market/                  --> [Target: wp-content/themes/market/]
│       ├── style.css            --> Theme declaration & root stylesheet
│       ├── functions.php        --> Theme setup, hooks & include loaders
│       ├── rtl.css              --> Dedicated RTL overrides & logical properties
│       ├── index.php            --> Main template fallback
│       ├── header.php           --> HTML head, meta & semantic header
│       ├── footer.php           --> Semantic footer & scripts closing
│       ├── front-page.php       --> Homepage template (dynamic blocks/hooks)
│       ├── page.php             --> Standard page template
│       ├── single.php           --> Single blog post template
│       ├── archive.php          --> Generic archive template
│       ├── 404.php              --> 404 error page
│       ├── inc/                 --> Modular backend logic & theme helpers
│       │   ├── setup.php        --> Theme supports, image sizes, nav menus
│       │   ├── assets.php       --> Scripts & styles enqueuing logic
│       │   ├── template-tags.php--> Reusable presentation helper functions
│       │   ├── woocommerce.php  --> WooCommerce integration & hook overrides
│       │   └── rtl-persian.php  --> Persian numerals, Jalali dates & RTL helpers
│       ├── template-parts/      --> Modular UI components (BEM / semantic)
│       │   ├── header/          --> Header components (nav, search, cart icon)
│       │   ├── footer/          --> Footer components
│       │   ├── product/         --> Product card, badges, price component
│       │   └── common/          --> Breadcrumbs, pagination, alerts
│       ├── woocommerce/         --> WooCommerce template overrides
│       │   ├── archive-product.php
│       │   ├── single-product/
│       │   ├── cart/
│       │   └── checkout/
│       └── assets/              --> Static production assets
│           ├── css/             --> Compiled/structured stylesheets & design tokens
│           ├── js/              --> Vanilla JS modules (cart, navigation, filters)
│           ├── fonts/           --> Local Persian web fonts (WOFF2)
│           └── images/          --> Local theme icons/placeholders (SVG only)
├── plugins/                     --> [Target: wp-content/plugins/{plugin-slug}/]
├── docs/                        --> Permanent engineering documentation
├── .agent/rules/                --> Strict development rules & constraints
└── README.md                    --> Project onboarding & workflow guide
```

## 3. High-Performance Order Storage (HPOS) Implementation
To guarantee native HPOS compatibility, the theme declares compatibility in `functions.php`:
```php
add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'custom_order_tables',
            __FILE__,
            true
        );
    }
});
```
All order querying must strictly pass through `wc_get_orders()` and order modification through `$order->save()`.

## 4. Frontend Asset Enqueue Architecture
- **CSS Strategy:**
  1. Base Design Tokens (`tokens.css`) containing all CSS custom properties.
  2. Reset & Normalized Typography (`reset.css`).
  3. Layout & Components (`main.css`).
  4. RTL Overrides / Logical flow (`rtl.css` loaded automatically when `is_rtl()` is true).
- **JavaScript Strategy:**
  - Modern ES6+ JavaScript, written in modular vanilla files.
  - Enqueued with `defer` or `type="module"` to eliminate render blocking.
  - Localization via `wp_localize_script()` passing nonces, localized strings, and AJAX/REST URLs.
