/**
 * Majelis.info Custom Styles - Code Snippets Version
 *
 * CARA PAKAI:
 * 1. Install plugin "Code Snippets" dari WordPress.org
 * 2. Dashboard → Snippets → Add New
 * 3. Title: "Majelis Custom Styles"
 * 4. Copy SEMUA code di bawah ini (mulai dari baris "function majelis...")
 * 5. Paste ke Code box
 * 6. Save Changes and Activate
 * 7. Refresh website dengan Ctrl+Shift+R
 */

function majelis_custom_styles_inject() {
    ?>
    <style id="majelis-custom-styles">
/* ============================================
   MAJELIS.INFO - COMPLETE CUSTOM STYLES
   ============================================ */

/* Color System & Typography */
:root {
  --primary-main: #1E40AF !important;
  --primary-light: #3B82F6 !important;
  --primary-dark: #1E3A8A !important;
  --secondary-main: #059669 !important;
  --secondary-light: #10B981 !important;
  --secondary-dark: #047857 !important;
  --accent-main: #F59E0B !important;
  --accent-light: #FBBF24 !important;
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

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
  color: var(--gray-800) !important;
  line-height: 1.6;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 600;
  line-height: 1.3;
  color: var(--gray-900);
}

h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.5rem; }

/* Hero Section */
.hero-section {
  position: relative;
  min-height: 600px;
  background: linear-gradient(135deg, rgba(30, 64, 175, 0.95) 0%, rgba(5, 150, 105, 0.9) 100%),
              url('images/hero-bg.jpg') center/cover no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: var(--spacing-3xl) var(--spacing-md);
  overflow: hidden;
}

.hero-content {
  max-width: 800px;
  z-index: 10;
}

.hero-title {
  font-size: 3rem;
  font-weight: 700;
  color: white;
  margin-bottom: var(--spacing-lg);
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  animation: fadeInUp 0.8s ease-out;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: rgba(255, 255, 255, 0.95);
  margin-bottom: var(--spacing-2xl);
  animation: fadeInUp 0.8s ease-out 0.2s;
  animation-fill-mode: both;
}

.hero-search-box {
  background: white;
  border-radius: 50px;
  padding: var(--spacing-sm);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
  display: flex;
  gap: var(--spacing-sm);
  max-width: 600px;
  margin: 0 auto var(--spacing-xl);
  animation: fadeInUp 0.8s ease-out 0.4s;
  animation-fill-mode: both;
}

.hero-search-input {
  flex: 1;
  border: none;
  padding: var(--spacing-md) var(--spacing-lg);
  font-size: 1rem;
  outline: none;
  border-radius: 50px;
}

.hero-search-button {
  background: var(--accent-main);
  color: white;
  border: none;
  padding: var(--spacing-md) var(--spacing-2xl);
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.hero-search-button:hover {
  background: var(--accent-light);
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(245, 158, 11, 0.3);
}

/* Category Section */
.category-section {
  padding: var(--spacing-3xl) 0;
  background: var(--bg-secondary);
}

.section-title {
  text-align: center;
  font-size: 2rem;
  margin-bottom: var(--spacing-2xl);
  color: var(--gray-900);
}

.category-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: var(--spacing-lg);
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

.category-card {
  background: white;
  border-radius: 16px;
  padding: var(--spacing-xl);
  text-align: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid transparent;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.category-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary-main), var(--secondary-main));
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.category-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  border-color: var(--primary-light);
}

.category-card:hover::before {
  transform: scaleX(1);
}

.category-icon {
  font-size: 3rem;
  margin-bottom: var(--spacing-md);
  background: linear-gradient(135deg, var(--primary-main), var(--secondary-main));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
  transform: scale(1.1) rotate(5deg);
}

.category-name {
  font-weight: 600;
  color: var(--gray-800);
  margin-bottom: var(--spacing-xs);
}

.category-count {
  font-size: 0.875rem;
  color: var(--gray-500);
}

/* Event Cards */
.event-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  display: flex;
  flex-direction: column;
  height: 100%;
  border: 1px solid var(--gray-100);
}

.event-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  border-color: var(--primary-main);
}

.event-image-container {
  position: relative;
  width: 100%;
  padding-top: 56.25%;
  overflow: hidden;
  background: var(--gray-200);
}

.event-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.event-card:hover .event-image {
  transform: scale(1.1);
}

.event-image-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 50%;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
  pointer-events: none;
}

