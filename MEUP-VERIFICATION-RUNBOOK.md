# MeUp Verification Runbook (Ringkas)

Panduan cepat untuk memverifikasi apakah fitur MeUp dan menu telah terpasang serta bekerja sesuai dokumentasi.

1) Tujuan
- Pastikan endpoint REST MeUp (`/wp-json/meup/v1`) aktif dan mengembalikan data events/categories.
- Pastikan theme MeUp terpasang/aktif dan menu + setting sesuai dokumentasi.
- Pastikan fitur booking / QR / wishlist bekerja di website dan mobile app terhubung.

2) Pemeriksaan API (jalankan dari mesin lokal)
- Cek endpoint events:

```bash
curl -sSf https://majelis.info/wp-json/meup/v1/events | jq '.[0] | {id: .id, title: .title}'
```
- Cek kategori event:

```bash
curl -sSf https://majelis.info/wp-json/meup/v1/event-categories | jq '.[0] | {id: .id, name: .name}'
```
- Jika respons 200 + JSON muncul: endpoint MeUp tersedia.
- Jika 404 atau error: periksa apakah plugin MeUp / OvaTheme Framework dan OT Events terinstall dan aktif.

3) Pemeriksaan Theme & Menu (WordPress dashboard)
- Login: `https://majelis.info/wp-admin`
- Theme:
  - Appearance → Themes → Pastikan `MeUp` (atau `MeUp Child`) aktif.
  - Jika menggunakan child theme, pastikan `meup-child` memiliki `Template: meup`.
- Additional CSS:
  - Appearance → Customize → Additional CSS → pastikan `custom-homepage-design.css` dan `event-cards-optimization.css` sudah ditempel atau child theme memuatnya.
- Menus:
  - Appearance → Menus → Pastikan `Primary Menu` berisi: Home, Events (submenu kategori), Vendors, Cara Pesan, FAQ, Kontak.
  - Pastikan menu di-assign ke lokasi `Primary Menu`.

4) Pemeriksaan Plugin & Settings
- Plugins → Pastikan setidaknya: OvaTheme Framework, OT Events, OT Vendor, Elementor, JWT Auth (jika mobile login), WooCommerce (jika booking via WooCommerce).
- MeUp Settings:
  - Dashboard → MeUp Settings → General Options → cek logo, warna, typography sesuai dokumentasi.
- Events → Settings → pastikan booking, QR code, ticket types aktif.

5) Uji fungsional (manual)
- Buka homepage: https://majelis.info
  - Hero section, search bar, kategori, event cards tampil.
- Klik kategori → daftar event muncul.
- Klik event → detail event + tombol "Book Now".
- Lakukan simulasi pemesanan (mode sandbox jika tersedia) → periksa generate QR dan email ticket.

6) Verifikasi integrasi mobile
- Setelah patch Flutter (client sekarang menggunakan `/wp-json/meup/v1`): build dan jalankan app.

```bash
cd flutter-app-structure
flutter pub get
flutter run
```
- Cek apakah event list muncul di app. Jika kosong, gunakan Network inspector atau log untuk melihat URL yang dipanggil.

7) Debugging cepat jika API tidak ada
- Pastikan plugin tema MeUp/OT Events aktif.
- Cek `wp-json` root: `https://majelis.info/wp-json/` untuk melihat namespaces terdaftar.
- Jika `meup` namespace tidak muncul: MeUp plugin belum aktif atau endpoint terdaftar di namespace lain.

8) Catatan untuk developer
- Flutter client sudah diubah agar memakai `AppConfig.meupApiUrl`.
- Jika Anda ingin client memanggil `wp/v2` untuk posts/pages, refactor client untuk menggunakan dua base URL: `wordpressApiUrl` dan `meupApiUrl`.

9) Rollback patch Flutter (jika perlu)
- Kembalikan baris di `flutter-app-structure/lib/core/api/wordpress_api.dart`:

```diff
- final String baseUrl = AppConfig.meupApiUrl;
+ final String baseUrl = AppConfig.wordpressApiUrl;
```

10) Laporkan hasil
- Setelah menjalankan pemeriksaan, kirim hasil (output `curl`, screenshot dashboard, atau logs). Saya akan bantu diagnosis jika ada error.

---
Update record: Runbook dibuat oleh agent pada 2025-11-19. Jika perlu, saya bisa tambahkan checklist lebih detail atau screenshot langkah WordPress.
