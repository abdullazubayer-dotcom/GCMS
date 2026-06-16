import 'package:flutter/material.dart';

import '../api_client.dart';
import '../widgets/async_list.dart';
import '../widgets/page_art.dart';
import '../widgets/screen_frame.dart';

class NotificationsScreen extends StatelessWidget {
  const NotificationsScreen({super.key});

  Future<List<Map<String, dynamic>>> _load() async {
    final response = await ApiClient.dio.get('/member/notifications');
    return List<Map<String, dynamic>>.from(response.data['data']);
  }

  @override
  Widget build(BuildContext context) {
    return ScreenFrame(
      title: 'Notifications',
      subtitle: 'Email and SMS attempts connected to your account.',
      artKind: ArtKind.notifications,
      children: [
        AsyncList<Map<String, dynamic>>(
          future: _load(),
          emptyText: 'No notifications found.',
          itemBuilder: (context, notification) {
            return Card(
              child: ListTile(
                leading: Icon(
                  notification['channel'] == 'sms'
                      ? Icons.sms_outlined
                      : Icons.email_outlined,
                ),
                title: Text(
                  notification['subject']?.toString() ??
                      notification['channel']?.toString() ??
                      'Notification',
                ),
                subtitle: Text(notification['message']?.toString() ?? ''),
                trailing: Text(notification['status']?.toString() ?? ''),
              ),
            );
          },
        ),
      ],
    );
  }
}
