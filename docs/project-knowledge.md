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

## 4. Existing Website Inventory & Inspection Status
> **Clarification Confirmed:** The existing website holds **no valuable business data** (zero products, product variations, customer accounts, orders, or critical business content that require migration). The frontend can be built entirely clean. However, the existing WordPress and WooCommerce installation must be inspected before any action is taken.

*Baseline parameters to inspect and verify with the user:*
- **WordPress Version:** *(To be inspected)*
- **WooCommerce Version:** *(To be inspected)*
- **PHP Version:** *(To be inspected)*
- **Database Server:** *(MySQL / MariaDB version)*
- **Active Web Server:** *(Nginx / Apache / LiteSpeed)*
- **Currently Active Theme:** *(Identified for replacement)*
- **Active Plugins & Leftovers:** *(To be audited for cleanup or reuse)*
- **Cleanup Requirement:** *(To be determined following environment inspection)*
- **Active Payment Gateways:** *(Iranian banking gateways, e.g., ZarinPal, Saman, Mellat, etc.)*
- **Active SMS / OTP Gateways:** *(e.g., Kavenegar, FarazSMS, etc.)*
- **Active Shipping Methods:** *(e.g., Iran Post, Tipax, local courier)*
