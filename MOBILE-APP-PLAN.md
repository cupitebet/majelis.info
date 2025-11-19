# 📱 Mobile App Development Plan
# majelis.info - Event Marketplace Mobile App

## 📋 Overview

**Repository:** https://github.com/cupitebet/appmobilewordpress
**Website:** https://majelis.info (WordPress + MeUp Theme)
**Platform:** iOS & Android
**Status:** New project (repository currently empty)

---

## 🎯 App Purpose & Features

### Primary Goal
Create a mobile companion app for majelis.info that allows users to:
- Browse and discover Islamic events
- Book tickets seamlessly
- Access tickets offline (QR code)
- Receive event notifications
- Manage bookings

### Target Users
1. **Event Attendees** - Browse & book events
2. **Event Organizers** - Scan tickets, manage events
3. **Vendors** - Manage their events on-the-go

---

## 🛠️ Technology Stack Recommendation

### Option 1: Flutter (RECOMMENDED ⭐)

**Why Flutter:**
- ✅ Single codebase for iOS & Android
- ✅ Fast development & hot reload
- ✅ Excellent performance (native compilation)
- ✅ Beautiful UI out of the box
- ✅ Strong WordPress REST API packages
- ✅ QR code scanning libraries available
- ✅ Good offline support

**Tech Stack:**
```yaml
Framework: Flutter 3.x
Language: Dart
State Management: Provider or Riverpod
API Integration: WordPress REST API + WooCommerce REST API
Database: SQLite (local storage)
Notifications: Firebase Cloud Messaging (FCM)
QR Scanner: qr_code_scanner package
Payments: Stripe, Midtrans, Xendit SDKs
```

**Pros:**
- Beautiful Material Design & Cupertino widgets
- Hot reload speeds up development
- Large community & packages
- Good documentation
- Performance close to native apps

**Cons:**
- Larger app size (~10-20MB)
- Learning curve if new to Dart

---

### Option 2: React Native

**Tech Stack:**
```json
Framework: React Native
Language: JavaScript/TypeScript
State Management: Redux or Context API
API: WordPress REST API
Database: Realm or AsyncStorage
Notifications: React Native Firebase
QR Scanner: react-native-camera
```

**Pros:**
- ✅ JavaScript ecosystem (familiar for web devs)
- ✅ Large community
- ✅ Many packages available
- ✅ Expo for rapid development

**Cons:**
- ❌ Bridge performance issues
- ❌ More dependencies
- ❌ Version upgrade challenges

---

### Option 3: Ionic (PWA + Native)

**Tech Stack:**
```json
Framework: Ionic + Capacitor
Language: TypeScript
Frontend: React/Vue/Angular
API: WordPress REST API
Database: IndexedDB / SQLite
```

**Pros:**
- ✅ Web technologies (HTML/CSS/JS)
- ✅ PWA support
- ✅ Easy deployment

**Cons:**
- ❌ Performance not as good as native
- ❌ Limited native features

---

## 🏗️ Recommended Architecture (Flutter)

