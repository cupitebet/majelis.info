# Copilot instructions for contributors

These notes help AI coding agents be productive in this repository. Keep suggestions specific, minimal, and always reference repository files when proposing edits.

**Big Picture**
- **Root purpose:** This repo contains a WordPress site/theme (PHP + theme files) in the repository root and a companion Flutter app in `flutter-app-structure/` that consumes the site's REST API.
- **Separation of concerns:** Edit PHP/WordPress site files in the repository root; mobile app work belongs in `flutter-app-structure/`.

**Important files & dirs**
- `index.php`, `default.php`, `wp-*.php` : Core WordPress template and bootstrap files.
- `majelis-complete-styles.css`, `custom-homepage-design.css`, `event-cards-optimization.css` : Primary CSS assets.
- `majelis-custom-styles-snippet.php` : Safe place for small theme customizations (preferred over editing many `wp-*.php` files).
- `flutter-app-structure/` : Flutter app; key file `lib/core/api/wordpress_api.dart` shows how the app talks to the WordPress backend.
- `commit-wordpress.sh`, `FTP-AUTO-DEPLOY-GUIDE.md`, `DEPLOYMENT.md` : Deployment and auto-deploy utilities — review before changing deployment flows.

**Architecture & data flow (concise)**
- The PHP site serves HTML/CSS/WordPress endpoints. The Flutter app calls the WordPress REST API via `lib/core/api/wordpress_api.dart` to fetch posts/pages.
- Changes to WordPress data models (custom fields, REST endpoint changes) require corresponding Flutter API updates.

**Developer workflows**
- Quick local PHP preview (no DB): run `php -S localhost:8000` from the repo root for static/template testing.
- Flutter app: `cd flutter-app-structure && flutter pub get && flutter run` (device/emulator required).
- Deployment: read `DEPLOYMENT.md` and `FTP-AUTO-DEPLOY-GUIDE.md` before editing `commit-wordpress.sh` or FTP settings.

**Project-specific conventions**
- Prefer adding CSS or theme tweaks to `majelis-custom-styles-snippet.php` or `custom-homepage-design.css` instead of changing many theme templates.
- When adding frontend styles, search for the existing files named `majelis-*` and add new rules there to keep naming consistent.
- Keep WordPress bootstrap files (`wp-*.php`) unchanged unless you understand WordPress lifecycle and have a migration/backup plan.

**Integration points & external dependencies**
- WordPress REST API — the Flutter app depends on stable endpoints in `wordpress_api.dart`.
- FTP auto-deploy scripts use repository conventions; do not change remote host logic without updating `DEPLOYMENT.md`.

**When you change code**
- For PHP/theme changes: point to exact files you will edit in the PR description and include visual/HTML/CSS before/after screenshots when possible (`SCREENSHOT-GUIDE.md`).
- For API changes: update `flutter-app-structure/lib/core/api/wordpress_api.dart` and add a short compatibility note describing expected request/response shapes.

**Examples to reference in suggestions**
- To show how Flutter calls the backend, refer to `flutter-app-structure/lib/core/api/wordpress_api.dart`.
- For CSS naming and placement examples, refer to `majelis-complete-styles.css` and `custom-homepage-design.css`.

If anything here is unclear or you want me to expand sections (e.g., add example patches, API contracts, or local Docker setup suggestions), tell me which area to expand and I'll iterate.
