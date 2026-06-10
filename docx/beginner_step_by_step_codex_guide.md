# Beginner Step-by-Step Codex Guide
## Project: General Club Management System
## Stack: Laravel + MySQL
## Target User: First Website Builder
## Backend Type: Self-Hosted Production Application

---

# 1. Project Summary

You will build a web-based **General Club Management System** using **Laravel + MySQL**.

This software will help a club authority manage:

- Members
- Events
- Payments
- Reports
- Notifications
- Admin dashboard
- Member dashboard

Important rule:

> There will be no public signup. Members will be created manually by club authority. Members will log in using the official Member ID provided by the club.

---

# 2. Main Business Rules

## Rule 1: No Public Signup

Do not create a public registration page where anyone can sign up.

## Rule 2: Authority Creates Members

Only admin or club authority can create member accounts.

## Rule 3: Member Login by Member ID

Members will log in using:

```text
Member ID + Password
```

## Rule 4: Email and Phone Are for Contact

Email and phone will be stored for:

- Communication
- Email notification
- SMS notification
- Contact record

They will not be the main login credential.

## Rule 5: Production Application

The system should be secure, organized, and maintainable.

---

# 3. Recommended Development Method

Because this is your first website, build slowly.

Do not ask Codex to build everything at once.

Build like this:

1. Project setup
2. Database setup
3. Login system
4. Admin dashboard
5. Member management
6. Event management
7. Payment management
8. Reports
9. Notification
10. Testing
11. Deployment

After every module:

1. Run the project
2. Test the feature
3. Take screenshot
4. Fix errors
5. Continue next module

---

# 4. Required Software

Install these before starting:

1. PHP
2. Composer
3. Laravel
4. MySQL
5. Node.js and NPM
6. VS Code
7. Laragon or XAMPP for local server
8. Git, optional but recommended

For beginner, Laragon is easier on Windows.

---

# 5. Suggested Project Name

```text
club-management-system
```

---

# 6. Basic Laravel Commands

Create Laravel project:

```bash
composer create-project laravel/laravel club-management-system
```

Go to project folder:

```bash
cd club-management-system
```

Run Laravel:

```bash
php artisan serve
```

Run migration:

```bash
php artisan migrate
```

Create model with migration and controller:

```bash
php artisan make:model Member -mcr
```

Clear cache:

```bash
php artisan optimize:clear
```

---

# 7. Software Requirements

## 7.1 User Roles

The system will have three main roles:

### Super Admin

Super Admin can:

- Manage everything
- Create admin users
- Create members
- Manage events
- Manage payments
- View reports
- View activity logs

### Admin

Admin can:

- Create members
- Edit members
- Manage events
- Add payments
- Generate reports
- Send notifications

### Member

Member can:

- Login using Member ID
- View own profile
- View events
- View own payment history
- View notifications
- Change password

---

# 8. Main Features

## 8.1 Authentication

The system must support:

- Login by login ID
- Member login by official Member ID
- Password login
- Logout
- Password change
- Role-based redirect
- Block inactive users

## 8.2 Member Management

Admin can:

- Add member manually
- Assign official Member ID
- Enter email and phone
- Set temporary password
- Edit member
- Deactivate member
- Reset member password
- Search member
- Filter member

## 8.3 Event Management

Admin can:

- Create event
- Edit event
- Delete event
- Publish event
- Cancel event
- Show event calendar

Member can:

- View published events

## 8.4 Payment Management

Admin can:

- Add payment
- Generate payment number
- Track paid/due payment
- View payment list
- Filter payment by date/member/status
- Print receipt

Member can:

- View own payment history

## 8.5 Reports

Admin can generate:

- Member report
- Payment report
- Due payment report
- Event report
- Date-wise payment report

## 8.6 Notification

The system should support:

- Email notification
- SMS placeholder
- Notification log

SMS can be future scope.

## 8.7 Activity Log

The system should log:

