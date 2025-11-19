# 🎨 Design Improvement Guide
# majelis.info - Visual & UX Enhancement Plan

## 📋 Overview

**Current Theme:** MeUp Event Marketplace
**Website:** https://majelis.info
**Goal:** Create a modern, professional, and user-friendly Islamic event marketplace

---

## 🎯 Design Principles

### 1. Islamic & Professional Aesthetic
- Clean, minimal design
- Trust and credibility
- Cultural sensitivity
- Modern yet respectful

### 2. User-Centric Design
- Easy navigation
- Clear call-to-actions
- Fast loading
- Mobile-first approach

### 3. Conversion-Focused
- Clear event information
- Simple booking process
- Trust signals
- Social proof

---

## 🎨 Color Palette

### Primary Color Scheme

**Option 1: Trust & Professionalism (Recommended)**
```css
:root {
  /* Primary Colors */
  --primary-main: #1E40AF;        /* Deep Blue - Trust, stability */
  --primary-light: #3B82F6;       /* Lighter blue for hover states */
  --primary-dark: #1E3A8A;        /* Darker for text/borders */

  /* Secondary Colors */
  --secondary-main: #059669;      /* Emerald Green - Growth, success */
  --secondary-light: #10B981;     /* Light green for accents */
  --secondary-dark: #047857;      /* Dark green */

  /* Accent Colors */
  --accent-main: #F59E0B;         /* Amber - Energy, attention */
  --accent-light: #FBBF24;        /* Light amber */

  /* Neutral Colors */
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

  /* Semantic Colors */
  --success: #10B981;
  --warning: #F59E0B;
  --error: #EF4444;
  --info: #3B82F6;

  /* Background */
  --bg-primary: #FFFFFF;
  --bg-secondary: #F9FAFB;
  --bg-tertiary: #F3F4F6;
}
```

**Option 2: Islamic Traditional**
```css
:root {
  --primary-main: #2C5F2D;        /* Deep Green (Islamic color) */
  --secondary-main: #D4AF37;      /* Gold - Luxury */
  --accent-main: #8B4513;         /* Brown - Earthy */
}
```

### Color Usage Guidelines

**Primary Blue:**
- Main navigation
- Primary buttons
- Links
- Headers

**Secondary Green:**
- Success states
- Secondary buttons
- Positive actions
- Icons

**Accent Amber:**
- Call-to-action buttons
- Featured badges
- Price tags
- Important highlights

**Gray Scale:**
- Text hierarchy
- Borders
- Backgrounds
- Disabled states

---

## 🔤 Typography

### Font Families

**Option 1: Modern & Clean (Recommended)**
```css
/* Headings */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

/* Body Text */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Poppins', sans-serif;
}
```

**Option 2: With Arabic Support**
```css
/* For bilingual sites */
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap');

[lang="ar"] {
  font-family: 'Noto Sans Arabic', sans-serif;
}
```

### Typography Scale

```css
/* Headings */
h1 { font-size: 2.5rem; font-weight: 700; line-height: 1.2; }    /* 40px */
h2 { font-size: 2rem; font-weight: 600; line-height: 1.3; }       /* 32px */
h3 { font-size: 1.5rem; font-weight: 600; line-height: 1.4; }     /* 24px */
h4 { font-size: 1.25rem; font-weight: 600; line-height: 1.5; }    /* 20px */
h5 { font-size: 1rem; font-weight: 600; line-height: 1.5; }       /* 16px */
h6 { font-size: 0.875rem; font-weight: 600; line-height: 1.5; }   /* 14px */

/* Body Text */
.text-lg { font-size: 1.125rem; }    /* 18px */
.text-base { font-size: 1rem; }       /* 16px */
.text-sm { font-size: 0.875rem; }     /* 14px */
.text-xs { font-size: 0.75rem; }      /* 12px */

/* Font Weights */
.font-light { font-weight: 300; }
.font-normal { font-weight: 400; }
.font-medium { font-weight: 500; }
.font-semibold { font-weight: 600; }
.font-bold { font-weight: 700; }
```

