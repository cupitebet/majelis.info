# 🎯 Goers-Inspired Features - Majelis.info

> **Implementasi:** 16 Desember 2025
> **Inspired by:** [Goersapp.com](https://www.goersapp.com) - Leading Event Platform in Indonesia

---

## 🌟 Overview

Implementasi ini mengadopsi best practices dari **Goersapp.com**, platform event terkemuka di Indonesia dengan 25+ juta tiket terjual sejak 2015. Goers dipercaya oleh brand besar seperti Telkomsel, Mekari, dan berbagai event organizer profesional.

### Fitur Utama Goers yang Diadopsi:

✅ **Explore Feed** - Filter event by "Hari Ini, Besok, Minggu Ini"
✅ **Rating & Review System** - 5-star rating + review 50-8000 karakter
✅ **Modern Homepage** - Clean UI dengan category discovery
✅ **Testimonials** - Social proof dari penyelenggara terpercaya
✅ **Professional UX** - Fast response, clear CTA, mobile-first

---

## 📄 Files Implementasi

### 1. **Modern Homepage Template**

**File:** `wp-content/themes/meup-child/template-home-modern.php`

**Template Name:** "Home Modern (Goers-inspired)"

**Fitur:**

#### A. Hero Section dengan Search
- Headline yang menarik dan value proposition jelas
- Search bar prominent dengan rounded corner design
- Quick stats (jumlah event, gratis, 24/7 akses)

#### B. Event Categories
- 6 kategori utama: Kajian Rutin, Majelis Ilmu, Maulid, Seminar, Workshop, Tahfidz
- Icon-based cards dengan hover effect
- Link ke filtered events

#### C. Explore Feed (Goers-Style)
- **4 Tabs Filter:**
  - 🌟 Hari Ini
  - 📅 Besok
  - 📆 Minggu Ini
  - 📋 Semua Event

- **AJAX Loading:** Filter events tanpa reload page
- **Event Cards:** Menampilkan:
  - Featured image
  - Title + quick info pills (tanggal, waktu, harga)
  - Lokasi
  - Rating stars (jika ada review)
  - CTA "Lihat Detail"

#### D. Testimonials Section
- 3 testimonial cards dari penyelenggara
- Avatar initials dengan gradient background
- 5-star rating display
- Professional layout

#### E. CTA Section
- Gradient background yang eye-catching
- 2 CTA buttons: "Submit Event Gratis" & "Hubungi Kami"
- Clear value proposition

**Cara Menggunakan:**

1. Buat halaman baru di WordPress
2. Beri judul "Home" atau "Beranda"
3. Pilih template: **"Home Modern (Goers-inspired)"**
4. Set sebagai homepage di **Settings → Reading → Static Page**
5. Publish

---

### 2. **Rating & Review System**

**Files:**
- `wp-content/themes/meup-child/functions.php` (lines 935-1253)
- `wp-content/themes/meup-child/partials/event-reviews.php`

**Fitur:**

#### A. Custom Post Type: `event_review`
- Stored di WordPress database
- Moderation system (status: pending/publish)
- Admin UI accessible via **Events → Event Reviews**

#### B. Review Meta Data
- `_event_id` - ID event yang di-review
- `_rating` - Rating 1-5 stars
- `_reviewer_name` - Nama reviewer
- `_reviewer_email` - Email reviewer (tidak dipublikasikan)

#### C. Review Display
- **Rating Summary:**
  - Average rating (large display)
  - Star distribution chart
  - Total review count

- **Review List:**
  - Reviewer name + date
  - Star rating
  - Review text (50-8000 characters)

#### D. Review Form
- Interactive star rating (click to select)
- Textarea with character counter (50-8000 chars)
- Name & email fields
- AJAX submission (no page reload)
- Validation:
  - Minimum 50 characters
  - Valid email format
  - Rating required
  - One review per email per event

#### E. Auto-Update Rating
- Automatically recalculates average when review status changes
- Stores rating in event meta: `_event_rating_average`, `_event_rating_count`
- Updates on: publish, unpublish, delete review

**Review Moderation:**

1. Go to **WordPress Dashboard → Events → Event Reviews**
2. Review pending submissions
3. Click "Edit" to review content
4. Change status to "Publish" to approve
5. Rating automatically updates on event page

---

### 3. **AJAX Event Filters**

**File:** `wp-content/themes/meup-child/functions.php` (lines 1116-1253)

**Function:** `majelis_get_events_by_time_ajax()`

**Filter Options:**

| Filter | Date Range |
|--------|-----------|
| `today` | Today 00:00:00 - 23:59:59 |
| `tomorrow` | Tomorrow 00:00:00 - 23:59:59 |
| `week` | Today - Next 7 days |
| `all` | Today - Next 30 days |

**How It Works:**

1. User clicks tab filter
2. JavaScript sends AJAX request to `admin-ajax.php`
3. PHP queries events based on date range
4. Returns HTML of event cards
5. JavaScript replaces container content
6. No page reload, smooth UX

**AJAX Endpoint:** `wp-admin/admin-ajax.php?action=get_events_by_time&filter=[today|tomorrow|week|all]`

---

### 4. **Enhanced Single Event Template**

**File:** `wp-content/themes/meup-child/single-mep_events.php` (updated)

**Changes:**

```php
// Added before closing </article>
<?php
if ( file_exists( get_stylesheet_directory() . '/partials/event-reviews.php' ) ) {
    include get_stylesheet_directory() . '/partials/event-reviews.php';
}
?>
```

**Result:**
- Rating & review section automatically appears on all event pages
- Seamless integration with existing template
- Mobile-responsive design

---

## 🎨 Design Philosophy (Goers-Style)

### Colors
- **Primary:** `#1E3A8A` (Deep Blue)
- **Secondary:** `#667eea` (Purple Blue)
- **Accent:** `#764ba2` (Purple)
- **Success:** `#10b981` (Green)
- **Warning:** `#f59e0b` (Amber)

### Typography
- **Headings:** Bold, large (2-3em), high contrast
- **Body:** 1.05-1.1em, line-height 1.6-1.8
- **CTA Buttons:** 1.1em, weight 700-800

### UI Elements
- **Border Radius:** 8-16px (cards), 50px (buttons)
- **Shadows:** Subtle `0 2px 12px rgba(0,0,0,0.08)`
- **Hover Effects:** `translateY(-2px)` + shadow increase
- **Transitions:** 0.2-0.3s for smooth animations

### Mobile-First
- Responsive grid: `repeat(auto-fit, minmax(280px, 1fr))`
- Flex-wrap for horizontal layouts
- Readable font sizes on small screens
- Touch-friendly button sizes (min 44px)

---

## 📊 Impact & Benefits

### User Experience
- ✅ **Faster Event Discovery:** Filter by time reduces scroll/search time
- ✅ **Trust Signals:** Reviews build confidence for jamaah
- ✅ **Modern Feel:** Professional UI increases platform credibility
- ✅ **Mobile-Optimized:** 70%+ users mobile, responsive design critical

### SEO & Engagement
- ✅ **Rich Snippets:** Review schema can appear in Google Search
- ✅ **User-Generated Content:** Reviews = fresh content = better SEO
- ✅ **Lower Bounce Rate:** Better navigation = longer session time
- ✅ **Social Proof:** Testimonials increase conversion rates

### Admin/Organizer
- ✅ **Review Management:** Moderation system prevents spam/abuse
- ✅ **Feedback Loop:** Reviews provide valuable insights
- ✅ **Professional Image:** Modern features = professional platform

---

## 🔧 Configuration & Customization

### Change Testimonials

Edit `template-home-modern.php` around line 350:

```php
<!-- Testimonial 1 -->
<div style="...">
    <div style="display: flex; gap: 4px; margin-bottom: 15px; font-size: 1.2em;">
        ⭐⭐⭐⭐⭐
    </div>
    <p style="...">
        "Your testimonial text here..."
    </p>
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="...">A</div> <!-- Initial -->
        <div>
            <div style="...">Organization Name</div>
            <div style="...">Location</div>
        </div>
    </div>
</div>
```

### Change Event Categories

Edit `template-home-modern.php` around line 80:

```php
$categories = array(
    array( 'name' => 'Your Category', 'icon' => '🔖', 'color' => '#3b82f6', 'slug' => 'your-slug' ),
    // Add more...
);
```

### Adjust Review Character Limits

Edit `functions.php` line 1018:

```php
if ( ! $event_id || $rating < 1 || $rating > 5 || empty( $review_text ) || strlen( $review_text ) < 50 ) {
    // Change min: 50 to your desired number
}
```

Edit `partials/event-reviews.php` line 190:

```html
<textarea ... minlength="50" maxlength="8000" ...>
<!-- Change minlength/maxlength as needed -->
```

### Disable Review Moderation

Edit `functions.php` line 1047:

```php
$review_id = wp_insert_post( array(
    'post_type'    => 'event_review',
    'post_title'   => 'Review by ' . $reviewer_name . ' for Event #' . $event_id,
    'post_content' => $review_text,
    'post_status'  => 'publish', // Changed from 'pending'
    'post_author'  => 0,
));
```

---

## 🚀 Performance Tips

### Caching
- Use caching plugin (WP Super Cache, W3 Total Cache)
- Cache AJAX responses (e.g., transient API for 15 minutes)
- Enable browser caching for static assets

### Database
- Index event meta keys for faster queries:
  ```sql
  CREATE INDEX event_start ON wp_postmeta(meta_key, meta_value) WHERE meta_key='event_start_datetime';
  ```

### Images
- Compress featured images (WebP format recommended)
- Lazy loading enabled by default in WordPress 5.5+
- Use CDN for image delivery

### AJAX
- Limit events per page (currently 12, configurable in functions.php)
- Add pagination for large result sets
- Consider infinite scroll for better UX

---

## 📱 Mobile Optimization

### Responsive Breakpoints

```css
@media (max-width: 768px) {
    /* Tablet & Mobile */
    - Heading font-size reduced
    - Search form stacks vertically
    - Grid columns adjust automatically
}

@media (max-width: 480px) {
    /* Small Mobile */
    - Further size adjustments
    - Increased touch target sizes
}
```

### Touch Interactions
- Star rating: Large touch targets (2.5em)
- Buttons: Min 44x44px (WCAG guideline)
- Swipe-friendly card layouts

---

## 🐛 Troubleshooting

### AJAX Filter Not Working

**Check:**
1. jQuery loaded: `wp_enqueue_script('jquery')`
2. Admin AJAX URL correct: `<?php echo admin_url('admin-ajax.php'); ?>`
3. Browser console for JS errors
4. Network tab for AJAX request/response

**Common Fix:**
Clear cache (browser + server) and regenerate permalinks.

### Reviews Not Showing

**Check:**
1. Review post type registered: Go to **Events → Event Reviews**
2. Review status is "Publish" (not "Pending")
3. `partials/event-reviews.php` file exists
4. File permissions: 644 for files, 755 for directories

**Debug:**
```php
// Add to functions.php temporarily
add_action('wp_footer', function() {
    $reviews = get_posts(array('post_type' => 'event_review', 'post_status' => 'publish'));
    echo '<pre>' . print_r($reviews, true) . '</pre>';
});
```

### Rating Not Updating

**Check:**
1. Post meta `_event_rating_average` exists
2. `majelis_update_event_rating()` function running
3. Hook `transition_post_status` attached

**Manual Recalculation:**
Go to **Events → Event Reviews**, edit any review, and hit "Update" (without changes). This triggers rating recalculation.

---

## 📚 References & Inspiration

### Goers Platform
- **Website:** [goersapp.com](https://www.goersapp.com)
- **Founded:** 2015
- **Track Record:** 25+ million tickets sold
- **Clients:** Telkomsel, Mekari, Seraya Group
- **Features:** GTS Scanner, POS, Waiting Room, Seating, Reviews

### Design Inspiration
- **Rating System:** Goers Rating & Review (50-8000 characters)
- **Explore Feed:** Goers homepage redesign (Today, Tomorrow, This Week)
- **Customer Support:** 2-5 minute response time (08:00-20:00 WIB)
- **Testimonials:** Real feedback from major event organizers

### Sources
- [Goers YES - Event Management Solution](https://www.goersapp.com/yes/)
- [GOERS - Tickets, Event, Travel on Google Play](https://play.google.com/store/apps/details?id=com.goersapp.goers)
- [Goers Rating & Review Feature](https://www.goersapp.com/blog/goers-rating-review/)
- [Waiting Room Feature](https://www.goersapp.com/blog/waiting-room-goers/)

---

## 🎯 Next Steps & Enhancements

### Phase 2 (Future Considerations)

1. **Advanced Filters**
   - Location-based (auto-detect)
   - Speaker/Ustadz filter
   - Price range filter

2. **Personalization Engine**
   - User preference tracking
   - Recommended events based on history
   - Save favorite events

3. **Notification System**
   - Email reminder 24h before event
   - Push notification for new events
   - Review response from organizer

4. **Social Features**
   - "Going" / "Interested" buttons
   - Share to story (Instagram, Facebook)
   - Invite friends feature

5. **Analytics Dashboard**
   - Event views tracking
   - Click-through rates
   - Popular categories
   - Review sentiment analysis

6. **Organizer Tools**
   - Self-service event submission form
   - Real-time ticket sales (if applicable)
   - Attendee management
   - QR code check-in

---

## 💡 Pro Tips

### For Admins
1. **Moderate Reviews Daily:** Check pending reviews every morning
2. **Feature Quality Events:** Add to "Featured" category for homepage highlight
3. **Update Testimonials:** Refresh every quarter with new feedback
4. **Monitor Analytics:** Track which filters users use most

### For Event Organizers
1. **Ask for Reviews:** Send follow-up email after event
2. **Respond to Reviews:** Engage with reviewers (build feature for this)
3. **Use High-Quality Images:** Featured image is crucial for CTR
4. **Write Clear Descriptions:** Use the standardized event template structure

### For Developers
1. **Test on Real Data:** Import sample events for testing
2. **Profile AJAX Queries:** Use Query Monitor plugin
3. **Version Control:** Always test in staging first
4. **Backup Before Deploy:** Database + files before major updates

---

## 📞 Support

Jika ada pertanyaan atau masalah:

- WhatsApp: +62 899-9150-143
- Email: info@majelis.info
- Documentation: Check `NEW-TEMPLATES-GUIDE.md` for related features

---

**Dibuat dengan ❤️ untuk Majelis.info**
*Platform Jadwal Kajian & Majelis Ilmu Terpercaya*

Inspired by the best practices of [Goersapp.com](https://www.goersapp.com) 🚀
