/// App Configuration
/// API URLs, constants, and app settings
class AppConfig {
  // API Base URLs
  static const String baseUrl = 'https://majelis.info';
  static const String wordpressApiUrl = '$baseUrl/wp-json/wp/v2';
  static const String woocommerceApiUrl = '$baseUrl/wp-json/wc/v3';
  static const String meupApiUrl = '$baseUrl/wp-json/meup/v1';
  static const String jwtAuthUrl = '$baseUrl/wp-json/jwt-auth/v1';

  // App Info
  static const String appName = 'Majelis.info';
  static const String appVersion = '1.0.0';
  static const String appBuildNumber = '1';

  // Pagination
  static const int perPage = 10;
  static const int maxCacheAge = 3600; // 1 hour in seconds

  // Image Placeholder
  static const String placeholderImage = 'https://via.placeholder.com/400x300';

  // Social Media
  static const String facebookUrl = 'https://facebook.com/majelis.info';
  static const String instagramUrl = 'https://instagram.com/majelis.info';
  static const String twitterUrl = 'https://twitter.com/majelis_info';

  // Contact
  static const String supportEmail = 'support@majelis.info';
  static const String supportPhone = '+62812345678';

  // Feature Flags
  static const bool enableQRScanner = true;
  static const bool enableOfflineMode = true;
  static const bool enablePushNotifications = true;
  static const bool enableAnalytics = true;

  // Cache Keys
  static const String cacheKeyEvents = 'cached_events';
  static const String cacheKeyCategories = 'cached_categories';
  static const String cacheKeyUser = 'cached_user';
  static const String cacheKeyToken = 'auth_token';

  // WooCommerce Credentials (move to environment variables in production)
  static const String wooConsumerKey = 'YOUR_CONSUMER_KEY';
  static const String wooConsumerSecret = 'YOUR_CONSUMER_SECRET';
}
