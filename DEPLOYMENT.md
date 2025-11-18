# 🚀 Deployment Guide: Hostinger ↔️ GitHub Integration

## 📋 Langkah-langkah Setup

### 1️⃣ Download Website dari Hostinger

**Opsi A: Via File Manager (Web)**
1. Login ke [Hostinger hPanel](https://hpanel.hostinger.com)
2. Pilih hosting **majelis.info**
3. Buka **File Manager**
4. Masuk ke folder `public_html`
5. Select All → Download as ZIP
6. Extract ZIP ke komputer Anda

**Opsi B: Via FTP**
1. Install FTP Client (FileZilla, WinSCP, dll)
2. Dapatkan kredensial FTP dari Hostinger:
   - Host: `ftp.majelis.info` atau IP server
   - Username: dari hPanel
   - Password: dari hPanel
   - Port: 21
3. Download semua file dari folder `public_html`

**Opsi C: Via SSH (Recommended - jika tersedia)**
```bash
# Login ke Hostinger via SSH
ssh username@majelis.info

# Zip semua file
cd public_html
tar -czf website-backup.tar.gz *

# Download ke komputer lokal
scp username@majelis.info:~/public_html/website-backup.tar.gz .
```

---

### 2️⃣ Upload ke GitHub Repository Ini

```bash
# Pindahkan file website ke folder repository ini
# Copy semua file dari public_html ke /home/user/majelis.info/

# Add semua file
git add .

# Commit dengan pesan yang jelas
git commit -m "Add website files from Hostinger"

# Push ke GitHub
git push -u origin claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e
```

---

### 3️⃣ Setup Auto-Deployment dari GitHub ke Hostinger

Hostinger mendukung **Git Deployment**! Ikuti langkah ini:

#### Di Hostinger hPanel:
1. Login ke [Hostinger hPanel](https://hpanel.hostinger.com)
2. Pilih hosting Anda
3. Cari menu **"Git"** atau pergi ke **Advanced → Git**
4. Klik **"Create New Repository"**
5. Isi informasi:
   - **Repository URL**: `https://github.com/cupitebet/majelis.info.git`
   - **Branch**: `main` (atau branch yang Anda inginkan)
   - **Target Path**: `/public_html` atau `/domains/majelis.info/public_html`
6. Klik **"Create"**

#### Setup Deploy Key (jika diminta):
1. Hostinger akan generate SSH key
2. Copy SSH public key yang diberikan
3. Pergi ke GitHub: **Settings → Deploy Keys**
4. Add New Deploy Key, paste key dari Hostinger
5. Centang **"Allow write access"** jika perlu

#### Test Deployment:
```bash
# Setiap kali Anda push ke GitHub:
git push origin main

# Hostinger akan otomatis pull perubahan!
```

---

### 4️⃣ Workflow Development

```bash
# 1. Buat perubahan di local
# Edit file website Anda...

# 2. Test di local (jika ada local server)

# 3. Commit perubahan
git add .
git commit -m "Update: deskripsi perubahan"

# 4. Push ke GitHub
git push origin main

# 5. Hostinger auto-deploy! ✅
```

---

## 🔧 Konfigurasi Tambahan

### Database Configuration
Jika website menggunakan database:
- **JANGAN** commit file `wp-config.php` atau `config.php`
- Gunakan environment variables atau config terpisah
- Update `.gitignore` untuk exclude sensitive files

### File Permissions
Setelah deployment, pastikan permission correct:
```bash
# Via SSH di Hostinger
chmod 755 public_html
chmod 644 public_html/*.php
chmod 644 public_html/*.html
```

---

## 📞 Troubleshooting

### Git deployment tidak jalan?
- Pastikan branch name benar
- Cek Deploy Key sudah ditambahkan di GitHub
- Cek path deployment di Hostinger sudah benar

### File tidak terupdate?
- Pastikan file tidak di-ignore di `.gitignore`
- Manual pull di Hostinger Git dashboard
- Cek file permission

### SSH Key Issues?
- Generate ulang SSH key di Hostinger
- Update Deploy Key di GitHub
- Test koneksi dari Hostinger dashboard

---

## 🎯 Next Steps

1. ✅ SSH Key sudah ditambahkan ke GitHub
2. 📁 Download file website dari Hostinger
3. 📤 Upload ke repository ini
4. 🔄 Setup auto-deployment di Hostinger
5. 🚀 Start development!

---

**Need Help?** Hubungi support:
- Hostinger: https://www.hostinger.com/tutorials/
- GitHub: https://docs.github.com/
