# PWA Icons Generation Guide

## Icons Yang Dibutuhkan

Untuk PWA Majelis.info berfungsi sempurna, Anda perlu membuat icon dengan ukuran berikut:

### Icon Sizes Required:
- `icon-72x72.png` - Small icon
- `icon-96x96.png` - Small icon
- `icon-128x128.png` - Medium icon
- `icon-144x144.png` - MS Tile
- `icon-152x152.png` - iOS icon
- `icon-192x192.png` - Standard PWA icon (REQUIRED)
- `icon-384x384.png` - Large icon
- `icon-512x512.png` - Large PWA icon (REQUIRED)
- `icon-maskable-192x192.png` - Maskable 192px
- `icon-maskable-512x512.png` - Maskable 512px

### Additional Icons:
- `search-icon.png` (96x96) - For shortcuts
- `ticket-icon.png` (96x96) - For shortcuts
- `favorite-icon.png` (96x96) - For shortcuts
- `badge-72x72.png` - Notification badge

### Screenshot Sizes:
- `screenshot-1.png` (540x720) - Narrow/mobile screenshot
- `screenshot-2.png` (1080x720) - Wide/desktop screenshot

## Cara Generate Icons

### Opsi 1: Menggunakan Online Tool (Paling Mudah)

**1. PWA Asset Generator (Recommended)**
- Website: https://www.pwabuilder.com/imageGenerator
- Upload logo utama Anda (minimal 512x512px, format PNG dengan background transparent)
- Download semua icon yang dihasilkan
- Extract ke `wp-content/themes/meup-child/assets/icons/`

**2. RealFaviconGenerator**
- Website: https://realfavicongenerator.net/
- Upload master icon (1024x1024px recommended)
- Pilih "Generate for PWA"
- Download package
- Extract ke folder icons

### Opsi 2: Menggunakan ImageMagick (CLI)

Jika Anda punya logo master (misalnya `logo-master.png` ukuran 1024x1024):

```bash
cd wp-content/themes/meup-child/assets/icons/

# Generate semua ukuran dari master
convert logo-master.png -resize 72x72 icon-72x72.png
convert logo-master.png -resize 96x96 icon-96x96.png
convert logo-master.png -resize 128x128 icon-128x128.png
convert logo-master.png -resize 144x144 icon-144x144.png
convert logo-master.png -resize 152x152 icon-152x152.png
convert logo-master.png -resize 192x192 icon-192x192.png
convert logo-master.png -resize 384x384 icon-384x384.png
convert logo-master.png -resize 512x512 icon-512x512.png

# Generate maskable icons (dengan padding 10%)
convert logo-master.png -resize 172x172 -gravity center -extent 192x192 -background transparent icon-maskable-192x192.png
convert logo-master.png -resize 460x460 -gravity center -extent 512x512 -background transparent icon-maskable-512x512.png

# Generate shortcut icons
convert logo-master.png -resize 96x96 search-icon.png
convert logo-master.png -resize 96x96 ticket-icon.png
convert logo-master.png -resize 96x96 favorite-icon.png
convert logo-master.png -resize 72x72 badge-72x72.png
```

### Opsi 3: Menggunakan Node.js Script

Install package:
```bash
npm install -g pwa-asset-generator
```

Generate icons:
```bash
pwa-asset-generator logo-master.png wp-content/themes/meup-child/assets/icons/ \
  --padding "10%" \
  --background "#1E3A8A" \
  --manifest manifest.json
```

## Design Guidelines

### Logo Requirements:
1. **Format:** PNG dengan transparent background
2. **Size:** Minimal 1024x1024px (semakin besar semakin baik)
3. **Safe Zone:** Konten penting harus dalam 80% center area (untuk maskable icons)
4. **Color:** Jelas dan terlihat di background terang maupun gelap

### Maskable Icons
Maskable icons digunakan untuk Android adaptive icons. Harus memiliki:
- Padding minimal 10% dari setiap sisi
- Konten penting di 80% center area
- Background color yang solid (atau bisa transparent)

Visualisasi maskable safe zone:
```
┌─────────────────┐
│ 10% padding     │
│  ┌───────────┐  │
│  │           │  │
│  │  80% Safe │  │
│  │   Zone    │  │
│  │           │  │
│  └───────────┘  │
│ 10% padding     │
└─────────────────┘
```

## Testing Maskable Icons

Upload icon Anda ke:
https://maskable.app/editor

Tool ini akan show preview bagaimana icon Anda akan terlihat sebagai maskable icon.

## Screenshots

### Screenshot 1 (Narrow - Mobile)
- **Size:** 540x720px
- **Content:** Homepage atau event list di mobile view
- **Format:** PNG atau JPEG

### Screenshot 2 (Wide - Desktop)
- **Size:** 1080x720px
- **Content:** Homepage atau event detail di desktop view
- **Format:** PNG atau JPEG

Cara capture:
1. Buka website di browser
2. Resize window ke ukuran yang sesuai
3. Use browser dev tools screenshot feature
4. Atau use tool seperti Screely.com untuk polish screenshot

## Quick Start: Temporary Placeholder Icons

Jika Anda ingin test PWA dulu tanpa design final, bisa generate placeholder:

```bash
cd wp-content/themes/meup-child/assets/icons/

# Create solid color placeholders
convert -size 192x192 xc:"#1E3A8A" -gravity center \
  -fill white -pointsize 80 -annotate +0+0 "M" icon-192x192.png

convert -size 512x512 xc:"#1E3A8A" -gravity center \
  -fill white -pointsize 200 -annotate +0+0 "M" icon-512x512.png
```

## Verification Checklist

After generating all icons, verify:

- [ ] All icon files exist in `wp-content/themes/meup-child/assets/icons/`
- [ ] Files are proper PNG format
- [ ] Icon sizes are exactly as specified
- [ ] Maskable icons have proper safe zone padding
- [ ] Screenshots are created and placed
- [ ] Test PWA installation on real device
- [ ] Check icon appearance in:
  - [ ] Android home screen
  - [ ] iOS home screen
  - [ ] Browser install prompt
  - [ ] Task switcher

## File Structure

Final structure harus seperti ini:

```
wp-content/themes/meup-child/assets/
├── icons/
│   ├── icon-72x72.png
│   ├── icon-96x96.png
│   ├── icon-128x128.png
│   ├── icon-144x144.png
│   ├── icon-152x152.png
│   ├── icon-192x192.png ⭐ REQUIRED
│   ├── icon-384x384.png
│   ├── icon-512x512.png ⭐ REQUIRED
│   ├── icon-maskable-192x192.png ⭐ REQUIRED
│   ├── icon-maskable-512x512.png ⭐ REQUIRED
│   ├── search-icon.png
│   ├── ticket-icon.png
│   ├── favorite-icon.png
│   └── badge-72x72.png
└── screenshots/
    ├── screenshot-1.png
    └── screenshot-2.png
```

## Resources

- **PWA Builder Image Generator:** https://www.pwabuilder.com/imageGenerator
- **Favicon Generator:** https://realfavicongenerator.net/
- **Maskable Icon Editor:** https://maskable.app/editor
- **PWA Asset Generator (NPM):** https://github.com/onderceylan/pwa-asset-generator
- **ImageMagick:** https://imagemagick.org/

## Notes

- Icon PNG harus **optimized** (use TinyPNG atau ImageOptim)
- File size untuk icons sebaiknya < 50KB each
- Test PWA installation di:
  - Chrome Android
  - Safari iOS
  - Edge Desktop
  - Chrome Desktop

Setelah icons ready, PWA Anda siap untuk di-install sebagai native app! 🚀
