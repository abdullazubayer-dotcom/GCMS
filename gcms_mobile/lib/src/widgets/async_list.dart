import 'package:flutter/material.dart';

import '../api_client.dart';

class AsyncList<T> extends StatelessWidget {
  const AsyncList({
    super.key,
    required this.future,
    required this.itemBuilder,
    this.emptyText = 'No records found.',
  });

  final Future<List<T>> future;
  final Widget Function(BuildContext context, T item) itemBuilder;
  final String emptyText;

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<T>>(
      future: future,
      builder: (context, snapshot) {
        if (snapshot.connectionState != ConnectionState.done) {
          return const Padding(
            padding: EdgeInsets.all(28),
            child: Center(child: CircularProgressIndicator()),
          );
        }

        if (snapshot.hasError) {
          return Card(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Text(ApiClient.messageFrom(snapshot.error!)),
            ),
          );
        }

        final items = snapshot.data ?? [];
        if (items.isEmpty) {
          return Card(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Text(emptyText),
            ),
          );
        }

        return Column(
          children: items.map((item) => itemBuilder(context, item)).toList(),
        );
      },
    );
  }
}
