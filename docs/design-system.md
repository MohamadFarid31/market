# Centralized Design System & Token Specification

## 1. Design Token Architecture
All styling in the Market theme derives from centralized CSS Custom Properties (`:root`).
Changing these tokens immediately propagates across the entire site without editing individual templates or components.

## 2. CSS Custom Properties Reference

```css
:root {
  /* ==========================================================================
     1. Color Palette (Neutral & Thematic Tokens)
     Note: Colors will be refined once the brand palette is established.
     ========================================================================== */
  --color-primary: #1e3a8a;          /* Deep Brand Blue (Default Token) */
  --color-primary-hover: #172554;
  --color-primary-light: #eff6ff;
  --color-secondary: #0d9488;        /* Teal Accent */
  --color-secondary-hover: #0f766e;

  /* Surfaces & Backgrounds */
  --color-bg-canvas: #f8fafc;        /* App / Page background */
  --color-bg-surface: #ffffff;       /* Card / Modal / Menu surface */
  --color-bg-subtle: #f1f5f9;        /* Hover fills, alternating rows */
  --color-bg-muted: #e2e8f0;         /* Disabled states, skeleton loaders */

  /* Text & Typography */
  --color-text-primary: #0f172a;     /* High contrast body text */
  --color-text-secondary: #475569;   /* Metadata, subheadings, labels */
  --color-text-muted: #94a3b8;       /* Placeholders, disabled text */
  --color-text-inverse: #ffffff;     /* Text on dark surfaces */

  /* Borders & Dividers */
  --color-border-subtle: #f1f5f9;
  --color-border-default: #e2e8f0;
  --color-border-strong: #cbd5e1;
  --color-border-focus: #3b82f6;

  /* Semantic Feedback States */
  --color-success: #10b981;
  --color-success-bg: #ecfdf5;
  --color-warning: #f59e0b;
  --color-warning-bg: #fffbeb;
  --color-danger: #ef4444;
  --color-danger-bg: #fef2f2;
  --color-info: #3b82f6;
  --color-info-bg: #eff6ff;

  /* ==========================================================================
     2. Typography Tokens (fa-IR & Persian First)
     ========================================================================== */
  --font-family-sans: "Vazirmatn", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  --font-family-mono: "Fira Code", monospace;

  /* Type Scale */
  --font-size-xs: 0.75rem;    /* 12px */
  --font-size-sm: 0.875rem;   /* 14px */
  --font-size-base: 1rem;     /* 16px */
  --font-size-md: 1.125rem;   /* 18px */
  --font-size-lg: 1.25rem;    /* 20px */
  --font-size-xl: 1.5rem;     /* 24px */
  --font-size-2xl: 1.875rem;  /* 30px */
  --font-size-3xl: 2.25rem;   /* 36px */
  --font-size-4xl: 3rem;      /* 48px */

  /* Line Heights (Optimized for Persian diacritics & ascenders) */
  --line-height-tight: 1.4;
  --line-height-normal: 1.7;
  --line-height-relaxed: 1.9;

  /* Font Weights */
  --font-weight-regular: 400;
  --font-weight-medium: 500;
  --font-weight-semibold: 600;
  --font-weight-bold: 700;

  /* ==========================================================================
     3. Spacing Scale (4px / 8px Modular Scale)
     ========================================================================== */
  --space-0: 0;
  --space-1: 0.25rem;  /* 4px */
  --space-2: 0.5rem;   /* 8px */
  --space-3: 0.75rem;  /* 12px */
  --space-4: 1rem;      /* 16px */
  --space-5: 1.25rem;  /* 20px */
  --space-6: 1.5rem;   /* 24px */
  --space-8: 2rem;     /* 32px */
  --space-10: 2.5rem;  /* 40px */
  --space-12: 3rem;    /* 48px */
  --space-16: 4rem;    /* 64px */

  /* ==========================================================================
     4. Elevation & Box Shadows
     ========================================================================== */
  --shadow-none: none;
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
  --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);

  /* ==========================================================================
     5. Border Radius Tokens
     ========================================================================== */
  --radius-none: 0;
  --radius-sm: 0.25rem;   /* 4px */
  --radius-md: 0.5rem;    /* 8px */
  --radius-lg: 0.75rem;   /* 12px */
  --radius-xl: 1rem;      /* 16px */
  --radius-2xl: 1.5rem;   /* 24px */
  --radius-full: 9999px;

  /* ==========================================================================
     6. Layout & Breakpoints
     ========================================================================== */
  --container-max-sm: 640px;
  --container-max-md: 768px;
  --container-max-lg: 1024px;
  --container-max-xl: 1280px;
  --container-max-2xl: 1440px;

  /* Transition Tokens */
  --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
}
```

## 3. Persian (RTL) Layout Standards
- **Logical Properties:** Components must use logical CSS properties:
  - `margin-inline-start`, `margin-inline-end` (instead of `margin-left` / `margin-right`)
  - `padding-inline-start`, `padding-inline-end` (instead of `padding-left` / `padding-right`)
  - `inset-inline-start`, `inset-inline-end` (instead of `left` / `right` in absolute positioning)
  - `border-start-start-radius`, `border-end-end-radius`
- **Icon Orientation:**
  - Chevrons, arrows, and breadcrumb dividers are dynamically flipped via:
    ```css
    [dir="rtl"] .icon-directional {
      transform: scaleX(-1);
    }
    ```
- **Persian Typography Rules:**
  - Persian text requires slightly larger font sizes and taller line heights compared to Latin text for equivalent readability.
  - Base body line-height must never drop below `1.6`.
