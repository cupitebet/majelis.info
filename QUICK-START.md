# 🚀 Quick Start: Upload WordPress ke GitHub

## ⚡ TL;DR - Langkah Cepat

```bash
# 1. Copy folder WordPress dari Hostinger ke repository ini
# (gunakan FTP, File Manager, atau SCP)

# 2. Jalankan helper script (RECOMMENDED!)
./commit-wordpress.sh

# ATAU commit manual per folder:
git add wp-admin/ && git commit -m "Add wp-admin" && git push
git add wp-includes/ && git commit -m "Add wp-includes" && git push
git add wp-content/themes/ && git commit -m "Add themes" && git push
git add wp-content/plugins/ && git commit -m "Add plugins" && git push
```

---

## 📋 Cara Upload File dari Hostinger

### Metode 1: File Manager (Paling Mudah)

1. **Login ke Hostinger:**
   - Buka https://hpanel.hostinger.com
   - Login dengan akun Anda

2. **Buka File Manager:**
   - Pilih hosting majelis.info
   - Klik "File Manager"

3. **Download Folder:**
   - Masuk ke folder `public_html`
   - Pilih folder: `wp-admin`, `wp-includes`, `wp-content`
   - Klik kanan → Download
   - Extract ZIP hasil download

4. **Copy ke Repository:**
   ```bash
   # Copy folder yang sudah di-extract ke folder repository
   cp -r /path/to/downloaded/wp-admin ./
   cp -r /path/to/downloaded/wp-includes ./
   cp -r /path/to/downloaded/wp-content ./
   ```

---

### Metode 2: FTP Client (Recommended untuk folder besar)

1. **Install FTP Client:**
   - Windows: FileZilla (https://filezilla-project.org/)
   - Mac: Cyberduck (https://cyberduck.io/)
   - Linux: `sudo apt install filezilla` atau `sudo yum install filezilla`

2. **Dapatkan FTP Credentials dari Hostinger:**
   - Login ke hPanel
   - Pilih hosting → FTP Accounts
   - Lihat/buat kredensial FTP:
     - **Host:** `ftp.majelis.info` atau IP server
     - **Username:** (dari hPanel)
     - **Password:** (dari hPanel)
     - **Port:** 21

3. **Connect & Download:**
   - Buka FileZilla
   - Masukkan Host, Username, Password, Port 21
   - Klik "Quickconnect"
   - Navigate ke `public_html`
   - Download folder: `wp-admin`, `wp-includes`, `wp-content`

4. **Copy ke Repository:**
   ```bash
   cp -r /path/to/downloaded/wp-admin ./
   cp -r /path/to/downloaded/wp-includes ./
   cp -r /path/to/downloaded/wp-content ./
   ```

---

### Metode 3: SSH/SCP (Fastest! Untuk advanced users)

```bash
# 1. Login ke Hostinger via SSH
ssh username@majelis.info

# 2. Buat archive
cd public_html
tar -czf wordpress-folders.tar.gz wp-admin/ wp-includes/ wp-content/

# 3. Download ke local (dari terminal local Anda)
scp username@majelis.info:~/public_html/wordpress-folders.tar.gz ./

# 4. Extract
tar -xzf wordpress-folders.tar.gz

# Folder wp-admin, wp-includes, wp-content sekarang ada di repository!
```

---

## ✅ Setelah Copy Folder

### Opsi A: Gunakan Helper Script (RECOMMENDED!)

```bash
# Jalankan script otomatis
./commit-wordpress.sh

# Script akan:
# ✓ Cek ukuran folder
# ✓ Commit per folder secara bertahap
# ✓ Push ke GitHub dengan retry otomatis
# ✓ Memberikan progress report
```

---

### Opsi B: Commit Manual

```bash
# 1. Cek ukuran dulu
du -sh wp-admin/ wp-includes/ wp-content/

# 2. Commit wp-admin
git add wp-admin/
git commit -m "Add wp-admin folder"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 3. Commit wp-includes
git add wp-includes/
git commit -m "Add wp-includes folder"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 4. Commit themes
git add wp-content/themes/
git commit -m "Add WordPress themes"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 5. Commit plugins
git add wp-content/plugins/
git commit -m "Add WordPress plugins"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 6. Commit sisanya (jika ada)
git add wp-content/
git commit -m "Add remaining wp-content files"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e
```

---

## 🔍 Verify Upload Berhasil

```bash
# Cek folder yang sudah ada
ls -la

# Seharusnya ada:
# ✓ wp-admin/
# ✓ wp-includes/
# ✓ wp-content/themes/
# ✓ wp-content/plugins/

# Cek di GitHub
# Buka: https://github.com/cupitebet/majelis.info
# Semua folder seharusnya terlihat
```

---

## ❓ Troubleshooting

### Problem: "File too large"

```bash
# Cari file > 50MB
find . -type f -size +50M -not -path "./.git/*"

# Exclude file besar dari .gitignore
echo "path/to/large/file" >> .gitignore

# Remove dari staging
git reset path/to/large/file
```

### Problem: Push timeout

```bash
# Commit folder lebih kecil lagi
# Atau increase buffer:
git config http.postBuffer 524288000

# Retry push
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e
```

### Problem: "wp-content/uploads/ terlalu besar"

```bash
# Jangan commit uploads! Sudah di .gitignore
# Cek .gitignore:
cat .gitignore | grep uploads

# Seharusnya ada: wp-content/uploads/
```

---

## 📚 Dokumentasi Lengkap

- **COMMIT-LARGE-FOLDERS.md** - Panduan detail commit folder besar
- **DEPLOYMENT.md** - Setup deployment Hostinger-GitHub
- **README.md** - Dokumentasi repository

---

## ✅ Checklist

- [ ] Folder downloaded dari Hostinger
- [ ] Folder di-copy ke repository
- [ ] wp-config.php TIDAK di-commit
- [ ] Jalankan `./commit-wordpress.sh` atau commit manual
- [ ] Verify di GitHub semua folder ada
- [ ] Setup FTP secrets untuk auto-deployment

---

## 🚀 SETUP AUTO-DEPLOY (PENTING!)

Setelah upload WordPress ke GitHub, setup auto-deploy agar setiap push otomatis sync ke Hostinger:

### Quick Setup (5 Menit):

**1. Ambil FTP Credentials**
- https://hpanel.hostinger.com → Files → FTP Accounts
- Copy: Host, Username, Password

**2. Add GitHub Secrets**
- https://github.com/cupitebet/majelis.info/settings/secrets/actions
- Add 3 secrets:
  - `FTP_SERVER` = `ftp.majelis.info`
  - `FTP_USERNAME` = dari Hostinger
  - `FTP_PASSWORD` = dari Hostinger

**3. Test Deploy**
```bash
git commit --allow-empty -m "test: auto-deploy"
git push origin main
```

**4. Verify**
- https://github.com/cupitebet/majelis.info/actions
- Workflow harus hijau ✅

✨ **Setelah ini, setiap push auto-deploy ke Hostinger!**

---

**Dokumentasi lengkap:**
- Auto-deploy FTP: `FTP-AUTO-DEPLOY-GUIDE.md`
- Git Integration: `HOSTINGER-GIT-INTEGRATION-GUIDE.md`
- Helper script: `bash scripts/verify-github-secrets.sh`

🚀 Happy Coding!
