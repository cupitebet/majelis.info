# 📦 Panduan Commit Folder Besar (WordPress)

## 🎯 Strategi Commit Folder Besar

Folder WordPress seperti `wp-content`, `wp-includes`, dan `wp-admin` bisa sangat besar. Berikut cara terbaik untuk commit-nya:

---

## 📋 Langkah 1: Cek Ukuran Folder

Sebelum commit, cek dulu ukuran folder:

```bash
# Cek ukuran setiap folder
du -sh wp-content/
du -sh wp-includes/
du -sh wp-admin/

# Cek detail per subfolder
du -sh wp-content/*
```

**Rekomendasi:**
- ✅ Total < 100MB → Commit langsung sekaligus
- ⚠️ Total 100MB - 500MB → Commit per folder
- 🔴 Total > 500MB → Commit bertahap + cleanup

---

## 📋 Langkah 2: Optimize dengan .gitignore

Sebelum commit, pastikan file yang TIDAK PERLU di-exclude:

### File yang HARUS di-exclude:

```
wp-content/uploads/          # User uploaded files (gambar, video)
wp-content/cache/            # Cache files
wp-content/backups/          # Backup files
wp-content/upgrade/          # WordPress upgrade temp
*.log                        # Log files
error_log                    # PHP error logs
.htaccess.backup            # Backup files
```

### File yang PERLU di-commit:

```
wp-content/themes/           # Theme website (PENTING!)
wp-content/plugins/          # Plugins (PENTING!)
wp-includes/                 # WordPress core (PENTING!)
wp-admin/                    # Admin panel (PENTING!)
```

---

## 📋 Langkah 3: Commit Bertahap (Recommended)

### **Metode A: Commit Per Folder (Paling Aman)**

```bash
# 1. Commit wp-admin/ dulu
git add wp-admin/
git commit -m "Add wp-admin folder"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 2. Commit wp-includes/
git add wp-includes/
git commit -m "Add wp-includes folder"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 3. Commit wp-content/themes/
git add wp-content/themes/
git commit -m "Add WordPress themes"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 4. Commit wp-content/plugins/
git add wp-content/plugins/
git commit -m "Add WordPress plugins"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e

# 5. Commit sisanya (jika ada)
git add wp-content/
git commit -m "Add remaining wp-content files"
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e
```

**Keuntungan:**
- ✅ Lebih cepat per commit
- ✅ Lebih mudah track progress
- ✅ Lebih mudah rollback jika ada error
- ✅ Tidak timeout saat push

---

### **Metode B: Commit Sekaligus (Jika Total < 100MB)**

```bash
# Add semua folder sekaligus
git add wp-admin/ wp-includes/ wp-content/

# Commit dengan pesan yang jelas
git commit -m "Add WordPress core folders (wp-admin, wp-includes, wp-content)"

# Push ke GitHub
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e
```

---

## 📋 Langkah 4: Handle File Sangat Besar

Jika ada file **> 50MB**, GitHub akan reject. Solusinya:

### **Cek file besar:**

```bash
# Cari file > 50MB
find . -type f -size +50M -not -path "./.git/*"

# Cari file > 10MB
find . -type f -size +10M -not -path "./.git/*"
```

### **Solusi untuk file besar:**

**1. Exclude dari Git (Recommended untuk uploads):**
```bash
# Tambahkan ke .gitignore
echo "wp-content/uploads/*.zip" >> .gitignore
echo "wp-content/uploads/*.mp4" >> .gitignore
echo "wp-content/backup-*.sql" >> .gitignore
```

**2. Gunakan Git LFS (untuk file yang perlu di-track):**
```bash
# Install Git LFS (jika belum)
git lfs install

# Track file type tertentu
git lfs track "*.psd"
git lfs track "*.zip"

# Commit .gitattributes
git add .gitattributes
git commit -m "Setup Git LFS for large files"
```

---

## 📋 Langkah 5: Monitor Progress

