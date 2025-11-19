# 🔌 Apply CSS via Code Snippets Plugin

**Method ini lebih reliable karena load CSS dengan priority tinggi yang tidak di-override theme!**

---

## 📋 Why Code Snippets Method?

**Kenapa Additional CSS tidak work:**
- ❌ MeUp theme mungkin override Customizer CSS
- ❌ Loading order issue (theme CSS load after Customizer)
- ❌ CSS specificity theme lebih tinggi
- ❌ Cache di Customizer

**Code Snippets advantages:**
- ✅ Control CSS loading priority
- ✅ Force load AFTER theme CSS (override theme styles)
- ✅ Higher specificity
- ✅ No cache issues
- ✅ Persistent (tidak hilang saat theme update)

---

## 🚀 STEP-BY-STEP GUIDE

### **STEP 1: Install Code Snippets Plugin** (2 menit)

1. Login WordPress: https://majelis.info/wp-admin
2. Go to: **Dashboard → Plugins → Add New**
3. Search: **"Code Snippets"**
4. Find plugin by: **Code Snippets** (by Code Snippets Pro)
   - Rating: 5 stars, 800K+ active installs
5. Click **"Install Now"**
6. Wait ~10 seconds
7. Click **"Activate"**

**Success!** Plugin installed & active ✅

---

### **STEP 2: Create New Snippet** (30 detik)

1. Dashboard → **Snippets → Add New**
   - Atau: **Snippets → All Snippets → Add New**
2. Kamu akan lihat form untuk create snippet

---

### **STEP 3: Configure Snippet** (1 menit)

**A. Snippet Title:**
```
Majelis.info Custom Styles
```

**B. Code Type:**
- Select: **"PHP Snippet"** (default)

**C. Snippet Code:**

Copy-paste code ini ke **Code box**:

```php
<?php
/**
 * Enqueue Majelis.info Custom CSS
 * Load custom styles with high priority to override theme
 */
function majelis_custom_styles() {
    // Get CSS content
    $custom_css = '
/* Majelis.info Complete Custom Styles */
:root {
  --primary-main: #1E40AF;
  --primary-light: #3B82F6;
  --primary-dark: #1E3A8A;
  --secondary-main: #059669;
  --secondary-light: #10B981;
  --secondary-dark: #047857;
  --accent-main: #F59E0B;
  --accent-light: #FBBF24;
  --gray-50: #F9FAFB;
  --gray-100: #F3F4F6;
  --gray-200: #E5E7EB;
  --gray-300: #D1D5DB;
  --gray-400: #9CA3AF;
  --gray-500: #6B7280;
  --gray-600: #4B5563;
  --gray-700: #374151;
  --gray-800: #1F2937;
  --gray-900: #111827;
  --success: #10B981;
  --warning: #F59E0B;
  --error: #EF4444;
  --info: #3B82F6;
  --bg-primary: #FFFFFF;
  --bg-secondary: #F9FAFB;
  --bg-tertiary: #F3F4F6;
  --spacing-xs: 0.25rem;
  --spacing-sm: 0.5rem;
  --spacing-md: 1rem;
  --spacing-lg: 1.5rem;
  --spacing-xl: 2rem;
  --spacing-2xl: 3rem;
  --spacing-3xl: 4rem;
}

/* Typography */
body {
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  color: var(--gray-800);
  line-height: 1.6;
}

h1, h2, h3, h4, h5, h6 {
  font-family: "Poppins", sans-serif;
  font-weight: 600;
  line-height: 1.3;
  color: var(--gray-900);
}

h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.5rem; }

/* PASTE REMAINING CSS HERE - CONTINUE BELOW */
    ';

    // Add inline CSS with high priority
    wp_add_inline_style('parent-style', $custom_css);
}

// Hook with priority 999 (load AFTER theme)
add_action('wp_enqueue_scripts', 'majelis_custom_styles', 999);
?>
```

**⚠️ IMPORTANT:** Code di atas baru sampai typography. Kamu perlu **paste sisa CSS** di bawah comment `/* PASTE REMAINING CSS HERE */`

