# 🚀 Development & Editing Guide
# Edit & Optimize Website via GitHub atau Local

## 📋 Table of Contents
1. [Setup Development Environment](#setup-development-environment)
2. [Editing via GitHub Web](#editing-via-github-web)
3. [Editing via Local (Git Clone)](#editing-via-local)
4. [Editing via Claude Code](#editing-via-claude-code)
5. [WordPress Optimization](#wordpress-optimization)
6. [Deployment Workflow](#deployment-workflow)

---

## 🎯 Setup Development Environment

### Option 1: Edit di GitHub (No Setup Required!)

**Pros:**
- ✅ Tidak perlu install apapun
- ✅ Edit langsung di browser
- ✅ Auto-commit dan push
- ✅ Akses dari mana saja

**Cons:**
- ❌ Tidak bisa test di local
- ❌ Tidak ada syntax highlighting bagus
- ❌ Sulit untuk edit multiple files

**Best for:** Quick fixes, small edits, dokumentasi

---

### Option 2: Edit di Local (Recommended!)

**Pros:**
- ✅ Full IDE support (VSCode, PHPStorm, dll)
- ✅ Test di local sebelum push
- ✅ Edit multiple files sekaligus
- ✅ Better version control

**Cons:**
- ❌ Perlu install Git
- ❌ Perlu setup local environment

**Best for:** Development, major changes, testing

---

### Option 3: Edit via Claude Code (This Environment!)

**Pros:**
- ✅ AI-assisted coding
- ✅ Automatic commit & push
- ✅ Code analysis & suggestions
- ✅ No local setup needed

**Cons:**
- ❌ Requires Claude Code access
- ❌ Session-based (temporary)

**Best for:** Complex changes, refactoring, optimization

---

## 🌐 Editing via GitHub Web

### Method 1: Edit Single File

1. **Go to GitHub repository:**
   ```
   https://github.com/cupitebet/majelis.info
   ```

2. **Navigate to file:**
   - Browse folders → find file
   - Example: `wp-content/themes/your-theme/style.css`

3. **Click pencil icon (Edit):**
   - Make your changes
   - Scroll down to "Commit changes"
   - Add commit message
   - Click "Commit changes"

4. **Auto-deploy:**
   - If GitHub Actions configured, auto-deploy to Hostinger
   - If manual, sync via FTP or Hostinger Git

### Method 2: Create New File

1. **In repository folder:**
   - Click "Add file" → "Create new file"

2. **Name your file:**
   ```
   wp-content/themes/your-theme/custom.css
   ```

3. **Add content:**
   - Write or paste code
   - Commit with message

### Method 3: Upload Files

1. **Click "Add file" → "Upload files"**
2. **Drag & drop or choose files**
3. **Commit changes**

---

## 💻 Editing via Local

### Step 1: Clone Repository

```bash
# Clone repository
git clone git@github.com:cupitebet/majelis.info.git
cd majelis.info

# Or via HTTPS
git clone https://github.com/cupitebet/majelis.info.git
cd majelis.info
```

### Step 2: Setup Local WordPress (Optional)

**Option A: XAMPP (Windows/Mac/Linux)**

1. Install XAMPP: https://www.apachefriends.org/
2. Copy repository to: `C:\xampp\htdocs\majelis`
3. Create database via phpMyAdmin
4. Update wp-config.php dengan database local
5. Access: http://localhost/majelis

**Option B: Local by Flywheel (Recommended)**

1. Install Local: https://localwp.com/
2. Create new site
3. Copy theme/plugin files ke site folder
4. Sync dengan Git

**Option C: Docker**

```bash
# Create docker-compose.yml
version: '3'
services:
  wordpress:
    image: wordpress:latest
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
      WORDPRESS_DB_NAME: wordpress
    volumes:
      - ./:/var/www/html
  db:
    image: mysql:5.7
    environment:
      MYSQL_DATABASE: wordpress
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpress
      MYSQL_ROOT_PASSWORD: rootpassword

# Start
docker-compose up -d
```

### Step 3: Make Changes

```bash
# Create new branch untuk perubahan
git checkout -b feature/new-feature

# Edit files dengan editor favorit
code .  # VSCode
# atau
vim wp-content/themes/your-theme/style.css

# Check perubahan
git status
git diff
```

### Step 4: Commit & Push

```bash
# Add changes
git add .

# Commit
git commit -m "Update: deskripsi perubahan"

# Push ke GitHub
git push origin feature/new-feature

# Atau push ke main (jika auto-deploy)
git checkout main
git merge feature/new-feature
git push origin main
```

---

## 🤖 Editing via Claude Code (This Environment!)

### Current Setup

You're already here! This is Claude Code environment.

### How to Use:

1. **Tell me what to edit:**
   ```
   "Edit file wp-content/themes/your-theme/style.css
    and change primary color to #ff0000"
   ```

2. **I'll make changes:**
   - Read file
   - Make edits
   - Show you the changes

3. **Auto-commit & push:**
   - I can commit changes
   - Push to your branch
   - Create PR if needed

### Example Commands:

```
"Edit homepage template and add new section"
"Optimize all images in wp-content/uploads"
"Add caching to wp-config.php"
"Create custom plugin for contact form"
"Refactor theme functions.php"
```

---

## ⚡ WordPress Optimization

### 1. Performance Optimization

**A. Enable Caching**

Add to `wp-config.php` (before "That's all, stop editing!"):
```php
// Enable caching
define('WP_CACHE', true);
define('WP_CACHE_KEY_SALT', 'majelis.info_');
```

**B. Optimize Database**

```bash
# Via WP-CLI (if available on server)
wp db optimize

# Or via plugin: WP-Optimize
```

**C. Minify CSS/JS**

Install plugins:
- Autoptimize
- WP Rocket
- W3 Total Cache

**D. Image Optimization**

```bash
# Add to .gitignore (already done)
wp-content/uploads/  # Don't commit large images

# Use plugins:
- Smush
- ShortPixel
- Imagify
```

### 2. Code Optimization

**A. Clean up wp-content/themes/**

```bash
# Remove unused themes (keep only active theme)
# Example: Remove Twenty Twenty-Three if not used
rm -rf wp-content/themes/twentytwentythree
```

**B. Clean up wp-content/plugins/**

```bash
# Remove inactive plugins
# Keep only what you need
```

**C. Optimize functions.php**

```php
// Disable WordPress features you don't need
// Add to theme's functions.php

// Disable emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Disable embeds
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove query strings
function remove_query_strings() {
    if(!is_admin()) {
        add_filter('script_loader_src', 'remove_query_strings_split', 15);
        add_filter('style_loader_src', 'remove_query_strings_split', 15);
    }
}
add_action('init', 'remove_query_strings');
```

### 3. Security Optimization

**A. Harden wp-config.php**

```php
// Add security constants
define('DISALLOW_FILE_EDIT', true);  // Disable file editor
define('DISALLOW_FILE_MODS', true);  // Disable plugin/theme install
define('FORCE_SSL_ADMIN', true);     // Force SSL for admin
```

**B. Protect .htaccess**

Add to `.htaccess`:
```apache
# Protect wp-config.php
<files wp-config.php>
order allow,deny
deny from all
</files>

# Disable directory browsing
Options -Indexes

# Protect .htaccess
<files .htaccess>
order allow,deny
deny from all
</files>
```

**C. Security Headers**

Add to `.htaccess`:
```apache
# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
Header set Referrer-Policy "strict-origin-when-cross-origin"
```

### 4. SEO Optimization

**A. Install SEO Plugin**
- Yoast SEO
- Rank Math
- All in One SEO

**B. Optimize Permalinks**

```
Dashboard → Settings → Permalinks
Choose: Post name
```

**C. Create sitemap.xml**

Most SEO plugins auto-generate this.

### 5. Mobile Optimization

**A. Responsive Check**

```bash
# Test theme responsiveness
# Use browser dev tools (F12) → Toggle device toolbar
```

**B. AMP (Optional)**

Install AMP plugin for mobile-optimized pages.

---

## 🔄 Deployment Workflow

### Workflow 1: Manual FTP Sync

```bash
# After making changes locally
# Upload via FTP to Hostinger
# Tools: FileZilla, WinSCP
```

### Workflow 2: GitHub Actions (Auto-Deploy)

**Setup Required:**

1. **Add GitHub Secrets:**
   - Go to: Repository → Settings → Secrets
   - Add:
     - `FTP_SERVER`: ftp.majelis.info
     - `FTP_USERNAME`: your-ftp-username
     - `FTP_PASSWORD`: your-ftp-password

2. **Workflow already created:**
   - `.github/workflows/deploy-to-hostinger.yml`
   - Auto-deploys on push to `main` branch

**Usage:**
```bash
# Make changes
git add .
git commit -m "Update"

# Push to main → auto-deploy!
git push origin main
```

### Workflow 3: Hostinger Git Integration

**Setup:**

1. **In Hostinger hPanel:**
   - Go to: Git → Create New Repository
   - Repository URL: https://github.com/cupitebet/majelis.info.git
   - Branch: main
   - Path: /public_html

2. **Usage:**
   - Push to GitHub → Click "Pull" in Hostinger
   - Or setup auto-pull webhook

---

## 🎨 Common Editing Tasks

### Edit Theme CSS

```bash
# File location
wp-content/themes/your-theme/style.css

# Or child theme
wp-content/themes/your-theme-child/style.css

# Make changes
vim wp-content/themes/your-theme/style.css

# Commit
git add wp-content/themes/your-theme/style.css
git commit -m "Update: theme CSS styling"
git push
```

### Edit Theme PHP

```bash
# Common files
wp-content/themes/your-theme/functions.php      # Theme functions
wp-content/themes/your-theme/header.php         # Header template
wp-content/themes/your-theme/footer.php         # Footer template
wp-content/themes/your-theme/index.php          # Main template
wp-content/themes/your-theme/single.php         # Single post template
wp-content/themes/your-theme/page.php           # Page template
```

### Add Custom Plugin

```bash
# Create plugin folder
mkdir -p wp-content/plugins/my-custom-plugin

# Create main file
cat > wp-content/plugins/my-custom-plugin/my-plugin.php << 'EOF'
<?php
/**
 * Plugin Name: My Custom Plugin
 * Description: Custom functionality
 * Version: 1.0
 * Author: Your Name
 */

// Plugin code here
EOF

# Commit
git add wp-content/plugins/my-custom-plugin/
git commit -m "Add: custom plugin"
git push
```

### Update WordPress Core (Careful!)

```bash
# NOT recommended via Git
# Update via WordPress admin:
# Dashboard → Updates → Update Now

# Or via WP-CLI on server:
wp core update
```

---

## 🔧 Troubleshooting

### Changes not showing?

1. **Clear cache:**
   - Browser cache
   - WordPress cache (plugin)
   - Server cache (Hostinger)

2. **Hard refresh:**
   - Windows: Ctrl + F5
   - Mac: Cmd + Shift + R

3. **Check deployment:**
   - Verify files uploaded to server
   - Check GitHub Actions logs
   - Check Hostinger Git pull status

### Git conflicts?

```bash
# Pull latest changes first
git pull origin main

# Resolve conflicts manually
# Then commit
git add .
git commit -m "Resolve conflicts"
git push
```

### Permission errors?

```bash
# On server (via SSH)
chmod 755 wp-content/
chmod 644 wp-content/themes/your-theme/*.php
chmod 644 wp-content/themes/your-theme/*.css
```

---

## 📚 Best Practices

### ✅ DO:

1. **Always create branch untuk perubahan besar**
   ```bash
   git checkout -b feature/new-homepage
   ```

2. **Test di local sebelum push to production**

3. **Write clear commit messages**
   ```bash
   git commit -m "Fix: homepage layout responsive issue"
   git commit -m "Add: contact form validation"
   git commit -m "Update: optimize header.php performance"
   ```

4. **Regular backups**
   - Database backup via Hostinger
   - Files backup via Git (already done!)

5. **Keep WordPress & plugins updated**
   - Check dashboard regularly
   - Update via admin panel

### ❌ DON'T:

1. ❌ Don't edit directly on production without backup
2. ❌ Don't commit wp-config.php (already protected)
3. ❌ Don't commit wp-content/uploads/ (already protected)
4. ❌ Don't push broken code to main branch
5. ❌ Don't forget to test after changes

---

## 🚀 Quick Commands Reference

```bash
# Clone repository
git clone git@github.com:cupitebet/majelis.info.git

# Create branch
git checkout -b feature/my-feature

# Check status
git status

# Add changes
git add .
git add specific-file.php

# Commit
git commit -m "Message"

# Push
git push origin branch-name

# Pull latest
git pull origin main

# Merge branch
git checkout main
git merge feature/my-feature

# Delete branch
git branch -d feature/my-feature
```

---

## 📞 Need Help?

**Resources:**
- WordPress Docs: https://wordpress.org/support/
- Git Guide: https://git-scm.com/docs
- GitHub Guides: https://guides.github.com/
- Claude Code: Ask me anything!

**This Repository:**
- SECURITY-AUDIT.md - Security best practices
- QUICK-START.md - Getting started
- COMMIT-LARGE-FOLDERS.md - Working with large files
- DEPLOYMENT.md - Deployment setup

---

**Happy Coding! 🎉**

**You can now:**
- ✅ Edit files via GitHub web interface
- ✅ Edit locally and push to GitHub
- ✅ Use Claude Code for AI-assisted editing
- ✅ Auto-deploy to Hostinger
- ✅ Optimize WordPress performance
- ✅ Maintain security best practices