### Project Structure
```
appmobilewordpress/
├── android/                 # Android native code
├── ios/                     # iOS native code
├── lib/
│   ├── main.dart           # App entry point
│   ├── app/
│   │   ├── routes.dart     # Navigation routes
│   │   ├── theme.dart      # App theme (colors, fonts)
│   │   └── constants.dart  # API URLs, constants
│   ├── core/
│   │   ├── api/
│   │   │   ├── wordpress_api.dart
│   │   │   ├── woocommerce_api.dart
│   │   │   └── auth_api.dart
│   │   ├── models/
│   │   │   ├── event.dart
│   │   │   ├── ticket.dart
│   │   │   ├── user.dart
│   │   │   └── booking.dart
│   │   ├── providers/
│   │   │   ├── event_provider.dart
│   │   │   ├── auth_provider.dart
│   │   │   └── booking_provider.dart
│   │   └── services/
│   │       ├── storage_service.dart
│   │       ├── notification_service.dart
│   │       └── qr_service.dart
│   ├── features/
│   │   ├── auth/
│   │   │   ├── login_screen.dart
│   │   │   ├── register_screen.dart
│   │   │   └── profile_screen.dart
│   │   ├── home/
│   │   │   ├── home_screen.dart
│   │   │   ├── widgets/
│   │   │   │   ├── event_card.dart
│   │   │   │   ├── category_chip.dart
│   │   │   │   └── featured_slider.dart
│   │   ├── events/
│   │   │   ├── event_list_screen.dart
│   │   │   ├── event_detail_screen.dart
│   │   │   ├── event_search_screen.dart
│   │   │   └── event_filter_screen.dart
│   │   ├── booking/
│   │   │   ├── booking_screen.dart
│   │   │   ├── checkout_screen.dart
│   │   │   ├── payment_screen.dart
│   │   │   └── booking_success_screen.dart
│   │   ├── tickets/
│   │   │   ├── my_tickets_screen.dart
│   │   │   ├── ticket_detail_screen.dart
│   │   │   └── qr_code_screen.dart
│   │   ├── scanner/
│   │   │   ├── qr_scanner_screen.dart
│   │   │   └── scan_result_screen.dart
│   │   └── vendor/ (if vendor features needed)
│   │       ├── vendor_dashboard.dart
│   │       ├── create_event_screen.dart
│   │       └── manage_bookings_screen.dart
│   ├── shared/
│   │   ├── widgets/
│   │   │   ├── custom_button.dart
│   │   │   ├── loading_indicator.dart
│   │   │   └── error_widget.dart
│   │   └── utils/
│   │       ├── formatters.dart
│   │       └── validators.dart
│   └── config/
│       └── app_config.dart
├── assets/
│   ├── images/
│   ├── icons/
│   └── fonts/
├── test/
├── pubspec.yaml            # Dependencies
└── README.md
```

---

## 📦 Required Flutter Packages

### pubspec.yaml
```yaml
dependencies:
  flutter:
    sdk: flutter

  # State Management
  provider: ^6.1.0

  # HTTP & API
  http: ^1.1.0
  dio: ^5.4.0  # Alternative to http with better features

  # WordPress Integration
  wordpress_api: ^1.0.0  # If available, or custom implementation

  # Local Storage
  shared_preferences: ^2.2.0
  sqflite: ^2.3.0

  # UI Components
  cached_network_image: ^3.3.0
  flutter_svg: ^2.0.9
  shimmer: ^3.0.0  # Loading placeholders

  # Navigation
  go_router: ^12.0.0

  # QR Code
  qr_code_scanner: ^1.0.1
  qr_flutter: ^4.1.0  # Generate QR codes

  # Notifications
  firebase_core: ^2.24.0
  firebase_messaging: ^14.7.0
  flutter_local_notifications: ^16.0.0

  # Payment
  stripe_payment: ^1.1.5  # For Stripe
  # midtrans_sdk: # For Midtrans (Indonesia)

  # Calendar & Date
  intl: ^0.18.0
  table_calendar: ^3.0.9

  # Map & Location
  google_maps_flutter: ^2.5.0
  geolocator: ^10.0.0

  # Authentication
  firebase_auth: ^4.15.0  # Optional

  # Image Picker (for profile, etc)
  image_picker: ^1.0.4

  # PDF Viewer (for tickets)
  flutter_pdfview: ^1.3.2

  # Sharing
  share_plus: ^7.2.0
  url_launcher: ^6.2.0

  # Analytics
  firebase_analytics: ^10.7.0

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.0
```

---

## 🔌 WordPress REST API Integration

### API Endpoints to Use

**WordPress Core API:**
```dart
// Base URL
const String baseUrl = 'https://majelis.info/wp-json';

// Events (Custom Post Type)
GET  /wp/v2/events                    // List events
GET  /wp/v2/events/{id}               // Event detail
GET  /wp/v2/events?category={id}      // Events by category
GET  /wp/v2/events?search={keyword}   // Search events

// Categories
GET  /wp/v2/event-categories          // Event categories

// Users / Authentication
POST /wp/v2/users/register            // Register
POST /jwt-auth/v1/token               // Login (JWT)
POST /wp/v2/users/me                  // Get current user
```

**WooCommerce REST API:**
```dart
// Base URL
const String wooBaseUrl = 'https://majelis.info/wp-json/wc/v3';

// Orders (Bookings)
GET  /orders                           // List user orders
POST /orders                           // Create booking/order
GET  /orders/{id}                      // Order detail

// Products (Tickets - if using WooCommerce)
GET  /products                         // List products/tickets
GET  /products/{id}                    // Product detail

// Payment Methods
GET  /payment_gateways                 // Available payment methods
```

