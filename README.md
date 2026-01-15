# Rebuild Majelis.info v2 (Beta First)

Dokumen ini adalah **plan + arahan teknis** untuk rebuild majelis.info ke **beta.majelis.info** dengan **CMS clean**, **vendor dashboard**, **ticket via WhatsApp**, dan **tanpa paid API**.

---

# Arahan Resmi ke Tim Dev: Majelis v2 di beta.majelis.info

## Tujuan & Boundary

- staging.majelis.info = WordPress maintenance (legacy).
- beta.majelis.info = Majelis v2 clean (**NO WordPress**).
- Production majelis.info **jangan disentuh**.
- Rule keras: beta **tidak boleh** ada folder WP: `wp-admin/`, `wp-includes/`, `wp-content/`.

## Struktur Environment (wajib dipahami)

**Production root (jangan disentuh):**  
`/home/u362428227/domains/majelis.info/public_html/`

**Beta v2 root (target deploy v2):**  
`/home/u362428227/domains/majelis.info/public_html/beta/`

**Staging WP root:** sesuai setting Hostinger staging (khusus WP).

## Repo & Branching (biar tidak campur aduk)

**Opsi paling aman:** repo terpisah untuk v2 (mis. `majelis-v2`).

**Branch utama:**

- `beta` → selalu deploy ke `beta.majelis.info`
- `main` → nanti untuk produksi v2 (belum aktif)

**Yang harus dilakukan:**

- Workflow deploy WP **dipensiunkan** dari repo v2.
- Workflow WP hanya boleh ada di repo/branch legacy untuk staging WP.
- Repo ini hanya untuk v2; jangan campur asset WP atau pipeline WP.

## Deployment SOP (beta v2)

**Prinsip:**

- Deploy beta hanya ketika secret guard **ON**.
- Setelah deploy sukses → secret guard langsung **OFF**.

**Secret yang wajib (beta):**

- `FTP_SERVER_BETA`
- `FTP_USERNAME_BETA`
- `FTP_PASSWORD_BETA`
- `ENABLE_BETA_DEPLOY` = default `false`

**Sentinel file (verifikasi cepat):**

- File v2: `.v2-deploy-sentinel.txt` berisi `v2 deploy ok`.
- Checklist setelah deploy:
  - File ada di `/public_html/beta/.v2-deploy-sentinel.txt`
  - File **tidak** ada di production root.

**Checklist verifikasi cepat (setelah deploy):**

- Buka `https://beta.majelis.info/.v2-deploy-sentinel.txt` → harus tampil `v2 deploy ok`.
- Pastikan **tidak ada** WordPress:
  - `https://beta.majelis.info/wp-login.php` → 404
  - `https://beta.majelis.info/wp-admin/` → 404
- Pastikan staging WP aman:
  - `https://staging.majelis.info/wp-login.php` → normal (WP legacy tetap hidup).

## Cara Deploy yang disarankan di Hostinger

Karena shared hosting sering sulit untuk Node SSR:

- **Frontend publik:** Next.js Static Export → upload **artifact build** (mis. `out/`) ke `/public_html/beta/`.
- **Backend API (CMS):**
  - Paling rapi: `api-beta.majelis.info` (subdomain API, document root ke `.../api/public`).
  - Alternatif shared hosting: `/public_html/beta/api` (document root ke `/public_html/beta/api/public` via `.htaccess`/rewrite).

**Prinsip penting:** jangan deploy source mentah lalu berharap server build — build di CI, upload artifact.

Tujuan MVP: event listing, event detail, map Leaflet, tombol WhatsApp.

## Modul MVP (Sprint 1–3)

**Sprint 1: Fondasi + Public Event**

- DB schema minimal: `vendors`, `events`, `cities`, `categories`, `media`
- API publik: `GET /events`, `GET /events/{slug}`
- Frontend: listing event, detail event + Leaflet
- SEO: slug stable, canonical, JSON-LD Event, sitemap minimal

**Sprint 2: Vendor Dashboard**

