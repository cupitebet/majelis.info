# WordPress Dashboard Setup Guide - Majelis.info

**Panduan lengkap setting WordPress dashboard untuk implementasi optimal semua fitur dan file yang sudah dibuat.**

---

## 📋 Table of Contents

1. [Theme Settings (MeUp Theme)](#1-theme-settings-meup-theme)
2. [Appearance Settings](#2-appearance-settings)
3. [Plugin Requirements](#3-plugin-requirements)
4. [Permalink Settings](#4-permalink-settings)
5. [Reading Settings](#5-reading-settings)
6. [WooCommerce Settings](#6-woocommerce-settings)
7. [Menu Setup](#7-menu-setup)
8. [Homepage Setup](#8-homepage-setup)
9. [Event Settings](#9-event-settings)
10. [Performance Optimization](#10-performance-optimization)

---

## 1. Theme Settings (MeUp Theme)

### 🎯 Location: `Dashboard → MeUp Settings → General Options`

#### **Logo & Branding**
```
✅ Site Logo: Upload logo baru (recommended size: 200x60px)
✅ Site Icon (Favicon): 512x512px PNG
✅ Footer Logo: Bisa sama atau berbeda dari header logo
```

#### **Color Scheme** (Sesuaikan dengan CSS yang sudah dibuat)
```
Primary Color:   #1E40AF (Blue)
Secondary Color: #059669 (Green)
Accent Color:    #F59E0B (Orange)
Text Color:      #1F2937 (Dark Gray)
Background:      #FFFFFF (White)
```

**Path:** `Dashboard → Appearance → Customize → Colors`

#### **Typography**
```
Heading Font: Poppins (Bold/SemiBold)
Body Font:    Inter (Regular)
Font Size:    16px (base)
```

**Path:** `Dashboard → Appearance → Customize → Typography`

---

## 2. Appearance Settings

### 🎨 Location: `Dashboard → Appearance → Customize`

#### **A. Additional CSS** (PALING PENTING!)
```
1. Go to: Appearance → Customize → Additional CSS
2. Copy isi dari file: custom-homepage-design.css
3. Paste ke Additional CSS box
4. Scroll down dalam CSS box
5. Copy isi dari file: event-cards-optimization.css
6. Paste di bawah CSS sebelumnya
7. Click "Publish"
```

**Verification:**
- Visit https://majelis.info
- Homepage harus tampil dengan hero section baru
- Event cards harus punya hover effect
- Colors harus sesuai (Blue/Green/Orange)

#### **B. Site Identity**
```
Dashboard → Appearance → Customize → Site Identity

✅ Site Title: Majelis.info
✅ Tagline: Platform Acara Kajian & Majelis Ilmu Terlengkap
✅ Site Icon: Upload 512x512px favicon
✅ Logo: Upload logo (200x60px recommended)
```

#### **C. Header Settings**
```
Dashboard → Appearance → Customize → Header

✅ Header Style: Transparent (untuk hero section)
✅ Header Background: White dengan shadow
✅ Sticky Header: Enable (tetap visible saat scroll)
✅ Search Icon: Show
✅ Login/Register Link: Show
```

#### **D. Footer Settings**
```
Dashboard → Appearance → Customize → Footer

✅ Footer Columns: 4 columns
  - Column 1: About Majelis.info + Logo
  - Column 2: Quick Links (Events, Categories, Vendors)
  - Column 3: Customer Service (Contact, FAQ, Terms)
  - Column 4: Social Media + Newsletter

✅ Copyright Text: © 2024 Majelis.info - All Rights Reserved
✅ Payment Icons: Show (WooCommerce payment methods)
```

---

## 3. Plugin Requirements

### 🔌 Required Plugins (Pastikan sudah terinstall & aktif)

```
Dashboard → Plugins → Installed Plugins
```

#### **Essential Plugins:**
| Plugin Name | Status | Purpose |
|------------|--------|---------|
| **Elementor** | ✅ Active | Page builder untuk custom layout |
| **Contact Form 7** | ✅ Active | Form kontak |
| **Yoast SEO** | ✅ Active | SEO optimization |
| **WooCommerce** | ✅ Active | Payment & booking system |
| **JWT Authentication** | ✅ Active | API authentication untuk mobile app |
| **WP REST API Cache** | ✅ Active | Cache API responses |
| **Smush** | ✅ Active | Image optimization |
| **WP Rocket** | 🔄 Recommended | Caching & performance |
| **Wordfence** | ✅ Active | Security |

#### **MeUp Theme Required Plugins:**
```
Dashboard → Appearance → Install Plugins
```
- **OvaTheme Framework** ✅ Required
- **OT Events** ✅ Required (event post type)
- **OT Vendor** ✅ Required (vendor management)
- **Elementor** ✅ Required (page builder)

**Install semua yang ada badge "Required"!**

---

## 4. Permalink Settings

### 🔗 Location: `Dashboard → Settings → Permalinks`

#### **Recommended Structure:**
```
✅ Post name: https://majelis.info/sample-post/

Custom Structure for Events:
https://majelis.info/event/%eventname%/

Custom Structure for Vendors:
https://majelis.info/vendor/%vendorname%/
```

**Why?** SEO-friendly, clean URLs, optimal untuk sharing

**⚠️ IMPORTANT:** After changing permalinks, click **"Save Changes"** twice!

---

## 5. Reading Settings

### 📖 Location: `Dashboard → Settings → Reading`

```
✅ Your homepage displays: A static page (select below)
   - Homepage: [Select "Home" page] ← Create this dengan Elementor
   - Posts page: [Select "Blog" page]

✅ Blog pages show at most: 12 posts
✅ Search engine visibility: ❌ Unchecked (allow indexing)
```

**Create Homepage:**
```
1. Dashboard → Pages → Add New
2. Title: "Home"
3. Template: Full Width (no sidebar)
4. Edit with Elementor → Design custom homepage
5. Atau gunakan MeUp pre-built homepage template
```

---

## 6. WooCommerce Settings

### 💳 Location: `Dashboard → WooCommerce → Settings`

#### **A. General Settings**
```
Tab: General

Store Address:
✅ Address Line 1: [Your office address]
✅ City: [City]
✅ Country/State: Indonesia
✅ Postcode: [Postal code]

Currency Options:
✅ Currency: Indonesian Rupiah (IDR)
✅ Currency Position: Rp (Right with space) → Rp 100.000
✅ Thousand Separator: . (dot)
✅ Decimal Separator: , (comma)
✅ Number of Decimals: 0
```

#### **B. Products Settings**
```
Tab: Products → General

✅ Shop Page: [Select page for events listing]
✅ Add to cart behavior:
   ✅ Redirect to cart page: No (stay on event page)
   ✅ Enable AJAX add to cart: Yes
```

#### **C. Payments**
```
Tab: Payments

Enable these payment methods:
✅ Bank Transfer (Manual)
✅ Midtrans (Indonesian payment gateway)
   - Get Midtrans API key: https://dashboard.midtrans.com/
   - Server Key: [Your server key]
   - Client Key: [Your client key]
   - Environment: Production

✅ PayPal (Optional - for international)
✅ Cash on Delivery (Optional - offline events)
```

**Midtrans Setup:**
```
1. Register: https://midtrans.com/
2. Dashboard → Settings → Access Keys
3. Copy Server Key & Client Key
4. WooCommerce → Payments → Midtrans → Configure
5. Paste keys → Save
```

#### **D. Checkout Settings**
```
Tab: Checkout

✅ Enable guest checkout: Yes
✅ Enable coupon codes: Yes
✅ Required fields:
   ✅ First Name, Last Name
   ✅ Email, Phone
   ✅ Billing Address (for invoice)
```

---

## 7. Menu Setup

### 🧭 Location: `Dashboard → Appearance → Menus`

#### **Primary Menu (Header Navigation)**

Create menu dengan struktur ini:
```
📌 Beranda (Home)
📌 Events
   └── Kajian Islam
   └── Seminar & Workshop
   └── Pendidikan
   └── Sosial & Kemanusiaan
📌 Vendors
📌 Cara Pesan
📌 FAQ
📌 Kontak
```

**Steps:**
```
1. Dashboard → Appearance → Menus
2. Click "Create a new menu"
3. Menu Name: "Primary Menu"
4. Add items dari:
   - Pages (Beranda, Kontak, FAQ)
   - Categories (Event categories)
   - Custom Links (external URLs)
5. Drag & drop untuk create submenu (indent to right)
6. Check "Primary Menu" di Display location
7. Save Menu
```

#### **Footer Menu**

Create 3 menus untuk footer columns:
```
Footer Menu 1: Quick Links
- Semua Events
- Categories
- Vendors
- Cara Booking

Footer Menu 2: Customer Service
- Kontak Kami
- FAQ
- Syarat & Ketentuan
- Kebijakan Privasi

Footer Menu 3: Social Media
- Facebook
- Instagram
- Twitter
- YouTube
```

---

## 8. Homepage Setup

### 🏠 Location: `Dashboard → Pages → Home → Edit with Elementor`

#### **Homepage Sections** (sesuai dengan custom-homepage-design.css)

Create these sections dengan Elementor:

**Section 1: Hero Section**
```
- Heading: "Temukan Kajian & Majelis Ilmu Terbaik"
- Subheading: "Platform terlengkap untuk acara kajian Islam..."
- Search Bar: Event search dengan autocomplete
- CTA Buttons: "Cari Event" + "Cara Pesan"
- Background: Gradient overlay + image
```

**Section 2: Event Categories**
```
- 4 Category cards:
  1. Kajian Islam (icon: 📖)
  2. Seminar & Workshop (icon: 🎓)
  3. Pendidikan (icon: 📚)
  4. Sosial (icon: 🤝)
- Each card links to category page
```

**Section 3: Featured Events**
```
- Title: "Event Unggulan"
- Event Grid: 3 columns × 2 rows
- Show: Featured events (set via event meta)
- CTA: "Lihat Semua Event"
```

**Section 4: Statistics**
```
- 4 Stat boxes:
  1. 500+ Events
  2. 100+ Vendors
  3. 10,000+ Peserta
  4. 50+ Kota
- Counter animation (use Elementor counter widget)
```

**Section 5: How It Works**
```
- 3 Steps:
  1. Pilih Event (icon: 🔍)
  2. Pesan Tiket (icon: 🎫)
  3. Hadiri Event (icon: ✅)
```

**Section 6: Testimonials**
```
- Slider: 3 testimonials
- Show: Name, photo, rating, review
```

**Section 7: Newsletter CTA**
```
- Heading: "Dapatkan Update Event Terbaru"
- Form: Email input + Subscribe button
- Background: Gradient
```

---

## 9. Event Settings

### 🎫 Location: `Dashboard → Events → Settings`

#### **General Event Settings**
```
✅ Enable booking system: Yes
✅ Enable seat selection: Yes (if needed)
✅ Enable QR code tickets: Yes ← IMPORTANT!
✅ QR code expiry: Never (or custom)
✅ Email ticket to customer: Yes
```

#### **Event Meta Fields** (untuk custom fields)
```
Required fields:
✅ Event Date & Time
✅ Location (Physical address or "Online")
✅ Price (atau "Free")
✅ Speaker/Ustadz Name
✅ Category
✅ Tags
✅ Max Participants
```

#### **Ticket Settings**
```
✅ Ticket types:
   - Early Bird (diskon)
   - Regular
   - VIP (if applicable)

✅ QR Code Settings:
   - Auto-generate on payment complete
   - Send via email + show in user dashboard
   - Scannable via mobile app (gunakan Flutter app)
```

---

## 10. Performance Optimization

### ⚡ Critical Settings untuk Speed

#### **A. Image Optimization**
```
Plugin: Smush
Dashboard → Smush → Settings

✅ Automatic compression: On
✅ Lazy load: On
✅ Strip metadata: On
✅ Convert to WebP: On
✅ Resize large images: Max 1920px width
```

#### **B. Caching** (if using WP Rocket)
```
Dashboard → WP Rocket → Settings

✅ Enable caching: On
✅ Cache lifespan: 10 hours
✅ Mobile cache: Separate cache for mobile
✅ User cache: On (for logged-in users)

✅ File Optimization:
   ✅ Minify CSS: On
   ✅ Combine CSS: On
   ✅ Minify JavaScript: On
   ✅ Defer JS: On

✅ Media:
   ✅ Lazy load images: On
   ✅ Lazy load iframes: On
```

#### **C. Database Optimization**
```
Plugin: WP-Optimize
Dashboard → WP-Optimize

✅ Clean post revisions
✅ Clean auto-drafts
✅ Remove spam comments
✅ Optimize database tables
✅ Schedule weekly auto-cleanup
```

#### **D. CDN Setup** (Optional - Cloudflare)
```
1. Register: https://cloudflare.com (Free plan)
2. Add site: majelis.info
3. Update nameservers di Hostinger:
   - Hostinger hPanel → Domains → majelis.info → DNS
   - Change to Cloudflare nameservers
4. Cloudflare → Speed → Optimization:
   ✅ Auto Minify: HTML, CSS, JS
   ✅ Brotli: On
   ✅ Rocket Loader: On
```

---

## 📱 Mobile App Integration Settings

### For Flutter App to Work Properly:

#### **A. REST API Settings**
```
Dashboard → Settings → Permalinks
✅ Permalink structure: Post name (required for API)

Dashboard → Users → Profile
✅ Application Passwords: Generate for API authentication
```

#### **B. JWT Authentication**
```
Plugin: JWT Authentication for WP REST API
Dashboard → JWT Auth → Settings

✅ Enable JWT: On
✅ Secret Key: Auto-generated (keep secure!)
✅ CORS Enable: Yes
✅ Allowed Origins: *  (or specific domain for security)
```

Add to wp-config.php (sudah di .gitignore, jangan commit!):
```php
define('JWT_AUTH_SECRET_KEY', 'your-secret-key-here');
define('JWT_AUTH_CORS_ENABLE', true);
```

#### **C. WooCommerce API**
```
Dashboard → WooCommerce → Settings → Advanced → REST API

✅ Create API Key:
   - Description: "Flutter Mobile App"
   - User: [Your admin user]
   - Permissions: Read/Write
   - Copy Consumer Key & Secret

Paste in Flutter app:
flutter-app-structure/lib/app/app_config.dart
```

---

## ✅ Verification Checklist

After completing all settings, verify:

```
🔲 Custom CSS applied (check homepage design)
🔲 Homepage displays static page (not blog posts)
🔲 Event categories visible in menu
🔲 Payment gateway configured (test with small transaction)
🔲 QR code tickets auto-generate on booking
🔲 Mobile responsive (check on phone)
🔲 Page load speed < 3 seconds (test: https://pagespeed.web.dev/)
🔲 SSL certificate active (https://)
🔲 REST API accessible (test: https://majelis.info/wp-json/)
🔲 Search function works
🔲 Contact form sends emails
🔲 Social media links work
```

---

## 🆘 Troubleshooting

### Issue: CSS tidak apply
```
Solution:
1. Hard refresh browser: Ctrl+Shift+R (Windows) atau Cmd+Shift+R (Mac)
2. Clear WordPress cache: Dashboard → WP Rocket → Clear Cache
3. Check Additional CSS pasted correctly
4. Verify no CSS errors: Browser → F12 → Console
```

### Issue: Events tidak muncul
```
Solution:
1. Check event published (not draft)
2. Check event category assigned
3. Check date/time valid
4. Clear cache
```

### Issue: Payment gateway error
```
Solution:
1. Verify API keys correct
2. Check Midtrans dashboard for errors
3. Test with sandbox mode first
4. Check WooCommerce → Status → Logs
```

### Issue: QR code tidak generate
```
Solution:
1. Verify MeUp plugin updated (latest version 1.8.4)
2. Check PHP GD library installed (for QR generation)
3. Check order status = "Completed"
4. Check email sent to customer
```

---

## 📞 Need Help?

Jika ada error atau setting yang tidak jelas:

1. **Check logs:**
   - Dashboard → WooCommerce → Status → Logs
   - Dashboard → Tools → Site Health

2. **Documentation:**
   - MeUp Theme: https://ovatheme.gitbook.io/meup/
   - WooCommerce: https://woocommerce.com/documentation/

3. **Created files di repository:**
   - `IMPLEMENTATION-GUIDE.md` - Cara apply CSS
   - `FTP-AUTO-DEPLOY-GUIDE.md` - Auto deployment setup
   - `SCREENSHOT-GUIDE.md` - Visual step-by-step

---

**Last Updated:** November 19, 2024
**Version:** 1.0
**For:** Majelis.info WordPress Dashboard Setup
