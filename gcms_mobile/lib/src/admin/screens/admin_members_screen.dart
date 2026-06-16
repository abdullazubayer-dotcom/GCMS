import 'package:flutter/material.dart';

import '../../api_client.dart';
import '../../widgets/page_art.dart';
import '../admin_api.dart';
import 'admin_form_helpers.dart';

class AdminMembersScreen extends StatefulWidget {
  const AdminMembersScreen({super.key});

  @override
  State<AdminMembersScreen> createState() => _AdminMembersScreenState();
}

class _AdminMembersScreenState extends State<AdminMembersScreen> {
  late Future<List<Map<String, dynamic>>> _future = AdminApi.members();

  void _reload() => setState(() => _future = AdminApi.members());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Members'),
        actions: [
          IconButton(
            tooltip: 'Add member',
            onPressed: () async {
              await Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const MemberFormScreen()),
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
          final members = snapshot.data ?? [];
          return ListView(
            padding: const EdgeInsets.fromLTRB(16, 8, 16, 24),
            children: [
              const PageArt(kind: ArtKind.admin),
              const SizedBox(height: 12),
              Text(
                'Member Management',
                style: Theme.of(context).textTheme.headlineSmall,
              ),
              const SizedBox(height: 12),
              if (snapshot.connectionState != ConnectionState.done)
                const Center(child: CircularProgressIndicator())
              else if (snapshot.hasError)
                Text(ApiClient.messageFrom(snapshot.error!))
              else if (members.isEmpty)
                const Card(child: ListTile(title: Text('No members found.')))
              else
                ...members.map((member) {
                  final user = _user(member);
                  return Card(
                    child: ListTile(
                      leading: const Icon(Icons.person_outline),
                      title: Text(
                        '${member['member_code']} - ${user['name'] ?? ''}',
                      ),
                      subtitle: Text(
                        '${user['email'] ?? ''}\n${member['membership_status']} | ${member['membership_type']}',
                      ),
                      isThreeLine: true,
                      trailing: PopupMenuButton<String>(
                        onSelected: (value) async {
                          if (value == 'edit') {
                            await Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (_) =>
                                    MemberFormScreen(member: member),
                              ),
                            );
                            if (!mounted) return;
                            _reload();
                          } else if (value == 'delete') {
                            final confirmed = await confirmDelete(
                              context,
                              member['member_code'].toString(),
                            );
                            if (!mounted || !confirmed) return;
                            await AdminApi.deleteMember(member['id']);
                            _reload();
                          }
                        },
                        itemBuilder: (context) => const [
                          PopupMenuItem(value: 'edit', child: Text('Edit')),
                          PopupMenuItem(value: 'delete', child: Text('Delete')),
                        ],
                      ),
                    ),
                  );
                }),
            ],
          );
        },
      ),
    );
  }

  Map<String, dynamic> _user(Map<String, dynamic> member) {
    final user = member['user'];
    if (user is Map && user['data'] is Map) {
      return Map<String, dynamic>.from(user['data']);
    }
    if (user is Map) return Map<String, dynamic>.from(user);
    return {};
  }
}

class MemberFormScreen extends StatefulWidget {
  const MemberFormScreen({super.key, this.member});

  final Map<String, dynamic>? member;

  @override
  State<MemberFormScreen> createState() => _MemberFormScreenState();
}

class _MemberFormScreenState extends State<MemberFormScreen> {
  final _form = GlobalKey<FormState>();
  late final _memberId = TextEditingController(text: _value('member_code'));
  late final _name = TextEditingController(text: _userValue('name'));
  late final _email = TextEditingController(text: _userValue('email'));
  late final _phone = TextEditingController(text: _userValue('phone'));
  late final _address = TextEditingController(text: _value('address'));
  late final _dob = TextEditingController(text: _value('date_of_birth'));
  late final _profession = TextEditingController(text: _value('occupation'));
  late final _organization = TextEditingController(
    text: _value('organization'),
  );
  late final _joining = TextEditingController(text: _value('joining_date'));
  late final _blood = TextEditingController(text: _value('blood_group'));
  late final _emergencyName = TextEditingController(
    text: _value('emergency_contact_name'),
  );
  late final _emergencyPhone = TextEditingController(
    text: _value('emergency_contact_phone'),
  );
  final _temporaryPassword = TextEditingController();
  late String _gender = _value('gender').isEmpty ? 'male' : _value('gender');
  late String _membershipType = _value('membership_type').isEmpty
      ? 'general'
      : _value('membership_type');
  late String _status = _value('membership_status').isEmpty
      ? 'active'
      : _value('membership_status');
  bool _saving = false;
  String? _error;