**MeUp Custom Endpoints:**
```dart
// These may vary based on MeUp implementation
GET  /meup/v1/events                   // Custom event endpoint
POST /meup/v1/bookings                 // Create booking
GET  /meup/v1/bookings/{id}            // Booking detail
POST /meup/v1/tickets/validate         // Validate QR code
```

---

### API Service Implementation Example

**wordpress_api.dart**
```dart
import 'package:dio/dio.dart';

class WordPressAPI {
  final Dio _dio = Dio();
  static const String baseUrl = 'https://majelis.info/wp-json';

  // Get Events
  Future<List<Event>> getEvents({
    int page = 1,
    int perPage = 10,
    String? category,
    String? search,
  }) async {
    try {
      final response = await _dio.get(
        '$baseUrl/wp/v2/events',
        queryParameters: {
          'page': page,
          'per_page': perPage,
          if (category != null) 'category': category,
          if (search != null) 'search': search,
        },
      );

      return (response.data as List)
          .map((json) => Event.fromJson(json))
          .toList();
    } catch (e) {
      throw Exception('Failed to load events: $e');
    }
  }

  // Get Event Detail
  Future<Event> getEventDetail(int eventId) async {
    try {
      final response = await _dio.get('$baseUrl/wp/v2/events/$eventId');
      return Event.fromJson(response.data);
    } catch (e) {
      throw Exception('Failed to load event detail: $e');
    }
  }

  // Login with JWT
  Future<String> login(String username, String password) async {
    try {
      final response = await _dio.post(
        '$baseUrl/jwt-auth/v1/token',
        data: {
          'username': username,
          'password': password,
        },
      );
      return response.data['token'];
    } catch (e) {
      throw Exception('Login failed: $e');
    }
  }
}
```

---

## 🎨 App Screens & Features

### 1. Authentication
**Screens:**
- Splash Screen
- Onboarding (first time users)
- Login Screen
- Register Screen
- Forgot Password
- Profile Settings

**Features:**
- Email/password authentication
- Social login (Google, Facebook) - optional
- JWT token storage
- Auto-login with saved credentials

---

### 2. Home Screen
**Layout:**
```
┌─────────────────────────────────┐
│ Header (Logo, Search, Profile)  │
├─────────────────────────────────┤
│ Search Bar                      │
├─────────────────────────────────┤
│ Category Chips (Horizontal)     │
├─────────────────────────────────┤
│ Featured Events Slider          │
├─────────────────────────────────┤
│ Upcoming Events (Grid/List)     │
│ ┌───────┐ ┌───────┐            │
│ │Event 1│ │Event 2│            │
│ └───────┘ └───────┘            │
├─────────────────────────────────┤
│ Popular Events                  │
└─────────────────────────────────┘
```

**Features:**
- Dynamic content from WordPress
- Pull-to-refresh
- Infinite scroll
- Quick filters

---

### 3. Event Listing & Search
**Features:**
- Grid/List view toggle
- Sort by: Date, Price, Popularity
- Filters:
  - Category
  - Date range
  - Price range
  - Location
  - Event type (Physical/Virtual)
- Search with autocomplete
- Map view (optional)

---

### 4. Event Detail Screen
**Information Display:**
```
┌─────────────────────────────────┐
│ Event Image (Carousel)          │
├─────────────────────────────────┤
│ Event Title                     │
│ Date & Time | Location          │
│ Price | Attendees               │
├─────────────────────────────────┤
│ [Book Now Button]               │
├─────────────────────────────────┤
│ About Event (Description)       │
├─────────────────────────────────┤
│ Schedule / Agenda               │
├─────────────────────────────────┤
│ Organizer Info                  │
├─────────────────────────────────┤
│ Map (if physical event)         │
├─────────────────────────────────┤
│ Similar Events                  │
└─────────────────────────────────┘
```

**Actions:**
- Book ticket
- Share event
- Add to favorites
- Add to calendar
- Get directions (if physical)

---