- Member creation
- Member update
- Password reset
- Event creation
- Payment creation
- Notification sending

---

# 9. Database Schema

## 9.1 Tables

Required tables:

1. roles
2. users
3. members
4. events
5. event_registrations
6. payments
7. notification_logs
8. activity_logs

---

## 9.2 roles Table

Purpose: Store user roles.

Fields:

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| name | varchar | Role name |
| display_name | varchar | Display name |
| description | text | Description |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |

Role values:

```text
super_admin
admin
member
```

---

## 9.3 users Table

Purpose: Store login accounts.

Important: login_id is used for login.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| role_id | bigint | Role ID |
| login_id | varchar | Login ID / Member ID |
| name | varchar | Name |
| email | varchar | Email |
| phone | varchar | Phone |
| password | varchar | Hashed password |
| status | enum | active/inactive/suspended |
| must_change_password | boolean | Force password change |
| last_login_at | timestamp | Last login |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |
| deleted_at | timestamp | Soft delete |

---

## 9.4 members Table

Purpose: Store member profile.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | User account ID |
| member_code | varchar | Official Member ID |
| date_of_birth | date | Date of birth |
| gender | varchar | Gender |
| present_address | text | Present address |
| permanent_address | text | Permanent address |
| profession | varchar | Profession |
| organization | varchar | Organization |
| membership_type | varchar | Membership type |
| joining_date | date | Joining date |
| blood_group | varchar | Blood group |
| emergency_contact_name | varchar | Emergency contact |
| emergency_contact_phone | varchar | Emergency phone |
| photo | varchar | Photo path |
| status | enum | active/inactive/suspended |
| remarks | text | Remarks |
| created_by | bigint | Created by admin |
| updated_by | bigint | Updated by admin |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |
| deleted_at | timestamp | Soft delete |

---

## 9.5 events Table

Purpose: Store club events.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| title | varchar | Event title |
| slug | varchar | Event slug |
| event_date | date | Event date |
| start_time | time | Start time |
| end_time | time | End time |
| venue | varchar | Venue |
| description | text | Details |
| event_fee | decimal | Event fee |
| capacity | integer | Capacity |
| status | enum | draft/published/completed/cancelled |
| created_by | bigint | Created by admin |
| updated_by | bigint | Updated by admin |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |
| deleted_at | timestamp | Soft delete |

---

## 9.6 event_registrations Table

Purpose: Store event registration if used.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| event_id | bigint | Event ID |
| member_id | bigint | Member ID |
| registration_date | date | Registration date |
| attendance_status | enum | registered/attended/absent/cancelled |
| payment_status | enum | not_required/unpaid/paid |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |

---

## 9.7 payments Table

Purpose: Store payment records.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| payment_no | varchar | Unique payment number |
| member_id | bigint | Member ID |
| event_id | bigint | Event ID if applicable |
| payment_type | varchar | Membership fee/event fee/donation |
| amount | decimal | Amount |
| payment_date | date | Payment date |
| payment_method | varchar | Cash/bank/mobile banking |
| transaction_reference | varchar | Reference |
| payment_status | enum | paid/due/cancelled/refunded |
| remarks | text | Remarks |
| received_by | bigint | Admin user ID |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |
| deleted_at | timestamp | Soft delete |

---

## 9.8 notification_logs Table

Purpose: Store email/SMS/system notification records.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | Receiver user |
| channel | enum | email/sms/system |
| recipient | varchar | Email or phone |
| subject | varchar | Subject |
| message | text | Message |
| status | enum | pending/sent/failed |
| error_message | text | Error message |
| sent_at | timestamp | Sent time |
| created_by | bigint | Sender admin |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |

---

## 9.9 activity_logs Table

Purpose: Store important system actions.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | User who performed action |
| action | varchar | Action |
| module | varchar | Module name |
| description | text | Details |
| ip_address | varchar | IP address |
| user_agent | text | Browser/device |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |

---

