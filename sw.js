/**
 * Service Worker for Majelis.info PWA
 * Provides offline functionality, caching, and background sync
 * Version: 1.0.0
 */

const CACHE_VERSION = 'majelis-v1.0.0';
const CACHE_STATIC = `${CACHE_VERSION}-static`;
const CACHE_DYNAMIC = `${CACHE_VERSION}-dynamic`;
const CACHE_IMAGES = `${CACHE_VERSION}-images`;
const CACHE_API = `${CACHE_VERSION}-api`;

// Files to cache immediately on install
const STATIC_ASSETS = [
  '/',
  '/manifest.json',
  '/offline.html', // Create this page later
  '/wp-content/themes/meup-child/style.css',
  '/majelis-master-styles.css'
];

// Maximum cache sizes
const MAX_DYNAMIC_CACHE_SIZE = 50;
const MAX_API_CACHE_SIZE = 30;
const MAX_IMAGE_CACHE_SIZE = 60;

/**
 * Install Event - Cache static assets
 */
self.addEventListener('install', (event) => {
  console.log('[Service Worker] Installing...', CACHE_VERSION);

  event.waitUntil(
    caches.open(CACHE_STATIC)
      .then((cache) => {
        console.log('[Service Worker] Caching static assets');
        return cache.addAll(STATIC_ASSETS);
      })
      .then(() => self.skipWaiting())
      .catch((err) => {
        console.error('[Service Worker] Installation failed:', err);
      })
  );
});

/**
 * Activate Event - Clean up old caches
 */
self.addEventListener('activate', (event) => {
  console.log('[Service Worker] Activating...', CACHE_VERSION);

  event.waitUntil(
    caches.keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames
            .filter((name) => name.startsWith('majelis-') && name !== CACHE_STATIC && name !== CACHE_DYNAMIC && name !== CACHE_IMAGES && name !== CACHE_API)
            .map((name) => {
              console.log('[Service Worker] Deleting old cache:', name);
              return caches.delete(name);
            })
        );
      })
      .then(() => self.clients.claim())
  );
});

/**
 * Fetch Event - Network first, fallback to cache
 */
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip non-GET requests
  if (request.method !== 'GET') {
    return;
  }

  // Skip chrome extensions and other protocols
  if (!request.url.startsWith('http')) {
    return;
  }

  // Handle API requests
  if (url.pathname.includes('/wp-json/')) {
    event.respondWith(handleAPIRequest(request));
    return;
  }

  // Handle image requests
  if (request.destination === 'image') {
    event.respondWith(handleImageRequest(request));
    return;
  }

  // Handle navigation requests
  if (request.mode === 'navigate') {
    event.respondWith(handleNavigationRequest(request));
    return;
  }

  // Handle other requests (CSS, JS, fonts)
  event.respondWith(handleStaticRequest(request));
});

/**
 * Handle API requests - Network first, cache fallback
 */
async function handleAPIRequest(request) {
  try {
    const networkResponse = await fetch(request);

    if (networkResponse.ok) {
      const cache = await caches.open(CACHE_API);
      cache.put(request, networkResponse.clone());
      await limitCacheSize(CACHE_API, MAX_API_CACHE_SIZE);
    }

    return networkResponse;
  } catch (error) {
    console.log('[Service Worker] Network failed, trying cache:', request.url);
    const cachedResponse = await caches.match(request);

    if (cachedResponse) {
      return cachedResponse;
    }

    // Return offline JSON response
    return new Response(
      JSON.stringify({
        error: 'Offline',
        message: 'Tidak ada koneksi internet. Data ini akan dimuat saat online.'
      }),
      {
        headers: { 'Content-Type': 'application/json' },
        status: 503
      }
    );
  }
}

/**
 * Handle image requests - Cache first, network fallback
 */
async function handleImageRequest(request) {
  const cachedResponse = await caches.match(request);

  if (cachedResponse) {
    return cachedResponse;
  }

  try {
    const networkResponse = await fetch(request);

    if (networkResponse.ok) {
      const cache = await caches.open(CACHE_IMAGES);
      cache.put(request, networkResponse.clone());
      await limitCacheSize(CACHE_IMAGES, MAX_IMAGE_CACHE_SIZE);
    }

    return networkResponse;
  } catch (error) {
    console.log('[Service Worker] Image fetch failed:', request.url);

    // Return placeholder image
    return new Response(
      '<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="300" fill="#f0f0f0"/><text x="50%" y="50%" text-anchor="middle" fill="#999" font-family="Arial" font-size="16">Gambar tidak tersedia</text></svg>',
      { headers: { 'Content-Type': 'image/svg+xml' } }
    );
  }
}

/**
 * Handle navigation requests - Network first, offline page fallback
 */