### 5. Booking & Checkout
**Flow:**
```
1. Select Ticket Type
   ├── Early Bird: Rp 100,000
   ├── Regular: Rp 150,000
   └── VIP: Rp 300,000

2. Quantity & Extra Services
   ├── Number of tickets
   └── Add-ons (parking, lunch, etc)

3. Customer Information
   ├── Name
   ├── Email
   ├── Phone
   └── Special requests

4. Review Order
   ├── Order summary
   ├── Total amount
   └── Terms & conditions

5. Payment
   ├── Choose payment method
   ├── Enter payment details
   └── Complete payment

6. Confirmation
   ├── Order number
   ├── Ticket(s) generated
   └── Email sent
```

**Payment Integration:**
- Stripe
- Midtrans (Indonesia)
- Bank Transfer
- E-wallet (GoPay, OVO, etc)

---

### 6. My Tickets
**Features:**
- List of all booked tickets
- Status: Upcoming, Past, Cancelled
- Ticket details
- QR code for each ticket
- Offline access to tickets
- Download ticket PDF
- Share ticket
- Request refund

**Ticket Card:**
```
┌───────────────────────────────┐
│ Event Name                    │
│ Date & Time                   │
│ Location                      │
│ Ticket Type: VIP              │
│ [QR Code]                     │
│ Ticket ID: #123456            │
│ [View Details] [Download PDF] │
└───────────────────────────────┘
```

---

### 7. QR Code Scanner (for Organizers)
**Features:**
- Scan attendee tickets
- Real-time validation
- Check-in confirmation
- View attendee info
- Offline mode (sync later)
- Scan history

**Scanner Flow:**
```
1. Open Scanner
2. Scan QR Code on Ticket
3. Validate with Server
4. Show Result:
   ├── ✅ Valid - Grant Entry
   ├── ❌ Invalid - Deny
   ├── ⚠️ Already Used
   └── ⏳ Pending Verification
```

---

### 8. Profile & Settings
**Sections:**
- Profile Info (edit name, email, phone)
- My Bookings
- Payment Methods
- Notifications Settings
- Language (English, Bahasa)
- Help & Support
- Terms & Privacy
- Logout

---

### 9. Vendor Dashboard (Optional)
**For Event Organizers:**
- My Events (list, create, edit)
- Event Analytics
- Bookings Management
- Check-in Scanner
- Earnings & Payouts
- Customer Messages

---

## 🔔 Push Notifications

### Firebase Cloud Messaging (FCM) Setup

**Notification Types:**
1. **Event Reminders**
   - 1 day before event
   - 1 hour before event

2. **Booking Confirmations**
   - Ticket purchased
   - Payment confirmed

3. **Updates**
   - Event changes
   - New events in favorite categories

4. **Promotions**
   - Early bird discounts
   - Special offers

**Implementation:**
```dart
// notification_service.dart
import 'package:firebase_messaging/firebase_messaging.dart';

class NotificationService {
  final FirebaseMessaging _fcm = FirebaseMessaging.instance;

  Future<void> initialize() async {
    // Request permission
    NotificationSettings settings = await _fcm.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );

    // Get FCM token
    String? token = await _fcm.getToken();
    print('FCM Token: $token');

    // Send token to WordPress backend
    // Save in user meta for targeted notifications

    // Handle foreground messages
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      print('Got a message: ${message.notification?.title}');
      // Show local notification
    });

    // Handle notification taps
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      // Navigate to relevant screen
    });
  }
}
```

---

## 📴 Offline Functionality

### Features Available Offline:
- View saved tickets (QR codes)
- View event details (cached)
- Browse previously loaded events
- Access profile information

### Implementation:
```dart
// storage_service.dart
import 'package:sqflite/sqflite.dart';

class StorageService {
  static Database? _database;

  // Cache events
  Future<void> cacheEvents(List<Event> events) async {
    final db = await database;
    for (var event in events) {
      await db.insert('events', event.toMap(),
        conflictAlgorithm: ConflictAlgorithm.replace);
    }
  }

  // Get cached events
  Future<List<Event>> getCachedEvents() async {
    final db = await database;
    final List<Map<String, dynamic>> maps = await db.query('events');
    return List.generate(maps.length, (i) => Event.fromMap(maps[i]));
  }

  // Save tickets locally
  Future<void> saveTicket(Ticket ticket) async {
    final db = await database;
    await db.insert('tickets', ticket.toMap(),
      conflictAlgorithm: ConflictAlgorithm.replace);
  }
}
```

---