  bool get isEdit => widget.member != null;

  @override
  void dispose() {
    for (final controller in [
      _memberId,
      _name,
      _email,
      _phone,
      _address,
      _dob,
      _profession,
      _organization,
      _joining,
      _blood,
      _emergencyName,
      _emergencyPhone,
      _temporaryPassword,
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

    final data = {
      'member_id': _memberId.text.trim(),
      'name': _name.text.trim(),
      'email': _email.text.trim(),
      'phone': _phone.text.trim(),
      'address': _address.text.trim(),
      'date_of_birth': _dob.text.trim().isEmpty ? null : _dob.text.trim(),
      'gender': _gender,
      'profession': _profession.text.trim(),
      'organization': _organization.text.trim(),
      'membership_type': _membershipType,
      'joining_date': _joining.text.trim(),
      'blood_group': _blood.text.trim(),
      'emergency_contact_name': _emergencyName.text.trim(),
      'emergency_contact_phone': _emergencyPhone.text.trim(),
      'status': _status,
      if (!isEdit) 'temporary_password': _temporaryPassword.text,
    };

    try {
      await AdminApi.saveMember(data, id: widget.member?['id']);
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
      appBar: AppBar(title: Text(isEdit ? 'Edit Member' : 'Create Member')),
      body: Form(
        key: _form,
        child: ListView(
          padding: const EdgeInsets.all(16),
          children: [
            AdminTextField(controller: _memberId, label: 'Member ID'),
            AdminTextField(controller: _name, label: 'Name'),
            AdminTextField(
              controller: _email,
              label: 'Email',
              keyboardType: TextInputType.emailAddress,
            ),
            AdminTextField(controller: _phone, label: 'Phone', required: false),
            AdminTextField(
              controller: _address,
              label: 'Address',
              required: false,
              maxLines: 2,
            ),
            AdminTextField(
              controller: _dob,
              label: 'DOB YYYY-MM-DD',
              required: false,
            ),
            AdminDropdown(
              label: 'Gender',
              value: _gender,
              items: const ['male', 'female', 'other'],
              onChanged: (v) => setState(() => _gender = v!),
            ),
            AdminTextField(
              controller: _profession,
              label: 'Profession',
              required: false,
            ),
            AdminTextField(
              controller: _organization,
              label: 'Organization',
              required: false,
            ),
            AdminDropdown(
              label: 'Membership Type',
              value: _membershipType,
              items: const ['general', 'lifetime', 'associate', 'honorary'],
              onChanged: (v) => setState(() => _membershipType = v!),
            ),
            AdminTextField(
              controller: _joining,
              label: 'Joining Date YYYY-MM-DD',
            ),
            AdminTextField(
              controller: _blood,
              label: 'Blood Group',
              required: false,
            ),
            AdminTextField(
              controller: _emergencyName,
              label: 'Emergency Contact Name',
              required: false,
            ),
            AdminTextField(
              controller: _emergencyPhone,
              label: 'Emergency Contact Phone',
              required: false,
            ),
            AdminDropdown(
              label: 'Status',
              value: _status,
              items: const ['active', 'inactive', 'suspended', 'cancelled'],
              onChanged: (v) => setState(() => _status = v!),
            ),
            if (!isEdit)
              AdminTextField(
                controller: _temporaryPassword,
                label: 'Temporary Password',
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
              label: Text(_saving ? 'Saving...' : 'Save Member'),
            ),
          ],
        ),
      ),
    );
  }

  String _value(String key) => widget.member?[key]?.toString() ?? '';

  String _userValue(String key) {
    final user = widget.member?['user'];
    if (user is Map && user['data'] is Map) {
      return user['data'][key]?.toString() ?? '';
    }
    if (user is Map) return user[key]?.toString() ?? '';
    return '';
  }
}
