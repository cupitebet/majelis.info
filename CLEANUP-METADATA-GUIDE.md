# Panduan Membersihkan Metadata dari n8n Workflow

## Latar Belakang

Metadata berikut ini berasal dari konfigurasi workflow n8n atau plugin yang mungkin sudah tidak digunakan lagi:

- `boomdevs_metabox` - dari plugin BoomDevs
- `litespeed_vpi_list` - list gambar cache dari LiteSpeed (akan di-regenerate otomatis)
- `ova_met_footer_version` - versi footer MeUp theme
- `ova_met_header_version` - versi header MeUp theme
- `ova_met_main_layout` - layout utama halaman
- `ova_met_page_heading` - pengaturan heading halaman
- `ova_met_width_site` - lebar situs

## Apakah Aman Dihapus?

✅ **YA, AMAN** - Menghapus metadata ini:
- Tidak akan merusak website
- Tidak akan menghapus konten
- Tidak akan mempengaruhi SEO
- Post/Page akan menggunakan pengaturan default theme

⚠️ **Catatan:**
- Metadata `ova_met_*` adalah override pengaturan theme. Setelah dihapus, halaman akan menggunakan pengaturan default theme.
- Metadata `litespeed_vpi_list` akan di-regenerate otomatis oleh LiteSpeed Cache saat diperlukan.

## Cara Menggunakan

### Metode 1: Menggunakan WP-CLI (Recommended)

#### Langkah 1: Preview (Dry-Run)
Lihat metadata apa saja yang akan dihapus tanpa benar-benar menghapus:

```bash
cd /home/user/majelis.info
wp eval-file scripts/cleanup-metadata.php
```

#### Langkah 2: Jalankan Pembersihan
Setelah yakin, edit file dan ubah mode menjadi `execute`:

```bash
# Edit file
nano scripts/cleanup-metadata.php

# Cari baris 34, ubah dari:
$mode = 'dry-run';
# Menjadi:
$mode = 'execute';

# Simpan (Ctrl+O, Enter, Ctrl+X)

# Jalankan pembersihan
wp eval-file scripts/cleanup-metadata.php
```

### Metode 2: Via WordPress Dashboard

1. Upload file `scripts/cleanup-metadata.php` ke server
2. Akses via browser: `https://majelis.info/scripts/cleanup-metadata.php`
3. Login sebagai admin
4. Script akan berjalan dan menampilkan hasilnya

**PENTING:** Hapus file setelah selesai digunakan untuk keamanan:
```bash
rm /home/user/majelis.info/scripts/cleanup-metadata.php
```

## Cara Cepat (One-liner)

Jika Anda yakin dan ingin langsung membersihkan:

```bash
cd /home/user/majelis.info && \
sed -i "s/\$mode = 'dry-run';/\$mode = 'execute';/" scripts/cleanup-metadata.php && \
wp eval-file scripts/cleanup-metadata.php
```

## Output Yang Diharapkan

### Saat Dry-Run:
```
=================================================
Cleanup Metadata dari Post/Page
=================================================
Mode: DRY-RUN
Tanggal: 2025-11-21 08:30:00
=================================================

Total post/page yang akan diperiksa: 50

Memeriksa: [page] Register - Laman (ID: 16368)
  ✓ Ditemukan metadata: boomdevs_metabox
    Nilai: {"s:1:{s:19:"disable_auto_insert";s:1:"0";};"}
    [AKAN DIHAPUS saat mode = execute]
  ✓ Ditemukan metadata: litespeed_vpi_list
    Nilai: {"0":"logo-Jadwal-Majlis.png"}
    [AKAN DIHAPUS saat mode = execute]

...

=================================================
RINGKASAN PEMBERSIHAN
=================================================
Total post/page diperiksa: 50
Total post/page dengan metadata: 15
Total metadata yang akan dihapus: 32

Detail per metadata:
  - boomdevs_metabox: 10 kali
  - litespeed_vpi_list: 8 kali
  - ova_met_footer_version: 5 kali
  - ova_met_main_layout: 9 kali

=================================================
⚠️  MODE DRY-RUN AKTIF
Tidak ada metadata yang benar-benar dihapus.
=================================================
```

### Saat Execute:
Output yang sama, tetapi metadata benar-benar dihapus dan ditandai `[DIHAPUS]`.

## Backup

Sebelum menjalankan pembersihan, disarankan untuk backup database:

```bash
# Backup menggunakan WP-CLI
wp db export backup-before-cleanup-$(date +%Y%m%d-%H%M%S).sql

# Atau backup manual
mysqldump -u username -p database_name > backup.sql
```

## Restore Jika Terjadi Masalah

Jika setelah pembersihan ada masalah, restore dari backup:

```bash
# Restore menggunakan WP-CLI
wp db import backup-before-cleanup-YYYYMMDD-HHMMSS.sql

# Atau restore manual
mysql -u username -p database_name < backup.sql
```

## Membersihkan Metadata Spesifik Saja

Jika Anda hanya ingin menghapus metadata tertentu, edit array `$metadata_to_clean` di file:

```php
// Contoh: Hanya hapus boomdevs_metabox
$metadata_to_clean = array(
    'boomdevs_metabox',
    // 'litespeed_vpi_list',  // Dikomentari = tidak dihapus
    // 'ova_met_footer_version',
);
```

## FAQ

### Q: Apakah ini akan menghapus konten post/page?
A: Tidak, script ini hanya menghapus metadata (pengaturan tambahan), bukan konten.

### Q: Apakah perlu backup?
A: Disarankan, meskipun risikonya kecil.

### Q: Bagaimana jika saya ingin mengembalikan metadata?
A: Anda perlu restore dari backup database. Metadata yang dihapus tidak bisa dikembalikan tanpa backup.

### Q: Apakah aman untuk production?
A: Ya, tetapi selalu jalankan dry-run terlebih dahulu dan buat backup.

### Q: Berapa lama prosesnya?
A: Tergantung jumlah post/page. Untuk 100 post biasanya < 1 menit.

## Troubleshooting

### Error: "Cannot modify header information"
Solusi: Jalankan via WP-CLI atau pastikan tidak ada output sebelum script.

### Error: "Permission denied"
Solusi: Pastikan Anda login sebagai admin atau jalankan via WP-CLI.

### Script tidak menghapus apa-apa
Solusi: Pastikan `$mode = 'execute';` sudah diubah.

## Rekomendasi

1. ✅ Jalankan dry-run terlebih dahulu
2. ✅ Buat backup database
3. ✅ Periksa hasil dry-run dengan teliti
4. ✅ Ubah mode ke 'execute'
5. ✅ Jalankan pembersihan
6. ✅ Verifikasi website masih berjalan normal
7. ✅ Hapus script setelah selesai

## Support

Jika ada masalah, silakan buat issue di GitHub repository atau hubungi developer.
