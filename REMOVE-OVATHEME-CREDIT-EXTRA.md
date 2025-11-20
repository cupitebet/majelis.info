# REMOVE OVA-THEME CREDIT — Extra Guidance

This file contains backup steps, child theme guidance, WP-CLI quick commands, debugging tips, rollback instructions, and a final checklist.

---

## 🔐 Backup & Safety (WAJIB DILAKUKAN SEBELUM EDIT)

Sebelum mengubah theme atau menambahkan snippet PHP, selalu lakukan backup:

- Backup full theme folder (`wp-content/themes/meup` atau child) ke lokasi aman.
- Export database (via phpMyAdmin atau `wp db export backup.sql`).
- Jika situs menggunakan cache/plugin optimizer, matikan sementara cache saat testing.

Contoh perintah WP-CLI untuk export DB dan membuat backup zip theme:

```bash
wp db export db-backup-$(date +%F).sql
cd wp-content/themes
zip -r ../theme-backup-$(date +%F).zip meup meup-child
```

Simpan file backup di luar server publik (misal di local machine atau storage aman).

## 🧩 Menggunakan Child Theme (Rekomendasi)

Mengedit parent theme langsung berisiko hilang saat update. Gunakan child theme:

1. Buat child theme (WP-CLI contoh):

```bash
wp scaffold child-theme meup-child --parent_theme=meup --activate
```

2. Copy `footer.php` atau template footer yang relevan dari parent ke `meup-child` lalu edit.
3. Tambahkan modifikasi PHP/CSS di `meup-child/functions.php` agar perubahan aman dari update.

Contoh `functions.php` minimal untuk override footer:

```php
<?php
add_action('after_setup_theme', function() {
    // Hapus action footer credit parent jika ada
    remove_action('ova_footer_credits', 'ova_footer_credits_default');

    // Tambah custom credit
    add_action('ova_footer_credits', function() {
        echo '<div class="copyright-footer">© ' . date('Y') . ' Majelis.info</div>';
    }, 99);
});
```

## 🔎 Cara Menemukan Sumber Credit (Debugging Lanjutan)

Kalau selector CSS tidak bekerja, temukan sumber teks dengan cari di file theme/plugin:

```bash
# cari referensi 'ovatheme' di theme/plugin
grep -R "ovatheme" wp-content/themes wp-content/plugins || true

# cari nama action hook yang dipakai (misal 'ova_footer_credits')
grep -R "ova_footer_credits" -n wp-content/themes || true
```

Hasil `grep` biasanya langsung menunjukkan file template atau fungsi yang menambahkan credit.

## ⚙️ WP-CLI Quick Commands (untuk yang nyaman pakai CLI)

- Buat snippet PHP sebagai muatan sementara (misal di `wp-content/mu-plugins`):

```bash
# buat folder mu-plugins jika belum ada
mkdir -p wp-content/mu-plugins
cat > wp-content/mu-plugins/hide-ovatheme.php <<'PHP'
<?php
// mu-plugin: hide ovatheme footer credit early
add_action('init', function(){
    add_action('wp_head', function(){
        echo "<style>.site-footer a[href*=\"ovatheme\"]{display:none!important;}</style>";
    }, 9999);
});
PHP

# verify file exists
ls -l wp-content/mu-plugins/hide-ovatheme.php
```

Mu-plugins dijalankan lebih awal dan tidak mudah dinonaktifkan oleh pengguna biasa.

## 🔁 Revert / Rollback

Jika perubahan menyebabkan masalah:

1. Hapus snippet yang ditambahkan (`mu-plugins` atau Snippets plugin).
2. Restore backup theme atau file dengan unzip backup.
3. Restore DB jika perlu:

```bash
wp db import db-backup-YYYY-MM-DD.sql
```

## ✅ Final Checklist (Before Publish)

- [ ] Backup DB dan theme dibuat
- [ ] Perubahan dikerjakan di child theme atau mu-plugin
- [ ] Tested di incognito & device lain
- [ ] Clear WordPress cache & CDN cache
- [ ] Cross-check license status (Theme license valid)
- [ ] Commit perubahan ke repo (jika applicable) dengan pesan jelas

Contoh commit:

```bash
git add wp-content/themes/meup-child wp-content/mu-plugins/hide-ovatheme.php
git commit -m "chore: remove/override OvaTheme footer credit via child theme/mu-plugin"
git push
```

---

Jika Anda mau, saya bisa:
- Membuat file `wp-content/mu-plugins/hide-ovatheme.php` langsung di repo (opsional),
- Atau buatkan patch `meup-child/functions.php` yang siap deploy.

Pilih salah satu opsi dan saya lanjutkan.
