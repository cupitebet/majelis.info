# 🚀 FTP AUTO-DEPLOY SETUP GUIDE
# Automatic Deployment dari GitHub ke Hostinger

## 📋 Overview

Setup ini akan membuat:
- ✅ Setiap push ke branch `main` → Auto-deploy ke Hostinger
- ✅ Files otomatis sync ke server
- ✅ No manual upload needed
- ✅ Professional CI/CD workflow

---

## 🎯 STEP-BY-STEP SETUP

### STEP 1: Get FTP Credentials dari Hostinger

#### A. Login Hostinger hPanel

```
1. Buka: https://hpanel.hostinger.com
2. Login dengan email & password
3. Pilih hosting: majelis.info
```

#### B. Get FTP Information

```
Navigate to: Files → FTP Accounts

You'll see:
┌────────────────────────────────────────────┐
│  FTP Accounts                              │
├────────────────────────────────────────────┤
│                                            │
│  FTP Host: ftp.majelis.info               │
│  (or IP: xxx.xxx.xxx.xxx)                  │
│                                            │
│  FTP Username: u123456789_username         │
│                                            │
│  FTP Password: [Click to view]             │
│                                            │
│  FTP Port: 21                              │
│                                            │
└────────────────────────────────────────────┘

COPY these 3 values:
1. FTP_SERVER (host or IP)
2. FTP_USERNAME
3. FTP_PASSWORD
```

#### C. Alternative: Create New FTP Account

```
If you want dedicated account for GitHub:

1. Click "Create FTP Account"
2. Fill:
   - Username: github_deploy
   - Password: [Generate strong password]
   - Directory: /public_html
3. Click "Create"
4. Save credentials securely
```

---

### STEP 2: Add Secrets to GitHub

#### A. Go to Repository Settings

```
1. Open: https://github.com/cupitebet/majelis.info
2. Click "Settings" tab (top right)
3. Left sidebar → "Secrets and variables" → "Actions"
4. Click "New repository secret"
```

#### B. Add FTP_SERVER Secret

```
┌────────────────────────────────────────────┐
│  New secret                                │
├────────────────────────────────────────────┤
│                                            │
│  Name *                                    │
│  ┌──────────────────────────────────────┐ │
│  │ FTP_SERVER                           │ │
│  └──────────────────────────────────────┘ │
│                                            │
│  Secret *                                  │
│  ┌──────────────────────────────────────┐ │
│  │ ftp.majelis.info                     │ │
│  │ (or your IP address)                 │ │
│  └──────────────────────────────────────┘ │
│                                            │
│  ┌────────────────┐                        │
│  │ Add secret     │ ← CLICK                │
│  └────────────────┘                        │
│                                            │
└────────────────────────────────────────────┘

Values to use:
- Name: FTP_SERVER
- Secret: ftp.majelis.info (atau IP dari hPanel)
```

#### C. Add FTP_USERNAME Secret

```
Click "New repository secret" again

Name: FTP_USERNAME
Secret: u123456789_username (dari hPanel)

Click "Add secret"
```

#### D. Add FTP_PASSWORD Secret

```
Click "New repository secret" again

Name: FTP_PASSWORD
Secret: your-ftp-password (dari hPanel)

Click "Add secret"
```

#### E. Verify All Secrets Added

```
You should now see:
┌────────────────────────────────────────────┐
│  Repository secrets                        │
├────────────────────────────────────────────┤
│  FTP_SERVER         Updated 1 minute ago   │
│  FTP_USERNAME       Updated 1 minute ago   │
│  FTP_PASSWORD       Updated 1 minute ago   │
└────────────────────────────────────────────┘

✅ All 3 secrets configured!
```

---

### STEP 3: Enable GitHub Actions Workflow

Workflow sudah ada tapi disabled. Mari enable:

#### A. Check Current Workflow

