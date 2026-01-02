# Majelis FSE Theme

Block theme for Majelis event listings and organizer UX.

## Templates
- `templates/archive-event.html` – event listing with filters + upcoming sort
- `templates/single-event.html` – event details, share, map
- `templates/page-login.html` – login page
- `templates/page-register.html` – registration page
- `templates/page-forgot-password.html` – password reset
- `templates/page-account.html` – account summary
- `templates/page-dashboard.html` – organizer dashboard

## Patterns
- Event hero
- Event details block area
- CTA share & calendar buttons

## Organizer flow
1. Organizer registers via `/register`.
2. Organizer submits event on `/dashboard` (stored as **pending**).
3. Admin reviews and publishes in wp-admin.

## Map support
If `lat` and `lng` meta fields are set, a Leaflet map loads with OpenStreetMap tiles.
The "Open in Google Maps" link is generated from `google_maps_url` or the address.

## Manual Test Checklist
- Activate theme and confirm templates render.
- `/events` archive shows filters and sorts by `start_datetime`.
- `/events/{slug}` shows details, share links, and map (when lat/lng exists).
- `/events.ics` and `?format=ics` endpoints still work (plugin).
- `/register` creates organizer role user.
- `/login` logs in and redirects to `/dashboard`.
- `/dashboard` allows organizer to submit event (status pending) and lists "My Events".
- Non-admin access to `/wp-admin` redirects to `/dashboard`.
