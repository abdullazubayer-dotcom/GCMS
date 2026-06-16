import '../api_client.dart';

class AdminApi {
  static List<Map<String, dynamic>> listFrom(dynamic responseData) {
    return List<Map<String, dynamic>>.from(responseData['data'] ?? []);
  }

  static Map<String, dynamic> mapFrom(dynamic responseData) {
    if (responseData is Map && responseData['data'] is Map) {
      return Map<String, dynamic>.from(responseData['data']);
    }
    if (responseData is Map) {
      return Map<String, dynamic>.from(responseData);
    }
    return {};
  }

  static Future<List<Map<String, dynamic>>> members() async {
    final response = await ApiClient.dio.get('/admin/members');
    return listFrom(response.data);
  }

  static Future<void> saveMember(Map<String, dynamic> data, {int? id}) async {
    if (id == null) {
      await ApiClient.dio.post('/admin/members', data: data);
      return;
    }

    await ApiClient.dio.put('/admin/members/$id', data: data);
  }

  static Future<void> deleteMember(int id) async {
    await ApiClient.dio.delete('/admin/members/$id');
  }

  static Future<List<Map<String, dynamic>>> events() async {
    final response = await ApiClient.dio.get('/admin/events');
    return listFrom(response.data);
  }

  static Future<void> saveEvent(Map<String, dynamic> data, {int? id}) async {
    if (id == null) {
      await ApiClient.dio.post('/admin/events', data: data);
      return;
    }

    await ApiClient.dio.put('/admin/events/$id', data: data);
  }

  static Future<void> deleteEvent(int id) async {
    await ApiClient.dio.delete('/admin/events/$id');
  }

  static Future<List<Map<String, dynamic>>> payments() async {
    final response = await ApiClient.dio.get('/admin/payments');
    return listFrom(response.data);
  }

  static Future<void> savePayment(Map<String, dynamic> data, {int? id}) async {
    if (id == null) {
      await ApiClient.dio.post('/admin/payments', data: data);
      return;
    }

    await ApiClient.dio.put('/admin/payments/$id', data: data);
  }

  static Future<void> deletePayment(int id) async {
    await ApiClient.dio.delete('/admin/payments/$id');
  }

  static Future<Map<String, dynamic>> dashboard() async {
    final response = await ApiClient.dio.get('/admin/dashboard');
    return mapFrom(response.data);
  }
}
