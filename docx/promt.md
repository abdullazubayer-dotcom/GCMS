# Codex Prompt Guide
## Project: General Club Management System
## Stack: Laravel + MySQL
## Backend: Self-Hosted Production Application

---

# 1. How to Use This Prompt Guide

Use this file step by step with Codex.

Do not ask Codex to build the full system in one prompt. Build one module at a time, test it, fix errors, then continue.

Important project rule:

Members will not sign up by themselves. Club authority will create every member account manually with Member ID, email, and phone. Members will log in using the Member ID provided by the club.

---

# 2. Master Project Instruction for Codex

Use this prompt first to establish the full project context.

```text
You are helping me build a production-ready Laravel + MySQL web application named General Club Management System.

Important business rules:
1. This is a self-hosted backend application.
2. Public user signup must be disabled.
3. Members will be created manually by club authority.
4. Each member will receive an official unique Member ID.
5. Members will log in using Member ID and password.
6. Email and phone will be stored for communication but not used as the primary login ID.
7. The system must support admin and member roles.
8. The application must be secure, maintainable, and production-ready.

Core modules:
- Authentication
- Role-based access
- Admin dashboard
- Manual member creation
- Member profile management
- Member dashboard
- Event management
- Event calendar
- Payment management
- Payment reports
- Email notification
- SMS notification placeholder
- Activity logging
- Mobile responsive UI

Use Laravel MVC structure, Form Request validation, service classes, migrations, seeders, policies or middleware, and Bootstrap-based Blade views.

Whenever you create code, include the file path and complete code. Also explain where to place the code and which artisan commands to run.
```

---

# 3. Project Setup Prompt

```text
Create a fresh Laravel project structure for a production-ready General Club Management System using MySQL.

Requirements:
- Use Laravel MVC architecture.
- Use Bootstrap for Blade layout.
- Prepare folder structure for Admin and Member controllers.
- Public signup must be disabled.
- Login will be based on login_id, not email.
- Members will login using official Member ID.
- Create a clean base layout with sidebar, navbar, and content area.
- Include recommended routes structure for admin and member panels.

Give me:
1. Artisan commands
2. Folder structure
3. Route file structure
4. Base Blade layout
5. Setup instructions
```

---

# 4. Environment and Database Setup Prompt

```text
Prepare the Laravel .env database configuration and MySQL setup plan for the General Club Management System.

Requirements:
- Database name: club_management
- Use MySQL
- Use production-safe configuration
- Explain APP_DEBUG=false for production
- Include local development and production configuration examples
- Include migration and seeding command sequence
```

---

# 5. Database Migration Prompt

```text
Create Laravel migrations for the General Club Management System.

Tables required:
1. roles
2. users
3. members
4. events
5. event_registrations
6. payments
7. notification_logs
8. activity_logs

Important:
- users table must have login_id as unique field.
- login_id will be used for login.
- member_code in members table must be unique.
- Members are created by admin only.
- Use soft deletes where appropriate.
- Add foreign keys properly.
- Add timestamps.
- Add indexes for search fields.

Give me complete migration code for each table and the artisan commands.
```

---

# 6. Model Relationship Prompt

```text
Create Laravel Eloquent models and relationships for the General Club Management System.

Models:
- Role
- User
- Member
- Event
- EventRegistration
- Payment
- NotificationLog
- ActivityLog

Relationships:
- Role hasMany Users
- User belongsTo Role
- User hasOne Member
- Member belongsTo User
- Member hasMany Payments
- Member hasMany EventRegistrations
- Event hasMany EventRegistrations
- Event hasMany Payments
- Payment belongsTo Member
- Payment belongsTo Event
- Payment belongsTo User as receivedBy
- NotificationLog belongsTo User
- ActivityLog belongsTo User

Include:
1. Complete model code
2. Fillable fields
3. Casts where needed
4. SoftDeletes where needed
5. Relationship methods
```

---

# 7. Seeder Prompt

```text
Create Laravel seeders for the General Club Management System.

Requirements:
- Seed roles: super_admin, admin, member
- Create one Super Admin user
- Super Admin should login using login_id: SA-001
- Use a secure hashed default password
- Add clear instruction to change the default password after first login
- No public signup should be seeded or enabled

Give me:
1. RoleSeeder
2. SuperAdminSeeder
3. DatabaseSeeder update
4. Artisan commands
```

---

# 8. Authentication Prompt: Login by Member ID

```text
Create custom Laravel authentication where users login using login_id and password instead of email.

Requirements:
- login_id field is used for login.
- Member login_id will be official Member ID.
- Admin login_id will be admin ID.
- Block inactive or suspended users.
- Use Laravel Hash for password verification.
- Use login throttling.
- Redirect based on role:
  - super_admin/admin to /admin/dashboard
  - member to /member/dashboard
- Public registration must be disabled.
- Include logout.
- Include first login password change if must_change_password is true.

Give me:
1. Auth routes
2. Login controller
3. Login request validation
4. Blade login page
5. Middleware for active users
6. Role-based redirect logic
```

