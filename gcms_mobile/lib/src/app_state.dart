import 'package:flutter/foundation.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

import 'api_client.dart';

class AuthState extends ChangeNotifier {
  static const _tokenKey = 'gcms_api_token';

  final FlutterSecureStorage _storage = const FlutterSecureStorage();

  bool isBooting = true;
  bool isLoading = false;
  bool mustChangePassword = false;
  String? token;
  Map<String, dynamic>? user;
  String? error;

  bool get isLoggedIn => token != null && token!.isNotEmpty;
  bool get isAdmin => ['super_admin', 'admin'].contains(user?['role']);

  Future<void> loadSession() async {
    token = await _storage.read(key: _tokenKey);
    ApiClient.setToken(token);

    if (token != null) {
      try {
        final response = await ApiClient.dio.get('/auth/me');
        user = _mapFromResource(response.data);
        mustChangePassword = user?['must_change_password'] == true;
      } catch (_) {
        await _storage.delete(key: _tokenKey);
        token = null;
      }
    }

    isBooting = false;
    notifyListeners();
  }

  Future<bool> login({
    required String loginId,
    required String password,
  }) async {
    isLoading = true;
    error = null;
    notifyListeners();

    try {
      final response = await ApiClient.dio.post(
        '/auth/login',
        data: {
          'login_id': loginId,
          'password': password,
          'device_name': 'GCMS Mobile',
        },
      );

      token = response.data['access_token'].toString();
      user = _mapFromResource(response.data['user']);
      mustChangePassword = response.data['must_change_password'] == true;
      await _storage.write(key: _tokenKey, value: token);
      ApiClient.setToken(token);
      return true;
    } catch (exception) {
      error = ApiClient.messageFrom(exception);
      return false;
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> changePassword({
    required String currentPassword,
    required String password,
    required String confirmation,
  }) async {
    isLoading = true;
    error = null;
    notifyListeners();

    try {
      final response = await ApiClient.dio.put(
        '/auth/password',
        data: {
          'current_password': currentPassword,
          'password': password,
          'password_confirmation': confirmation,
        },
      );
      user = _mapFromResource(response.data['user']);
      mustChangePassword = false;
      return true;
    } catch (exception) {
      error = ApiClient.messageFrom(exception);
      return false;
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }

  Future<void> logout() async {
    try {
      await ApiClient.dio.post('/auth/logout');
    } catch (_) {
      // Local logout should still happen if the token has already expired.
    }

    await _storage.delete(key: _tokenKey);
    token = null;
    user = null;
    mustChangePassword = false;
    ApiClient.setToken(null);
    notifyListeners();
  }

  Map<String, dynamic> _mapFromResource(dynamic value) {
    if (value is Map && value['data'] is Map) {
      return Map<String, dynamic>.from(value['data']);
    }
    if (value is Map) {
      return Map<String, dynamic>.from(value);
    }
    return {};
  }
}