---

## 📐 Spacing & Layout

### Spacing System

```css
/* Use consistent spacing scale */
--spacing-0: 0;
--spacing-1: 0.25rem;   /* 4px */
--spacing-2: 0.5rem;    /* 8px */
--spacing-3: 0.75rem;   /* 12px */
--spacing-4: 1rem;      /* 16px */
--spacing-5: 1.25rem;   /* 20px */
--spacing-6: 1.5rem;    /* 24px */
--spacing-8: 2rem;      /* 32px */
--spacing-10: 2.5rem;   /* 40px */
--spacing-12: 3rem;     /* 48px */
--spacing-16: 4rem;     /* 64px */
--spacing-20: 5rem;     /* 80px */
--spacing-24: 6rem;     /* 96px */
```

### Container & Grid

```css
/* Container */
.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Grid System */
.grid {
  display: grid;
  gap: 1.5rem;
}

.grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
.grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
.grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
.grid-cols-4 { grid-template-columns: repeat(4, 1fr); }

/* Responsive */
@media (max-width: 768px) {
  .grid-cols-2,
  .grid-cols-3,
  .grid-cols-4 {
    grid-template-columns: 1fr;
  }
}
```

---

## 🏠 Homepage Design

### 1. Header / Navigation

**Design:**
```
┌────────────────────────────────────────────────────┐
│ [Logo]  Home Events Categories Vendors  [Search🔍]│
│                                  Login | Register  │
└────────────────────────────────────────────────────┘
```

**Improvements:**
- [ ] Sticky header on scroll
- [ ] Search bar prominent in header
- [ ] Mobile hamburger menu
- [ ] User profile dropdown (when logged in)
- [ ] Cart/booking counter badge
- [ ] Language switcher (if bilingual)

**Code Example:**
```css
.site-header {
  position: sticky;
  top: 0;
  z-index: 1000;
  background: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.site-header.scrolled {
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
```

---

### 2. Hero Section

**Layout Options:**

**Option A: Full-Width Background Image**
```
┌────────────────────────────────────────────────────┐
│                                                    │
│           Discover Amazing Islamic Events         │
│         Connect, Learn, and Grow Together         │
│                                                    │
│   [Search Events: Keyword, Category, Location]    │
│                                                    │
│           [Explore Events Button]                 │
│                                                    │
└────────────────────────────────────────────────────┘
```

**Option B: Split Layout**
```
┌─────────────────────────┬──────────────────────────┐
│                         │                          │
│  Discover Amazing       │   [Beautiful Event       │
│  Islamic Events         │    Image/Illustration]   │
│                         │                          │
│  [Search Bar]           │                          │
│  [Browse Events]        │                          │
│                         │                          │
└─────────────────────────┴──────────────────────────┘
```

**Design Elements:**
- [ ] High-quality background image or video
- [ ] Overlay gradient for text readability
- [ ] Large, bold headline (H1)
- [ ] Clear value proposition
- [ ] Prominent search bar
- [ ] Strong CTA button
- [ ] Subtle animation on load

**CSS Example:**
```css
.hero-section {
  min-height: 600px;
  background: linear-gradient(135deg, rgba(30,64,175,0.9), rgba(5,150,105,0.8)),
              url('hero-image.jpg') center/cover;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
}

.hero-title {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.hero-search {
  max-width: 600px;
  margin: 2rem auto;
  background: white;
  border-radius: 50px;
  padding: 0.5rem;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}
```

---

### 3. Event Categories

**Layout:**
```
        Browse Events by Category

┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐
│  [📿]   │ │  [📚]   │ │  [🕌]   │ │  [🎓]   │
│ Islamic │ │ Seminar │ │ Worship │ │  Study  │
│  Talks  │ │         │ │         │ │  Circle │
└─────────┘ └─────────┘ └─────────┘ └─────────┘

┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐
│  [🎤]   │ │  [🤝]   │ │  [💼]   │ │  [👥]   │
│ Lecture │ │ Charity │ │Business │ │Community│
└─────────┘ └─────────┘ └─────────┘ └─────────┘
```

