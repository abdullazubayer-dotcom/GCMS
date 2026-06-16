import 'package:flutter/material.dart';

import '../../api_client.dart';
import '../../widgets/page_art.dart';
import '../admin_api.dart';
import 'admin_form_helpers.dart';

class AdminEventsScreen extends StatefulWidget {
  const AdminEventsScreen({super.key});

  @override
  State<AdminEventsScreen> createState() => _AdminEventsScreenState();
}

class _AdminEventsScreenState extends State<AdminEventsScreen> {
  late Future<List<Map<String, dynamic>>> _future = AdminApi.events();

  void _reload() => setState(() => _future = AdminApi.events());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Events'),
        actions: [
          IconButton(
            tooltip: 'Add event',
            onPressed: () async {
              await Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const EventFormScreen()),
              );
              _reload();
            },
            icon: const Icon(Icons.add),
          ),
        ],
      ),
      body: FutureBuilder<List<Map<String, dynamic>>>(
        future: _future,
        builder: (context, snapshot) {
          final events = snapshot.data ?? [];
          return ListView(
            padding: const EdgeInsets.fromLTRB(16, 8, 16, 24),
            children: [
              const PageArt(kind: ArtKind.events),
              const SizedBox(height: 12),
              Text(
                'Event Management',
                style: Theme.of(context).textTheme.headlineSmall,
              ),
              const SizedBox(height: 12),
              if (snapshot.connectionState != ConnectionState.done)
                const Center(child: CircularProgressIndicator())
              else if (snapshot.hasError)
                Text(ApiClient.messageFrom(snapshot.error!))
              else if (events.isEmpty)
                const Card(child: ListTile(title: Text('No events found.')))
              else
                ...events.map(
                  (event) => Card(
                    child: ListTile(
                      leading: const Icon(Icons.event_outlined),
                      title: Text(event['title']?.toString() ?? 'Event'),
                      subtitle: Text(
                        '${event['event_date'] ?? ''} | ${event['status'] ?? ''}\n${event['venue'] ?? ''}',
                      ),
                      isThreeLine: true,
                      trailing: PopupMenuButton<String>(
                        onSelected: (value) async {
                          if (value == 'edit') {
                            await Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (_) => EventFormScreen(event: event),
                              ),
                            );
                            if (!mounted) return;
                            _reload();
                          } else if (value == 'delete') {
                            final confirmed = await confirmDelete(
                              context,
                              event['title'].toString(),
                            );
                            if (!mounted || !confirmed) return;
                            await AdminApi.deleteEvent(event['id']);
                            _reload();
                          }
                        },
                        itemBuilder: (context) => const [
                          PopupMenuItem(value: 'edit', child: Text('Edit')),
                          PopupMenuItem(value: 'delete', child: Text('Delete')),
                        ],
                      ),
                    ),
                  ),
                ),
            ],
          );
        },
      ),
    );
  }
}

class EventFormScreen extends StatefulWidget {
  const EventFormScreen({super.key, this.event});

  final Map<String, dynamic>? event;

  @override
  State<EventFormScreen> createState() => _EventFormScreenState();
}

class _EventFormScreenState extends State<EventFormScreen> {
  final _form = GlobalKey<FormState>();
  late final _title = TextEditingController(text: _value('title'));
  late final _slug = TextEditingController(text: _value('slug'));
  late final _date = TextEditingController(text: _value('event_date'));
  late final _start = TextEditingController(text: _value('start_time'));
  late final _end = TextEditingController(text: _value('end_time'));
  late final _venue = TextEditingController(text: _value('venue'));
  late final _description = TextEditingController(text: _value('description'));
  late final _fee = TextEditingController(
    text: _value('event_fee').isEmpty ? '0' : _value('event_fee'),
  );
  late final _capacity = TextEditingController(text: _value('capacity'));
  late String _status = _value('status').isEmpty ? 'draft' : _value('status');
  bool _saving = false;
  String? _error;

  bool get isEdit => widget.event != null;

  @override
  void dispose() {
    for (final controller in [
      _title,
      _slug,
      _date,
      _start,
      _end,
      _venue,
      _description,
      _fee,
      _capacity,
    ]) {
      controller.dispose();
    }
    super.dispose();
  }

  Future<void> _save() async {
    if (!_form.currentState!.validate()) return;
    setState(() {
      _saving = true;
      _error = null;
    });

    try {
      await AdminApi.saveEvent({
        'title': _title.text.trim(),
        'slug': _slug.text.trim().isEmpty ? null : _slug.text.trim(),
        'event_date': _date.text.trim(),
        'start_time': _start.text.trim().isEmpty ? null : _start.text.trim(),
        'end_time': _end.text.trim().isEmpty ? null : _end.text.trim(),
        'venue': _venue.text.trim(),
        'description': _description.text.trim(),
        'event_fee': _fee.text.trim(),
        'capacity': _capacity.text.trim().isEmpty
            ? null
            : _capacity.text.trim(),
        'status': _status,
      }, id: widget.event?['id']);
      if (mounted) Navigator.pop(context);
    } catch (exception) {
      setState(() => _error = ApiClient.messageFrom(exception));
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(isEdit ? 'Edit Event' : 'Create Event')),
      body: Form(
        key: _form,
        child: ListView(
          padding: const EdgeInsets.all(16),
          children: [
            AdminTextField(controller: _title, label: 'Title'),
            AdminTextField(controller: _slug, label: 'Slug', required: false),
            AdminTextField(controller: _date, label: 'Event Date YYYY-MM-DD'),
            AdminTextField(
              controller: _start,
              label: 'Start Time HH:MM',
              required: false,
            ),
            AdminTextField(
              controller: _end,
              label: 'End Time HH:MM',
              required: false,
            ),
            AdminTextField(controller: _venue, label: 'Venue', required: false),
            AdminTextField(
              controller: _description,
              label: 'Description',
              required: false,
              maxLines: 3,
            ),
            AdminTextField(
              controller: _fee,
              label: 'Event Fee',
              keyboardType: TextInputType.number,
            ),
            AdminTextField(
              controller: _capacity,
              label: 'Capacity',
              required: false,
              keyboardType: TextInputType.number,
            ),
            AdminDropdown(
              label: 'Status',
              value: _status,
              items: const ['draft', 'published', 'completed', 'cancelled'],
              onChanged: (v) => setState(() => _status = v!),
            ),
            if (_error != null)
              Padding(
                padding: const EdgeInsets.only(bottom: 12),
                child: Text(
                  _error!,
                  style: TextStyle(color: Theme.of(context).colorScheme.error),
                ),
              ),
            FilledButton.icon(
              onPressed: _saving ? null : _save,
              icon: const Icon(Icons.save_outlined),
              label: Text(_saving ? 'Saving...' : 'Save Event'),
            ),
          ],
        ),
      ),
    );
  }

  String _value(String key) => widget.event?[key]?.toString() ?? '';
}
