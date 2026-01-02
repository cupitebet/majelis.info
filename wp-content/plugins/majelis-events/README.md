# Majelis Events Plugin

Core data layer for Majelis events.

## Features
- Custom post type: `event`
- Taxonomies: `event_category`, `event_tag`, `city`, `event_organizer`
- Meta fields:
  - `start_datetime`
  - `end_datetime`
  - `all_day`
  - `attendance_mode`
  - `venue`
  - `address`
  - `lat`
  - `lng`
  - `google_maps_url`
  - `organizer_contact`
  - `registration_url`
  - `status`
- JSON-LD schema.org Event on single event pages
- OG/Twitter meta tags on single event pages
- ICS endpoints:
  - Single event: `?format=ics` or `/events/{slug}/download/ics/`
  - Feed: `/events.ics`
- Add to Google Calendar URL helper (see below)
- REST API:
  - `GET /wp-json/majelis/v1/events`
  - `GET /wp-json/majelis/v1/events/{id}`

## Google Calendar URL (no API)
Example format:
```
https://calendar.google.com/calendar/render?action=TEMPLATE&text=EVENT_TITLE&dates=YYYYMMDDTHHMMSSZ/YYYYMMDDTHHMMSSZ&details=DESCRIPTION&location=ADDRESS&trp=false
```

You can build this client-side using event data from the REST API.

## Manual Test Checklist
- Create an event and confirm it appears under **Events** in wp-admin.
- Save meta fields and confirm values appear in REST responses.
- Visit a single event page and confirm:
  - JSON-LD is rendered in `<head>`
  - OG/Twitter meta tags are present
- Download an event ICS:
  - `?format=ics` on the event page
  - `/events/{slug}/download/ics/`
- Visit `/events.ics` and confirm it returns upcoming events.
- Call REST endpoints:
  - `/wp-json/majelis/v1/events`
  - `/wp-json/majelis/v1/events/{id}`

## Notes
- Meta fields use `register_post_meta` with sanitization and capability checks.
- No UI templates are provided by this plugin (data layer only).
