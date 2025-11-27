# 🚀 Hostinger Git Integration Setup Guide
## Auto-Deploy GitHub → Hostinger (Native, No FTP Needed!)

**⭐ RECOMMENDED METHOD - Lebih mudah, cepat, dan stabil dari FTP**

---

## 📋 Apa itu Hostinger Git Integration?

Fitur native Hostinger yang memungkinkan:
- ✅ **Auto-pull** dari GitHub setiap kali ada push
- ✅ **Tidak perlu GitHub Actions** (hemat resource)
- ✅ **Lebih cepat** dari FTP upload
- ✅ **Lebih reliable** - direct SSH connection
- ✅ **One-time setup** - setelah itu auto-sync

---

## 🎯 STEP-BY-STEP SETUP

### STEP 1: Login ke Hostinger hPanel

```
1. Buka: https://hpanel.hostinger.com
2. Login dengan email & password
3. Pilih hosting: majelis.info
```

---

### STEP 2: Buka Git Version Control

```
Navigation:
┌─────────────────────────────────────────┐
│ Hostinger hPanel                        │
├─────────────────────────────────────────┤
│                                         │
│ Dashboard                               │
│ ├─ Websites                            │
│ ├─ Hosting                             │
│ ├─ Email                               │
│ └─ Advanced ◀── CLICK HERE             │
│     ├─ SSH Access                      │
│     ├─ Cron Jobs                       │
│     └─ Git Version Control ◀── PILIH   │
│                                         │
└─────────────────────────────────────────┘

Atau langsung search: "Git" di search box
```

**Catatan:** Beberapa hosting panel Hostinger versi baru:
```
Advanced → Developer → Git
atau
Tools → Git Version Control
```

---

### STEP 3: Create New Repository

Klik tombol **"Create New Repository"** atau **"+ New Repository"**

Anda akan melihat form seperti ini:

```
┌────────────────────────────────────────────────┐
│  Create Git Repository                         │
├────────────────────────────────────────────────┤
│                                                │
│  Repository URL *                              │
│  ┌──────────────────────────────────────────┐ │
│  │ https://github.com/cupitebet/           │ │
│  │ majelis.info.git                        │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  Branch *                                      │
│  ┌──────────────────────────────────────────┐ │
│  │ main                                     │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  Repository Path *                             │
│  ┌──────────────────────────────────────────┐ │
│  │ /public_html                             │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  ┌────────────────┐                            │
│  │ Create         │ ◀── CLICK                  │
│  └────────────────┘                            │
│                                                │
└────────────────────────────────────────────────┘
```

**Isi dengan:**
- **Repository URL:** `https://github.com/cupitebet/majelis.info.git`
- **Branch:** `main`
- **Repository Path:** `/public_html`

**⚠️ PENTING:** 
- Path harus `/public_html` (bukan `public_html` atau `/public_html/`)
- Branch harus exact: `main` (bukan `master`)

---

### STEP 4: Copy SSH Deploy Key

Setelah klik **Create**, Hostinger akan generate **SSH Deploy Key**.

Anda akan melihat layar seperti ini:

```
┌────────────────────────────────────────────────┐
│  Repository Created Successfully!              │
├────────────────────────────────────────────────┤
│                                                │
│  ⚠️ Add this deploy key to your GitHub        │
│                                                │
│  SSH Public Key:                               │
│  ┌──────────────────────────────────────────┐ │
│  │ ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAAB... │ │
│  │ ...very long key...                      │ │
│  │ ...ends with hostinger.com               │ │
│  │                                          │ │
│  │  [📋 Copy to Clipboard]  ◀── CLICK       │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  Repository will NOT work until you add       │
│  this key to GitHub Deploy Keys.              │
│                                                │
└────────────────────────────────────────────────┘
```

**Klik tombol "Copy to Clipboard"** atau select & copy manual.

**⚠️ JANGAN TUTUP TAB INI DULU** - kita butuh key ini untuk GitHub!

---

### STEP 5: Add Deploy Key ke GitHub

#### A. Buka GitHub Repository Settings

```
1. Buka: https://github.com/cupitebet/majelis.info
2. Klik tab "Settings" (paling kanan di menu atas)
3. Sidebar kiri → "Deploy keys"
4. Klik tombol "Add deploy key"
```

#### B. Add SSH Key

Anda akan melihat form:

```
┌────────────────────────────────────────────────┐
│  Add new deploy key                            │
├────────────────────────────────────────────────┤
│                                                │
│  Title                                         │
│  ┌──────────────────────────────────────────┐ │
│  │ Hostinger Auto-Deploy                    │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  Key                                           │
│  ┌──────────────────────────────────────────┐ │
│  │ ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAAB... │ │
│  │ (paste SSH key dari Hostinger)           │ │
│  │                                          │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  ☐ Allow write access                         │
│     (Leave UNCHECKED - read-only is safer)    │
│                                                │
│  ┌────────────────┐                            │
│  │ Add key        │ ◀── CLICK                  │
│  └────────────────┘                            │
│                                                │
└────────────────────────────────────────────────┘
```

**Isi dengan:**
- **Title:** `Hostinger Auto-Deploy` (atau nama lain yang deskriptif)
- **Key:** Paste SSH public key dari Hostinger (dari Step 4)
- **Allow write access:** ❌ **JANGAN CENTANG** (read-only lebih aman)

**Klik "Add key"**

✅ GitHub akan menampilkan konfirmasi: "Deploy key was successfully added"

---

### STEP 6: Verify Setup di Hostinger

Kembali ke **Hostinger hPanel → Git Version Control**

Anda sekarang akan melihat repository Anda terdaftar:

```
┌────────────────────────────────────────────────┐
│  Git Repositories                              │
├────────────────────────────────────────────────┤
│                                                │
│  ┌──────────────────────────────────────────┐ │
│  │ 📦 majelis.info                          │ │
│  │                                          │ │
│  │ URL: github.com/cupitebet/majelis.info   │ │
│  │ Branch: main                             │ │
│  │ Path: /public_html                       │ │
│  │                                          │ │
│  │ Status: ✅ Connected                     │ │
│  │                                          │ │
│  │ [Pull Changes] [Settings] [Delete]       │ │
│  └──────────────────────────────────────────┘ │
│                                                │
└────────────────────────────────────────────────┘
```

**Status harus "Connected" atau hijau ✅**

Jika ada error merah, kemungkinan:
- Deploy key belum ditambahkan di GitHub
- Repository URL salah
- Branch name salah

---

### STEP 7: Initial Pull (Deploy Pertama Kali)

Klik tombol **"Pull Changes"** atau **"Deploy Now"**

Hostinger akan:
```
1. ⬇️  Clone repository dari GitHub
2. 📂 Extract ke /public_html
3. ✅ Setup complete!
```

**Proses ini bisa 2-5 menit** tergantung ukuran repository.

Anda akan melihat progress:

```
┌────────────────────────────────────────────────┐
│  Deploying...                                  │
├────────────────────────────────────────────────┤
│                                                │
│  ✓ Connecting to GitHub...                    │
│  ✓ Authenticating with SSH key...             │
│  ✓ Cloning repository...                       │
│  ⏳ Extracting files... (2.3 MB)               │
│                                                │
│  Progress: ████████░░ 80%                      │
│                                                │
└────────────────────────────────────────────────┘
```

**Tunggu sampai selesai:**

```
┌────────────────────────────────────────────────┐
│  ✅ Deployment Successful!                     │
├────────────────────────────────────────────────┤
│                                                │
│  Files deployed to: /public_html               │
│  Commit: a1b2c3d "Latest commit message"       │
│  Time: 2024-01-15 14:30:25                     │
│                                                │
│  [View Files] [Pull Again]                     │
│                                                │
└────────────────────────────────────────────────┘
```

---

### STEP 8: Verify Website

Buka website Anda: **https://majelis.info**

Pastikan:
- ✅ Website loading
- ✅ File-file dari GitHub muncul
- ✅ Tidak ada error 404

Jika ada masalah:
```bash
# Check via File Manager
Hostinger hPanel → File Manager → public_html

Pastikan folder/file dari GitHub muncul:
- wp-admin/
- wp-content/
- wp-includes/
- index.php
- dll.
```

---

## 🔄 AUTO-DEPLOY: Cara Kerjanya

### Setelah Setup Complete:

**Setiap kali Anda push ke GitHub:**

```bash
# 1. Buat perubahan di local
vim custom-homepage-design.css

# 2. Commit
git add custom-homepage-design.css
git commit -m "Update: hero section gradient"

# 3. Push ke main
git push origin main

# ✅ HOSTINGER AUTO-PULL!
# Website otomatis update dalam 1-2 menit
```

**Hostinger akan:**
1. Detect push baru di GitHub (via webhook)
2. Otomatis pull perubahan terbaru
3. Extract ke `/public_html`
4. Website langsung update! ✨