Saat commit folder besar, monitor dengan:

```bash
# Cek ukuran staging area
git diff --cached --stat

# Cek jumlah file yang akan di-commit
git diff --cached --name-only | wc -l

# Cek total ukuran yang akan di-commit
git diff --cached --stat | tail -1
```

---

## 🚀 Quick Reference Guide

### **Scenario 1: Upload pertama kali (Full WordPress)**

```bash
# 1. Copy folder dari Hostinger ke repository
cp -r /path/from/hostinger/wp-admin ./
cp -r /path/from/hostinger/wp-includes ./
cp -r /path/from/hostinger/wp-content ./

# 2. Check ukuran
du -sh wp-*/

# 3. Commit bertahap
git add wp-admin/
git commit -m "Add wp-admin"
git push

git add wp-includes/
git commit -m "Add wp-includes"
git push

git add wp-content/themes/
git commit -m "Add themes"
git push

git add wp-content/plugins/
git commit -m "Add plugins"
git push
```

---

### **Scenario 2: Update beberapa file saja**

```bash
# Add file spesifik
git add wp-content/themes/your-theme/

# Commit dan push
git commit -m "Update theme"
git push
```

---

### **Scenario 3: Error "file too large"**

```bash
# 1. Cari file yang terlalu besar
find . -type f -size +50M -not -path "./.git/*"

# 2. Exclude file tersebut
echo "path/to/large/file.zip" >> .gitignore

# 3. Remove dari staging (jika sudah di-add)
git reset path/to/large/file.zip

# 4. Commit tanpa file besar
git commit -m "Add files (excluding large files)"
git push
```

---

## ⚡ Tips & Best Practices

### ✅ DO:
- Commit folder bertahap (per folder/subfolder)
- Exclude uploads, cache, dan backup files
- Cek ukuran sebelum commit
- Push secara berkala (jangan tunggu terlalu banyak commits)
- Gunakan commit message yang jelas

### ❌ DON'T:
- Jangan commit wp-content/uploads/ (user uploads)
- Jangan commit file backup/cache
- Jangan commit file > 50MB tanpa Git LFS
- Jangan commit wp-config.php (credentials!)
- Jangan commit semua sekaligus jika total > 500MB

---

## 🔧 Troubleshooting

### **Problem: Push timeout/fail**

```bash
# Solusi 1: Increase buffer size
git config http.postBuffer 524288000

# Solusi 2: Push dengan compression
git config core.compression 9

# Solusi 3: Commit lebih kecil lagi
# Split commit menjadi lebih kecil
```

### **Problem: Out of memory**

```bash
# Increase git memory
git config pack.windowMemory "100m"
git config pack.packSizeLimit "100m"
git config pack.threads "1"
```

### **Problem: File sudah ter-commit tapi seharusnya di-ignore**

```bash
# Remove dari Git (tapi tetap di local)
git rm --cached path/to/file

# Tambahkan ke .gitignore
echo "path/to/file" >> .gitignore

# Commit perubahan
git commit -m "Remove ignored files from Git"
git push
```

---

## 📞 Estimated Time

| Folder Size | Method | Estimated Time |
|-------------|--------|----------------|
| < 50MB | Single commit | 1-5 menit |
| 50-200MB | Per folder | 5-15 menit |
| 200-500MB | Bertahap | 15-30 menit |
| > 500MB | Cleanup + bertahap | 30-60 menit |

**Note:** Waktu tergantung koneksi internet Anda!

---

## ✅ Checklist

Sebelum commit, pastikan:

- [ ] Sudah exclude wp-content/uploads/
- [ ] Sudah exclude cache dan backup files
- [ ] Sudah cek ukuran folder dengan `du -sh`
- [ ] Tidak ada file > 50MB (atau sudah setup Git LFS)
- [ ] wp-config.php tidak di-commit
- [ ] .gitignore sudah configured
- [ ] Commit message jelas dan deskriptif

---

**Happy Coding! 🚀**