async function handleNavigationRequest(request) {
  try {
    const networkResponse = await fetch(request);

    if (networkResponse.ok) {
      const cache = await caches.open(CACHE_DYNAMIC);
      cache.put(request, networkResponse.clone());
      await limitCacheSize(CACHE_DYNAMIC, MAX_DYNAMIC_CACHE_SIZE);
    }

    return networkResponse;
  } catch (error) {
    console.log('[Service Worker] Navigation failed, showing offline page');

    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    }

    // Return offline page
    const offlinePage = await caches.match('/offline.html');
    return offlinePage || new Response(
      '<h1>Offline</h1><p>Tidak ada koneksi internet. Silakan coba lagi nanti.</p>',
      { headers: { 'Content-Type': 'text/html' } }
    );
  }
}

/**
 * Handle static asset requests - Cache first, network fallback
 */
async function handleStaticRequest(request) {
  const cachedResponse = await caches.match(request);

  if (cachedResponse) {
    return cachedResponse;
  }

  try {
    const networkResponse = await fetch(request);

    if (networkResponse.ok) {
      const cache = await caches.open(CACHE_STATIC);
      cache.put(request, networkResponse.clone());
    }

    return networkResponse;
  } catch (error) {
    console.log('[Service Worker] Static asset fetch failed:', request.url);
    return new Response('Offline', { status: 503 });
  }
}

/**
 * Limit cache size by removing oldest entries
 */
async function limitCacheSize(cacheName, maxSize) {
  const cache = await caches.open(cacheName);
  const keys = await cache.keys();

  if (keys.length > maxSize) {
    const keysToDelete = keys.slice(0, keys.length - maxSize);
    await Promise.all(keysToDelete.map(key => cache.delete(key)));
  }
}

/**
 * Background Sync - For offline ticket purchases
 */
self.addEventListener('sync', (event) => {
  console.log('[Service Worker] Background sync triggered:', event.tag);

  if (event.tag === 'sync-bookings') {
    event.waitUntil(syncOfflineBookings());
  }

  if (event.tag === 'sync-favorites') {
    event.waitUntil(syncFavorites());
  }
});

/**
 * Sync offline bookings when connection is restored
 */
async function syncOfflineBookings() {
  try {
    console.log('[Service Worker] Syncing offline bookings...');

    // Get pending bookings from IndexedDB (implement later)
    // Send to server via API
    // Remove from local storage on success

    return Promise.resolve();
  } catch (error) {
    console.error('[Service Worker] Booking sync failed:', error);
    throw error;
  }
}

/**
 * Sync favorites
 */
async function syncFavorites() {
  try {
    console.log('[Service Worker] Syncing favorites...');
    // Implement favorites sync logic
    return Promise.resolve();
  } catch (error) {
    console.error('[Service Worker] Favorites sync failed:', error);
    throw error;
  }
}

/**
 * Push Notification Handler
 */
self.addEventListener('push', (event) => {
  console.log('[Service Worker] Push notification received');

  let data = {
    title: 'Majelis.info',
    body: 'Ada update baru!',
    icon: '/wp-content/themes/meup-child/assets/icons/icon-192x192.png',
    badge: '/wp-content/themes/meup-child/assets/icons/badge-72x72.png'
  };

  if (event.data) {
    data = event.data.json();
  }

  event.waitUntil(
    self.registration.showNotification(data.title, {
      body: data.body,
      icon: data.icon,
      badge: data.badge,
      vibrate: [200, 100, 200],
      data: {
        url: data.url || '/'
      }
    })
  );
});

/**
 * Notification Click Handler
 */
self.addEventListener('notificationclick', (event) => {
  console.log('[Service Worker] Notification clicked');

  event.notification.close();

  const urlToOpen = event.notification.data?.url || '/';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true })
      .then((clientList) => {
        // Check if there's already a window open
        for (const client of clientList) {
          if (client.url === urlToOpen && 'focus' in client) {
            return client.focus();
          }
        }

        // Open new window
        if (clients.openWindow) {
          return clients.openWindow(urlToOpen);
        }
      })
  );
});

/**
 * Message Handler - Communication with main thread
 */
self.addEventListener('message', (event) => {
  console.log('[Service Worker] Message received:', event.data);

  if (event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }

  if (event.data.type === 'CLEAR_CACHE') {
    event.waitUntil(
      caches.keys().then((cacheNames) => {
        return Promise.all(
          cacheNames.map((name) => caches.delete(name))
        );
      })
    );
  }

  if (event.data.type === 'GET_VERSION') {
    event.ports[0].postMessage({ version: CACHE_VERSION });
  }
});

console.log('[Service Worker] Loaded successfully', CACHE_VERSION);