**Tidak perlu:**
- ❌ Manual FTP upload
- ❌ GitHub Actions
- ❌ Manual trigger
- ❌ Wait time

---

## ⚙️ KONFIGURASI AUTO-PULL (Optional)

### Enable Automatic Pull

Beberapa versi Hostinger memerlukan enable webhook:

```
Git Version Control → Repository Settings → Auto-Deploy

☑️ Enable automatic deployment
☑️ Deploy on push to main branch
☐ Deploy on pull request (optional)

Webhook URL: (auto-generated by Hostinger)
```

**Webhook akan auto-setup** - Anda tidak perlu konfigurasi manual di GitHub!

---

## 🔍 MONITORING & LOGS

### View Deployment History

```
Git Version Control → Repository → History

┌────────────────────────────────────────────────┐
│  Deployment History                            │
├────────────────────────────────────────────────┤
│                                                │
│  ✅ 2024-01-15 14:30  main  a1b2c3d           │
│     "Update: hero section gradient"            │
│                                                │
│  ✅ 2024-01-15 12:15  main  x9y8z7w           │
│     "Add: new event cards CSS"                 │
│                                                │
│  ✅ 2024-01-14 18:45  main  p5q4r3s           │
│     "Fix: mobile responsive footer"            │
│                                                │
└────────────────────────────────────────────────┘
```

Click untuk detail:
- Files changed
- Commit message
- Deployment status
- Error logs (jika ada)

---

## 🛠️ ADVANCED CONFIGURATION

### Deploy Specific Folder Only

Jika Anda hanya mau deploy folder tertentu:

```
Repository Path: /public_html/wp-content/themes/meup
```

Maka hanya folder `themes/meup` dari GitHub yang akan di-deploy.

**Use case:**
- Deploy theme saja (bukan full WordPress)
- Deploy custom folder
- Multiple repositories ke path berbeda

---

### Deploy from Non-Main Branch

```
Branch: staging    # Instead of main
Path: /public_html/staging
```

**Use case:**
- Staging environment di subdomain
- Test changes sebelum production
- Multiple environments

---

### Exclude Files

Hostinger otomatis exclude:
- `.git/`
- `.gitignore`
- `README.md` (optional, bisa diatur)

Untuk custom exclude, tambahkan `.gitattributes`:

```bash
# .gitattributes
node_modules/ export-ignore
.env export-ignore
*.log export-ignore
```

---

## 🚨 TROUBLESHOOTING

### Error: "Authentication Failed"

**Cause:** Deploy key tidak ditambahkan atau salah

**Fix:**
```
1. Check GitHub → Settings → Deploy keys
2. Pastikan key dari Hostinger ada di list
3. Key harus exact match (no extra spaces)
4. Re-generate key di Hostinger jika perlu
5. Update di GitHub
```

---

### Error: "Repository Not Found"

**Cause:** Repository URL salah atau private

**Fix:**
```
1. Verify URL exact: 
   https://github.com/cupitebet/majelis.info.git
2. Check repository is accessible (public atau deploy key valid)
3. Pastikan tidak ada typo di username/repo name
```

---

### Error: "Permission Denied"

**Cause:** SSH key tidak punya akses

**Fix:**
```
1. Re-generate deploy key di Hostinger
2. Delete old key di GitHub
3. Add new key di GitHub
4. Test connection di Hostinger
```

---

### Files Not Updating After Push

**Cause:** Auto-deploy tidak enabled atau webhook issue

**Fix:**
```
1. Manual pull di Hostinger Git panel
2. Check auto-deploy settings
3. Verify webhook di GitHub:
   Settings → Webhooks → Check recent deliveries
4. Clear cache (jika pakai CDN/caching)
```

**Force manual pull:**
```
Hostinger → Git → Repository → [Pull Changes]
```

---

### Deployment Slow (>5 minutes)

**Cause:** Large repository size

**Solutions:**
```
1. Gunakan .gitattributes untuk exclude files
2. Separate deployment (theme only, not full WP)
3. Optimize repository (remove large assets)
4. Use CDN for images/videos
```

---

## 🔐 SECURITY BEST PRACTICES

### ✅ DO:

```
✅ Use deploy keys (read-only)
✅ Don't enable "write access" di deploy key
✅ Monitor deployment history regularly
✅ Use .gitignore untuk exclude sensitive files
✅ Rotate deploy keys setiap 6 bulan
✅ Enable 2FA di GitHub account
✅ Review file permissions di server
```

### ❌ DON'T:

```
❌ Jangan commit wp-config.php dengan credentials
❌ Jangan commit .env files
❌ Jangan enable write access untuk deploy key
❌ Jangan share SSH private keys
❌ Jangan deploy ke root directory (/)
❌ Jangan skip backup sebelum deployment
```

---

## 📊 COMPARISON: Git vs FTP Deploy

| Feature | Hostinger Git | FTP Deploy |
|---------|--------------|------------|
| **Setup Time** | 5 min | 10 min |
| **Speed** | ⚡ Fast (SSH) | 🐌 Slow (FTP) |
| **Reliability** | ✅ High | ⚠️ Medium |
| **Auto-Deploy** | ✅ Native | Needs GitHub Actions |
| **Resource Use** | 💚 Low | 💛 Medium |
| **Maintenance** | ✅ Zero | ⚠️ Check workflows |
| **Rollback** | ✅ Easy | ❌ Manual |
| **Cost** | 💚 Free | 💚 Free |

**Winner: Hostinger Git Integration** ⭐

---

## 🎯 MIGRATION: From FTP to Git Deploy

Jika Anda currently pakai FTP auto-deploy:

### Migration Steps:

```bash
# 1. Disable GitHub Actions workflow
# Edit: .github/workflows/deploy-to-hostinger.yml

# Comment out trigger:
# on:
#   push:
#     branches:
#       - main

# Keep workflow_dispatch for manual backup option

# 2. Setup Git integration (follow steps above)

# 3. Test Git deployment:
git commit --allow-empty -m "test: Git deployment"
git push origin main

# 4. Verify di Hostinger Git panel

# 5. Commit workflow changes
git add .github/workflows/deploy-to-hostinger.yml
git commit -m "chore: migrate to Hostinger Git integration"
git push origin main
```

**Benefits:**
- ✅ Faster deployments
- ✅ Simpler setup
- ✅ One less GitHub Actions usage
- ✅ Native Hostinger feature

---

## ✅ SETUP CHECKLIST

```
Step 1: Hostinger hPanel
  ☐ Login ke hPanel
  ☐ Navigate ke Git Version Control
  
Step 2: Create Repository
  ☐ Repository URL: github.com/cupitebet/majelis.info.git
  ☐ Branch: main
  ☐ Path: /public_html
  ☐ Click Create
  
Step 3: SSH Deploy Key
  ☐ Copy SSH public key dari Hostinger
  ☐ Don't close tab yet
  
Step 4: GitHub Deploy Keys
  ☐ Open GitHub → Settings → Deploy keys
  ☐ Add deploy key
  ☐ Title: Hostinger Auto-Deploy
  ☐ Paste SSH key
  ☐ DON'T check "write access"
  ☐ Click Add key
  
Step 5: Initial Deploy
  ☐ Back to Hostinger Git panel
  ☐ Status shows "Connected" ✅
  ☐ Click "Pull Changes"
  ☐ Wait for deployment complete
  
Step 6: Verify
  ☐ Visit https://majelis.info
  ☐ Website loads correctly
  ☐ Files from GitHub present
  
Step 7: Test Auto-Deploy
  ☐ Make test commit & push
  ☐ Check Hostinger auto-pulls
  ☐ Website updates automatically
  
Step 8: Configure (Optional)
  ☐ Enable auto-deploy if not default
  ☐ Set up notifications (optional)
  ☐ Review exclude patterns

✅ GIT INTEGRATION FULLY CONFIGURED!
```

---

## 🎉 SUCCESS!

Setelah setup complete:

```
✨ Push to main → Auto-deploy dalam 1-2 menit
✨ No manual work needed
✨ Fast & reliable
✨ Native Hostinger feature
✨ Professional workflow
✨ Zero maintenance
```

**Your workflow now:**

```bash
# Make changes
vim file.css

# Commit
git commit -am "update styles"

# Push
git push

# ✅ Done! Website updates automatically!
```

---

## 🆘 NEED HELP?

Kalau ada error:

```
"Deploy key tidak work"
→ Saya akan help verify key setup

"Auto-deploy tidak jalan"
→ Saya akan check webhook configuration

"Files tidak muncul di server"
→ Saya akan debug path & permissions

"Want to customize deployment"
→ Saya akan help dengan advanced config
```

Just say:
- "Test Git deployment"
- "Verify deploy key"
- "Check deployment logs"
- "Setup staging environment"

---

**Ready untuk setup sekarang?** 🚀

Atau mau saya:
1. Buatkan script test deployment
2. Update workflow yml untuk backup
3. Setup staging environment config
4. Lainnya?