**Design Improvements:**
- [ ] Icon + text labels
- [ ] Hover effects (scale, shadow)
- [ ] Consistent icon style
- [ ] Event count per category
- [ ] Gradient backgrounds
- [ ] Smooth transitions

**CSS Example:**
```css
.category-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  cursor: pointer;
}

.category-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.15);
  border-color: var(--primary-main);
}

.category-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  background: linear-gradient(135deg, var(--primary-main), var(--secondary-main));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
```

---

### 4. Featured Events Slider

**Layout:**
```
           Featured Events This Month

┌──────────────────────────────────────────────────┐
│ ←                                              → │
│  ┌────────────┬────────────┬────────────┐       │
│  │ Event 1    │ Event 2    │ Event 3    │       │
│  │ [Image]    │ [Image]    │ [Image]    │       │
│  │ Title      │ Title      │ Title      │       │
│  │ Date       │ Date       │ Date       │       │
│  │ Price      │ Price      │ Price      │       │
│  └────────────┴────────────┴────────────┘       │
│              ● ○ ○ ○                            │
└──────────────────────────────────────────────────┘
```

**Features:**
- [ ] Auto-play carousel
- [ ] Navigation arrows
- [ ] Dot indicators
- [ ] Swipe gestures (mobile)
- [ ] 3-4 events visible (desktop)
- [ ] 1 event visible (mobile)
- [ ] Smooth transitions

**Libraries:**
- Swiper.js
- Slick Slider
- Or native CSS scroll-snap

---

### 5. Event Cards Design

**Modern Card Layout:**
```
┌─────────────────────────────┐
│    [Event Image]            │
│    ┌─────┐                  │
│    │SOLD │ (badge)          │
│    │ OUT │                  │
│    └─────┘                  │
├─────────────────────────────┤
│ [Category Badge]            │
│ Event Title Here            │
│ Short description...        │
│                             │
│ 📅 Dec 25, 2025            │
│ 📍 Jakarta Convention      │
│ 👥 150 going               │
│                             │
│ Rp 150,000  [Book Now →]   │
└─────────────────────────────┘
```

**Design Elements:**
- [ ] High-quality event image (16:9 ratio)
- [ ] Gradient overlay on image
- [ ] Wishlist heart icon (top-right)
- [ ] Status badges (Sold Out, Early Bird, etc)
- [ ] Category tag
- [ ] Event meta info with icons
- [ ] Price prominence
- [ ] Clear CTA button
- [ ] Hover effect

**CSS Example:**
```css
.event-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.event-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.event-image {
  position: relative;
  height: 200px;
  overflow: hidden;
}

.event-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.event-card:hover .event-image img {
  transform: scale(1.1);
}

.event-badge {
  position: absolute;
  top: 1rem;
  left: 1rem;
  background: var(--accent-main);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 600;
}

.wishlist-icon {
  position: absolute;
  top: 1rem;
  right: 1rem;
  width: 40px;
  height: 40px;
  background: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.wishlist-icon:hover {
  background: var(--error);
  color: white;
  transform: scale(1.1);
}
```

---

### 6. Statistics / Social Proof

**Layout:**
```
        Why Choose Majelis.info?

┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐
│  500+   │ │ 10,000+ │ │   50+   │ │  4.8/5  │
│ Events  │ │ Tickets │ │ Vendors │ │ Rating  │
│  Listed │ │  Sold   │ │  Active │ │         │
└─────────┘ └─────────┘ └─────────┘ └─────────┘
```

**Features:**
- [ ] Animated counters (count up on scroll)
- [ ] Icons for each stat
- [ ] Background gradient or pattern
- [ ] Trustworthy metrics

