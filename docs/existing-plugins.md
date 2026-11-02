# Existing Plugins & Dependency Audit

## 1. Dependency Evaluation Framework
Every plugin on the existing WordPress site must undergo a rigorous architectural audit:
1. **Critical Functionality:** Is this plugin strictly required for store operations (e.g., Iranian payment gateway, SMS notification provider)?
2. **Theme Overlap:** Does this plugin inject styles, scripts, or templates that conflict with our custom theme?
3. **Performance Impact:** Does the plugin introduce unindexed database queries, render-blocking scripts, or slow external HTTP calls?
4. **Licensing & Cost:** Is it 100% free and GPL-compatible? Any commercial or expiring license plugins must be flagged for replacement with native code or free alternatives.
5. **Security:** Has the plugin received updates within the last 12 months? Are there known vulnerabilities in public databases (CVE/WPScan)?

## 2. Existing Plugins Audit Register

| Plugin Name | Identified Role | Status & Action | Impact on Custom Theme |
| :--- | :--- | :--- | :--- |
| **WooCommerce** | Core e-commerce engine | **Keep (Mandatory)** | Foundation for shop, cart, checkout, account, and product catalog. Theme provides custom templates. |
| **Elementor** | Visual page builder | **Retain temporarily -> Decommission post-launch** | Kept active during theme transition. Deactivate and remove once custom theme natively replaces all templates. |
| **Google for WooCommerce** | Google Shopping & Merchant feed | **Keep** | Retained. Does not conflict with custom theme frontend templates. |
| **Jetpack** | Site security, stats, tools | **Keep** | Retained. Requires separate justification if removal is desired in the future. |

## 3. High-Priority Functional Categories to Check
When reviewing the existing setup, we specifically look for:
- **Payment Gateways:** Active Iranian banking modules (ZarinPal, Saman, Mellat, Parsian, IDPay, etc.).
- **SMS / OTP Authentication:** Iranian OTP login plugins (Digits, Iran SMS providers, etc.).
- **Shipping & Delivery:** Post / Courier rate calculators for Iran provinces and cities.
- **Date & Calendar Localization:** Any existing Jalali / Shamsi calendar plugins (e.g., wp-parsidate, wpp-jalali) to prevent double conversion or conflicts.
- **SEO & Sitemaps:** Yoast, Rank Math, or native WordPress sitemaps.
- **Caching & Optimization:** LiteSpeed Cache, WP Super Cache, Redis Object Cache, etc.

## 4. Policy for Introducing New Plugins
- Prior approval from the user is **mandatory**.
- No new plugin will be installed without answering:
  - What native WP/WC capability was evaluated first?
  - Why is custom code inferior to this specific plugin for this requirement?
  - What is the license, performance cost, and security record of the plugin?

## 5. Deactivation & Removal Governance
- With no business data requiring preservation, previous plugins (such as page builders, demo importers, or unused add-ons) can be cleaned up to ensure a lean, secure environment.
- **Strict Protocol:**
  1. Inspect and catalog all active and inactive plugins.
  2. Identify whether any plugin is actually needed or causing bloat/security risk.
  3. Formulate a transparent recommendation detailing why a plugin should be kept, deactivated, or deleted.
  4. **Never** assume plugins should be removed without prior user review and explicit approval.
