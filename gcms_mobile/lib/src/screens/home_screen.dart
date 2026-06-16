import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../app_state.dart';
import '../widgets/page_art.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final auth = context.watch<AuthState>();
    final user = auth.user ?? {};

    return Scaffold(
      appBar: AppBar(
        title: const Text('GCMS Mobile'),
        actions: [
          IconButton(
            tooltip: 'Logout',
            onPressed: auth.logout,
            icon: const Icon(Icons.logout),
          ),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.fromLTRB(16, 8, 16, 24),
        children: [
          const PageArt(kind: ArtKind.home),
          const SizedBox(height: 14),
          Text(
            'Welcome, ${user['name'] ?? 'Member'}',
            style: Theme.of(context).textTheme.headlineSmall,
          ),
          const SizedBox(height: 4),
          Text('Role: ${user['role'] ?? '-'}'),
          const SizedBox(height: 18),
          const _QuickCard(
            icon: Icons.event_available,
            title: 'Published Events',
            text: 'Check official club events and schedules.',
          ),
          const _QuickCard(
            icon: Icons.receipt_long,
            title: 'Payment History',
            text: 'See your own payments and due records.',
          ),
          const _QuickCard(
            icon: Icons.security,
            title: 'Private Access',
            text: 'The app only loads data for the logged-in member.',
          ),
        ],
      ),
    );
  }
}

class _QuickCard extends StatelessWidget {
  const _QuickCard({
    required this.icon,
    required this.title,
    required this.text,
  });

  final IconData icon;
  final String title;
  final String text;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: ListTile(
        leading: Icon(icon, color: Theme.of(context).colorScheme.primary),
        title: Text(title),
        subtitle: Text(text),
      ),
    );
  }
}
