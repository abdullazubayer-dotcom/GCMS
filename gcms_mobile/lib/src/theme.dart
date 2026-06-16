import 'package:flutter/material.dart';

ThemeData buildGcmsTheme() {
  const ink = Color(0xFF17202A);
  const teal = Color(0xFF00A9A5);
  const coral = Color(0xFFFF6B6B);
  const amber = Color(0xFFFFC857);

  final scheme = ColorScheme.fromSeed(
    seedColor: teal,
    brightness: Brightness.light,
    primary: teal,
    secondary: coral,
    tertiary: amber,
    surface: const Color(0xFFF7F9FB),
  );

  return ThemeData(
    useMaterial3: true,
    colorScheme: scheme,
    scaffoldBackgroundColor: const Color(0xFFF7F9FB),
    appBarTheme: const AppBarTheme(centerTitle: false, elevation: 0),
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: Colors.white,
      border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8),
        borderSide: const BorderSide(color: Color(0xFFDDE5ED)),
      ),
    ),
    cardTheme: CardThemeData(
      color: Colors.white,
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(8),
        side: const BorderSide(color: Color(0xFFE3EAF1)),
      ),
    ),
    textTheme: const TextTheme(
      headlineSmall: TextStyle(
        color: ink,
        fontWeight: FontWeight.w800,
        letterSpacing: 0,
      ),
      titleMedium: TextStyle(
        color: ink,
        fontWeight: FontWeight.w700,
        letterSpacing: 0,
      ),
      bodyMedium: TextStyle(color: Color(0xFF4C5A67), letterSpacing: 0),
    ),
  );
}
