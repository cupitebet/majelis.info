import 'dart:convert';
import 'package:http/http.dart' as http;
import '../../app/app_config.dart';

/// WordPress / MeUp REST API Service
class WordPressAPI {
  // Use MeUp namespace for event-related endpoints, and WP v2 for generic WP endpoints
  final String meupBase = AppConfig.meupApiUrl; // e.g. https://majelis.info/wp-json/meup/v1
  final String wpBase = AppConfig.wordpressApiUrl; // e.g. https://majelis.info/wp-json/wp/v2

  // Headers
  Map<String, String> get headers => {
        'Content-Type': 'application/json',
      };

  // Get Events
  Future<List<dynamic>> getEvents({
    int page = 1,
    int perPage = 10,
    String? category,
    String? search,
    String? orderBy = 'date',
  }) async {
    try {
      final queryParams = {
        'page': page.toString(),
        'per_page': perPage.toString(),
        'orderby': orderBy,
        if (category != null) 'category': category,
        if (search != null) 'search': search,
      };

        final uri = Uri.parse('${meupBase}/events')
          .replace(queryParameters: queryParams);

      final response = await http.get(uri, headers: headers);

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('Failed to load events: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error fetching events: $e');
    }
  }

  // Get Event Detail
  Future<Map<String, dynamic>> getEventDetail(int eventId) async {
    try {
      final response = await http.get(
        Uri.parse('${meupBase}/events/$eventId'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('Failed to load event: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error fetching event detail: $e');
    }
  }

  // Get Categories
  Future<List<dynamic>> getCategories() async {
    try {
      final response = await http.get(
        Uri.parse('${meupBase}/event-categories'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('Failed to load categories: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error fetching categories: $e');
    }
  }

  // Login with JWT
  Future<Map<String, dynamic>> login(String username, String password) async {
    try {
      final response = await http.post(
        Uri.parse('${AppConfig.jwtAuthUrl}/token'),
        headers: headers,
        body: json.encode({
          'username': username,
          'password': password,
        }),
      );

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('Login failed: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error during login: $e');
    }
  }

  // Register User
  Future<Map<String, dynamic>> register({
    required String email,
    required String username,
    required String password,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('${wpBase}/users'),
        headers: headers,
        body: json.encode({
          'email': email,
          'username': username,
          'password': password,
        }),
      );

      if (response.statusCode == 201) {
        return json.decode(response.body);
      } else {
        throw Exception('Registration failed: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error during registration: $e');
    }
  }

  // Get Current User
  Future<Map<String, dynamic>> getCurrentUser(String token) async {
    try {
      final response = await http.get(
        Uri.parse('${wpBase}/users/me'),
        headers: {
          ...headers,
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('Failed to get user: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error fetching user: $e');
    }
  }

  // Search Events
  Future<List<dynamic>> searchEvents(String keyword) async {
    return getEvents(search: keyword);
  }

  // Get Events by Category
  Future<List<dynamic>> getEventsByCategory(String categoryId) async {
    return getEvents(category: categoryId);
  }
}
