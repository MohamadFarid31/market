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