---

# 9. Middleware Prompt

```text
Create Laravel middleware for role-based access in the General Club Management System.

Required middleware:
1. EnsureUserIsAdmin
2. EnsureUserIsMember
3. EnsureUserIsActive

Rules:
- Only super_admin and admin can access admin routes.
- Only member can access member routes.
- Inactive and suspended users cannot access dashboard.
- Unauthorized users should be redirected with error message.

Give me:
1. Middleware code
2. Registration in Kernel or Laravel bootstrap app configuration depending on Laravel version
3. Example route groups
```

---

# 10. Admin Dashboard Prompt

```text
Create an admin dashboard for the General Club Management System.

Dashboard cards:
- Total active members
- Total inactive members
- Total events
- Upcoming events
- Total payment collection
- Due payments
- Recent members
- Recent payments

Requirements:
- Use Bootstrap cards.
- Use a DashboardController.
- Use a service class if needed.
- Data should come from MySQL tables.
- Admin dashboard route: /admin/dashboard
- Only admin and super_admin can access.

Give me:
1. Controller code
2. Service code if needed
3. Blade view
4. Route definition
```

---

# 11. Manual Member Creation Prompt

```text
Create manual member creation module for the General Club Management System.

Important business rule:
No public signup is allowed. Only admin or super_admin can create members.

Requirements:
- Admin enters Member ID, name, email, phone, address, membership type, joining date, and status.
- System creates a user account and member profile together.
- Member login_id must be same as official Member ID.
- member_code must be same as official Member ID.
- Generate a temporary password or allow admin to set temporary password.
- Password must be hashed.
- must_change_password should be true for newly created members.
- Use database transaction.
- Validate unique login_id, member_code, email, and phone.
- After creation, show temporary password only once or provide a reset option.

Give me:
1. Migration adjustment if needed
2. Form Request validation
3. MemberController methods
4. MemberService code
5. Create member Blade form
6. Success message
7. Routes
```

---

# 12. Member List and Search Prompt

```text
Create member list, search, and filter module.

Requirements:
- Admin can view all members.
- Search by Member ID, name, email, phone.
- Filter by membership type and status.
- Show pagination.
- Show action buttons: view, edit, deactivate, reset password.
- Use Bootstrap responsive table.
- Only admin and super_admin can access.

Give me:
1. Controller index method
2. Query filter logic
3. Blade view
4. Routes
```

---

# 13. Member Edit Prompt

```text
Create member edit and update module.

Requirements:
- Admin can update member name, email, phone, address, profession, organization, membership type, joining date, status, and remarks.
- Member ID should not be changed easily after creation.
- If Member ID change is allowed, it must update both users.login_id and members.member_code in a transaction.
- Validate unique email and phone except current user.
- Use Form Request validation.
- Use transaction.
- Log the activity.

Give me:
1. Edit Blade view
2. Update validation request
3. Controller update method
4. Service method
5. Route
```

---

# 14. Member Password Reset Prompt

```text
Create admin-controlled member password reset feature.

Requirements:
- Admin can reset a member password.
- New password may be manually entered or auto-generated.
- Password must be hashed.
- Set must_change_password to true.
- Store activity log.
- Do not expose password except immediately after reset.
- Only admin and super_admin can reset password.

Give me:
1. Controller method
2. Service method
3. Blade button/modal
4. Route
5. Security notes
```

---

# 15. Member Dashboard Prompt

```text
Create member dashboard for the General Club Management System.

Requirements:
- Member can view own profile summary.
- Member can view upcoming events.
- Member can view latest payment history.
- Member can view notifications.
- Member must not access other member data.
- Use authenticated user's member profile.
- Use Bootstrap responsive design.

Give me:
1. Member DashboardController
2. Blade view
3. Routes
4. Authorization protection
```

---

# 16. Member Profile Prompt

```text
Create member profile page.

Requirements:
- Member can view own profile.
- Member may update limited fields only: phone, address, emergency contact, photo.
- Member cannot change Member ID, role, status, or payment data.
- Admin can update full profile from admin panel.
- Validate all fields.
- Secure photo upload if included.

Give me:
1. ProfileController
2. Form Request validation
3. Blade profile view
4. Update route
5. File upload security
```

---

# 17. Event Management Prompt

