# Deployment & FTP Transfer Guide

## 1. Environment Policy
- **No Direct Remote Access:** The engineering agent operates exclusively inside the local workspace repository.
- **Manual FTP Synchronization:** The site administrator / user will transfer clean, tested artifacts to the live or staging server via FTP/SFTP (e.g., using FileZilla, WinSCP, Cyberduck).

## 2. Directory Mapping Matrix

| Workspace Source Path | Target Remote Server Path | Purpose |
| :--- | :--- | :--- |
| `f:\Code\market\themes\market\` | `/public_html/wp-content/themes/market/` | Active custom WordPress & WooCommerce theme |
| `f:\Code\market\plugins\{plugin-name}\` | `/public_html/wp-content/plugins/{plugin-name}/` | Custom plugins (if any created) |
| `f:\Code\market\docs\` | *(Do NOT deploy)* | Local engineering documentation |
| `f:\Code\market\.agent\` | *(Do NOT deploy)* | Agent rules and workflow memory |

*(Note: If the server root is `/var/www/html/` or `/httpdocs/`, adjust the parent directory accordingly).*

## 3. Step-by-Step FTP Deployment Protocol

### Step A: Pre-Deployment Verification (In Workspace)
1. Ensure all PHP code passes syntax and security checks (`php -l` or static analysis).
2. Confirm no hardcoded URLs, localhost paths, or debug statements (`var_dump()`, `error_log()`) remain active.
3. Verify that `style.css` contains correct theme headers and version number increment.

### Step B: Manual FTP Transfer
1. Connect to the host using your FTP/SFTP client.
2. Navigate to remote path: `wp-content/themes/`.
3. Upload the entire `market` folder from `f:\Code\market\themes\market` into `wp-content/themes/`.
4. Ensure file permissions on the server:
   - Directories: `755`
   - Files: `644`

### Step C: Post-Deployment Activation & Verification
1. Log in to WordPress Admin (`/wp-admin/`).
2. Go to **Appearance > Themes** and activate **Market** (when testing/launching).
3. Check **WooCommerce > Status**:
   - Verify WooCommerce detects theme support.
   - Confirm HPOS compatibility declaration is accepted without warnings.
   - Check the **Templates** section for any outdated or problematic overrides.
4. Purge all page caching and object caching (e.g. LiteSpeed Cache, Redis, WP Super Cache, Cloudflare).
5. Flush Permalinks by visiting **Settings > Permalinks** and clicking **Save Changes**.

## 4. Rollback Strategy
- Before updating an active theme on production:
  1. Rename the existing remote folder on the server to `market-backup-YYYYMMDD/` before overwriting.
  2. In the event of a critical failure or fatal error, immediately rename the backup folder back to `market/` or activate a standard default theme (e.g. Storefront or Twenty Twenty-Four) via WP-Admin or FTP.

## 5. Safe Ahura Theme Decommissioning Procedure
1. **Prerequisite:** Ensure a default core fallback theme (e.g., Twenty Twenty-Four) is present in `wp-content/themes/`.
2. **Parallel Installation:** Upload `market` folder via FTP alongside `ahura`. Both themes coexist on the filesystem; Ahura remains active.
3. **Activation Checkpoint:** Activate `Market` in WP Admin. Test frontend, header, footer, cart, and checkout in staging or under admin preview.
4. **Emergency Plan:** If any regression is observed, immediately switch active theme back to `Ahura` with one click.
5. **Final Decommissioning:** Only after full verification of `Market`, delete the `ahura` (and child theme) folder from `wp-content/themes/` via FTP. Never leave the server without an active working theme.
