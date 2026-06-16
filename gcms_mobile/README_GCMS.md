# GCMS Mobile App

This is the Flutter mobile app for the Laravel General Club Management System.

## Current Version

Member App v1:

- Login with official Member ID / Login ID
- Store API token securely
- Force temporary password change
- View own profile
- View published events
- View own payment history
- View own notifications
- Logout

## API Base URL

Default API URL:

```text
http://10.0.2.2:8000/api/v1
```

Use this default for the Android emulator.

For a real Android phone, run Laravel like this:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Then build or run Flutter with your computer LAN IP:

```bash
flutter run --dart-define=API_BASE_URL=http://192.168.0.105:8000/api/v1
```

Replace `192.168.0.105` with your computer's actual Wi-Fi/LAN IP address.

## Run App

```bash
flutter run
```

## Check Code

```bash
flutter analyze
flutter test
```

## Build Debug APK

```bash
flutter build apk --debug
```

APK path:

```text
build/app/outputs/flutter-apk/app-debug.apk
```

## Windows Note

If Flutter shows a symlink or plugin message, enable Windows Developer Mode:

```text
Settings > System > For developers > Developer Mode
```

## Admin Mobile Test Data

From the Laravel project root, run:

```bash
php artisan db:seed --class=MobileTestDataSeeder
```

This creates or updates:

- Member: `MOB-TEST-001`
- Event: `Mobile Demo Club Night`
- Payment: `PAY-MOBILE-TEST-001`
