# majelis.info

Website repository untuk **majelis.info** yang di-hosting di Hostinger.

## 🌐 Tentang

Repository ini berisi source code website majelis.info dengan integrasi GitHub untuk version control dan auto-deployment ke Hostinger.

## 🚀 Quick Start

### Setup Awal

1. **Clone repository ini:**
   ```bash
   git clone git@github.com:cupitebet/majelis.info.git
   cd majelis.info
   ```

2. **Upload file website dari Hostinger:**
   - Download file dari Hostinger (via FTP/SSH/File Manager)
   - Copy semua file ke repository ini
   - Commit dan push

3. **Setup Auto-Deployment:**
   - Baca panduan lengkap di [DEPLOYMENT.md](DEPLOYMENT.md)

## 📁 Struktur Project

```
majelis.info/
├── .github/workflows/     # GitHub Actions untuk auto-deploy
├── DEPLOYMENT.md          # Panduan deployment lengkap
├── .gitignore            # File yang di-exclude dari Git
└── README.md             # File ini
```

## 🔄 Workflow Development

```bash
# 1. Buat perubahan
git checkout -b feature/nama-fitur

# 2. Commit perubahan
git add .
git commit -m "Add: deskripsi perubahan"

# 3. Push ke GitHub
git push origin feature/nama-fitur

# 4. Merge ke main untuk auto-deploy ke Hostinger
```

## 📚 Dokumentasi Lengkap

### 🚀 Getting Started
- [QUICK-START.md](QUICK-START.md) - **START HERE!** Panduan cepat upload website
- [DEPLOYMENT.md](DEPLOYMENT.md) - Setup Hostinger ↔️ GitHub integration
- [COMPLETENESS-REPORT.md](COMPLETENESS-REPORT.md) - Status kelengkapan website

### 📋 Project Planning (NEW!)
- [DEVELOPMENT-ROADMAP.md](DEVELOPMENT-ROADMAP.md) - **16-week complete implementation plan**
- [MEUP-OPTIMIZATION-PLAN.md](MEUP-OPTIMIZATION-PLAN.md) - MeUp theme optimization guide
- [MOBILE-APP-PLAN.md](MOBILE-APP-PLAN.md) - Mobile app development guide (Flutter)
- [DESIGN-IMPROVEMENTS.md](DESIGN-IMPROVEMENTS.md) - Design enhancement guide

### 💻 Development & Editing
- [DEVELOPMENT-GUIDE.md](DEVELOPMENT-GUIDE.md) - **Cara edit & optimize website**
- [COMMIT-LARGE-FOLDERS.md](COMMIT-LARGE-FOLDERS.md) - Commit folder WordPress yang besar

### 🔒 Security
- [SECURITY-AUDIT.md](SECURITY-AUDIT.md) - **PENTING! Baca ini untuk keamanan**

### 🔧 Helper Tools
- [commit-wordpress.sh](commit-wordpress.sh) - Script otomatis untuk commit bertahap

### 📖 External Resources
- [Hostinger Tutorials](https://www.hostinger.com/tutorials/)
- [WordPress Codex](https://codex.wordpress.org/)
- [GitHub Docs](https://docs.github.com/)

## 🔧 Setup Required

### GitHub Secrets (untuk auto-deployment via FTP)

Tambahkan secrets di GitHub repository settings:

1. `FTP_SERVER` - FTP server Hostinger (contoh: `ftp.majelis.info`)
2. `FTP_USERNAME` - Username FTP Anda
3. `FTP_PASSWORD` - Password FTP Anda

**Cara menambahkan:**
- GitHub Repository → Settings → Secrets and variables → Actions
- Klik "New repository secret"
- Tambahkan ketiga secrets di atas

## ✅ Setup Progress

### Completed ✅
- [x] Repository setup & initialization
- [x] SSH Key ditambahkan ke GitHub
- [x] .gitignore configured (protect sensitive files)
- [x] GitHub Actions workflow ready
- [x] Security audit completed
- [x] Documentation lengkap dibuat
- [x] Helper scripts dibuat

### Pending ⏳
- [ ] **Upload folder WordPress** (wp-admin, wp-includes, wp-content)
- [ ] **Change database password** (CRITICAL - credentials exposed)
- [ ] Setup FTP secrets di GitHub (untuk auto-deployment)
- [ ] Test auto-deployment
- [ ] (Optional) Clean Git history

### Current Status: 📊
```
WordPress Files:  25% (hanya root files)
Documentation:   100% ✅
Security:         75% (perlu ganti password)
Ready to Deploy:  50% (perlu upload folder)
```

## 🎯 Next Steps - Langkah Selanjutnya

### 1. 🔒 CRITICAL: Change Database Password
**⚠️ PRIORITAS TINGGI!** Database credentials exposed di Git history.

**Action:**
1. Login ke Hostinger hPanel
2. Databases → MySQL Databases
3. Find `u362428227_XCgMd` → Change Password
4. Update wp-config.php di server dengan password baru
5. ✅ Read: [SECURITY-AUDIT.md](SECURITY-AUDIT.md)

### 2. 📦 Upload WordPress Folders
Website belum lengkap! Perlu upload 3 folder penting:

**Action:**
1. Download dari Hostinger (FTP/File Manager)
   - wp-admin/
   - wp-includes/
   - wp-content/
2. Copy ke repository ini
3. Run: `./commit-wordpress.sh`
4. ✅ Read: [QUICK-START.md](QUICK-START.md)

### 3. 🚀 Setup Auto-Deployment (Optional)
**Action:**
1. Add GitHub Secrets (FTP credentials)
2. Test GitHub Actions workflow
3. ✅ Read: [DEPLOYMENT.md](DEPLOYMENT.md)

### 4. 💻 Start Editing & Optimizing
**Setelah upload selesai, Anda bisa:**
- Edit via GitHub web interface
- Edit via local Git clone
- Use Claude Code untuk AI-assisted editing
- ✅ Read: [DEVELOPMENT-GUIDE.md](DEVELOPMENT-GUIDE.md)

---

## 🆘 Bantuan & Support

### Dokumentasi
1. [SECURITY-AUDIT.md](SECURITY-AUDIT.md) - Security issues & fixes
2. [QUICK-START.md](QUICK-START.md) - Getting started guide
3. [DEVELOPMENT-GUIDE.md](DEVELOPMENT-GUIDE.md) - Edit & optimize website
4. [DEPLOYMENT.md](DEPLOYMENT.md) - Deployment troubleshooting

### Troubleshooting
- GitHub Actions logs untuk deployment errors
- Hostinger error logs via hPanel
- Check [COMMIT-LARGE-FOLDERS.md](COMMIT-LARGE-FOLDERS.md) untuk upload issues

### Contact
- GitHub Issues: Report bugs atau tanya
- Claude Code: Ask me anything!

---

## 📊 Repository Stats

- **Total Documentation:** 11 comprehensive guides (22,000+ words)
- **Project Planning:** ✅ Complete (4 new detailed guides)
- **Security Level:** 75% (needs password change)
- **Completeness:** 25% (needs WordPress folders)
- **Ready for Development:** ✅ Yes - Full roadmap available

---

**Live Website:** https://majelis.info
**Repository:** https://github.com/cupitebet/majelis.info