```bash
# File already exists:
.github/workflows/deploy-to-hostinger.yml

# Currently set to manual trigger only
# We need to enable auto-trigger on push to main
```

#### B. Update Workflow File

Saya akan update file untuk enable auto-deploy:

---

### STEP 4: Test FTP Connection

Before enabling auto-deploy, let's test FTP connection:

---

### STEP 5: Enable Auto-Deploy

After test passes, enable full auto-deploy:

---

### STEP 6: Test Auto-Deploy

Make a test commit to verify:

```bash
# Make a small change
echo "# Auto-deploy test" >> TEST.md

# Commit
git add TEST.md
git commit -m "Test: auto-deploy to Hostinger"

# Push to main
git push origin main
```

Check GitHub Actions:
```
1. Go to: Actions tab on GitHub
2. See workflow running
3. Wait for completion (green checkmark)
4. Verify files on Hostinger
```

---

## 🔧 FTP AUTO-DEPLOY CONFIGURATION

### Current Workflow Features:

```yaml
Trigger: Push to main branch
Action: Deploy via FTP
Target: /public_html/
Excludes:
  - .git files
  - node_modules
  - .env files
  - Documentation files
```

### What Gets Deployed:

```
✅ CSS files (custom-homepage-design.css, etc)
✅ PHP files (if any)
✅ JavaScript files
✅ Images
✅ Theme files
✅ Plugin files

❌ NOT deployed:
❌ .git/
❌ .gitignore
❌ README.md files
❌ node_modules/
❌ .env files
```

---

## 🎯 USAGE AFTER SETUP

### Normal Workflow:

```bash
# 1. Make changes locally
vim custom-homepage-design.css

# 2. Commit changes
git add custom-homepage-design.css
git commit -m "Update: hero section gradient"

# 3. Push to main
git push origin main

# 4. Auto-deploy happens!
# ✅ GitHub Actions runs
# ✅ Files upload to Hostinger via FTP
# ✅ Website updates automatically
# ⏱️ Takes ~2-3 minutes
```

### Check Deployment Status:

```
1. Go to: https://github.com/cupitebet/majelis.info/actions
2. See latest workflow run
3. Click to see details
4. Green checkmark = Success ✅
5. Red X = Failed ❌ (check logs)
```

---

## 🔍 MONITORING & LOGS

### View Deployment Logs:

```
GitHub → Actions → Select workflow run

You'll see:
┌────────────────────────────────────────────┐
│  Deploy to Hostinger                       │
├────────────────────────────────────────────┤
│  ✓ Checkout code                          │
│  ✓ Deploy to Hostinger via FTP           │
│    ├─ Connecting to ftp.majelis.info...  │
│    ├─ Connected successfully              │
│    ├─ Uploading files...                  │
│    ├─ custom-homepage-design.css ✓       │
│    ├─ event-cards-optimization.css ✓     │
│    └─ Upload complete                     │
│  ✓ Deployment successful                  │
└────────────────────────────────────────────┘
```

---

## 🛠️ ADVANCED OPTIONS

### Deploy Specific Folder Only:

Edit workflow to deploy specific folder:

```yaml
with:
  server-dir: /public_html/wp-content/themes/meup/
  local-dir: ./theme-files/
```

### Deploy on Specific Branch:

```yaml
on:
  push:
    branches:
      - production  # Instead of main
```

### Manual Deployment:

```yaml
on:
  workflow_dispatch:  # Manual trigger via GitHub UI
```

Then trigger via:
```
GitHub → Actions → Deploy to Hostinger → Run workflow
```

---

## 🚨 TROUBLESHOOTING

### Deployment Fails?

#### Error: "FTP connection failed"

```
✅ Check FTP credentials in GitHub Secrets
✅ Verify FTP server is correct (ftp.majelis.info or IP)
✅ Check FTP port (should be 21)
✅ Test FTP manually (use FileZilla)
✅ Check Hostinger firewall settings
```