---

### **STEP 4: Complete CSS Code** (2 menit)

Kode di atas belum complete. Kamu perlu paste **full CSS**.

**Option A: Saya buatkan snippet file complete** (RECOMMENDED)

Tunggu sebentar, saya buat file `.php` snippet yang sudah include FULL CSS.

**Option B: Manual paste**

1. Buka file: `majelis-complete-styles.css`
2. Copy SEMUA isi (kecuali comment di paling atas)
3. Paste di dalam `$custom_css = '...'` (replace `/* PASTE REMAINING CSS HERE */`)

---

### **STEP 5: Snippet Settings** (30 detik)

Scroll ke bawah form, configure:

**A. Run snippet everywhere:**
- Select: **"Run snippet everywhere"** (default)
- Atau: **"Only run on site front-end"**

**B. Tags (optional):**
```
styling, custom-css, majelis
```

**C. Priority:**
```
999
```
(Ini ensure CSS load AFTER theme CSS)

---

### **STEP 6: Save & Activate** (10 detik)

1. Click tombol **"Save Changes and Activate"**
   - Atau: Click "Save Changes" dulu, lalu toggle "Active"
2. Success message akan muncul ✅

**Snippet is now ACTIVE!**

---

### **STEP 7: Verify** (1 menit)

1. Buka https://majelis.info di tab baru
2. Hard refresh: **Ctrl+Shift+R** (Windows) atau **Cmd+Shift+R** (Mac)
3. Check apakah design berubah!

**Expected changes:**
- ✅ Colors: Blue/Green/Orange theme
- ✅ Hero section (if exists) dengan gradient
- ✅ Modern typography (Poppins headings, Inter body)
- ✅ Category cards hover effects
- ✅ Event cards modern design

---

## 📂 Files to Create

Wait, saya buatkan **complete snippet file** supaya kamu tinggal copy-paste aja!

---

## 🔍 Troubleshooting Code Snippets

### **Issue: "Fatal error" atau white screen**

**Cause:** PHP syntax error dalam snippet

**Fix:**
1. Don't panic! WordPress has safe mode
2. Go to: https://majelis.info/wp-admin/admin.php?page=snippets
3. Deactivate snippet (toggle off)
4. Fix syntax error
5. Reactivate

**Or via FTP:**
```
1. Login FTP/File Manager
2. Go to: wp-content/plugins/code-snippets/
3. Rename folder temporarily to disable plugin
4. Fix issue
5. Rename back
```

---

### **Issue: CSS still not applying**

**Cause:** Wrong hook or cache

**Fix 1: Change hook priority:**
```php
// Try even higher priority:
add_action('wp_enqueue_scripts', 'majelis_custom_styles', 9999);
```

**Fix 2: Use different hook:**
```php
// Use wp_head instead:
add_action('wp_head', 'majelis_custom_styles', 999);
```

**Fix 3: Add !important to CSS:**
```php
// In CSS variables, add !important:
:root {
  --primary-main: #1E40AF !important;
  --secondary-main: #059669 !important;
  --accent-main: #F59E0B !important;
}
```

---

### **Issue: Snippet not saving (too large)**

**Cause:** PHP limit pada snippet size

**Fix: Upload CSS as separate file**

Create file method instead (saya kasih guide di bawah).

---

## 🎯 Next: Complete Snippet File

Tunggu sebentar, saya buatkan **complete PHP snippet file** yang include full CSS, supaya kamu tinggal:
1. Copy code
2. Paste ke Code Snippets
3. Save & Activate
4. DONE! ✅

---

## 📊 Comparison: Methods

| Method | Pros | Cons | Success Rate |
|--------|------|------|--------------|
| **Additional CSS** | Easy, built-in | Theme override, cache | 60% |
| **Code Snippets** | High priority, control | Need plugin | 90% |
| **Child Theme** | Permanent, professional | Technical, complex | 95% |
| **Custom Plugin** | Ultimate control | Most complex | 99% |

**Recommended:** Code Snippets (balance antara mudah & effective!)

---

Wait, saya create complete snippet file sekarang...