.event-badges {
  position: absolute;
  top: 12px;
  left: 12px;
  z-index: 10;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.event-badge {
  display: inline-flex;
  align-items: center;
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  animation: badgePulse 2s ease-in-out infinite;
}

.badge-featured {
  background: linear-gradient(135deg, #F59E0B, #FBBF24);
  color: white;
}

.badge-sold-out {
  background: #EF4444;
  color: white;
}

.badge-early-bird {
  background: linear-gradient(135deg, #10B981, #34D399);
  color: white;
}

.badge-new {
  background: linear-gradient(135deg, #3B82F6, #60A5FA);
  color: white;
}

.badge-trending {
  background: linear-gradient(135deg, #8B5CF6, #A78BFA);
  color: white;
}

@keyframes badgePulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.wishlist-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  width: 44px;
  height: 44px;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-radius: 50%;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 10;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.wishlist-btn:hover {
  background: white;
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.wishlist-btn.active {
  background: #EF4444;
  color: white;
}

.event-content {
  padding: 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.event-category {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  background: var(--primary-light);
  color: white;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  margin-bottom: 12px;
  align-self: flex-start;
  transition: background 0.3s ease;
}

.event-category:hover {
  background: var(--primary-dark);
}

.event-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--gray-900);
  margin-bottom: 8px;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: color 0.3s ease;
}

.event-card:hover .event-title {
  color: var(--primary-main);
}

.event-description {
  font-size: 0.875rem;
  color: var(--gray-600);
  line-height: 1.6;
  margin-bottom: 16px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
}

.event-meta {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 16px;
  padding-top: 12px;
  border-top: 1px solid var(--gray-100);
}

.event-meta-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.875rem;
  color: var(--gray-700);
}

.meta-icon {
  width: 18px;
  height: 18px;
  color: var(--primary-main);
  flex-shrink: 0;
}

.event-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding-top: 16px;
  border-top: 1px solid var(--gray-100);
}

.event-price {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--primary-main);
  line-height: 1;
}

.event-price.free {
  color: var(--success);
}

.btn-book-now {
  background: linear-gradient(135deg, var(--accent-main), var(--accent-light));
  color: white;
  padding: 10px 24px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.btn-book-now:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
}

.btn-view-details {
  background: white;
  color: var(--primary-main);
  border: 2px solid var(--primary-main);
  padding: 8px 20px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-view-details:hover {
  background: var(--primary-main);
  color: white;
}

.events-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px;
  margin: 0 auto;
  padding: 24px;
}

.event-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
  transition: left 0.6s;
  pointer-events: none;
}

.event-card:hover::after {
  left: 100%;
}

/* Statistics Section */
.stats-section {
  padding: var(--spacing-3xl) 0;
  background: linear-gradient(135deg, var(--primary-main), var(--primary-dark));
  color: white;
  text-align: center;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: var(--spacing-2xl);
  max-width: 1200px;
  margin: var(--spacing-2xl) auto 0;
  padding: 0 var(--spacing-md);
}

.stat-number {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: var(--spacing-sm);
  background: linear-gradient(135deg, white, var(--accent-light));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.stat-label {
  font-size: 1.125rem;
  opacity: 0.9;
}

/* CTA Section */
.cta-section {
  padding: var(--spacing-3xl) 0;
  background: var(--bg-secondary);
  text-align: center;
}

.btn-cta {
  background: linear-gradient(135deg, var(--accent-main), var(--accent-light));
  color: white;
  padding: var(--spacing-md) var(--spacing-3xl);
  border-radius: 50px;
  font-weight: 700;
  font-size: 1.125rem;
  border: none;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
  transition: all 0.3s ease;
  display: inline-block;
  text-decoration: none;
}

.btn-cta:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 32px rgba(245, 158, 11, 0.4);
}

/* Animations */
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

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title { font-size: 2rem; }
  .hero-subtitle { font-size: 1rem; }
  .hero-search-box {
    flex-direction: column;
    border-radius: 16px;
  }
  .category-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .events-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    padding: 16px;
  }
}

@media (max-width: 480px) {
  .category-grid { grid-template-columns: 1fr; }
  .stats-grid { grid-template-columns: 1fr; }
  .events-grid { grid-template-columns: 1fr; }
  .event-footer {
    flex-direction: column;
    align-items: stretch;
  }
  .btn-book-now,
  .btn-view-details {
    width: 100%;
    justify-content: center;
  }
}

/* Utility Classes */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-md);
}

.text-center { text-align: center; }
.fade-in { animation: fadeInUp 0.6s ease-out; }

/* Accessibility */
.event-card:focus-within {
  outline: 3px solid var(--primary-light);
  outline-offset: 2px;
}

.btn-book-now:focus,
.btn-view-details:focus,
.btn-cta:focus {
  outline: 3px solid var(--primary-light);
  outline-offset: 2px;
}
    </style>
    <?php
}
// Hook to wp_head with priority 999 (load after theme)
add_action('wp_head', 'majelis_custom_styles_inject', 999);