**JavaScript (Counter Animation):**
```javascript
// Animate counter on scroll
const animateCounter = (element, target) => {
  let current = 0;
  const increment = target / 100;
  const timer = setInterval(() => {
    current += increment;
    element.textContent = Math.floor(current);
    if (current >= target) {
      element.textContent = target;
      clearInterval(timer);
    }
  }, 20);
};

// Trigger on scroll into view
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const counter = entry.target;
      const target = parseInt(counter.dataset.target);
      animateCounter(counter, target);
      observer.unobserve(counter);
    }
  });
});

document.querySelectorAll('.counter').forEach(counter => {
  observer.observe(counter);
});
```

---

### 7. How It Works Section

**Layout:**
```
           How to Book Your Event

   ①                 ②                 ③
┌─────────┐      ┌─────────┐      ┌─────────┐
│  [🔍]   │  →   │  [🎫]   │  →   │  [✓]    │
│ Browse  │      │  Book   │      │ Attend  │
│ Events  │      │ Tickets │      │  Event  │
└─────────┘      └─────────┘      └─────────┘

  Find your      Select tickets    Receive QR
  perfect        and checkout      code ticket
  event
```

**Design:**
- [ ] 3-4 simple steps
- [ ] Large icons
- [ ] Connecting arrows/lines
- [ ] Brief description
- [ ] Minimal text

---

### 8. Testimonials

**Layout:**
```
        What Our Users Say

┌─────────────────────────────────────────────┐
│  ⭐⭐⭐⭐⭐                                  │
│  "Amazing platform! Easy to find Islamic    │
│   events and book tickets. Highly           │
│   recommended!"                             │
│                                             │
│  - Ahmad Yusuf, Jakarta                     │
│  [Profile Photo]                            │
└─────────────────────────────────────────────┘
```

**Features:**
- [ ] Star ratings
- [ ] User photos
- [ ] Name & location
- [ ] Carousel/slider
- [ ] 3-5 testimonials

---

### 9. Call-to-Action (CTA) Section

**Layout:**
```
┌────────────────────────────────────────────────┐
│                                                │
│        Ready to Discover Amazing Events?       │
│        Join thousands of event-goers today!    │
│                                                │
│              [Get Started →]                   │
│                                                │
└────────────────────────────────────────────────┘
```

**Design:**
- [ ] Gradient or colored background
- [ ] Large, clear headline
- [ ] Single, prominent button
- [ ] Contrasting colors

---

### 10. Footer

**Layout:**
```
┌────────────────────────────────────────────────────┐
│  About Us     Events       Support      Connect    │
│  Our Story    Categories   Help Center  Facebook   │
│  Team         Upcoming     FAQs         Twitter    │
│  Careers      Past         Contact      Instagram  │
│                                                     │
│  Newsletter: [Email Address] [Subscribe]           │
│                                                     │
│  © 2025 Majelis.info | Privacy | Terms             │
└────────────────────────────────────────────────────┘
```

**Features:**
- [ ] 4-column layout (responsive to 1 column on mobile)
- [ ] Newsletter signup
- [ ] Social media icons
- [ ] Contact information
- [ ] Sitemap links
- [ ] Payment method icons
- [ ] Copyright & legal links

---

## 📄 Inner Pages Design

### Event Detail Page

**Layout:**
```
┌────────────────────────────────────────────────┐
│ Breadcrumb: Home > Events > Islamic Conference │
├────────────────────────────────────────────────┤
│                                                │
│  Event Image Gallery (Main + Thumbnails)       │
│                                                │
├────────────────┬───────────────────────────────┤
│                │  Event Title                  │
│                │  ⭐⭐⭐⭐⭐ (4.5) 120 reviews│
│  Sticky        │  📅 Dec 25, 2025             │
│  Sidebar       │  📍 Jakarta Convention Center│
│                │  👤 Organized by: Islamic Org│
│  [Ticket       │                               │
│   Selection]   │  About This Event             │
│                │  Lorem ipsum dolor sit amet...│
│  Price         │                               │
│  Rp 150,000    │  Event Schedule               │
│                │  09:00 - Registration         │
│  [Book Now]    │  10:00 - Opening Speech       │
│                │  ...                          │
│  Share:        │                               │
│  [Social]      │  Location Map                 │
│                │  [Google Map Embed]           │
│  Wishlist      │                               │
│  [❤️]          │  Organizer Info               │
│                │  [Contact Details]            │
│                │                               │
│                │  Reviews & Ratings            │
│                │  [User Reviews]               │
│                │                               │
│                │  Similar Events               │
│                │  [Event Cards]                │
└────────────────┴───────────────────────────────┘
```

