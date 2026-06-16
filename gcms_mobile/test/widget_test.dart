import 'package:flutter_test/flutter_test.dart';
import 'package:gcms_mobile/src/app_state.dart';
import 'package:gcms_mobile/src/screens/login_screen.dart';
import 'package:gcms_mobile/src/theme.dart';
import 'package:provider/provider.dart';
import 'package:flutter/material.dart';

void main() {
  testWidgets('shows the GCMS login screen', (tester) async {
    await tester.pumpWidget(
      ChangeNotifierProvider(
        create: (_) => AuthState()..isBooting = false,
        child: MaterialApp(theme: buildGcmsTheme(), home: const LoginScreen()),
      ),
    );
    await tester.pump();

    expect(find.text('General Club'), findsOneWidget);
    expect(find.text('Login'), findsOneWidget);
    expect(find.text('Member ID / Login ID'), findsOneWidget);
  });
}
