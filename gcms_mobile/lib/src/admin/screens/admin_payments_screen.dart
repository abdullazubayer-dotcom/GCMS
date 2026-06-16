import 'package:flutter/material.dart';

import '../../api_client.dart';
import '../../widgets/page_art.dart';
import '../admin_api.dart';
import 'admin_form_helpers.dart';

class AdminPaymentsScreen extends StatefulWidget {
  const AdminPaymentsScreen({super.key});

  @override
  State<AdminPaymentsScreen> createState() => _AdminPaymentsScreenState();
}

class _AdminPaymentsScreenState extends State<AdminPaymentsScreen> {
  late Future<List<Map<String, dynamic>>> _future = AdminApi.payments();

  void _reload() => setState(() => _future = AdminApi.payments());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Payments'),
        actions: [
          IconButton(
            tooltip: 'Add payment',
            onPressed: () async {
              await Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const PaymentFormScreen()),
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
          final payments = snapshot.data ?? [];
          return ListView(
            padding: const EdgeInsets.fromLTRB(16, 8, 16, 24),
            children: [
              const PageArt(kind: ArtKind.payments),
              const SizedBox(height: 12),
              Text(
                'Payment Management',
                style: Theme.of(context).textTheme.headlineSmall,
              ),
              const SizedBox(height: 12),
              if (snapshot.connectionState != ConnectionState.done)
                const Center(child: CircularProgressIndicator())
              else if (snapshot.hasError)
                Text(ApiClient.messageFrom(snapshot.error!))
              else if (payments.isEmpty)
                const Card(child: ListTile(title: Text('No payments found.')))
              else
                ...payments.map(
                  (payment) => Card(
                    child: ListTile(
                      leading: const Icon(Icons.receipt_long_outlined),
                      title: Text(
                        payment['payment_no']?.toString() ?? 'Payment',
                      ),
                      subtitle: Text(
                        '${payment['payment_type'] ?? ''} | ${payment['payment_status'] ?? ''}\nAmount: ${payment['amount'] ?? ''}',
                      ),
                      isThreeLine: true,
                      trailing: PopupMenuButton<String>(
                        onSelected: (value) async {
                          if (value == 'edit') {
                            await Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (_) =>
                                    PaymentFormScreen(payment: payment),
                              ),
                            );
                            if (!mounted) return;
                            _reload();
                          } else if (value == 'delete') {
                            final confirmed = await confirmDelete(
                              context,
                              payment['payment_no'].toString(),
                            );
                            if (!mounted || !confirmed) return;
                            await AdminApi.deletePayment(payment['id']);
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

class PaymentFormScreen extends StatefulWidget {
  const PaymentFormScreen({super.key, this.payment});

  final Map<String, dynamic>? payment;

  @override
  State<PaymentFormScreen> createState() => _PaymentFormScreenState();
}

class _PaymentFormScreenState extends State<PaymentFormScreen> {
  final _form = GlobalKey<FormState>();
  late final _memberId = TextEditingController(text: _nestedId('member'));
  late final _eventId = TextEditingController(text: _nestedId('event'));
  late final _type = TextEditingController(text: _value('payment_type'));
  late final _amount = TextEditingController(text: _value('amount'));
  late final _date = TextEditingController(text: _value('payment_date'));
  late final _reference = TextEditingController(
    text: _value('transaction_reference'),
  );
  late final _remarks = TextEditingController(text: _value('remarks'));
  late final _receivedBy = TextEditingController(
    text: _nestedId('received_by'),
  );
  late String _method = _value('payment_method').isEmpty
      ? 'cash'
      : _value('payment_method');
  late String _status = _value('payment_status').isEmpty
      ? 'paid'
      : _value('payment_status');
  bool _saving = false;
  String? _error;

  bool get isEdit => widget.payment != null;

  @override
  void dispose() {
    for (final controller in [
      _memberId,
      _eventId,
      _type,
      _amount,
      _date,
      _reference,
      _remarks,
      _receivedBy,
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
      await AdminApi.savePayment({
        'member_id': _memberId.text.trim(),
        'event_id': _eventId.text.trim().isEmpty ? null : _eventId.text.trim(),
        'payment_type': _type.text.trim(),
        'amount': _amount.text.trim(),
        'payment_date': _date.text.trim(),
        'payment_method': _method,
        'transaction_reference': _reference.text.trim(),
        'payment_status': _status,
        'remarks': _remarks.text.trim(),
        'received_by': _receivedBy.text.trim(),
      }, id: widget.payment?['id']);
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
      appBar: AppBar(title: Text(isEdit ? 'Edit Payment' : 'Create Payment')),
      body: Form(
        key: _form,
        child: ListView(
          padding: const EdgeInsets.all(16),
          children: [
            AdminTextField(
              controller: _memberId,
              label: 'Member Database ID',
              keyboardType: TextInputType.number,
            ),
            AdminTextField(
              controller: _eventId,
              label: 'Event ID Optional',
              required: false,
              keyboardType: TextInputType.number,
            ),
            AdminTextField(controller: _type, label: 'Payment Type'),
            AdminTextField(
              controller: _amount,
              label: 'Amount',
              keyboardType: TextInputType.number,
            ),
            AdminTextField(controller: _date, label: 'Payment Date YYYY-MM-DD'),
            AdminDropdown(
              label: 'Payment Method',
              value: _method,
              items: const ['cash', 'bank', 'mobile_banking', 'card', 'other'],
              onChanged: (v) => setState(() => _method = v!),
            ),
            AdminTextField(
              controller: _reference,
              label: 'Transaction Reference',
              required: false,
            ),
            AdminDropdown(
              label: 'Status',
              value: _status,
              items: const ['due', 'partial', 'paid', 'waived', 'cancelled'],
              onChanged: (v) => setState(() => _status = v!),
            ),
            AdminTextField(
              controller: _remarks,
              label: 'Remarks',
              required: false,
              maxLines: 2,
            ),
            AdminTextField(
              controller: _receivedBy,
              label: 'Received By User ID',
              keyboardType: TextInputType.number,
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
              label: Text(_saving ? 'Saving...' : 'Save Payment'),
            ),
          ],
        ),
      ),
    );
  }

  String _value(String key) => widget.payment?[key]?.toString() ?? '';

  String _nestedId(String key) {
    final value = widget.payment?[key];
    if (value is Map && value['data'] is Map) {
      return value['data']['id']?.toString() ?? '';
    }
    if (value is Map) return value['id']?.toString() ?? '';
    return '';
  }
}