#### Error: "Permission denied"

```
✅ Check FTP user has write permissions
✅ Verify server-dir path is correct (/public_html/)
✅ Check folder permissions on server (755)
✅ Try using FTP user with full access
```

#### Error: "Secrets not found"

```
✅ Verify secrets names exactly match:
   - FTP_SERVER (not FTP-SERVER or ftp_server)
   - FTP_USERNAME (exact case)
   - FTP_PASSWORD (exact case)
✅ Re-add secrets if needed
✅ Check repository settings access
```

---

## 🔐 SECURITY BEST PRACTICES

### ✅ DO:

```
✅ Use strong FTP passwords (16+ characters)
✅ Create dedicated FTP user for GitHub
✅ Limit FTP user to /public_html only
✅ Use GitHub Secrets (never commit passwords)
✅ Enable 2FA on GitHub account
✅ Review deployment logs regularly
✅ Rotate FTP password quarterly
```

### ❌ DON'T:

```
❌ Never commit FTP credentials to code
❌ Don't use same password for everything
❌ Don't give FTP user more access than needed
❌ Don't share FTP credentials
❌ Don't deploy to root directory (/)
❌ Don't skip security updates
```

---

## 📊 DEPLOYMENT STATISTICS

After setup, you'll have:

```
Deployment Time: ~2-3 minutes
Success Rate: ~99% (with correct setup)
Manual Work: 0 (fully automated)
Cost: $0 (GitHub Actions free tier)

Before Auto-Deploy:
- Manual upload: 10-15 minutes
- Risk of errors: High
- Consistency: Low

After Auto-Deploy:
- Automatic: 2-3 minutes
- Risk of errors: Low
- Consistency: High ✅
```

---

## 🎓 NEXT LEVEL: CI/CD Pipeline

### Future Enhancements:

```
1. Add automated tests before deploy
2. Staging environment (test.majelis.info)
3. Rollback on failure
4. Slack/Email notifications
5. Database backup before deploy
6. PHP linting & validation
7. CSS/JS minification
8. Image optimization
```

---

## ✅ SETUP CHECKLIST

```
□ Step 1: Get FTP credentials from Hostinger
  □ FTP Host
  □ FTP Username
  □ FTP Password
  □ FTP Port (21)

□ Step 2: Add GitHub Secrets
  □ FTP_SERVER secret added
  □ FTP_USERNAME secret added
  □ FTP_PASSWORD secret added
  □ All 3 secrets verified

□ Step 3: Test FTP Connection
  □ Run test script
  □ Connection successful
  □ Upload test file works

□ Step 4: Enable Workflow
  □ Workflow file updated
  □ Auto-trigger enabled
  □ Committed & pushed

□ Step 5: Test Auto-Deploy
  □ Made test commit
  □ Pushed to main
  □ Workflow ran successfully
  □ Files appeared on server

□ Step 6: Verify & Monitor
  □ Check Actions tab regularly
  □ Test website after deploy
  □ Monitor for errors

✅ AUTO-DEPLOY FULLY CONFIGURED!
```

---

## 🎉 SUCCESS!

After setup complete:

```
✨ Every push to main → Auto-deploy to Hostinger
✨ No manual FTP upload needed
✨ Professional workflow
✨ Version controlled
✨ Audit trail in GitHub
✨ Team-ready (if needed)
```

---

## 📞 NEED HELP?

Common issues:

```
"FTP credentials not working"
→ I'll help verify and test connection

"Workflow not triggering"
→ I'll check workflow configuration

"Files not appearing on server"
→ I'll debug deployment path

"Want to customize deployment"
→ I'll help modify workflow
```

Just say:
- "Test my FTP connection"
- "Why did deployment fail?"
- "Customize deployment workflow"
- "Add deployment notifications"

---

Ready untuk setup FTP auto-deploy sekarang? Atau mau test FTP connection dulu? 🚀