```text
Create event management CRUD module for admin.

Requirements:
- Admin can create, edit, view, delete events.
- Event fields: title, event_date, start_time, end_time, venue, description, event_fee, capacity, status.
- Status values: draft, published, completed, cancelled.
- Use slug for event.
- Use Form Request validation.
- Use SoftDeletes.
- Log create, update, and delete actions.
- Members can only see published events.

Give me:
1. Event migration if needed
2. Event model
3. StoreEventRequest
4. UpdateEventRequest
5. Admin EventController
6. Blade views: index, create, edit, show
7. Routes
```

---

# 18. Event Calendar Prompt

```text
Create event calendar page for the General Club Management System.

Requirements:
- Show published upcoming events.
- Admin can view all statuses.
- Member can view only published events.
- Calendar can be simple monthly list or Bootstrap calendar-style layout.
- Include event date, time, venue, and title.
- Make it mobile responsive.

Give me:
1. Controller method
2. Blade calendar view
3. Routes for admin and member
```

---

# 19. Event Registration Prompt

```text
Create optional event registration module.

Requirements:
- Member can register for published events.
- Prevent duplicate registration for same event and member.
- Track attendance_status: registered, attended, absent, cancelled.
- Track payment_status: not_required, unpaid, paid.
- Admin can view event participants.
- Admin can mark attendance.

Give me:
1. EventRegistration model relationship
2. Controller methods
3. Routes
4. Blade views
5. Validation and duplicate prevention logic
```

---

# 20. Payment Management Prompt

```text
Create payment management module.

Requirements:
- Admin can add payment for a member.
- Payment fields: payment_no, member_id, event_id optional, payment_type, amount, payment_date, payment_method, transaction_reference, payment_status, remarks.
- Generate unique payment_no automatically.
- Payment status values: paid, due, cancelled, refunded.
- Use Form Request validation.
- Use database transaction if needed.
- Log payment creation.
- Member can view own payment history only.

Give me:
1. Payment model
2. StorePaymentRequest
3. UpdatePaymentRequest
4. PaymentService
5. Admin PaymentController
6. Member PaymentController
7. Blade views
8. Routes
```

---

# 21. Payment Receipt Prompt

```text
Create payment receipt page.

Requirements:
- Admin can view and print payment receipt.
- Receipt should show club name, payment number, member ID, member name, payment type, amount, date, method, received by, and remarks.
- Member can view own receipt only.
- Use print-friendly Blade design.
- Do not require PDF in first version.

Give me:
1. Receipt controller method
2. Blade receipt template
3. Routes
4. Authorization rule
```

---

# 22. Report Module Prompt

```text
Create report module for admin.

Reports required:
1. Member report
2. Payment report
3. Due payment report
4. Event report
5. Date-wise collection report
6. Member-wise payment report

Requirements:
- Add filters by date range, member, status, payment type.
- Use pagination where needed.
- Show total amount summary.
- Use Bootstrap tables.
- Make tables print-friendly.
- Only admin and super_admin can access.

Give me:
1. ReportController
2. ReportService
3. Blade views
4. Routes
5. Query examples
```

---

# 23. Email Notification Prompt

```text
Create email notification system.

Requirements:
- Send email after member account creation.
- Send email after password reset if email exists.
- Send event announcement email.
- Send payment reminder email.
- Store every notification attempt in notification_logs table.
- If email fails, store error message.
- Use Laravel Mail.
- Use queue if possible but allow simple sync sending for first version.

Give me:
1. Mailable classes
2. NotificationService
3. Email Blade templates
4. Controller methods
5. Routes
6. .env mail configuration example
```

---

# 24. SMS Placeholder Prompt

```text
Create SMS notification placeholder module.

Requirements:
- Do not integrate a real SMS gateway now.
- Admin can prepare SMS message for a member or group.
- Store SMS message in notification_logs table with channel=sms.
- Mark status as pending.
- Keep real SMS gateway integration as future scope.
- Show SMS log in admin panel.

Give me:
1. Controller method
2. Service method
3. Blade form
4. SMS log view
5. Routes
```

---

# 25. Activity Log Prompt

```text
Create activity logging system.

Requirements:
- Log important admin actions.
- Log member creation, update, deactivate, password reset.
- Log event create/update/delete.
- Log payment create/update/delete.
- Store user_id, action, module, description, ip_address, user_agent.
- Create helper service AuditLogService.
- Admin can view activity logs.
- Super Admin can view all logs.

Give me:
1. ActivityLog model
2. AuditLogService
3. Example usage in controllers
4. Activity log admin view
5. Routes
```

---

# 26. Security Hardening Prompt

```text
Review and improve the Laravel General Club Management System for production security.

Check and implement:
- Public signup disabled
- Login by login_id only
- Password hashing
- Login throttling
- Role middleware
- Active user middleware
- CSRF protection
- Form Request validation
- Output escaping in Blade
- File upload validation
- APP_DEBUG=false
- Protected .env file
- Secure route groups
- Member can only access own data
- Admin-only routes protected
- Soft delete where needed
- Activity logs for important actions

Give me specific code changes and checklist.
```

