import 'package:flutter/material.dart';

enum ArtKind {
  login,
  home,
  profile,
  events,
  payments,
  notifications,
  password,
  admin,
}

class PageArt extends StatelessWidget {
  const PageArt({super.key, required this.kind, this.height = 150});

  final ArtKind kind;
  final double height;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: height,
      width: double.infinity,
      child: CustomPaint(
        painter: _PageArtPainter(
          kind,
          Theme.of(context).colorScheme.primary,
          Theme.of(context).colorScheme.secondary,
          Theme.of(context).colorScheme.tertiary,
        ),
      ),
    );
  }
}

class _PageArtPainter extends CustomPainter {
  _PageArtPainter(this.kind, this.primary, this.secondary, this.tertiary);

  final ArtKind kind;
  final Color primary;
  final Color secondary;
  final Color tertiary;

  @override
  void paint(Canvas canvas, Size size) {
    final grid = Paint()
      ..color = primary.withValues(alpha: .08)
      ..strokeWidth = 1;
    for (double x = 0; x < size.width; x += 22) {
      canvas.drawLine(Offset(x, 0), Offset(x + 35, size.height), grid);
    }

    final stroke = Paint()
      ..style = PaintingStyle.stroke
      ..strokeWidth = 4
      ..strokeCap = StrokeCap.round
      ..color = primary;
    final accent = Paint()
      ..style = PaintingStyle.stroke
      ..strokeWidth = 3
      ..strokeCap = StrokeCap.round
      ..color = secondary;
    final fill = Paint()
      ..style = PaintingStyle.fill
      ..color = tertiary.withValues(alpha: .32);

    final center = Offset(size.width * .5, size.height * .52);
    switch (kind) {
      case ArtKind.login:
        canvas.drawCircle(center, 34, fill);
        canvas.drawRRect(
          RRect.fromRectAndRadius(
            Rect.fromCenter(center: center, width: 78, height: 48),
            const Radius.circular(8),
          ),
          stroke,
        );
        canvas.drawArc(
          Rect.fromCenter(
            center: center.translate(0, -25),
            width: 42,
            height: 42,
          ),
          3.14,
          3.14,
          false,
          accent,
        );
      case ArtKind.home:
        for (int i = 0; i < 4; i++) {
          canvas.drawRRect(
            RRect.fromRectAndRadius(
              Rect.fromLTWH(
                size.width * .24 + i * 28,
                size.height * .35 - i * 8,
                18,
                70 + i * 8,
              ),
              const Radius.circular(5),
            ),
            i.isEven ? stroke : accent,
          );
        }
      case ArtKind.profile:
        canvas.drawCircle(center.translate(0, -22), 22, stroke);
        canvas.drawArc(
          Rect.fromCenter(
            center: center.translate(0, 36),
            width: 104,
            height: 80,
          ),
          3.55,
          2.35,
          false,
          accent,
        );
        canvas.drawLine(
          center.translate(-62, 54),
          center.translate(62, 54),
          stroke,
        );
      case ArtKind.events:
        canvas.drawRRect(
          RRect.fromRectAndRadius(
            Rect.fromCenter(center: center, width: 112, height: 84),
            const Radius.circular(8),
          ),
          stroke,
        );
        canvas.drawLine(
          center.translate(-56, -18),
          center.translate(56, -18),
          accent,
        );
        for (int i = 0; i < 3; i++) {
          canvas.drawCircle(center.translate(-30 + i * 30, 18), 5, fill);
        }
      case ArtKind.payments:
        canvas.drawRRect(
          RRect.fromRectAndRadius(
            Rect.fromCenter(center: center, width: 118, height: 62),
            const Radius.circular(8),
          ),
          stroke,
        );
        canvas.drawCircle(center, 18, accent);
        canvas.drawLine(
          center.translate(-42, 0),
          center.translate(-22, 0),
          stroke,
        );
        canvas.drawLine(
          center.translate(22, 0),
          center.translate(42, 0),
          stroke,
        );
      case ArtKind.notifications:
        canvas.drawArc(
          Rect.fromCenter(center: center, width: 86, height: 92),
          2.9,
          3.55,
          false,
          stroke,
        );
        canvas.drawLine(
          center.translate(-34, 28),
          center.translate(34, 28),
          stroke,
        );
        canvas.drawCircle(center.translate(0, 42), 7, fill);
        canvas.drawArc(
          Rect.fromCenter(
            center: center.translate(44, -24),
            width: 40,
            height: 40,
          ),
          -.7,
          1.4,
          false,
          accent,
        );
      case ArtKind.password:
        canvas.drawCircle(center, 38, fill);
        canvas.drawRRect(
          RRect.fromRectAndRadius(
            Rect.fromCenter(
              center: center.translate(0, 14),
              width: 92,
              height: 54,
            ),
            const Radius.circular(8),
          ),
          stroke,
        );
        canvas.drawArc(
          Rect.fromCenter(
            center: center.translate(0, -17),
            width: 52,
            height: 52,
          ),
          3.14,
          3.14,
          false,
          accent,
        );
      case ArtKind.admin:
        canvas.drawRRect(
          RRect.fromRectAndRadius(
            Rect.fromCenter(center: center, width: 118, height: 76),
            const Radius.circular(8),
          ),
          stroke,
        );
        canvas.drawLine(
          center.translate(-42, -12),
          center.translate(42, -12),
          accent,
        );
        canvas.drawCircle(center.translate(-26, 18), 8, fill);
        canvas.drawCircle(center.translate(0, 18), 8, fill);
        canvas.drawCircle(center.translate(26, 18), 8, fill);
        canvas.drawLine(
          center.translate(58, -44),
          center.translate(78, -64),
          accent,
        );
        canvas.drawLine(
          center.translate(78, -64),
          center.translate(96, -42),
          accent,
        );
    }
  }

  @override
  bool shouldRepaint(covariant _PageArtPainter oldDelegate) =>
      oldDelegate.kind != kind;
}