**Key Features:**
- [ ] Image gallery with lightbox
- [ ] Sticky booking sidebar
- [ ] Breadcrumbs navigation
- [ ] Share buttons
- [ ] Wishlist/save button
- [ ] Event countdown timer
- [ ] Attendee count
- [ ] Organizer verification badge
- [ ] Map integration
- [ ] Reviews & ratings
- [ ] Similar events recommendations
- [ ] FAQ accordion
- [ ] Terms & conditions

---

## 📱 Mobile Responsiveness

### Mobile-First Approach

**Breakpoints:**
```css
/* Mobile First */
@media (min-width: 640px) { /* sm */ }
@media (min-width: 768px) { /* md */ }
@media (min-width: 1024px) { /* lg */ }
@media (min-width: 1280px) { /* xl */ }
@media (min-width: 1536px) { /* 2xl */ }
```

### Mobile Optimizations:
- [ ] Hamburger menu
- [ ] Touch-friendly buttons (min 44x44px)
- [ ] Simplified navigation
- [ ] Collapsible sections
- [ ] Bottom navigation bar (optional)
- [ ] Swipe gestures
- [ ] Optimized images (WebP, lazy loading)
- [ ] Fast loading (< 3 seconds)

---

## 🎭 UI Components Library

### Buttons

```css
/* Primary Button */
.btn-primary {
  background: var(--primary-main);
  color: white;
  padding: 0.75rem 2rem;
  border-radius: 8px;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(30,64,175,0.2);
}

.btn-primary:hover {
  background: var(--primary-dark);
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(30,64,175,0.3);
}

/* Secondary Button */
.btn-secondary {
  background: white;
  color: var(--primary-main);
  border: 2px solid var(--primary-main);
  padding: 0.75rem 2rem;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-secondary:hover {
  background: var(--primary-main);
  color: white;
}

/* CTA Button (Accent) */
.btn-cta {
  background: linear-gradient(135deg, var(--accent-main), var(--accent-light));
  color: white;
  padding: 1rem 2.5rem;
  border-radius: 50px;
  font-weight: 700;
  font-size: 1.125rem;
  border: none;
  cursor: pointer;
  box-shadow: 0 8px 16px rgba(245,158,11,0.3);
  transition: all 0.3s ease;
}

.btn-cta:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(245,158,11,0.4);
}
```

### Input Fields

```css
.form-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 2px solid var(--gray-300);
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-input:focus {
  outline: none;
  border-color: var(--primary-main);
  box-shadow: 0 0 0 3px rgba(30,64,175,0.1);
}

.form-label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: var(--gray-700);
}
```

### Badges

```css
.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.875rem;
  font-weight: 600;
}

.badge-primary { background: var(--primary-main); color: white; }
.badge-success { background: var(--success); color: white; }
.badge-warning { background: var(--warning); color: white; }
.badge-error { background: var(--error); color: white; }
```

### Cards

```css
.card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.card:hover {
  box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}

.card-header {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.card-body {
  color: var(--gray-600);
}
```

---

## ⚡ Performance Optimization

### 1. Image Optimization
```html
<!-- Use WebP with fallback -->
<picture>
  <source srcset="event-image.webp" type="image/webp">
  <img src="event-image.jpg" alt="Event" loading="lazy">
</picture>

<!-- Responsive images -->
<img
  srcset="image-320.jpg 320w,
          image-640.jpg 640w,
          image-1280.jpg 1280w"
  sizes="(max-width: 640px) 100vw,
         (max-width: 1280px) 50vw,
         33vw"
  src="image-640.jpg"
  alt="Event"
  loading="lazy">
```

