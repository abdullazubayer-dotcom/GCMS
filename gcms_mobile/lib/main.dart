import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'src/app_state.dart';
import 'src/screens/app_shell.dart';
import 'src/screens/login_screen.dart';
import 'src/screens/password_change_screen.dart';
import 'src/theme.dart';

void main() {
  runApp(const GcmsMobileApp());
}

class GcmsMobileApp extends StatelessWidget {
  const GcmsMobileApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => AuthState()..loadSession(),
      child: MaterialApp(
        title: 'GCMS Mobile',
        debugShowCheckedModeBanner: false,
        theme: buildGcmsTheme(),
        home: const AppGate(),
      ),
    );
  }
}

class AppGate extends StatelessWidget {
  const AppGate({super.key});

  @override
  Widget build(BuildContext context) {
    final auth = context.watch<AuthState>();

    if (auth.isBooting) {
      return const Scaffold(body: Center(child: CircularProgressIndicator()));
    }

    if (!auth.isLoggedIn) {
      return const LoginScreen();
    }

    if (auth.mustChangePassword) {
      return const PasswordChangeScreen();
    }

    return const AppShell();
  }
}