# 10. Build Roadmap

## Phase 1: Planning

Output:

- Requirement document
- Database schema
- Build plan
- Codex prompts

## Phase 2: Setup

Output:

- Laravel installed
- MySQL connected
- Base layout ready

## Phase 3: Authentication

Output:

- Login by Member ID
- Role-based dashboard
- No public signup

## Phase 4: Admin Module

Output:

- Admin dashboard
- Member creation
- Member list
- Member edit
- Password reset

## Phase 5: Member Module

Output:

- Member dashboard
- Profile view
- Payment history
- Event view

## Phase 6: Event Module

Output:

- Event CRUD
- Calendar view

## Phase 7: Payment Module

Output:

- Payment entry
- Payment receipt
- Payment report

## Phase 8: Notification

Output:

- Email notification
- SMS placeholder
- Notification log

## Phase 9: Testing

Output:

- Test checklist
- Bug fixing

## Phase 10: Deployment

Output:

- Self-hosted production application

---

# 11. Master Prompt for Codex

Use this prompt first.

```text
I am a beginner building my first production Laravel + MySQL website.

Project name: General Club Management System.

Important business rules:
1. No public signup.
2. Members are created manually by club authority.
3. Each member receives an official unique Member ID.
4. Members log in using Member ID and password.
5. Email and phone are stored for contact only.
6. System has Super Admin, Admin, and Member roles.
7. Backend should be self-hosted and production-ready.
8. Use Laravel MVC, MySQL, Blade, Bootstrap, migrations, models, controllers, Form Request validation, middleware, service classes, seeders, and activity logs.
9. Explain everything step by step for a beginner.
10. Give exact file paths and complete code.
11. Do not skip commands.
12. Do not build everything at once.

First, prepare the project setup plan and database migration plan only.
```

---

# 12. Prompt 1: Laravel Setup

```text
Create the Laravel project setup instructions for General Club Management System.

I am a beginner, so explain step by step.

Include:
1. Required software
2. Laravel installation command
3. Project folder command
4. How to run Laravel locally
5. How to create MySQL database
6. How to configure .env
7. How to test database connection
8. How to clear cache if error happens

Important:
- No public signup.
- Member login will use Member ID.
```

---

# 13. Prompt 2: Database Migrations

```text
Create Laravel migrations for the General Club Management System.

Tables:
1. roles
2. users
3. members
4. events
5. event_registrations
6. payments
7. notification_logs
8. activity_logs

Important:
- users table must have unique login_id.
- members table must have unique member_code.
- login_id for members will be same as member_code.
- Public signup is not allowed.
- Members are created manually by admin.
- Use foreign keys.
- Use timestamps.
- Use soft deletes where suitable.
- Add indexes for searchable fields.

Give complete migration code with file paths and artisan commands.
```

---

# 14. Prompt 3: Models and Relationships

```text
Create Laravel models and relationships.

Models:
- Role
- User
- Member
- Event
- EventRegistration
- Payment
- NotificationLog
- ActivityLog

Include:
1. Complete model code
2. Fillable fields
3. Casts
4. SoftDeletes where needed
5. Relationship methods

Important relationships:
- Role has many users
- User belongs to role
- User has one member
- Member belongs to user
- Member has many payments
- Member has many event registrations
- Event has many event registrations
- Event has many payments
- Payment belongs to member
- Payment belongs to event
- Payment belongs to receivedBy user
```

---

# 15. Prompt 4: Seed Roles and Super Admin

```text
Create Laravel seeders for roles and Super Admin.

Requirements:
- Seed roles: super_admin, admin, member
- Create default Super Admin
- Super Admin login_id: SA-001
- Super Admin email: admin@example.com
- Use hashed password
- Set must_change_password to true
- Explain how to change default password later
- No public signup should be enabled

Give:
1. Seeder code
2. DatabaseSeeder update
3. Artisan commands
```

---

# 16. Prompt 5: Login by Member ID