### 2. Lazy Loading
```javascript
// Images
document.querySelectorAll('img[loading="lazy"]');

// Or use Intersection Observer for more control
const imageObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const img = entry.target;
      img.src = img.dataset.src;
      img.classList.add('loaded');
      observer.unobserve(img);
    }
  });
});

document.querySelectorAll('img[data-src]').forEach(img => {
  imageObserver.observe(img);
});
```

### 3. Critical CSS
```html
<!-- Inline critical CSS in <head> -->
<style>
  /* Above-the-fold styles */
  .header, .hero { /* ... */ }
</style>

<!-- Load rest of CSS asynchronously -->
<link rel="preload" href="styles.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
```

### 4. Minification
- Minify CSS, JS files
- Use Gzip compression
- Enable browser caching
- Use CDN for assets

---

## 🎨 Animation & Interactions

### Subtle Animations

```css
/* Fade in on scroll */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in-up {
  animation: fadeInUp 0.6s ease-out;
}

/* Hover grow */
.hover-grow {
  transition: transform 0.3s ease;
}

.hover-grow:hover {
  transform: scale(1.05);
}

/* Loading skeleton */
@keyframes skeleton-loading {
  0% { background-position: -200px 0; }
  100% { background-position: calc(200px + 100%) 0; }
}

.skeleton {
  background: linear-gradient(90deg, #f0f0f0 0px, #f8f8f8 40px, #f0f0f0 80px);
  background-size: 200px 100%;
  animation: skeleton-loading 1.4s ease infinite;
}
```

### Scroll Animations (AOS Library)
```html
<!-- Add AOS library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Use in HTML -->
<div data-aos="fade-up" data-aos-duration="1000">
  Content
</div>

<script>
  AOS.init();
</script>
```

---

## ✅ Design Checklist

### Visual Design
- [ ] Consistent color palette
- [ ] Typography hierarchy
- [ ] Proper spacing/whitespace
- [ ] High-quality images
- [ ] Icon consistency
- [ ] Brand identity

### User Experience
- [ ] Clear navigation
- [ ] Fast loading (< 3s)
- [ ] Mobile responsive
- [ ] Accessible (WCAG AA)
- [ ] Clear CTAs
- [ ] Breadcrumbs

### Trust & Credibility
- [ ] Professional design
- [ ] Social proof (testimonials, stats)
- [ ] Secure payment badges
- [ ] Contact information
- [ ] Privacy policy
- [ ] Terms & conditions

### Performance
- [ ] Optimized images (WebP)
- [ ] Lazy loading
- [ ] Minified CSS/JS
- [ ] Caching enabled
- [ ] CDN integration
- [ ] 90+ PageSpeed score

---

## 📊 A/B Testing Ideas

Test different variations:
- [ ] Hero headline
- [ ] CTA button text/color
- [ ] Event card layout
- [ ] Checkout flow
- [ ] Pricing display

---

## 📚 Design Resources

**UI Kits & Inspiration:**
- Dribbble: https://dribbble.com/tags/event-website
- Behance: Event marketplace designs
- Awwwards: Award-winning websites
- UI8: Event booking templates

**Tools:**
- Figma: Design prototypes
- Adobe XD: UI/UX design
- Canva: Graphics & social media
- TinyPNG: Image compression

**WordPress Plugins:**
- Elementor: Page builder
- WPBakery: Alternative builder
- Slider Revolution: Sliders
- WP Rocket: Performance

---

## 🎯 Next Steps

1. **Review Current Design**
   - Screenshot homepage
   - Identify pain points
   - List improvements

2. **Create Mockups**
   - Design in Figma/XD
   - Get feedback
   - Iterate

3. **Implement Changes**
   - Update theme files
   - Customize with CSS
   - Test thoroughly

4. **Monitor & Optimize**
   - Track user behavior
   - A/B test variations
   - Continuously improve

---

**Last Updated:** 2025-11-19
**Status:** Design Planning Phase
**Related:** [MEUP-OPTIMIZATION-PLAN.md](MEUP-OPTIMIZATION-PLAN.md)