## 🎨 UI/UX Design Guidelines

### Color Scheme (Match majelis.info)
```dart
// theme.dart
class AppColors {
  static const primary = Color(0xFF1E40AF);      // Blue
  static const secondary = Color(0xFF059669);    // Green
  static const accent = Color(0xFFF59E0B);       // Orange
  static const textDark = Color(0xFF1F2937);
  static const textLight = Color(0xFF6B7280);
  static const background = Color(0xFFF9FAFB);
  static const white = Color(0xFFFFFFFF);
  static const error = Color(0xFFEF4444);
  static const success = Color(0xFF10B981);
}
```

### Typography
```dart
class AppTextStyles {
  static const heading1 = TextStyle(
    fontSize: 32,
    fontWeight: FontWeight.bold,
    fontFamily: 'Poppins',
  );

  static const heading2 = TextStyle(
    fontSize: 24,
    fontWeight: FontWeight.w600,
    fontFamily: 'Poppins',
  );

  static const body = TextStyle(
    fontSize: 16,
    fontWeight: FontWeight.normal,
    fontFamily: 'Inter',
  );

  static const caption = TextStyle(
    fontSize: 14,
    fontWeight: FontWeight.normal,
    fontFamily: 'Inter',
  );
}
```

### Spacing & Layout
```dart
class AppSpacing {
  static const double xs = 4.0;
  static const double sm = 8.0;
  static const double md = 16.0;
  static const double lg = 24.0;
  static const double xl = 32.0;
}
```

---

## 🚀 Development Roadmap

### Phase 1: Setup & Foundation (Week 1)
- [ ] Initialize Flutter project
- [ ] Setup project structure
- [ ] Configure dependencies (pubspec.yaml)
- [ ] Setup Firebase project
- [ ] Implement theme & styling
- [ ] Create reusable widgets

### Phase 2: Authentication (Week 2)
- [ ] Design login/register screens
- [ ] Implement WordPress JWT authentication
- [ ] Token storage & management
- [ ] Profile screen
- [ ] Password reset flow

### Phase 3: Event Features (Week 3-4)
- [ ] Home screen with featured events
- [ ] Event listing & search
- [ ] Event detail screen
- [ ] Category filters
- [ ] Favorites/wishlist
- [ ] Share functionality

### Phase 4: Booking System (Week 5-6)
- [ ] Booking flow UI
- [ ] Cart/order management
- [ ] WooCommerce integration
- [ ] Payment gateway integration
- [ ] Order confirmation
- [ ] Email notifications

### Phase 5: Tickets & QR (Week 7)
- [ ] My Tickets screen
- [ ] QR code generation
- [ ] Ticket detail view
- [ ] Download PDF ticket
- [ ] QR scanner (organizer feature)
- [ ] Offline ticket access

### Phase 6: Additional Features (Week 8)
- [ ] Push notifications
- [ ] Calendar integration
- [ ] Map integration
- [ ] Reviews & ratings
- [ ] Social sharing
- [ ] Analytics tracking

### Phase 7: Testing & Polish (Week 9-10)
- [ ] Unit testing
- [ ] Integration testing
- [ ] UI/UX testing
- [ ] Performance optimization
- [ ] Bug fixes
- [ ] Final polish

### Phase 8: Deployment (Week 11-12)
- [ ] Prepare app store assets
- [ ] Create app screenshots
- [ ] Write app description
- [ ] Submit to Google Play Store
- [ ] Submit to Apple App Store
- [ ] Beta testing with users

---

## 📱 App Store Requirements

### Google Play Store
- [ ] App icon (512x512 PNG)
- [ ] Feature graphic (1024x500 PNG)
- [ ] Screenshots (at least 2, up to 8)
- [ ] Privacy policy URL
- [ ] App description
- [ ] Developer account ($25 one-time)

### Apple App Store
- [ ] App icon (1024x1024 PNG)
- [ ] Screenshots for all devices
- [ ] App preview video (optional)
- [ ] Privacy policy
- [ ] App description
- [ ] Developer account ($99/year)

---

## 🔧 Backend Requirements (WordPress)

### Required WordPress Configurations

1. **Enable REST API:**
```php
// Already enabled by default in WordPress
// Ensure permalinks are set to "Post name"
```