```text
Create custom Laravel login system using login_id instead of email.

Requirements:
- Login form has login_id and password.
- Members use official Member ID as login_id.
- Admin uses admin login ID.
- Check user status active.
- Block inactive and suspended users.
- Redirect:
  - super_admin/admin to /admin/dashboard
  - member to /member/dashboard
- Public signup must not exist.
- Include logout.
- Include first login password change if must_change_password is true.
- Use Laravel Hash and Auth.
- Use login throttling.

Give:
1. Routes
2. Controller
3. Request validation
4. Blade login page
5. Middleware
6. Testing steps
```

---

# 17. Prompt 6: Role Middleware

```text
Create role-based middleware for Laravel.

Middleware required:
1. EnsureUserIsAdmin
2. EnsureUserIsMember
3. EnsureUserIsActive

Rules:
- Super Admin and Admin can access /admin routes.
- Member can access /member routes.
- Inactive and suspended users cannot access dashboards.
- Unauthorized users get redirected with error message.

Give:
1. Middleware code
2. How to register middleware
3. Route group examples
4. Testing steps
```

---

# 18. Prompt 7: Admin Dashboard

```text
Create admin dashboard for General Club Management System.

Dashboard should show:
- Total active members
- Total inactive members
- Total suspended members
- Total events
- Upcoming events
- Total payment collection
- Due payment total
- Recent members
- Recent payments

Requirements:
- Use Bootstrap cards.
- Use Admin/DashboardController.
- Only admin and super_admin can access.
- Use MySQL data.
- Make page mobile responsive.

Give:
1. Controller code
2. Blade view
3. Routes
4. Testing steps
```

---

# 19. Prompt 8: Manual Member Creation

```text
Create manual member creation module.

Important:
No public signup is allowed.

Admin will create member manually.

Fields:
- Member ID
- Name
- Email
- Phone
- Present address
- Permanent address
- Date of birth
- Gender
- Profession
- Organization
- Membership type
- Joining date
- Blood group
- Emergency contact name
- Emergency contact phone
- Status
- Temporary password

Rules:
- users.login_id = Member ID
- members.member_code = Member ID
- Member ID must be unique.
- Email and phone must be unique if provided.
- Password must be hashed.
- must_change_password must be true.
- Create user and member in one transaction.
- Log activity.

Give:
1. StoreMemberRequest
2. MemberController create/store
3. MemberService
4. Create Blade form
5. Routes
6. Success message
7. Testing steps
```

---

# 20. Prompt 9: Member List, Search, Edit

```text
Create member list, search, filter, view, and edit module.

Requirements:
- Admin can view all members.
- Search by Member ID, name, email, phone.
- Filter by status and membership type.
- Paginate results.
- Admin can view member details.
- Admin can edit member details.
- Admin can activate, deactivate, or suspend member.
- Use Bootstrap responsive table.
- Log update actions.

Give:
1. Controller methods
2. Service methods
3. Blade views
4. Routes
5. Validation
6. Testing steps
```

---

# 21. Prompt 10: Member Password Reset

```text
Create admin-controlled member password reset.

Requirements:
- Admin can reset member password.
- New temporary password can be generated or manually entered.
- Password must be hashed.
- Set must_change_password to true.
- Show new password only once after reset.
- Log activity.
- Do not send password publicly unless email setup is secure.

Give:
1. Controller method
2. Service method
3. Route
4. Blade button or modal
5. Testing steps
```

---

# 22. Prompt 11: Member Dashboard and Profile

```text
Create member dashboard and profile pages.

Requirements:
- Member can view own profile only.
- Member can view upcoming published events.
- Member can view latest payment history.
- Member can view notifications.
- Member can change password.
- Member cannot access other members' data.
- Member cannot change Member ID, role, status, or payment data.

Give:
1. Member DashboardController
2. ProfileController
3. Blade views
4. Routes
5. Authorization checks
6. Testing steps
```

