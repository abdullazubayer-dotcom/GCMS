# Backend Architecture Document
## Project: General Club Management System
## Stack: Laravel + MySQL
## Backend Type: Self-Hosted Production Application

---

# 1. Purpose

This document defines the backend architecture for a production-ready Web-Based General Club Management System.

The system will be developed using Laravel and MySQL. It will be self-hosted on a VPS, cPanel server, or institutional server. Members will not register themselves through public signup. Club authority will create member accounts manually using official Member ID, email, and phone number. Members will log in using the Member ID provided by the club.

---

# 2. Core Business Rule

## 2.1 Member Account Creation Rule

Members shall not create accounts through automated public signup.

Instead:

1. Club authority or admin creates the member profile.
2. Admin assigns an official unique Member ID.
3. Admin enters member email and phone number.
4. Admin creates or generates an initial password.
5. Member logs in using Member ID and password.
6. Member may change password after first login.

This rule improves security, prevents fake registration, and keeps membership controlled by the club authority.

---

# 3. System Users and Roles

## 3.1 Super Admin

Super Admin has full system control.

Responsibilities:

- Manage admin users
- Manage system settings
- Manage all members
- Manage events
- Manage payments
- View all reports
- View activity logs
- Control backup and maintenance access

## 3.2 Club Admin

Club Admin manages daily club operations.

Responsibilities:

- Add members
- Edit member information
- Activate or deactivate members
- Manage events
- Record payments
- Generate reports
- Send notifications

## 3.3 Member

Member is an official club member created by authority.

Responsibilities:

- Login using Member ID
- View own profile
- Update limited profile information if allowed
- View event calendar
- View payment history
- Receive notifications
- Change password

---

# 4. Backend Architecture Style

The backend should follow Laravel MVC architecture.

Recommended layers:

1. Routes
2. Controllers
3. Form Requests
4. Services
5. Models
6. Policies / Gates
7. Jobs / Queues
8. Notifications
9. Database Migrations
10. Seeders
11. Middleware

---