- Auth + role: `admin`, `vendor`
- Vendor CRUD event milik sendiri
- Set lokasi via map picker (Leaflet)
- Ticket types CRUD

**Sprint 3: Ticket via WhatsApp (tanpa WA API)**

- UI pilih tiket + qty
- `POST /order-intents`
- Redirect `wa.me` dengan template pesan
- Tracking minimal status `wa_clicked`
- Vendor dashboard: total leads per event

## Definition of Done (DoD) Beta v2

- Deploy ke `beta.majelis.info`
- **Tidak ada** jejak WP di beta root
- **Tidak ada** Google Maps scripts
- Page speed masuk akal (frontend ringan)
- Endpoint terdokumentasi (Postman/Swagger minimal)
- Ada sentinel file verifikasi deploy

## Output yang harus dikumpulkan tim dev

1. ERD ringkas + migrations
2. Spec API (Postman collection atau OpenAPI)
3. URL beta yang bisa dites
4. Checklist SEO (canonical, schema, sitemap)
5. Dokumen SOP deploy beta (guard + sentinel)

## Pesan singkat (broadcast ke grup)

“Team, mulai hari ini: staging = WP, beta = v2 clean. Beta tidak boleh ada folder WP. Deploy beta hanya dari branch beta dengan secret ENABLE_BETA_DEPLOY=true, setelah deploy langsung OFF. Target path beta: /public_html/beta/. Pakai sentinel .v2-deploy-sentinel.txt buat verifikasi.”

---

# Plan Rebuild Majelis.info v2 (Beta First)

## Tujuan

Membangun ulang majelis.info dengan arsitektur yang:

* **Clean** (schema rapi, bukan meta soup)
* **Cepat & SEO-ready**
* **Vendor bisa input event sendiri**
* **Tiket via WhatsApp** (tanpa WhatsApp API)
* **Tanpa paid API** (Maps pakai Leaflet + OSM; search self-host nanti)

## Scope awal

* Build di **beta.majelis.info**
* Fokus parity fitur inti + fondasi future (ticketing & vendor)

---

## Deployment Safety (IMPORTANT)

- Auto-deploy ke production (majelis.info) **DISABLED**.
- Deployment hanya boleh dari branch `beta` ke subdomain `beta.majelis.info`.
- Deploy target beta harus ke `/home/u362428227/domains/majelis.info/public_html/beta/`.
- Jangan gunakan credential/remote path production untuk beta.
- Production root: `/home/u362428227/domains/majelis.info/public_html/` → **jangan disentuh**.
- Workflow deploy WP **tidak digunakan** untuk beta v2 (WP hanya di staging).

### SOP Secrets (Default OFF)

- Jangan buat secret `ENABLE_BETA_DEPLOY` dulu, atau set ke `"false"`.
- Secrets yang wajib ada sebelum uji deploy beta:
  - `FTP_SERVER_BETA`
  - `FTP_USERNAME_BETA`
  - `FTP_PASSWORD_BETA`
- Gunakan secrets `_BETA` meskipun servernya sama.

### SOP Uji Deploy Pertama (Safe Test)

1. Pastikan `ENABLE_BETA_DEPLOY` **OFF** (tidak ada / `false`).
2. Push perubahan kecil di branch `beta` yang memicu workflow → job **harus skipped**.
3. Set `ENABLE_BETA_DEPLOY=true`.
4. Push perubahan kecil lagi → deploy **harus jalan**.
5. Verifikasi hanya `/public_html/beta/` yang berubah (beta.majelis.info), production tetap aman.
6. Setelah test, set `ENABLE_BETA_DEPLOY=false` lagi.

### Mode Operasional (Broadcast ke Tim)

**Default (sehari-hari)**

- `ENABLE_BETA_DEPLOY`: `false` / tidak ada
- Deploy tidak jalan walaupun push ke `beta`.

**Deploy beta normal**

1. Set `ENABLE_BETA_DEPLOY=true`.
2. Push perubahan ke `beta` (path yang match workflow).
3. Setelah deploy selesai → set `ENABLE_BETA_DEPLOY=false`.
4. **Rule:** “Secret ON hanya saat mau deploy, setelah sukses langsung OFF.”

