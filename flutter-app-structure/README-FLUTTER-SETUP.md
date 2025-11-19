# 🚀 Flutter App Setup Guide
# majelis.info Mobile App

## Quick Setup Instructions

### 1. Create Flutter Project

```bash
# Navigate to your projects folder
cd ~/projects

# Create Flutter project
flutter create appmobilewordpress

# Or with custom bundle ID
flutter create --org com.majelis appmobilewordpress

# Navigate into project
cd appmobilewordpress
```

### 2. Copy Files from This Folder

After creating the Flutter project, copy these files:

```bash
# Copy pubspec.yaml (dependencies)
cp flutter-app-structure/pubspec.yaml appmobilewordpress/

# Copy app configuration
cp flutter-app-structure/lib/app/app_config.dart appmobilewordpress/lib/app/
cp flutter-app-structure/lib/app/app_theme.dart appmobilewordpress/lib/app/
cp flutter-app-structure/lib/app/app_routes.dart appmobilewordpress/lib/app/

# Copy core services
cp -r flutter-app-structure/lib/core/ appmobilewordpress/lib/

# Copy screens
cp -r flutter-app-structure/lib/features/ appmobilewordpress/lib/

# Copy main.dart
cp flutter-app-structure/lib/main.dart appmobilewordpress/lib/
```

### 3. Install Dependencies

```bash
cd appmobilewordpress
flutter pub get
```

### 4. Run the App

```bash
# Run on connected device/emulator
flutter run

# Or specific device
flutter devices
flutter run -d <device_id>
```

## Project Structure

```
appmobilewordpress/
├── lib/
│   ├── main.dart                    # App entry point
│   ├── app/
│   │   ├── app_config.dart         # API URLs, constants
│   │   ├── app_theme.dart          # App theme (colors, fonts)
│   │   └── app_routes.dart         # Navigation routes
│   ├── core/
│   │   ├── api/
│   │   │   ├── wordpress_api.dart   # WordPress REST API
│   │   │   └── woocommerce_api.dart # WooCommerce API
│   │   ├── models/
│   │   │   ├── event.dart
│   │   │   ├── ticket.dart
│   │   │   └── user.dart
│   │   ├── providers/
│   │   │   ├── event_provider.dart
│   │   │   └── auth_provider.dart
│   │   └── services/
│   │       ├── storage_service.dart
│   │       └── notification_service.dart
│   └── features/
│       ├── auth/
│       │   ├── login_screen.dart
│       │   └── register_screen.dart
│       ├── home/
│       │   └── home_screen.dart
│       ├── events/
│       │   ├── event_list_screen.dart
│       │   └── event_detail_screen.dart
│       └── tickets/
│           └── my_tickets_screen.dart
├── assets/
│   ├── images/
│   └── fonts/
├── pubspec.yaml                     # Dependencies
└── README.md
```

## Next Steps

1. Setup Firebase (for notifications)
2. Configure API endpoints in app_config.dart
3. Test WordPress REST API connection
4. Build & test features
5. Deploy to stores

See MOBILE-APP-PLAN.md for detailed development guide.
