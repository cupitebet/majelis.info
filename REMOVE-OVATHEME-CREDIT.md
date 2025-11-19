# 🗑️ Remove "Design and Develop by Ovatheme" dari Footer

**3 Methods - Pilih yang paling mudah!**

---

## 🎯 METHOD 1: Hide via CSS (PALING MUDAH - 2 MENIT)

Cara tercepat: Hide text pakai CSS `display: none`

### **Steps:**

**A. Via Additional CSS:**

1. Login: https://majelis.info/wp-admin
2. Go to: **Appearance → Customize → Additional CSS**
3. Paste code ini di **paling bawah** Additional CSS box:

```css
/* Hide Ovatheme Footer Credit */
.site-footer .copyright-footer,
.site-footer .site-info,
footer .copyright,
footer .credits,
.footer-credit,
.site-info a[href*="ovatheme"],
.copyright-footer a[href*="ovatheme"],
a[href*="ovatheme.com"] {
  display: none !important;
}

/* Clean footer text - remove any remaining Ovatheme mention */
.site-footer .site-info::after,
.copyright-footer::after {
  content: "" !important;
}
```

4. Click **"Publish"**
5. Refresh website: **Ctrl+Shift+R**

**✅ DONE! Text hilang!**

---

**B. Via Code Snippets Plugin:**

Jika Additional CSS tidak work, pakai Code Snippets:

1. Dashboard → **Snippets → Add New**
2. Title: `Hide Ovatheme Credit`
3. Code:

```php
function hide_ovatheme_footer_credit() {
    ?>
    <style>
    .site-footer .copyright-footer,
    .site-footer .site-info,
    footer .copyright,
    footer .credits,
    .footer-credit,
    .site-info a[href*="ovatheme"],
    .copyright-footer a[href*="ovatheme"],
    a[href*="ovatheme.com"] {
        display: none !important;
    }
    </style>
    <?php
}
add_action('wp_head', 'hide_ovatheme_footer_credit', 9999);
```

4. **Save Changes and Activate**
5. Refresh website

**✅ DONE!**

---

## 🛠️ METHOD 2: Remove via PHP Filter (PROPER WAY - 5 MENIT)

Ini method yang lebih "clean" - actually remove text instead of just hiding.

### **Via Code Snippets:**

1. Dashboard → **Snippets → Add New**
2. Title: `Remove Ovatheme Footer Credit`
3. Code:

```php
/**
 * Remove Ovatheme Footer Credit
 * Properly removes copyright text instead of just hiding
 */

// Method 1: Filter footer text
function remove_ovatheme_footer_text($text) {
    // Remove any text containing "ovatheme"
    $text = preg_replace('/Design(ed)? (and|&) Develop(ed)? by OvaTheme/i', '', $text);
    $text = preg_replace('/<a[^>]*ovatheme[^>]*>.*?<\/a>/i', '', $text);

    // Replace with custom text (optional)
    // $text = '© ' . date('Y') . ' Majelis.info - All Rights Reserved';

    return $text;
}
add_filter('the_content', 'remove_ovatheme_footer_text');
add_filter('widget_text', 'remove_ovatheme_footer_text');

// Method 2: Remove footer credit action
function remove_meup_footer_credit() {
    // MeUp theme uses this action for footer credit
    remove_action('ova_footer_credits', 'ova_footer_credits_default');
}
add_action('after_setup_theme', 'remove_meup_footer_credit');

// Method 3: Override footer template
function custom_footer_credits() {
    echo '<div class="copyright-footer">';
    echo '© ' . date('Y') . ' Majelis.info - All Rights Reserved';
    echo '</div>';
}
add_action('ova_footer_credits', 'custom_footer_credits', 99);
```

4. **Save Changes and Activate**
5. Refresh website

**✅ Text diganti dengan custom text!**

---

## 🎨 METHOD 3: Replace with Custom Text (RECOMMENDED - 5 MENIT)

Replace "Design by Ovatheme" dengan copyright text sendiri.

### **Via Code Snippets:**

1. Dashboard → **Snippets → Add New**
2. Title: `Custom Footer Copyright`
3. Code:

