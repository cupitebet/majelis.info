# 📚 Panduan Template Halaman Baru - Majelis.info

> **Dibuat:** 15 Desember 2025
> **Status:** Implementasi SEO & UX Improvements

---

## 🎯 Ringkasan Perubahan

Implementasi ini mengatasi masalah SEO dan UX yang teridentifikasi dari review eksternal:

### ✅ Masalah yang Diselesaikan

1. **Footer "COMING SOON"** - Footer sudah menggunakan copyright dinamis (tahun otomatis update)
2. **Push Notification** - Sudah optimal, hanya muncul via tombol install PWA (tidak auto-popup)
3. **Transparansi Donasi** - Halaman khusus untuk membangun trust
4. **Kontak/NAP Konsisten** - Halaman kontak dengan NAP (Name, Address, Phone) yang jelas
5. **Link Hub** - Halaman terpusat untuk semua link penting
6. **Schema Markup** - Structured data untuk Google dan mesin pencari
7. **Template Event** - Standarisasi struktur event page yang SEO-friendly

---

## 📄 Template Halaman Baru

### 1. **Transparansi Donasi & Tiket**

**File:** `wp-content/themes/meup-child/page-transparansi-donasi.php`

**Cara Membuat Halaman:**

1. Login ke WordPress Dashboard
2. Buka **Pages → Add New**
3. Beri judul: **"Transparansi Donasi & Tiket"**
4. Di **Page Attributes** (sidebar kanan), pilih **Template: Transparansi Donasi & Tiket**
5. Isi konten tambahan jika diperlukan
6. Publish dengan slug: `/transparansi-donasi/`

**Fitur Template:**

- ✅ Penjelasan lengkap tentang Majelis.info sebagai platform
- ✅ NAP (Name, Address, Phone) yang jelas dan konsisten
- ✅ Alur donasi/tiket yang transparan
- ✅ Tips aman berdonasi
- ✅ FAQ seputar donasi
- ✅ CTA untuk support dan pelaporan

**Link dari Event:**

Template single event (`single-mep_events.php`) sudah otomatis menampilkan link ke halaman ini di bagian penyelenggara.

---

### 2. **Kontak & Redaksi**

**File:** `wp-content/themes/meup-child/page-kontak.php`

**Cara Membuat Halaman:**

1. Login ke WordPress Dashboard
2. Buka **Pages → Add New**
3. Beri judul: **"Kontak & Redaksi"** atau **"Kontak Kami"**
4. Di **Page Attributes**, pilih **Template: Kontak & Redaksi**
5. Publish dengan slug: `/kontak/`

**Fitur Template:**

- ✅ NAP (Name, Address, Phone) yang prominent dan SEO-friendly
- ✅ Informasi tentang tim redaksi
- ✅ Multiple cara kontak (WhatsApp, Email, Telegram)
- ✅ Kategori kontak (Submit Event, Partnership, Support, dll)
- ✅ Jam operasional support
- ✅ Social media links

**Manfaat SEO:**

- Konsistensi NAP untuk local SEO
- Schema Organization otomatis ditambahkan
- Membantu Google memahami bahwa ini platform media, bukan toko barang bekas

---

### 3. **Link Hub**

**File:** `wp-content/themes/meup-child/page-links.php`

**Cara Membuat Halaman:**

1. Login ke WordPress Dashboard
2. Buka **Pages → Add New**
3. Beri judul: **"Link Hub"** atau **"Semua Link Kami"**
4. Di **Page Attributes**, pilih **Template: Link Hub**
5. Publish dengan slug: `/links/`

**Fitur Template:**

- ✅ Halaman terpusat untuk semua link penting
- ✅ Link ke social media (WhatsApp, Telegram, Email)
- ✅ Quick access ke halaman utama (Events, Transparansi, Kontak)
- ✅ CTA untuk submit event
- ✅ Link kota-kota populer (dapat dikustomisasi)
- ✅ Partnership info

**Cara Kustomisasi Daftar Kota:**

Edit file `page-links.php` di bagian:

```php
$cities = array(
    'Jakarta' => '/location/jakarta/',
    'Bandung' => '/location/bandung/',
    // Tambahkan kota lain di sini
);
```

**Penggunaan:**

- Taruh link ini di bio Telegram: `https://majelis.info/links/`
- Taruh di bio media sosial lainnya
- Gunakan sebagai landing page untuk QR code

---

### 4. **Template Single Event (Terstandarisasi)**

**File:** `wp-content/themes/meup-child/single-mep_events.php`

**Otomatis Aktif:** Template ini otomatis digunakan untuk semua event (post type `mep_events`)

**Struktur Standar:**

1. **Featured Image** - Gambar utama event
2. **Quick Info Pills** - Tanggal, waktu, harga (jika ada)
3. **Ringkasan** - Excerpt 3 baris (opsional)
4. **Action Buttons** - Tambah ke kalender, Share
5. **Lokasi** - Alamat lengkap + tombol Google Maps/Waze
6. **Detail Acara** - Konten lengkap event (rundown, deskripsi)
7. **Penyelenggara & Kontak** - Info penyelenggara dengan link transparansi
8. **FAQ** - Pertanyaan umum (gratis/berbayar, cara daftar, dll)
9. **Share CTA** - Tombol share via WhatsApp dan Telegram

**Meta Fields yang Digunakan:**

- `event_start_datetime` - Tanggal mulai
- `event_end_datetime` - Tanggal selesai
- `mep_location` - Alamat lengkap
- `mep_location_name` - Nama lokasi
- `mep_latitude` - Koordinat latitude
- `mep_longitude` - Koordinat longitude
- `mep_organizer` - Nama penyelenggara
- `mep_contact` - Kontak penyelenggara (otomatis detect WhatsApp)
- `mep_ticket_price` - Harga tiket/kontribusi

