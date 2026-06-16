import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

import '../api_client.dart';
import '../widgets/async_list.dart';
import '../widgets/page_art.dart';
import '../widgets/screen_frame.dart';

class EventsScreen extends StatelessWidget {
  const EventsScreen({super.key});

  Future<List<Map<String, dynamic>>> _load() async {
    final response = await ApiClient.dio.get('/member/events');
    return List<Map<String, dynamic>>.from(response.data['data']);
  }

  @override
  Widget build(BuildContext context) {
    return ScreenFrame(
      title: 'Events',
      subtitle: 'Published club events available to members.',
      artKind: ArtKind.events,
      children: [
        AsyncList<Map<String, dynamic>>(
          future: _load(),
          emptyText: 'No published events are available.',
          itemBuilder: (context, event) {
            return Card(
              child: ListTile(
                leading: const Icon(Icons.event_outlined),
                title: Text(event['title']?.toString() ?? 'Untitled event'),
                subtitle: Text(
                  [event['event_date'], event['start_time'], event['venue']]
                      .where(
                        (value) => value != null && value.toString().isNotEmpty,
                      )
                      .join(' | '),
                ),
                trailing: Text(
                  NumberFormat.currency(symbol: '').format(
                    num.tryParse(event['event_fee']?.toString() ?? '0') ?? 0,
                  ),
                ),
              ),
            );
          },
        ),
      ],
    );
  }
}