```php
/**
 * Replace Ovatheme credit with custom copyright
 */
function majelis_custom_footer_copyright() {
    ?>
    <style>
    /* Hide original Ovatheme credit */
    .site-footer .site-info,
    .copyright-footer {
        display: none !important;
    }

    /* Style for custom copyright */
    .custom-footer-copyright {
        text-align: center;
        padding: 20px 0;
        background: #1F2937;
        color: #fff;
        font-size: 14px;
    }

    .custom-footer-copyright a {
        color: #3B82F6;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .custom-footer-copyright a:hover {
        color: #60A5FA;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find footer
        var footer = document.querySelector('.site-footer') ||
                     document.querySelector('footer') ||
                     document.querySelector('#colophon');

        if (footer) {
            // Create custom copyright div
            var copyrightDiv = document.createElement('div');
            copyrightDiv.className = 'custom-footer-copyright';
            copyrightDiv.innerHTML = '© <?php echo date("Y"); ?> <a href="https://majelis.info">Majelis.info</a> - Platform Acara Kajian & Majelis Ilmu Terlengkap';

            // Hide original credits
            var oldCredits = footer.querySelectorAll('.site-info, .copyright-footer, .credits');
            oldCredits.forEach(function(el) {
                el.style.display = 'none';
            });

            // Append new copyright
            footer.appendChild(copyrightDiv);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'majelis_custom_footer_copyright', 999);
```

4. **Save Changes and Activate**
5. Refresh website

**✅ Custom copyright muncul!**

**Result:**
```
© 2024 Majelis.info - Platform Acara Kajian & Majelis Ilmu Terlengkap
```

---

## 🔍 Cek Footer Element (Untuk Debugging)

Kalau methods di atas tidak work, kita perlu tau exact class/ID footer nya.

### **Steps:**

1. Buka https://majelis.info
2. Scroll ke **footer** (paling bawah)
3. **Right-click** di text "Design and Develop by Ovatheme"
4. Click **"Inspect"** atau **"Inspect Element"**
5. Browser DevTools terbuka
6. Lihat HTML structure

**Kasih tau saya:**
- Class name apa? (misal: `.site-info`, `.copyright`, etc.)
- ID apa? (misal: `#colophon`)
- Text ada di dalam tag apa? (`<p>`, `<div>`, `<span>`)

**Screenshot atau copy HTML structure nya**, nanti saya buatkan CSS/PHP yang exact!

---

## 📋 Quick Decision Tree

**Pilih method berdasarkan kebutuhan:**

### **Mau yang PALING CEPAT (2 menit):**
→ **METHOD 1A: Additional CSS**
```css
.site-footer .site-info,
a[href*="ovatheme"] {
    display: none !important;
}
```

### **Additional CSS tidak work:**
→ **METHOD 1B: Code Snippets CSS**

### **Mau proper removal (not just hide):**
→ **METHOD 2: PHP Filter**

### **Mau custom copyright sendiri:**
→ **METHOD 3: Replace with Custom Text**

---

## ✅ RECOMMENDED: Method 1A (Tercepat!)

Untuk quick fix, pakai ini:

1. **Appearance → Customize → Additional CSS**
2. Paste:
```css
/* Remove Ovatheme Credit */
.site-footer a[href*="ovatheme"],
.copyright-footer,
.site-info {
    display: none !important;
}
```
3. **Publish**
4. **Refresh (Ctrl+Shift+R)**

**DONE! 2 menit!** ✅

---

## 🆘 Troubleshooting

### **Text masih muncul setelah apply CSS:**

**Cause:** Wrong class/selector

**Fix:**
1. Inspect element (right-click → Inspect)
2. Find exact class name
3. Update CSS selector
4. Kasih tau saya class name nya, saya update code!

---

### **CSS apply tapi text masih ada (cache):**

**Fix:**
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+Shift+R)
3. Clear WordPress cache
4. Try incognito mode

---

### **Mau remove di specific pages only:**

```css
/* Remove only on homepage */
.home .site-footer a[href*="ovatheme"] {
    display: none !important;
}

/* Remove on all pages except homepage */
body:not(.home) .site-footer a[href*="ovatheme"] {
    display: none !important;
}
```

---

## 💡 Legal Note

**Tentang MeUp Theme License:**

MeUp adalah premium theme. Check license agreement:
- ✅ **Regular License:** OK untuk remove credit (your website)
- ✅ **Extended License:** OK untuk remove credit
- ⚠️ Some themes require credit to remain (check documentation)

**MeUp Theme dari OvaTheme biasanya:**
- License memperbolehkan remove footer credit
- Tidak ada enforced requirement untuk keep credit
- **Safe untuk remove** selama kamu punya valid license

**Confirm license:**
```
Dashboard → MeUp Theme → License
Check license status: Active & valid
```

If valid license: **100% OK untuk remove credit!** ✅

---

## 🎯 ACTION NOW

**Pilih method & kasih tau hasilnya:**

**Option A: METHOD 1A (Quick CSS)**
- 2 menit
- Paling simple
- Just hide text

**Option B: METHOD 3 (Custom Copyright)**
- 5 menit
- Professional
- Replace dengan copyright sendiri

**Mau yang mana? Atau mau saya inspect footer dulu untuk lihat exact structure?** 🚀

---

Setelah ini kelar, kita balik ke CSS issue dengan fresh mind ya! 😊