---

# 23. Prompt 12: Event Management

```text
Create event management CRUD module.

Fields:
- Title
- Slug
- Event date
- Start time
- End time
- Venue
- Description
- Event fee
- Capacity
- Status

Status:
- draft
- published
- completed
- cancelled

Requirements:
- Admin can create, edit, view, delete events.
- Members can view only published events.
- Use soft delete.
- Use validation.
- Log activity.
- Use Bootstrap UI.

Give:
1. EventController for admin
2. EventController for member view
3. StoreEventRequest
4. UpdateEventRequest
5. Blade views
6. Routes
7. Testing steps
```

---

# 24. Prompt 13: Event Calendar

```text
Create event calendar page.

Requirements:
- Admin can view all events.
- Member can view only published events.
- Show event title, date, time, venue.
- Use calendar-style layout or monthly list.
- Mobile responsive.
- Include upcoming event section.

Give:
1. Controller methods
2. Blade views
3. Routes
4. Testing steps
```

---

# 25. Prompt 14: Payment Management

```text
Create payment management module.

Fields:
- payment_no
- member_id
- event_id optional
- payment_type
- amount
- payment_date
- payment_method
- transaction_reference
- payment_status
- remarks
- received_by

Rules:
- Generate unique payment_no automatically.
- Admin can add, edit, view, delete payment.
- Member can view own payment only.
- Payment status: paid, due, cancelled, refunded.
- Use validation.
- Use activity log.
- Use Bootstrap responsive views.

Give:
1. PaymentController
2. PaymentService
3. StorePaymentRequest
4. UpdatePaymentRequest
5. Blade views
6. Routes
7. Testing steps
```

---

# 26. Prompt 15: Payment Receipt

```text
Create payment receipt page.

Requirements:
- Admin can view and print receipt.
- Member can view own receipt only.
- Receipt shows:
  - Club name
  - Payment number
  - Member ID
  - Member name
  - Payment type
  - Amount
  - Payment date
  - Payment method
  - Received by
  - Remarks
- Use print-friendly Blade design.
- PDF is not required now.

Give:
1. Controller method
2. Blade receipt template
3. Routes
4. Authorization checks
5. Testing steps
```

---

# 27. Prompt 16: Reports

```text
Create report module for admin.

Reports:
1. Member report
2. Payment report
3. Due payment report
4. Event report
5. Date-wise collection report
6. Member-wise payment report

Requirements:
- Filter by date range.
- Filter by member.
- Filter by payment status.
- Filter by payment type.
- Show total amount.
- Use responsive Bootstrap tables.
- Make report printable.
- Only admin and super_admin can access.

Give:
1. ReportController
2. ReportService
3. Blade views
4. Routes
5. Testing steps
```

---

# 28. Prompt 17: Email Notification

```text
Create email notification module.

Requirements:
- Send email when member account is created.
- Send email when password is reset.
- Send event announcement email.
- Send payment reminder email.
- Store every email attempt in notification_logs.
- If email fails, store error message.
- Use Laravel Mail.
- Use simple sync sending for first version.
- Add .env mail configuration example.

Give:
1. Mailable classes
2. NotificationService
3. Email Blade templates
4. Controller methods
5. Routes
6. Testing steps
```

---

# 29. Prompt 18: SMS Placeholder

```text
Create SMS placeholder module.

Requirements:
- No real SMS gateway now.
- Admin can create SMS message.
- Store message in notification_logs with channel=sms.
- Status should be pending.
- Show SMS log in admin panel.
- Mention real SMS gateway as future scope.

Give:
1. Controller
2. Service method
3. Blade form
4. SMS log view
5. Routes
6. Testing steps
```

---

# 30. Prompt 19: Activity Logs