### Sentinel File (Verifikasi Cepat)

- File sentinel v2: `.v2-deploy-sentinel.txt` (isi: `v2 deploy ok`).
- Setelah deploy, file harus ada di:
  `/public_html/beta/.v2-deploy-sentinel.txt`
- File **tidak** boleh muncul di:
  `/public_html/.v2-deploy-sentinel.txt`

---

# Keputusan Arsitektur

## Stack

**Backend (CMS + API)**

* Laravel (PHP 8.2+)
* PostgreSQL
* Auth: Laravel Sanctum
* Role/permission: Spatie Permission
* Storage: local (beta), opsi MinIO nanti

**Frontend publik**

* Next.js (TypeScript)
* SSG/ISR untuk halaman statis, SSR opsional untuk search berat

**Maps**

* Leaflet + OpenStreetMap tiles
* **No Google Maps**, no paid map API
* Geocode: **tidak otomatis**. Admin/vendor set pin manual (lat/lng).

**Search**

* MVP: query Postgres (indexing bagus)
* Fase 2: Meilisearch self-host (jika data sudah banyak)

---

# Modul & Fitur: MVP Beta

## 1) Publik: Direktori Event

**Pages**

* Home / listing event
* Event detail
* Listing by kategori/kota
* Sitemap + robots

**Fitur**

* Filter: keyword, kota, kategori, tanggal range (minimal start date)
* Event detail: info lengkap + peta Leaflet marker

**Acceptance Criteria**

* LCP bagus (target internal: cepat dan ringan, no heavy scripts)
* JSON-LD schema Event valid di event detail
* Tidak ada script Google Maps kebawa

---

## 2) Vendor Dashboard (CMS khusus vendor)

**Role**

* `admin`, `editor`, `vendor`

**Vendor bisa**

* Kelola profil vendor (nama, no WA, logo)
* CRUD event (draft/publish)
* Set lokasi via map picker (lat/lng)
* Buat ticket type (nama, harga, kuota, periode jual)
* Lihat statistik sederhana: jumlah klik “Pesan via WA” (leads)

**Acceptance Criteria**

* Vendor hanya bisa mengedit event miliknya
* Admin bisa melihat dan mengedit semua
* Status event: `draft` / `published`

---

## 3) Ticketing MVP: Pesan via WhatsApp (tanpa WhatsApp API)

**Konsep**

* Tidak ada checkout, tidak ada payment gateway di fase beta.
* Tombol “Pesan via WhatsApp” membuat link `wa.me` ke nomor vendor, dengan template pesan otomatis.

**Flow**

1. User pilih jenis tiket + qty (di event detail)
2. Klik “Pesan via WhatsApp”
3. Sistem:

   * simpan record `order_intents`
   * redirect ke link `wa.me` (template pesan)

**Acceptance Criteria**

* Template pesan terisi: nama event, tanggal, ticket type, qty, nama/HP (optional), lokasi
* Ada pencatatan lead minimal: `order_intents.status = wa_clicked`
* Tidak perlu integrasi WA Business API

---

# Future Roadmap (Disiapkan dari Skema)

## Phase B: Invoice + Upload bukti bayar (masih tanpa gateway)

* Generate invoice number
* User upload bukti transfer / QRIS statis vendor
* Vendor/admin approve → generate ticket code/QR

## Phase C: Payment otomatis (opsional)

* Integrasi payment gateway (kalau sudah validasi demand)
* Catatan: ini bukan “bayar API mahal”, biasanya fee per transaksi.

---

# Data Model (Minimal, Clean)

## Tabel inti

### `vendors`

* id, name, whatsapp_number, description, logo_media_id, status, created_at

### `events`

* id
* vendor_id
* title, slug
* status: draft/published
* start_at, end_at
* description
* address_text
* city_id, province_id
* latitude, longitude
* cover_media_id
* seo_title, seo_description, canonical_url
* published_at, created_by, updated_by
* timestamps

