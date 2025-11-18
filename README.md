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

## 📚 Dokumentasi

- [DEPLOYMENT.md](DEPLOYMENT.md) - Panduan lengkap setup Hostinger ↔️ GitHub
- [Hostinger Tutorials](https://www.hostinger.com/tutorials/)
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

## ✅ Status

- [x] Repository setup
- [x] SSH Key ditambahkan ke GitHub
- [x] .gitignore configured
- [x] GitHub Actions workflow ready
- [ ] Upload website files dari Hostinger
- [ ] Setup FTP secrets di GitHub
- [ ] Test auto-deployment

## 🆘 Bantuan

Jika ada masalah, check:
1. [DEPLOYMENT.md](DEPLOYMENT.md) untuk troubleshooting
2. GitHub Actions logs untuk error deployment
3. Hostinger error logs via hPanel

---

**Live Website:** https://majelis.info