---

# 27. Responsive UI Prompt

```text
Make the Laravel Blade interface mobile responsive using Bootstrap.

Pages:
- Login page
- Admin dashboard
- Member list
- Member create/edit form
- Event list/form/calendar
- Payment list/form/report
- Member dashboard
- Member profile
- Payment receipt

Requirements:
- Responsive sidebar or top navigation.
- Tables should be responsive.
- Forms should be mobile-friendly.
- Cards should stack on small screens.
- Keep design simple and professional.

Give me updated Blade layout and example pages.
```

---

# 28. Error Handling Prompt

```text
Improve error handling for the Laravel General Club Management System.

Requirements:
- Use try-catch where needed.
- Use database transactions for multi-table operations.
- Show user-friendly error messages.
- Log technical errors.
- Do not show debug details in production.
- Handle validation errors properly.
- Handle duplicate Member ID, email, phone, and payment number.

Give me:
1. Updated service examples
2. Controller examples
3. User-friendly error message handling
4. Logging examples
```

---

# 29. Testing Prompt

```text
Create a complete testing checklist for the General Club Management System.

Test areas:
- Login by Member ID
- Admin login
- Invalid login
- Inactive user login block
- Member creation
- Duplicate Member ID prevention
- Member edit
- Member password reset
- Member dashboard access
- Admin route protection
- Event CRUD
- Event calendar
- Payment entry
- Payment report filters
- Receipt view
- Email notification
- SMS placeholder
- Activity log
- Mobile responsiveness

Give me:
1. Manual test cases in table format
2. Expected result for each case
3. Priority level
4. Production acceptance checklist
```

---

# 30. Deployment Prompt

```text
Prepare production deployment guide for Laravel General Club Management System on a self-hosted server.

Server options:
- VPS with Apache/Nginx
- cPanel hosting
- Local institutional server

Requirements:
- Upload project
- Configure .env
- Set database
- Run composer install
- Run migrations and seeders
- Set public folder as document root
- Set file permissions
- Set APP_DEBUG=false
- Configure mail
- Configure backup
- Enable HTTPS
- Test all modules after deployment

Give me:
1. Step-by-step deployment guide
2. Commands
3. cPanel notes
4. VPS notes
5. Common errors and fixes
```

---

# 31. Backup Prompt

```text
Create backup strategy for the Laravel + MySQL General Club Management System.

Requirements:
- Daily database backup
- Weekly full file backup
- Backup before major update
- Store backup outside public directory
- Document restore procedure
- Recommend cron job
- Include MySQL dump command

Give me:
1. Backup policy
2. Backup command examples
3. Restore command examples
4. Production checklist
```

---

# 32. Documentation Prompt

```text
Create developer documentation for the General Club Management System.

Include:
- Project overview
- Technology stack
- Installation steps
- Database setup
- Default Super Admin login
- User roles
- Main modules
- Folder structure
- Route summary
- Testing checklist
- Deployment notes
- Future scope

Write it as README.md.
```

---

# 33. Class Presentation Prompt

```text
Create a class presentation flow for demonstrating the General Club Management System.

Include:
1. Project title
2. Problem statement
3. Objective
4. Technology used
5. Why Laravel + MySQL
6. Why self-hosted backend
7. Requirement collection process
8. Member login by official Member ID
9. Database design
10. System modules
11. Codex development process
12. Live demo flow
13. Screenshots to capture
14. Limitations
15. Future scope

Keep it suitable for a term paper/project presentation.
```

---

# 34. Final Production Review Prompt

```text
Act as a senior Laravel production reviewer.

Review the General Club Management System and check:
- Architecture quality
- Security issues
- Database design
- Role-based access
- Member ID login
- Manual member creation
- Validation
- Error handling
- Activity logging
- Reports
- Deployment readiness
- Backup plan
- Production risks

Give me:
1. Problems found
2. Recommended fixes
3. Priority level
4. Production readiness score
5. Final checklist before launch
```

---

# 35. Suggested Build Sequence

Follow this order:

1. Project setup
2. Database migrations
3. Models and relationships
4. Seed roles and Super Admin
5. Custom login by login_id
6. Role middleware
7. Admin dashboard
8. Manual member creation
9. Member list/search/edit
10. Member password reset
11. Member dashboard
12. Event management
13. Event calendar
14. Payment management
15. Payment reports
16. Receipt view
17. Email notification
18. SMS placeholder
19. Activity log
20. Security hardening
21. Testing
22. Deployment
23. Backup
24. Documentation
25. Final review

---

# 36. Important Reminder for Codex

Always tell Codex:

```text
Do not enable public registration. Members are created only by admin authority and login using official Member ID.
```

This is the most important business rule of the application.