```text
Create activity log system.

Requirements:
- Log important admin actions:
  - member create
  - member update
  - member status change
  - password reset
  - event create/update/delete
  - payment create/update/delete
  - notification send
- Store:
  - user_id
  - action
  - module
  - description
  - ip_address
  - user_agent
- Super Admin can view activity logs.

Give:
1. ActivityLog model
2. AuditLogService
3. Example usage in controllers
4. Activity log Blade view
5. Routes
6. Testing steps
```

---

# 31. Prompt 20: Security Review

```text
Review the whole Laravel General Club Management System for production security.

Check:
- Public signup disabled
- Login by Member ID
- Password hashing
- Login throttling
- Role middleware
- Active user middleware
- CSRF protection
- Form validation
- Member can only access own data
- Admin routes protected
- APP_DEBUG=false for production
- .env protected
- File upload validation
- Activity logs
- Soft deletes
- Backup plan

Give:
1. Security issues found
2. Code fixes
3. Production checklist
4. Testing steps
```

---

# 32. Prompt 21: Deployment

```text
Create deployment guide for Laravel General Club Management System.

Deployment target:
- Self-hosted server
- VPS or cPanel
- MySQL database

Include:
1. Upload project
2. Configure .env
3. Create database
4. Run composer install
5. Run migration
6. Run seeders
7. Set public folder as web root
8. Set permissions
9. Set APP_DEBUG=false
10. Configure mail
11. Enable HTTPS
12. Setup database backup
13. Test all modules

Also include common errors and fixes.
```

---

# 33. Testing Checklist

Use this checklist after building.

## Authentication

- [ ] Admin can login
- [ ] Member can login with Member ID
- [ ] Wrong password blocked
- [ ] Inactive user blocked
- [ ] Logout works
- [ ] Public signup does not exist

## Member

- [ ] Admin can create member
- [ ] Duplicate Member ID blocked
- [ ] Member password hashed
- [ ] Member can login
- [ ] Member can view own profile
- [ ] Member cannot view other profile
- [ ] Admin can edit member
- [ ] Admin can reset password

## Event

- [ ] Admin can create event
- [ ] Admin can edit event
- [ ] Admin can delete event
- [ ] Member can view published event
- [ ] Member cannot view draft event

## Payment

- [ ] Admin can add payment
- [ ] Payment number generated
- [ ] Admin can view payment
- [ ] Member can view own payment
- [ ] Member cannot view other payment
- [ ] Receipt prints properly

## Report

- [ ] Payment report works
- [ ] Member report works
- [ ] Due report works
- [ ] Date filter works

## Notification

- [ ] Email notification logs
- [ ] SMS placeholder logs
- [ ] Failure logs error message

## Security

- [ ] Admin route protected
- [ ] Member route protected
- [ ] CSRF works
- [ ] Validation works
- [ ] APP_DEBUG=false in production

---

# 34. Class Presentation Flow

Use this order for class presentation:

1. Project title
2. Problem statement
3. Objective
4. Technology used
5. Why Laravel + MySQL
6. Why self-hosted backend
7. No public signup rule
8. Member login by official Member ID
9. Database design
10. Admin dashboard demo
11. Manual member creation demo
12. Member login demo
13. Event module demo
14. Payment module demo
15. Report module demo
16. Codex prompt example
17. Problems faced
18. Future scope

---

# 35. Screenshot Checklist

Take screenshots of:

1. Requirement document
2. Database schema
3. Laravel project folder
4. .env database setup
5. Migration files
6. Database tables
7. Codex prompts
8. Login page
9. Admin dashboard
10. Add member page
11. Member list
12. Member dashboard
13. Event page
14. Payment page
15. Report page
16. Mobile view
17. Error fixing steps
18. Final output

---

# 36. Beginner Advice

Do not hurry.

For each module:

1. Ask Codex for one module.
2. Copy code carefully.
3. Check file path.
4. Run command.
5. Test in browser.
6. Take screenshot.
7. Fix error.
8. Continue.

Most important reminder:

```text
No public signup. Members are created by authority and login using official Member ID.
```