**SEO Features:**

- ✅ Schema Event markup otomatis
- ✅ BreadcrumbList schema
- ✅ Social sharing meta tags
- ✅ Struktur konten yang SEO-friendly

---

## 🔍 Schema Markup (Structured Data)

**File:** `wp-content/themes/meup-child/functions.php`

Fungsi schema yang ditambahkan:

### 1. **Organization Schema**

Muncul di: Homepage, halaman Kontak, Transparansi, Links

```json
{
  "@type": "Organization",
  "name": "Majelis.info",
  "address": {
    "streetAddress": "Jl. Guru Mughni No.27F",
    "addressLocality": "Jakarta"
  },
  "contactPoint": {
    "telephone": "+62-899-9150-143",
    "email": "info@majelis.info"
  }
}
```

**Manfaat:**

- Google memahami ini adalah organisasi/platform, bukan toko
- Konsistensi NAP untuk local SEO
- Muncul di Knowledge Panel (jika disetujui Google)

### 2. **WebSite Schema**

Muncul di: Homepage

**Manfaat:**

- Sitelinks search box di Google
- Brand recognition

### 3. **Event Schema**

Muncul di: Semua halaman event

**Manfaat:**

- Event rich snippets di Google Search
- Tampil di Google Events
- "Add to Calendar" langsung dari search results

### 4. **BreadcrumbList Schema**

Muncul di: Semua halaman (kecuali homepage)

**Manfaat:**

- Breadcrumb navigation di Google Search
- Better site structure understanding

---

## 📝 Checklist Implementasi untuk Admin

### Setup Halaman (One-Time)

- [ ] Buat halaman "Transparansi Donasi & Tiket" dengan template yang sesuai
- [ ] Buat halaman "Kontak & Redaksi" dengan template yang sesuai
- [ ] Buat halaman "Link Hub" dengan template yang sesuai
- [ ] Tambahkan halaman-halaman ini ke menu navigasi
- [ ] Update link di footer ke halaman-halaman baru

### Update Profil Bisnis (External)

- [ ] Klaim profil Google Business (jika belum)
- [ ] Update kategori bisnis: "Event Planner" atau "Media Company"
- [ ] Pastikan NAP konsisten: Jl. Guru Mughni No.27F, +62-899-9150-143
- [ ] Laporkan/claim listing yang salah asosiasi (Toko Alipati, dll)

### Update Social Media Bio

- [ ] Telegram @JadwalMajelis: Update bio, tambahkan link ke `/links/`
- [ ] Tumblr: Hapus platform mati (Google+), update link
- [ ] Pin posting di Telegram: "Cara submit event + aturan + link kota"

### Best Practices untuk Event Baru

Saat membuat event baru, pastikan:

- [ ] Isi **Excerpt** (ringkasan 2-3 baris)
- [ ] Upload **Featured Image** berkualitas
- [ ] Isi **Lokasi** lengkap (alamat + koordinat)
- [ ] Isi **Nama Lokasi** (nama masjid/gedung)
- [ ] Isi **Penyelenggara** yang jelas
- [ ] Isi **Kontak** (nomor WhatsApp penyelenggara)
- [ ] Isi **Harga Tiket** jika berbayar
- [ ] Konten event berisi rundown/jadwal acara

---

## 🚀 Dampak yang Diharapkan

### SEO Improvements

1. **Local SEO:** NAP konsisten + schema Organization
2. **Event SEO:** Schema Event untuk rich snippets
3. **Trust Signals:** Halaman transparansi + kontak yang jelas
4. **Site Structure:** BreadcrumbList + internal linking

### UX Improvements

1. **Trust:** Transparansi donasi mengurangi keraguan
2. **Accessibility:** Kontak jelas dan mudah dihubungi
3. **Sharing:** Link hub untuk semua platform
4. **Event Experience:** Template standar yang mudah dipahami

### Branding

1. **Positioning:** Platform agregator, bukan toko/bisnis biasa
2. **Professionalism:** Konten terstruktur dan lengkap
3. **Community:** CTA yang jelas untuk submit event dan partnership

---

## 🔧 Troubleshooting

### Template tidak muncul di Page Attributes

**Solusi:**

1. Pastikan file ada di: `wp-content/themes/meup-child/`
2. Pastikan child theme aktif
3. Clear cache (browser + plugin cache jika ada)
4. Coba switch theme lalu kembali ke child theme

### Schema tidak muncul

**Cek:**

1. View page source, cari `<script type="application/ld+json">`
2. Test di: https://search.google.com/test/rich-results
3. Pastikan functions.php tidak ada error (cek di Dashboard → Tools → Site Health)

### Event tidak pakai template baru

**Solusi:**

1. Pastikan post type adalah `mep_events`
2. Clear cache
3. Regenerate permalinks: Dashboard → Settings → Permalinks → Save Changes

---

## 📞 Support

Jika ada pertanyaan atau masalah:

- WhatsApp: +62 899-9150-143
- Email: info@majelis.info

---

## 📌 Catatan Penting

1. **Backup:** Selalu backup sebelum update theme/plugin
2. **Testing:** Test di staging dulu sebelum production
3. **Cache:** Clear cache setelah setiap perubahan
4. **Mobile:** Pastikan tampilan mobile responsif
5. **Analytics:** Monitor performa halaman baru di Google Analytics

---

**Dibuat dengan ❤️ untuk Majelis.info**
*Platform Jadwal Kajian & Majelis Ilmu Terpercaya*