# 5. Recommended Laravel Folder Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── MemberController.php
│   │   │   ├── EventController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ReportController.php
│   │   │   └── NotificationController.php
│   │   ├── Member/
│   │   │   ├── DashboardController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── EventController.php
│   │   │   └── PaymentController.php
│   │   └── Auth/
│   ├── Middleware/
│   │   ├── EnsureUserIsAdmin.php
│   │   ├── EnsureUserIsMember.php
│   │   └── EnsureUserIsActive.php
│   └── Requests/
│       ├── StoreMemberRequest.php
│       ├── UpdateMemberRequest.php
│       ├── StoreEventRequest.php
│       ├── UpdateEventRequest.php
│       ├── StorePaymentRequest.php
│       └── UpdatePaymentRequest.php
├── Models/
│   ├── User.php
│   ├── Role.php
│   ├── Member.php
│   ├── Event.php
│   ├── EventRegistration.php
│   ├── Payment.php
│   ├── NotificationLog.php
│   └── ActivityLog.php
├── Services/
│   ├── MemberService.php
│   ├── EventService.php
│   ├── PaymentService.php
│   ├── ReportService.php
│   ├── NotificationService.php
│   └── AuditLogService.php
├── Policies/
├── Jobs/
├── Notifications/
└── Mail/
```

---

# 6. Authentication Architecture

## 6.1 Login Identifier

Members and admins should log in using:

```text
login_id
password
```

For members, `login_id` will be the official Club Member ID.

For admins, `login_id` may be an admin username or employee/admin ID.

Email and phone will be used for communication, password reset, and notifications.

## 6.2 Authentication Requirements

- Public signup must be disabled.
- Admin-created account only.
- Login by Member ID / Admin ID.
- Password must be hashed using Laravel Hash.
- Inactive users must not log in.
- First login password change may be required.
- Failed login attempts should be throttled.
- Session timeout should be configured.
- CSRF protection must be enabled.

---

# 7. Authorization Architecture

Use role-based access control.

Recommended roles:

```text
super_admin
admin
member
```

Authorization rules:

- Super Admin can access all modules.
- Admin can manage members, events, payments, and reports.
- Member can only view own dashboard, profile, events, and payment history.
- Members must not access admin routes.
- Admins must not accidentally modify Super Admin unless allowed.

---

# 8. Database Design

## 8.1 Main Tables

1. roles
2. users
3. members
4. events
5. event_registrations
6. payments
7. notification_logs
8. activity_logs
9. password_reset_tokens

---

# 9. Database Table Specification

## 9.1 roles table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Role ID |
| name | varchar(100) | unique, not null | Role name |
| display_name | varchar(150) | nullable | Human readable name |
| description | text | nullable | Role description |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |

Example values:

```text
super_admin
admin
member
```

---

## 9.2 users table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | User ID |
| role_id | bigint unsigned | foreign key | Role ID |
| login_id | varchar(80) | unique, not null | Member ID or Admin ID |
| name | varchar(150) | not null | Full name |
| email | varchar(150) | nullable, unique | Email address |
| phone | varchar(30) | nullable, unique | Phone number |
| password | varchar(255) | not null | Hashed password |
| status | enum | active/inactive/suspended | Login status |
| must_change_password | boolean | default true | Force password change |
| last_login_at | timestamp | nullable | Last login time |
| email_verified_at | timestamp | nullable | Email verification time |
| remember_token | varchar(100) | nullable | Remember token |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |
| deleted_at | timestamp | nullable | Soft delete |

Important:

- `login_id` is the main login credential.
- `login_id` for member should match official club Member ID.
- `email` and `phone` should not be required for login but should be stored.

---

## 9.3 members table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Member profile ID |
| user_id | bigint unsigned | foreign key, unique | Linked user account |
| member_code | varchar(80) | unique, not null | Official Club Member ID |
| date_of_birth | date | nullable | Date of birth |
| gender | varchar(30) | nullable | Gender |
| present_address | text | nullable | Present address |
| permanent_address | text | nullable | Permanent address |
| profession | varchar(150) | nullable | Profession |
| organization | varchar(150) | nullable | Workplace or institution |
| membership_type | varchar(100) | not null | General/Life/Donor/etc. |
| joining_date | date | nullable | Joining date |
| blood_group | varchar(10) | nullable | Blood group |
| emergency_contact_name | varchar(150) | nullable | Emergency contact person |
| emergency_contact_phone | varchar(30) | nullable | Emergency phone |
| photo | varchar(255) | nullable | Profile photo path |
| status | enum | active/inactive/suspended | Membership status |
| remarks | text | nullable | Admin notes |
| created_by | bigint unsigned | foreign key | Admin who created record |
| updated_by | bigint unsigned | foreign key nullable | Admin who updated record |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |
| deleted_at | timestamp | nullable | Soft delete |

---

## 9.4 events table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Event ID |
| title | varchar(200) | not null | Event title |
| slug | varchar(220) | unique | Event URL slug |
| event_date | date | not null | Event date |
| start_time | time | nullable | Start time |
| end_time | time | nullable | End time |
| venue | varchar(200) | nullable | Event venue |
| description | text | nullable | Event description |
| event_fee | decimal(10,2) | default 0.00 | Event fee |
| capacity | integer | nullable | Participant capacity |
| status | enum | draft/published/completed/cancelled | Event status |
| created_by | bigint unsigned | foreign key | Admin user ID |
| updated_by | bigint unsigned | foreign key nullable | Updated by |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |
| deleted_at | timestamp | nullable | Soft delete |

---

## 9.5 event_registrations table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Registration ID |
| event_id | bigint unsigned | foreign key | Event ID |
| member_id | bigint unsigned | foreign key | Member ID |
| registration_date | date | not null | Registration date |
| attendance_status | enum | registered/attended/absent/cancelled | Attendance |
| payment_status | enum | not_required/unpaid/paid | Event payment status |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |

Unique rule:

```text
event_id + member_id must be unique
```

---

## 9.6 payments table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Payment ID |
| payment_no | varchar(80) | unique, not null | Receipt/payment number |
| member_id | bigint unsigned | foreign key | Member ID |
| event_id | bigint unsigned | nullable foreign key | Related event |
| payment_type | varchar(100) | not null | Membership fee/event fee/donation/other |
| amount | decimal(12,2) | not null | Payment amount |
| payment_date | date | not null | Payment date |
| payment_method | varchar(100) | nullable | Cash/bank/mobile banking |
| transaction_reference | varchar(150) | nullable | Transaction reference |
| payment_status | enum | paid/due/cancelled/refunded | Status |
| remarks | text | nullable | Remarks |
| received_by | bigint unsigned | foreign key | Admin user ID |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |
| deleted_at | timestamp | nullable | Soft delete |

---

## 9.7 notification_logs table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Notification ID |
| user_id | bigint unsigned | nullable foreign key | Receiver user |
| channel | enum | email/sms/system | Notification channel |
| recipient | varchar(150) | nullable | Email or phone |
| subject | varchar(200) | nullable | Email subject |
| message | text | not null | Message body |
| status | enum | pending/sent/failed | Delivery status |
| error_message | text | nullable | Failure reason |
| sent_at | timestamp | nullable | Sent time |
| created_by | bigint unsigned | nullable foreign key | Admin sender |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |

---

## 9.8 activity_logs table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint unsigned | primary key | Log ID |
| user_id | bigint unsigned | nullable foreign key | Actor |
| action | varchar(150) | not null | Action name |
| module | varchar(100) | nullable | System module |
| description | text | nullable | Action details |
| ip_address | varchar(60) | nullable | IP address |
| user_agent | text | nullable | Browser/device |
| created_at | timestamp | nullable | Created time |
| updated_at | timestamp | nullable | Updated time |

---

# 10. Model Relationships

## User

```text
User belongsTo Role
User hasOne Member
User hasMany NotificationLog
User hasMany ActivityLog
```

## Role

```text
Role hasMany User
```

## Member

```text
Member belongsTo User
Member hasMany Payment
Member hasMany EventRegistration
Member belongsTo User as createdBy
Member belongsTo User as updatedBy
```

## Event

```text
Event belongsTo User as createdBy
Event belongsTo User as updatedBy
Event hasMany EventRegistration
Event hasMany Payment
```

## EventRegistration

```text
EventRegistration belongsTo Event
EventRegistration belongsTo Member
```

## Payment

```text
Payment belongsTo Member
Payment belongsTo Event
Payment belongsTo User as receivedBy
```

## NotificationLog

```text
NotificationLog belongsTo User
NotificationLog belongsTo User as createdBy
```

## ActivityLog

```text
ActivityLog belongsTo User
```

---

# 11. Backend Modules

## 11.1 Authentication Module

Features:

- Login using login_id and password
- Logout
- Change password
- First login password change
- Password reset by admin
- Login throttling
- Active/inactive user check

Routes:

```text
GET /login
POST /login
POST /logout
GET /change-password
POST /change-password
```

---

## 11.2 Admin Dashboard Module

Features:

- Total active members
- Total inactive members
- Total events
- Upcoming events
- Total payment collection
- Due payment summary
- Recent members
- Recent payments

Route:

```text
GET /admin/dashboard
```

---

## 11.3 Member Management Module

Features:

- Add member manually
- Assign Member ID
- Enter email and phone
- Generate temporary password
- Edit member
- Activate/deactivate member
- View member profile
- Search/filter member list
- Export-ready member table

Routes:

```text
GET /admin/members
GET /admin/members/create
POST /admin/members
GET /admin/members/{member}
GET /admin/members/{member}/edit
PUT /admin/members/{member}
PATCH /admin/members/{member}/status
DELETE /admin/members/{member}
POST /admin/members/{member}/reset-password
```

---

## 11.4 Member Panel Module

Features:

- View own dashboard
- View own profile
- Change password
- View events
- View payment history
- View notifications

Routes:

```text
GET /member/dashboard
GET /member/profile
GET /member/events
GET /member/payments
GET /member/notifications
```

---

## 11.5 Event Management Module

Features:

- Create event
- Edit event
- Delete event
- Publish/cancel event
- Calendar view
- Member event view

Routes:

```text
GET /admin/events
GET /admin/events/create
POST /admin/events
GET /admin/events/{event}
GET /admin/events/{event}/edit
PUT /admin/events/{event}
DELETE /admin/events/{event}
GET /events/calendar
```

---

## 11.6 Payment Management Module

Features:

- Add member payment
- Generate payment number
- Track membership fee, event fee, donation, other fee
- Filter by member, date, type, status
- Member-wise payment history
- Payment receipt view

Routes:

```text
GET /admin/payments
GET /admin/payments/create
POST /admin/payments
GET /admin/payments/{payment}
GET /admin/payments/{payment}/edit
PUT /admin/payments/{payment}
DELETE /admin/payments/{payment}
GET /admin/payments/{payment}/receipt
```

---

## 11.7 Report Module

Reports:

- Member report
- Payment report
- Due payment report
- Event report
- Date-wise collection report
- Member-wise payment report

Routes:

```text
GET /admin/reports
GET /admin/reports/members
GET /admin/reports/payments
GET /admin/reports/dues
GET /admin/reports/events
```

---

## 11.8 Notification Module

Features:

- Email notification
- SMS placeholder
- System notification record
- Notification status log
- Admin announcement

Routes:

```text
GET /admin/notifications
GET /admin/notifications/create
POST /admin/notifications
GET /member/notifications
```

---

# 12. Service Layer Design

Use service classes to keep controllers clean.

## MemberService

Responsibilities:

- Create user and member profile
- Generate temporary password
- Assign member code
- Update member details
- Change status
- Reset member password

## EventService

Responsibilities:

- Create event
- Update event
- Cancel event
- Prepare calendar data

## PaymentService

Responsibilities:

- Create payment
- Generate receipt number
- Calculate total payment
- Calculate due amount
- Prepare payment reports

## ReportService

Responsibilities:

- Prepare dashboard data
- Generate filtered reports
- Prepare printable data

## NotificationService

Responsibilities:

- Send email
- Store SMS placeholder
- Store notification log
- Update notification status

## AuditLogService

Responsibilities:

- Record create/update/delete actions
- Store IP address and user agent
- Track admin activities

---

# 13. Validation Rules

## Member Create Validation

```text
member_code: required, unique
name: required, max 150
email: nullable, email, unique
phone: nullable, max 30, unique
membership_type: required
status: required
password: required or auto-generated
```

## Event Validation

```text
title: required, max 200
event_date: required, date
start_time: nullable
end_time: nullable
venue: nullable, max 200
event_fee: numeric, min 0
status: required
```

## Payment Validation

```text
member_id: required, exists
payment_type: required
amount: required, numeric, min 0
payment_date: required, date
payment_status: required
payment_method: nullable
transaction_reference: nullable
```

---

# 14. Security Requirements

## 14.1 Authentication Security

- Disable public signup.
- Login ID must be unique.
- Passwords must be hashed.
- Login attempts must be throttled.
- Inactive users must be blocked.
- Password reset should be admin-controlled or verified.

## 14.2 Authorization Security

- Use middleware for admin/member access.
- Use policies for sensitive actions.
- Members must only access their own data.
- Admin routes must be protected.

## 14.3 Input Security

- Use Form Request validation.
- Escape output in Blade templates.
- Use CSRF protection.
- Avoid raw SQL where possible.
- Use Eloquent ORM or Query Builder safely.

## 14.4 File Upload Security

If profile photo is used:

- Allow only jpg, jpeg, png.
- Limit file size.
- Store outside direct public execution path.
- Rename uploaded files.
- Validate MIME type.

## 14.5 Production Security

- Set `APP_DEBUG=false`.
- Use strong `APP_KEY`.
- Use HTTPS.
- Protect `.env` file.
- Restrict storage and bootstrap/cache permissions.
- Regular database backup.
- Keep Laravel and packages updated.

---

# 15. Error Handling

Use Laravel default error handling with production configuration.

Production rules:

- Do not show detailed error pages to users.
- Log errors to server log.
- Show friendly error messages.
- Validate all forms before saving.
- Use database transactions for multi-table operations.

Use transactions for:

- Creating user + member profile
- Deleting related records
- Creating payment and notification record
- Resetting password and logging action

---

# 16. Audit Logging

Important actions should be logged:

- Admin login
- Member creation
- Member update
- Member status change
- Password reset
- Event creation/update/delete
- Payment creation/update/delete
- Notification send attempt

Audit log should store:

- User ID
- Action
- Module
- Description
- IP address
- User agent
- Date and time

---

# 17. Backup Strategy

Production application should include backup planning.

Recommended backup:

- Daily MySQL database backup
- Weekly full application backup
- Backup before major update
- Store backup outside public web directory
- Test restore process monthly

---

# 18. Deployment Architecture

## 18.1 Self-Hosted Server Requirements

Minimum:

```text
PHP 8.2+
Composer
MySQL 8+ or MariaDB 10+
Apache or Nginx
Laravel required PHP extensions
SSL certificate
Cron job access
File permission control
```

## 18.2 Deployment Steps

1. Upload Laravel project to server.
2. Configure `.env` file.
3. Set database credentials.
4. Run Composer install.
5. Run migrations.
6. Run seeders for roles and Super Admin.
7. Set public folder as document root.
8. Set permissions for storage and bootstrap/cache.
9. Set `APP_DEBUG=false`.
10. Configure queue and scheduler if needed.
11. Test login and all major modules.

---

# 19. Environment Configuration

Example `.env` production settings:

```text
APP_NAME="General Club Management System"
APP_ENV=production
APP_KEY=base64:GENERATED_KEY
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=club_management
DB_USERNAME=database_user
DB_PASSWORD=strong_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@your-domain.com
MAIL_FROM_NAME="Club Management System"
```

---

# 20. Production Readiness Checklist

Before production:

- [ ] Public signup disabled
- [ ] Login by Member ID working
- [ ] Super Admin account created
- [ ] Role-based access working
- [ ] Member cannot access admin routes
- [ ] Admin can add member manually
- [ ] Member can login using Member ID
- [ ] Password change working
- [ ] Event module tested
- [ ] Payment module tested
- [ ] Reports tested
- [ ] Email tested
- [ ] SMS placeholder tested
- [ ] Mobile responsive design checked
- [ ] APP_DEBUG=false
- [ ] HTTPS enabled
- [ ] Database backup configured
- [ ] Error logs checked
- [ ] Activity log working
- [ ] Soft delete working where needed
- [ ] Validation working
- [ ] Server permissions checked

---

# 21. Minimum Production Version

The first production version should include:

1. Admin login
2. Login by Member ID
3. Manual member creation by authority
4. Member profile management
5. Member dashboard
6. Event management
7. Event calendar
8. Payment management
9. Payment reports
10. Email notification
11. SMS placeholder
12. Activity log
13. Role-based access
14. Mobile responsive interface

---

# 22. Future Enhancements

Future features may include:

1. Online payment gateway
2. Real SMS gateway integration
3. PDF receipt generation
4. Member ID card generation
5. QR code attendance
6. Advanced permission management
7. Financial analytics
8. Mobile app
9. Automatic backup dashboard
10. Multi-branch club support

---

# 23. Final Architecture Recommendation

For production use, the system should be built with controlled member creation, strong role-based access, proper validation, audit logging, and backup planning. Public registration should remain disabled unless the club authority later decides to open online application submission.

The first release should focus on stability, security, and accurate data management rather than too many advanced features.
