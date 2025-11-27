# 🚀 FTP Auto-Deploy Setup Guide

GitHub Actions sudah dikonfigurasi untuk auto-deploy ke Hostinger setiap kali ada push ke branch `main`.

## 📋 Setup GitHub Secrets (PENTING!)

Anda perlu menambahkan 3 secrets di GitHub:

### Langkah-langkah:

1. **Buka Settings Secrets:**
   ```
   https://github.com/cupitebet/majelis.info/settings/secrets/actions
   ```

2. **Klik "New repository secret"** dan tambahkan 3 secrets berikut:

   **Secret 1: FTP_SERVER**
   - Name: `FTP_SERVER`
   - Value: `ftp.majelis.info`

   **Secret 2: FTP_USERNAME**
   - Name: `FTP_USERNAME`
   - Value: `u362428227.github`

   **Secret 3: FTP_PASSWORD**
   - Name: `FTP_PASSWORD`
   - Value: `Muhammad1545616..`

3. **Klik "Add secret"** untuk setiap secret

## 🎯 Cara Kerja Auto-Deploy

### Automatic Deploy (Otomatis)
Workflow akan otomatis running setiap kali:
- Ada `git push` ke branch `main`
- File akan otomatis diupload ke server

### Manual Deploy
Anda juga bisa trigger deploy manual:
1. Go to: https://github.com/cupitebet/majelis.info/actions
2. Pilih workflow "Deploy to Hostinger"
3. Klik "Run workflow"
4. Pilih branch `main`
5. Klik tombol hijau "Run workflow"

## 📁 File yang Akan Diupload

File yang **AKAN** diupload:
- ✅ Semua file WordPress core (wp-*.php, index.php, dll)
- ✅ Folder `wp-content/` (themes, plugins, uploads)
- ✅ `.htaccess`
- ✅ `manifest.json`, `sw.js`, `offline.html` (PWA files)
- ✅ Custom styles: `majelis-custom-styles-snippet.php`, `majelis-master-styles.css`

File yang **TIDAK** diupload (exclude):
- ❌ `.git/`, `.github/` folders
- ❌ Semua file dokumentasi (*.md)
- ❌ Scripts: `commit-wordpress.sh`, `flutter-quick-setup.sh`
- ❌ Folder: `flutter-app-structure/`, `_deprecated/`, `scripts/`
- ❌ Backup files: `.htaccess.bk`, `wp-admin.zip`
- ❌ Config samples: `wp-config-SAMPLE.txt`

## 🔍 Monitor Deployment

Untuk melihat status deployment:
1. Go to: https://github.com/cupitebet/majelis.info/actions
2. Klik workflow run yang sedang berjalan
3. Lihat logs untuk detail proses upload

## ⚠️ Catatan Penting

1. **wp-config.php** di-exclude untuk keamanan. Jika perlu update wp-config.php, upload manual via FTP/cPanel
2. Path server: `/home/u362428227/domains/majelis.info/public_html/`
3. Deployment menggunakan FTP biasa (bukan FTPS/SFTP) di port 21

## 🐛 Troubleshooting

### Deployment Failed?
- Pastikan secrets sudah diset dengan benar
- Cek apakah FTP credentials masih valid
- Lihat error logs di GitHub Actions

### File tidak terupload?
- Cek apakah file ada di exclude list
- Verify path file di repository

### Connection timeout?
- Hostinger mungkin sedang maintenance
- Coba run workflow lagi (retry)

## 🎉 Next Steps

Setelah setup secrets:
1. Commit & push changes ke branch `main`
2. Workflow akan otomatis running
3. File akan diupload ke server
4. Cek website: https://majelis.info

---

**Dibuat:** 2025-11-27
**Workflow File:** `.github/workflows/deploy-to-hostinger.yml`
