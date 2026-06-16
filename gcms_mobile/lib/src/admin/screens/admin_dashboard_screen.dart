import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../app_state.dart';
import '../../widgets/page_art.dart';
import '../admin_api.dart';

class AdminDashboardScreen extends StatelessWidget {
  const AdminDashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final auth = context.watch<AuthState>();

    return Scaffold(
      appBar: AppBar(
        title: const Text('Admin Dashboard'),
        actions: [
          IconButton(
            tooltip: 'Logout',
            onPressed: auth.logout,
            icon: const Icon(Icons.logout),
          ),
        ],
      ),
      body: FutureBuilder<Map<String, dynamic>>(
        future: AdminApi.dashboard(),
        builder: (context, snapshot) {
          final data = snapshot.data ?? {};

          return ListView(
            padding: const EdgeInsets.fromLTRB(16, 8, 16, 24),
            children: [
              const PageArt(kind: ArtKind.admin),
              const SizedBox(height: 14),
              Text(
                'Welcome, ${auth.user?['name'] ?? 'Admin'}',
                style: Theme.of(context).textTheme.headlineSmall,
              ),
              const SizedBox(height: 4),
              const Text('Manage members, events, and payments from mobile.'),
              const SizedBox(height: 18),
              if (snapshot.connectionState != ConnectionState.done)
                const Center(child: CircularProgressIndicator())
              else if (snapshot.hasError)
                Card(
                  child: Padding(
                    padding: const EdgeInsets.all(16),
                    child: Text(snapshot.error.toString()),
                  ),
                )
              else
                Wrap(
                  spacing: 10,
                  runSpacing: 10,
                  children: [
                    _MetricCard(label: 'Members', value: data['total_members']),
                    _MetricCard(label: 'Active', value: data['active_members']),
                    _MetricCard(label: 'Events', value: data['total_events']),
                    _MetricCard(
                      label: 'Upcoming',
                      value: data['upcoming_events'],
                    ),
                    _MetricCard(
                      label: 'Collected',
                      value: data['total_payment_collection'],
                    ),
                    _MetricCard(label: 'Due', value: data['due_payments']),
                  ],
                ),
            ],
          );
        },
      ),
    );
  }
}

class _MetricCard extends StatelessWidget {
  const _MetricCard({required this.label, required this.value});

  final String label;
  final Object? value;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: (MediaQuery.sizeOf(context).width - 42) / 2,
      child: Card(
        child: Padding(
          padding: const EdgeInsets.all(14),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(label, style: Theme.of(context).textTheme.labelLarge),
              const SizedBox(height: 8),
              Text(
                value?.toString() ?? '0',
                style: Theme.of(context).textTheme.headlineSmall,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