2. **Install JWT Authentication Plugin:**
```bash
# Install JWT Authentication for WP REST API
wp plugin install jwt-authentication-for-wp-rest-api --activate

# Configure wp-config.php
define('JWT_AUTH_SECRET_KEY', 'your-secret-key');
define('JWT_AUTH_CORS_ENABLE', true);
```

3. **Custom Endpoints for MeUp:**
```php
// functions.php or custom plugin
add_action('rest_api_init', function () {
  // Custom endpoint for bookings
  register_rest_route('meup/v1', '/bookings', array(
    'methods' => 'GET',
    'callback' => 'get_user_bookings',
    'permission_callback' => 'is_user_logged_in'
  ));

  // Endpoint for QR validation
  register_rest_route('meup/v1', '/tickets/validate', array(
    'methods' => 'POST',
    'callback' => 'validate_ticket_qr',
  ));
});
```

4. **Enable Push Notifications:**
```php
// Save FCM tokens
function save_fcm_token($user_id, $token) {
  update_user_meta($user_id, 'fcm_token', $token);
}

// Send notification function
function send_push_notification($user_id, $title, $body) {
  $token = get_user_meta($user_id, 'fcm_token', true);
  // Use Firebase Admin SDK or HTTP API to send notification
}
```

---

## 📊 Analytics & Tracking

### Events to Track:
- App opens
- Screen views
- Event views
- Booking initiations
- Booking completions
- Search queries
- Filter usage
- QR scans

### Tools:
- Firebase Analytics (built-in)
- Google Analytics (optional)
- Custom events to WordPress

---

## 🔒 Security Considerations

### Best Practices:
- [ ] Store JWT tokens securely (Flutter Secure Storage)
- [ ] HTTPS only for API calls
- [ ] Validate all user inputs
- [ ] Implement rate limiting on API
- [ ] Encrypt sensitive data in local database
- [ ] Secure QR code validation
- [ ] Implement certificate pinning (advanced)

---

## 💰 Cost Estimation

### Development Costs (if outsourcing):
- Flutter Developer: $3,000 - $8,000
- UI/UX Designer: $1,000 - $2,000
- Backend Developer: $500 - $1,500
- **Total:** $4,500 - $11,500

### Operational Costs (monthly):
- Firebase (Free tier should be sufficient)
- Push notifications: Free (FCM)
- App Store: $8.25/month (Apple), $0 (Google after one-time)
- **Total:** ~$10/month

### Alternative: DIY Development
- Time: 3-4 months (part-time)
- Cost: $0 (except app store fees)

---

## 📚 Learning Resources

### Flutter Learning:
- Official Docs: https://flutter.dev/docs
- Flutter Codelabs: https://flutter.dev/docs/codelabs
- YouTube: The Net Ninja Flutter Tutorial
- Udemy: Flutter & Dart - The Complete Guide

### WordPress REST API:
- REST API Handbook: https://developer.wordpress.org/rest-api/
- WooCommerce REST API: https://woocommerce.github.io/woocommerce-rest-api-docs/

---

## ✅ Quick Start Checklist

### Prerequisites:
- [ ] Flutter SDK installed
- [ ] Android Studio or VS Code setup
- [ ] Firebase account created
- [ ] WordPress site with REST API enabled
- [ ] MeUp theme installed & configured

### Getting Started:
```bash
# 1. Create Flutter project
flutter create appmobilewordpress
cd appmobilewordpress

# 2. Add dependencies (see pubspec.yaml above)

# 3. Setup Firebase
flutterfire configure

# 4. Run the app
flutter run
```

---

## 🎯 Success Metrics

### Target KPIs (First 3 Months):
- [ ] 500+ app downloads
- [ ] 100+ monthly active users
- [ ] 50+ bookings via app
- [ ] 4.0+ app rating
- [ ] < 5% crash rate

---

## 📞 Support & Resources

**Repository:** https://github.com/cupitebet/appmobilewordpress
**Website API:** https://majelis.info/wp-json/
**Documentation:** This guide + Flutter docs

**Next Steps:**
1. Review this plan
2. Choose tech stack (recommend Flutter)
3. Setup development environment
4. Start with Phase 1 (Setup & Foundation)
5. Iterate and improve

---

**Last Updated:** 2025-11-19
**Status:** Planning Phase - Ready to Start
**Estimated Completion:** 12 weeks
