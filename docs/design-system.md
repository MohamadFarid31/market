# Centralized Design System & Token Specification

## 1. Design Token Architecture
All styling in the Market theme derives strictly from centralized CSS Custom Properties (`:root`).
- **Single Source of Truth:** Changing tokens in `:root` updates colors, typography, sizing, layout, and spacing consistently across the entire website without modifying individual template files or component stylesheets.
- **Strict Logical Property Rule:** All component layout rules must use CSS Logical Properties (`margin-inline-*`, `padding-inline-*`, `inset-inline-*`, `border-start-start-radius`, etc.) to guarantee seamless, native RTL behavior for Persian (`fa-IR`).
- **No Hardcoded Values:** No component stylesheet may use raw hex codes, fixed pixel margins, or arbitrary magic numbers.

---

## 2. Comprehensive CSS Custom Properties Master Reference

```css
:root {
  /* ==========================================================================
     1. Brand Colors (Tokens ready to bind to brand identity upon decision)
     ========================================================================== */
  --color-primary: #1e3a8a;            /* Primary brand shade */
  --color-primary-hover: #172554;      /* Interactive hover state */
  --color-primary-active: #0f172a;     /* Interactive active/pressed state */
  --color-primary-light: #eff6ff;      /* Subtle tinted background */
  --color-primary-contrast: #ffffff;   /* Text on primary surface */

  --color-secondary: #0d9488;          /* Complementary accent (e.g. badges, secondary CTAs) */
  --color-secondary-hover: #0f766e;
  --color-secondary-active: #115e59;
  --color-secondary-light: #f0fdfa;
  --color-secondary-contrast: #ffffff;

  --color-accent: #f59e0b;             /* Special highlights, discounts, ratings */
  --color-accent-hover: #d97706;
  --color-accent-light: #fffbeb;
  --color-accent-contrast: #ffffff;

  /* ==========================================================================
     2. Text & Typography Colors
     ========================================================================== */
  --color-text-primary: #0f172a;       /* High-contrast body text */
  --color-text-secondary: #475569;     /* Metadata, labels, secondary info */
  --color-text-muted: #94a3b8;         /* Placeholders, disabled text */
  --color-text-inverse: #ffffff;       /* Text on dark/primary surfaces */
  --color-text-link: #1e3a8a;          /* Inline anchor links */
  --color-text-link-hover: #2563eb;    /* Anchor link hover state */

  /* ==========================================================================
     3. Background & Surface Colors
     ========================================================================== */
  --color-bg-canvas: #f8fafc;          /* Global page background */
  --color-bg-surface: #ffffff;         /* Card, panel, dialog surface */
  --color-bg-surface-raised: #ffffff;  /* Elevated cards, dropdown menus */
  --color-bg-subtle: #f1f5f9;          /* Alternating rows, input backgrounds */
  --color-bg-muted: #e2e8f0;           /* Skeleton loaders, disabled surfaces */
  --color-bg-overlay: rgba(15, 23, 42, 0.6); /* Modal & drawer backdrops */

  /* ==========================================================================
     4. Border & Divider Colors
     ========================================================================== */
  --color-border-subtle: #f1f5f9;      /* Delicate card dividers */
  --color-border-default: #e2e8f0;     /* Standard component borders */
  --color-border-strong: #cbd5e1;      /* Interactive input borders */
  --color-border-focus: #3b82f6;       /* Keyboard focus outlines */

  /* ==========================================================================
     5. Semantic Feedback States
     ========================================================================== */
  --color-success: #10b981;
  --color-success-hover: #059669;
  --color-success-bg: #ecfdf5;
  --color-success-text: #065f46;

  --color-warning: #f59e0b;
  --color-warning-hover: #d97706;
  --color-warning-bg: #fffbeb;
  --color-warning-text: #92400e;

  --color-danger: #ef4444;
  --color-danger-hover: #dc2626;
  --color-danger-bg: #fef2f2;
  --color-danger-text: #991b1b;

  --color-info: #3b82f6;
  --color-info-hover: #2563eb;
  --color-info-bg: #eff6ff;
  --color-info-text: #1e40af;

  /* ==========================================================================
     6. Typography Tokens (Persian fa-IR Optimized)
     ========================================================================== */
  --font-family-base: "Vazirmatn", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  --font-family-heading: "Vazirmatn", -apple-system, BlinkMacSystemFont, sans-serif;
  --font-family-mono: "Fira Code", monospace;

  /* Font Weights */
  --font-weight-regular: 400;
  --font-weight-medium: 500;
  --font-weight-semibold: 600;
  --font-weight-bold: 700;
  --font-weight-extrabold: 800;

  /* Type Scale */
  --font-size-xs: 0.75rem;             /* 12px */
  --font-size-sm: 0.875rem;            /* 14px */
  --font-size-base: 1rem;              /* 16px - Base body */
  --font-size-md: 1.125rem;            /* 18px */
  --font-size-lg: 1.25rem;             /* 20px */
  --font-size-xl: 1.5rem;              /* 24px - H4 */
  --font-size-2xl: 1.875rem;           /* 30px - H3 */
  --font-size-3xl: 2.25rem;            /* 36px - H2 */
  --font-size-4xl: 3rem;               /* 48px - H1 / Hero */

  /* Line Heights (Tuned for Persian Ascenders/Descenders) */
  --line-height-tight: 1.35;
  --line-height-normal: 1.65;
  --line-height-relaxed: 1.85;

  /* ==========================================================================
     7. Spacing Scale (Modular 4px / 8px Grid)
     ========================================================================== */
  --space-0: 0;
  --space-1: 0.25rem;                  /* 4px */
  --space-2: 0.5rem;                   /* 8px */
  --space-3: 0.75rem;                  /* 12px */
  --space-4: 1rem;                     /* 16px */
  --space-5: 1.25rem;                  /* 20px */
  --space-6: 1.5rem;                   /* 24px */
  --space-8: 2rem;                     /* 32px */
  --space-10: 2.5rem;                  /* 40px */
  --space-12: 3rem;                    /* 48px */
  --space-16: 4rem;                    /* 64px */
  --space-20: 5rem;                    /* 80px */
  --space-24: 6rem;                    /* 96px */

  /* ==========================================================================
     8. Container Widths
     ========================================================================== */
  --container-sm: 640px;
  --container-md: 768px;
  --container-lg: 1024px;
  --container-xl: 1280px;
  --container-2xl: 1440px;

  /* ==========================================================================
     9. Border Radius Tokens
     ========================================================================== */
  --radius-none: 0;
  --radius-sm: 0.25rem;                /* 4px - Pills, tags, badges */
  --radius-md: 0.5rem;                 /* 8px - Inputs, buttons */
  --radius-lg: 0.75rem;                /* 12px - Cards, dropdowns */
  --radius-xl: 1rem;                   /* 16px - Modals, banners */
  --radius-2xl: 1.5rem;                /* 24px - Rounded hero containers */
  --radius-full: 9999px;               /* Circular buttons, avatars */

  /* ==========================================================================
     10. Elevation & Box Shadows
     ========================================================================== */
  --shadow-none: none;
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.04);
  --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
  --shadow-inner: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);

  /* ==========================================================================
     11. Standardized Breakpoints (CSS / Media Query Reference)
     ========================================================================== */
  --bp-mobile: 480px;
  --bp-phablet: 640px;
  --bp-tablet: 768px;
  --bp-desktop: 1024px;
  --bp-wide: 1280px;
  --bp-ultrawide: 1440px;

  /* ==========================================================================
     12. Z-Index Layer Tokens (Predictable Stacking Context)
     ========================================================================== */
  --z-deep: -1;
  --z-base: 1;
  --z-dropdown: 100;
  --z-sticky: 200;
  --z-overlay: 300;
  --z-drawer: 400;
  --z-modal: 500;
  --z-popover: 600;
  --z-toast: 700;
  --z-tooltip: 800;

  /* ==========================================================================
     13. Transitions & Animation Timings
     ========================================================================== */
  --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
  --ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
}
```

---

## 3. Persian (RTL) Layout Standards & Logical Properties

- **Logical Properties Standard:**
  All component rules strictly avoid `left` and `right`.
  - Instead of `margin-left` / `margin-right` $\rightarrow$ use `margin-inline-start` / `margin-inline-end`.
  - Instead of `padding-left` / `padding-right` $\rightarrow$ use `padding-inline-start` / `padding-inline-end`.
  - Instead of `left: 0` / `right: 0` $\rightarrow$ use `inset-inline-start: 0` / `inset-inline-end: 0`.
  - Instead of `border-top-left-radius` $\rightarrow$ use `border-start-start-radius`.
  - Instead of `text-align: right` $\rightarrow$ use `text-align: start`.
- **Directional Icon Flipping:**
  Icons indicating forwards/backwards progression (arrows, breadcrumbs, chevrons, pagination) flip automatically in RTL:
  ```css
  [dir="rtl"] .icon-directional {
    transform: scaleX(-1);
  }
  ```
- **Persian Typography Rules:**
  - Base body text requires `line-height: var(--line-height-normal)` (minimum $1.65$) to prevent diacritic clipping.
  - OpenType features enabled: `font-feature-settings: "kern" 1, "ss01" 1` for Persian numeral variants where desired.
