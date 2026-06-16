import 'package:flutter/material.dart';

import '../api_client.dart';
import '../widgets/page_art.dart';
import '../widgets/screen_frame.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  Future<Map<String, dynamic>> _load() async {
    final response = await ApiClient.dio.get('/member/profile');
    return Map<String, dynamic>.from(response.data['data']);
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<Map<String, dynamic>>(
      future: _load(),
      builder: (context, snapshot) {
        final member = snapshot.data ?? {};
        final rawUser = member['user'];
        final user = rawUser is Map && rawUser['data'] is Map
            ? Map<String, dynamic>.from(rawUser['data'])
            : rawUser is Map
            ? Map<String, dynamic>.from(rawUser)
            : <String, dynamic>{};

        return ScreenFrame(
          title: 'My Profile',
          subtitle: member.isEmpty
              ? 'Loading your official member profile.'
              : '${member['member_code']}',
          artKind: ArtKind.profile,
          children: [
            if (snapshot.connectionState != ConnectionState.done)
              const Center(child: CircularProgressIndicator())
            else if (snapshot.hasError)
              Card(
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Text(ApiClient.messageFrom(snapshot.error!)),
                ),
              )
            else ...[
              InfoTile(
                label: 'Name',
                value: user['name']?.toString() ?? '',
                icon: Icons.person_outline,
              ),
              InfoTile(
                label: 'Email',
                value: user['email']?.toString() ?? '',
                icon: Icons.email_outlined,
              ),
              InfoTile(
                label: 'Phone',
                value: user['phone']?.toString() ?? '',
                icon: Icons.phone_outlined,
              ),
              InfoTile(
                label: 'Membership Type',
                value: member['membership_type']?.toString() ?? '',
                icon: Icons.workspace_premium_outlined,
              ),
              InfoTile(
                label: 'Status',
                value: member['membership_status']?.toString() ?? '',
                icon: Icons.verified_outlined,
              ),
              InfoTile(
                label: 'Joining Date',
                value: member['joining_date']?.toString() ?? '',
                icon: Icons.calendar_month_outlined,
              ),
              InfoTile(
                label: 'Address',
                value: member['address']?.toString() ?? '',
                icon: Icons.location_on_outlined,
              ),
            ],
          ],
        );
      },
    );
  }
}