### `ticket_types`

* id, event_id
* name
* price (integer)
* quota (integer)
* sold_count (integer default 0)
* sales_start, sales_end (nullable)
* timestamps

### `order_intents` (MVP WA)

* id
* event_id, ticket_type_id, vendor_id
* qty
* buyer_name (nullable)
* buyer_phone (nullable)
* status: initiated/wa_clicked/closed
* user_agent, referrer (optional, untuk analitik ringan)
* timestamps

### taxonomy (minimal)

* `categories`, `event_categories` (pivot)
* `tags`, `event_tags` (pivot)
* `cities`, `provinces`

### SEO util

* `redirects`: from_path, to_path, status_code, hits_count

### `media`

* id, path, mime, width, height, alt_text, created_by, timestamps

---

# API Contract (Disepakati dari awal)

## Public API

* `GET /api/events?query=&city=&category=&date_from=&date_to=&page=`
* `GET /api/events/{slug}`
* `GET /api/categories`
* `GET /api/cities`
* `POST /api/order-intents` (buat record sebelum redirect WA)

## Vendor/Admin API (protected)

* `POST /api/auth/login`
* `GET /api/vendor/me`
* `POST /api/vendor/events`
* `PUT /api/vendor/events/{id}`
* `POST /api/vendor/ticket-types`
* `PUT /api/vendor/ticket-types/{id}`
* `POST /api/media`

---

# Sprint Plan (Beta)

## Sprint 1: Foundation + Event Public

**Backend**

* Setup Laravel + Postgres + migrations inti (vendors, events, media, cities/provinces)
* Auth + RBAC (admin/vendor)
* CRUD event minimal (title, date, address, lat/lng, status)

**Frontend**

* Listing event
* Event detail + Leaflet map (marker)
* Basic SEO: slug + canonical + JSON-LD Event

**DoD**

* beta.majelis.info deploy
* Event detail sudah ada map Leaflet
* Tidak ada Google scripts

---

## Sprint 2: Vendor Dashboard + Ticket Types

**Backend**

* Vendor profile + limit akses data milik sendiri
* Ticket types CRUD
* Publish workflow: draft/publish

**Frontend**

* Vendor dashboard UI minimal (bisa internal Next atau blade admin, tapi konsisten)
* Event create/edit + map picker (Leaflet)

**DoD**

* Vendor bisa create event + set lat/lng
* Ticket types muncul di event detail

---

## Sprint 3: WhatsApp Order Intents + Tracking

**Backend**

* `order_intents` endpoint + status update
* Rate limit sederhana (anti spam)

**Frontend**

* UI pilih tiket + qty
* Tombol “Pesan via WhatsApp”
* Redirect ke `wa.me` dengan template pesan

**DoD**

* Setiap klik tercatat sebagai lead
* Vendor bisa lihat count lead per event

---

# Arahan Teknis Kunci (biar tim tidak salah arah)

## Maps

* Leaflet only.
* Lat/lng wajib disimpan di kolom `events.latitude/longitude`
* Tidak ada geocode otomatis di MVP.

## SEO

* Slug stable
* Canonical selalu ada
* JSON-LD Event wajib di detail
* Sitemap generator minimal (events + kategori) pada beta

## Performance

* Hindari bundle besar di frontend
* Caching:

  * public pages: ISR/SSG kalau memungkinkan
  * API: response cache (opsional)

## Security & Roles

* Vendor hanya akses datanya
* Admin override semua
* Audit log minimal (optional sprint 2/3)

---

# Deliverables yang harus diminta dari tim dev (output nyata)

1. Dokumen schema DB (ERD ringkas)
2. Spec API (OpenAPI/Swagger atau minimal Postman collection)
3. URL beta yang bisa di-test
4. Checklist SEO teknis (canonical, schema, sitemap)
5. Daftar endpoint + contoh response

---

Kalau dibutuhkan, bisa dibuat **Jira epics + user stories + acceptance criteria** dalam format siap import (Epic → Story → Subtask).
