import 'package:flutter/material.dart';

/// App Theme - matches majelis.info website design
class AppTheme {
  // Colors - matching website color scheme
  static const Color primaryMain = Color(0xFF1E40AF);
  static const Color primaryLight = Color(0xFF3B82F6);
  static const Color primaryDark = Color(0xFF1E3A8A);

  static const Color secondaryMain = Color(0xFF059669);
  static const Color secondaryLight = Color(0xFF10B981);
  static const Color secondaryDark = Color(0xFF047857);

  static const Color accentMain = Color(0xFFF59E0B);
  static const Color accentLight = Color(0xFFFBBF24);

  // Grays
  static const Color gray50 = Color(0xFFF9FAFB);
  static const Color gray100 = Color(0xFFF3F4F6);
  static const Color gray200 = Color(0xFFE5E7EB);
  static const Color gray300 = Color(0xFFD1D5DB);
  static const Color gray400 = Color(0xFF9CA3AF);
  static const Color gray500 = Color(0xFF6B7280);
  static const Color gray600 = Color(0xFF4B5563);
  static const Color gray700 = Color(0xFF374151);
  static const Color gray800 = Color(0xFF1F2937);
  static const Color gray900 = Color(0xFF111827);

  // Semantic Colors
  static const Color success = Color(0xFF10B981);
  static const Color warning = Color(0xFFF59E0B);
  static const Color error = Color(0xFFEF4444);
  static const Color info = Color(0xFF3B82F6);

  // Light Theme
  static ThemeData lightTheme = ThemeData(
    useMaterial3: true,
    colorScheme: ColorScheme.light(
      primary: primaryMain,
      secondary: secondaryMain,
      tertiary: accentMain,
      error: error,
      background: gray50,
      surface: Colors.white,
    ),

    // App Bar Theme
    appBarTheme: const AppBarTheme(
      backgroundColor: Colors.white,
      foregroundColor: gray900,
      elevation: 0,
      centerTitle: true,
      titleTextStyle: TextStyle(
        fontFamily: 'Poppins',
        fontSize: 18,
        fontWeight: FontWeight.w600,
        color: gray900,
      ),
    ),

    // Text Theme
    textTheme: const TextTheme(
      // Headlines
      headlineLarge: TextStyle(
        fontFamily: 'Poppins',
        fontSize: 32,
        fontWeight: FontWeight.w700,
        color: gray900,
      ),
      headlineMedium: TextStyle(
        fontFamily: 'Poppins',
        fontSize: 24,
        fontWeight: FontWeight.w600,
        color: gray900,
      ),
      headlineSmall: TextStyle(
        fontFamily: 'Poppins',
        fontSize: 20,
        fontWeight: FontWeight.w600,
        color: gray900,
      ),

      // Body Text
      bodyLarge: TextStyle(
        fontFamily: 'Inter',
        fontSize: 16,
        fontWeight: FontWeight.w400,
        color: gray700,
      ),
      bodyMedium: TextStyle(
        fontFamily: 'Inter',
        fontSize: 14,
        fontWeight: FontWeight.w400,
        color: gray600,
      ),
      bodySmall: TextStyle(
        fontFamily: 'Inter',
        fontSize: 12,
        fontWeight: FontWeight.w400,
        color: gray500,
      ),

      // Labels
      labelLarge: TextStyle(
        fontFamily: 'Inter',
        fontSize: 14,
        fontWeight: FontWeight.w600,
        color: gray700,
      ),
    ),

    // Button Theme
    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        backgroundColor: primaryMain,
        foregroundColor: Colors.white,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(8),
        ),
        elevation: 2,
        textStyle: const TextStyle(
          fontFamily: 'Inter',
          fontSize: 14,
          fontWeight: FontWeight.w600,
        ),
      ),
    ),

    outlinedButtonTheme: OutlinedButtonThemeData(
      style: OutlinedButton.styleFrom(
        foregroundColor: primaryMain,
        side: const BorderSide(color: primaryMain, width: 2),
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(8),
        ),
      ),
    ),

    // Input Decoration Theme
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: gray50,
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8),
        borderSide: const BorderSide(color: gray300),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8),
        borderSide: const BorderSide(color: primaryMain, width: 2),
      ),
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
    ),

    // Card Theme
    cardTheme: CardTheme(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      color: Colors.white,
    ),

    // Chip Theme
    chipTheme: ChipThemeData(
      backgroundColor: gray100,
      selectedColor: primaryLight,
      labelStyle: const TextStyle(
        fontFamily: 'Inter',
        fontSize: 12,
        fontWeight: FontWeight.w600,
      ),
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(16),
      ),
    ),
  );

  // Dark Theme (optional)
  static ThemeData darkTheme = ThemeData(
    useMaterial3: true,
    colorScheme: ColorScheme.dark(
      primary: primaryLight,
      secondary: secondaryLight,
      tertiary: accentLight,
      error: error,
      background: gray900,
      surface: gray800,
    ),
    // ... similar configuration for dark theme
  );

  // Spacing
  static const double spacingXS = 4;
  static const double spacingSM = 8;
  static const double spacingMD = 16;
  static const double spacingLG = 24;
  static const double spacingXL = 32;
  static const double spacing2XL = 48;

  // Border Radius
  static const double radiusSM = 4;
  static const double radiusMD = 8;
  static const double radiusLG = 12;
  static const double radiusXL = 16;
  static const double radiusFull = 999;

  // Shadows
  static List<BoxShadow> shadowSM = [
    BoxShadow(
      color: Colors.black.withOpacity(0.08),
      blurRadius: 4,
      offset: const Offset(0, 2),
    ),
  ];

  static List<BoxShadow> shadowMD = [
    BoxShadow(
      color: Colors.black.withOpacity(0.1),
      blurRadius: 8,
      offset: const Offset(0, 4),
    ),
  ];

  static List<BoxShadow> shadowLG = [
    BoxShadow(
      color: Colors.black.withOpacity(0.15),
      blurRadius: 16,
      offset: const Offset(0, 8),
    ),
  ];
}
