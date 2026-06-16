import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

import '../api_client.dart';
import '../widgets/async_list.dart';
import '../widgets/page_art.dart';
import '../widgets/screen_frame.dart';

class PaymentsScreen extends StatelessWidget {
  const PaymentsScreen({super.key});

  Future<List<Map<String, dynamic>>> _load() async {
    final response = await ApiClient.dio.get('/member/payments');
    return List<Map<String, dynamic>>.from(response.data['data']);
  }

  @override
  Widget build(BuildContext context) {
    final money = NumberFormat.currency(symbol: '৳ ');

    return ScreenFrame(
      title: 'Payments',
      subtitle: 'Your personal payment history from the club system.',
      artKind: ArtKind.payments,
      children: [
        AsyncList<Map<String, dynamic>>(
          future: _load(),
          emptyText: 'No payment records found.',
          itemBuilder: (context, payment) {
            final amount =
                num.tryParse(payment['amount']?.toString() ?? '0') ?? 0;
            return Card(
              child: ListTile(
                leading: const Icon(Icons.receipt_long_outlined),
                title: Text(payment['payment_no']?.toString() ?? 'Payment'),
                subtitle: Text(
                  [
                        payment['payment_type'],
                        payment['payment_date'],
                        payment['payment_status'],
                      ]
                      .where(
                        (value) => value != null && value.toString().isNotEmpty,
                      )
                      .join(' | '),
                ),
                trailing: Text(money.format(amount)),
              ),
            );
          },
        ),
      ],
    );
  }
}
