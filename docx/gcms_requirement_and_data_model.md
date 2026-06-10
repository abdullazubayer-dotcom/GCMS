# Requirement Document and Data Model
## Project: Web-Based General Club Management System
## Technology Stack: Laravel + MySQL
## Backend: Self-Hosted

---

# 1. Project Overview

The Web-Based General Club Management System is a self-hosted web application designed to manage club operations in a structured and efficient way. The system will support online member registration, member approval, event management, payment tracking, reporting, SMS/email notification, and an admin dashboard.

The system will be developed using Laravel as the backend framework and MySQL as the database. It will be accessible through web browsers and designed with a mobile-responsive interface.

---

# 2. Background

Many clubs manage members, events, payments, and announcements manually through paper records, spreadsheets, phone calls, or social media groups. This often creates problems such as duplicate records, missing payment information, poor communication, delayed approval of members, and difficulty generating reports.

A web-based system can solve these problems by centralizing all major club activities in one platform. The proposed system will help club administrators manage records easily and allow members to access important information online.

---

# 3. Problem Statement

The current manual club management process may create several difficulties:

- Member information is not stored in a centralized database.
- New member registration and approval may take time.
- Event information may not be properly communicated to all members.
- Payment records may be difficult to track.
- Manual reports may contain errors.
- Club authority may not have a real-time dashboard.
- Members may not have easy mobile access to club information.

Therefore, a web-based General Club Management System is needed to improve efficiency, accuracy, communication, and record management.

---

# 4. Project Objectives

The main objective of this project is to develop a self-hosted web-based system for managing club activities.

Specific objectives are:

1. To develop an online member registration system.
2. To provide admin approval for new membership applications.
3. To maintain member profiles in a centralized database.
4. To manage club events through an event management module.
5. To display events through a calendar-based interface.
6. To record and manage member payments.
7. To generate payment and member reports.
8. To provide SMS/email notification support.
9. To create an admin dashboard for monitoring club activities.
10. To make the system accessible from desktop and mobile devices.

---

# 5. Scope of the System

The scope of the system includes:

- Online registration for new members
- Admin approval and rejection of members
- Member profile management
- Event creation, update, and deletion
- Event calendar view
- Payment entry and tracking
- Payment reports
- Email notification
- SMS notification placeholder or future integration
- Admin dashboard
- Mobile-responsive interface
- Self-hosted Laravel backend with MySQL database

The system will not initially include full online payment gateway integration. This may be added as a future improvement.

---

# 6. Stakeholders

The main stakeholders of the system are:

1. Club Authority
2. System Administrator
3. Club Admin
4. Registered Members
5. New Applicants
6. Event Coordinators
7. Finance or Accounts Personnel

---

# 7. User Roles

## 7.1 Guest User

A guest user is a visitor who has not logged into the system.

Guest user can:

- View basic club information
- View public event information
- Submit online membership registration form

## 7.2 Member

A member is an approved user of the club.

Member can:

- Log in to the system
- View personal profile
- Update limited profile information
- View event calendar
- View payment history
- Receive notifications

## 7.3 Club Admin

Club admin is responsible for managing daily club operations.

Club admin can:

- Log in to admin panel
- View dashboard
- Review member applications
- Approve or reject members
- Manage events
- Add payment records
- Generate reports
- Send notifications

## 7.4 Super Admin

Super admin has full control over the system.

Super admin can:

- Manage admin users
- Manage all members
- Manage events
- Manage payments
- Manage reports
- Manage system settings
- Control user roles and permissions

---

# 8. Functional Requirements

## 8.1 Authentication Module

The system shall provide secure login and logout functionality.

Requirements:

- Users shall log in using email and password.
- Passwords shall be stored in encrypted format.
- Users shall be redirected based on their role.
- Admin users shall access the admin dashboard.
- Members shall access the member dashboard.
- Unauthorized users shall not access restricted pages.

---

## 8.2 Online Member Registration Module

The system shall allow new users to register online.

Requirements:

- The registration form shall collect member information.
- The applicant shall provide name, email, phone, address, profession, and membership type.
- New registration shall be saved with pending status.
- Admin approval shall be required before full member access.
- Duplicate email registration shall not be allowed.

---

## 8.3 Member Approval Module

The system shall allow admin to approve or reject new member applications.

Requirements:

- Admin shall view pending applications.
- Admin shall approve member applications.
- Admin shall reject member applications.
- Approved members shall receive active status.
- Rejected members shall remain inactive or rejected.
- The system may send email notification after approval or rejection.

---

## 8.4 Member Management Module

The system shall maintain member information.

Requirements:

- Admin shall view member list.
- Admin shall search and filter members.
- Admin shall update member information.
- Admin shall deactivate members if required.
- Members shall view their own profile.
- Members may update limited profile information.

---

## 8.5 Event Management Module

The system shall allow admin to manage club events.

Requirements:

- Admin shall create new events.
- Admin shall update event details.
- Admin shall delete or deactivate events.
- Events shall include title, date, time, venue, and description.
- Members shall view upcoming events.
- Events shall be shown in calendar format.

---

## 8.6 Payment Management Module

The system shall allow admin to manage member payments.

Requirements:

- Admin shall add payment records.
- Payment records shall be linked with members.
- Payment type shall be recorded.
- Payment amount and payment date shall be recorded.
- Payment status shall be marked as paid, unpaid, or due.
- Admin shall view member-wise payment history.

---

## 8.7 Report Module

The system shall generate useful reports.

Requirements:

- Member report
- Payment report
- Event report
- Due payment report
- Date-wise payment report
- Member-wise payment report

Reports shall be filterable by date, member, payment type, and payment status.

---

## 8.8 Notification Module

The system shall support communication with members.

Requirements:

- The system shall send registration confirmation email.
- The system shall send approval notification email.
- Admin shall send event announcements.
- Admin shall send payment reminders.
- SMS gateway integration may be included as a future scope.
- Notification records shall be stored in the database.

---

## 8.9 Admin Dashboard Module

The system shall provide a dashboard for quick overview.

Dashboard shall show:

- Total members
- Pending members
- Approved members
- Rejected members
- Total events
- Upcoming events
- Total payment collection
- Due payments
- Recent registrations

---

## 8.10 Mobile Access

The system shall be responsive and accessible from mobile devices.

Requirements:

- Layout shall support desktop, tablet, and mobile view.
- Forms shall be mobile-friendly.
- Tables shall be responsive.
- Dashboard cards shall be readable on small screens.

---

# 9. Non-Functional Requirements

## 9.1 Security

- Passwords shall be encrypted.
- Role-based access shall be implemented.
- Input validation shall be applied.
- Unauthorized access shall be restricted.
- CSRF protection shall be enabled.

## 9.2 Usability

- Interface shall be simple and user-friendly.
- Navigation shall be clear.
- Forms shall include validation messages.
- Admin dashboard shall be easy to understand.

## 9.3 Performance

- Pages shall load within a reasonable time.
- Database queries shall be optimized.
- Pagination shall be used for large lists.

## 9.4 Reliability

- System shall store data accurately.
- System shall reduce duplicate data.
- Backup facility may be maintained by server administrator.

## 9.5 Maintainability

- Laravel MVC structure shall be followed.
- Code shall be organized by modules.
- Database migrations shall be used.
- Reusable Blade layouts shall be used.

## 9.6 Compatibility

- System shall run on modern web browsers.
- System shall support mobile and desktop devices.
- System shall run on Apache/Nginx server with PHP and MySQL.

---

# 10. Assumptions

The following assumptions are made:

1. The club authority has permitted the development of the system.
2. The club does not currently have a formal written requirement document.
3. Requirements are prepared based on discussion, observation, and practical needs.
4. The first version will focus on core features.
5. SMS gateway and online payment gateway may be added later.
6. The backend will be self-hosted.
7. Laravel and MySQL will be used for system development.

---

# 11. Limitations

The initial version may have the following limitations:

1. No full online payment gateway integration.
2. SMS gateway may remain as future scope.
3. Advanced role permission system may be limited.
4. Mobile app will not be developed initially.
5. Reports may initially be generated in web format only.
6. PDF export may be added later.

---

# 12. Future Scope

Future improvements may include:

1. Online payment gateway integration.
2. SMS gateway integration.
3. PDF report export.
4. Member ID card generation.
5. Event attendance tracking.
6. Mobile app development.
7. Advanced role and permission management.
8. Backup and restore system.
9. Financial analytics dashboard.
10. QR code-based member verification.

---

# 13. Data Model Overview

The system will use a relational database model. MySQL will store user, member, event, payment, and notification information.

Main database entities:

1. Users
2. Members
3. Events
4. Payments
5. Notifications
6. Roles
7. Event Registrations

---

# 14. Entity Relationship Summary

## Main Relationships

- One user may have one member profile.
- One member may have many payments.
- One event may have many event registrations.
- One member may register for many events.
- One user may receive many notifications.
- One role may be assigned to many users.

---

# 15. Database Tables

---

## 15.1 roles table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Role ID |
| name | varchar(100) | Not Null | Role name |
| description | text | Nullable | Role description |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

Example role values:

- super_admin
- admin
- member

---

## 15.2 users table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | User ID |
| role_id | bigint | Foreign Key | Role ID |
| name | varchar(150) | Not Null | User full name |
| email | varchar(150) | Unique | Login email |
| password | varchar(255) | Not Null | Encrypted password |
| phone | varchar(30) | Nullable | Phone number |
| status | enum | active/inactive/pending | User status |
| email_verified_at | timestamp | Nullable | Email verification time |
| remember_token | varchar(100) | Nullable | Login remember token |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

## 15.3 members table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Member ID |
| user_id | bigint | Foreign Key | User ID |
| member_code | varchar(50) | Unique | Member identification code |
| date_of_birth | date | Nullable | Date of birth |
| gender | varchar(20) | Nullable | Gender |
| address | text | Nullable | Present address |
| profession | varchar(150) | Nullable | Profession |
| organization | varchar(150) | Nullable | Workplace or institution |
| membership_type | varchar(100) | Not Null | Membership type |
| joining_date | date | Nullable | Joining date |
| status | enum | pending/approved/rejected/inactive | Member status |
| photo | varchar(255) | Nullable | Profile photo path |
| remarks | text | Nullable | Admin remarks |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

## 15.4 events table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Event ID |
| title | varchar(200) | Not Null | Event title |
| event_date | date | Not Null | Event date |
| event_time | time | Nullable | Event time |
| venue | varchar(200) | Nullable | Event venue |
| description | text | Nullable | Event details |
| event_fee | decimal(10,2) | Default 0.00 | Event fee |
| status | enum | active/inactive/completed/cancelled | Event status |
| created_by | bigint | Foreign Key | Admin user ID |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

## 15.5 event_registrations table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Event registration ID |
| event_id | bigint | Foreign Key | Event ID |
| member_id | bigint | Foreign Key | Member ID |
| registration_date | date | Not Null | Registration date |
| attendance_status | enum | registered/attended/absent | Attendance status |
| payment_status | enum | paid/unpaid/not_required | Event payment status |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

## 15.6 payments table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Payment ID |
| member_id | bigint | Foreign Key | Member ID |
| event_id | bigint | Nullable Foreign Key | Related event ID |
| payment_type | varchar(100) | Not Null | Membership fee/event fee/donation |
| amount | decimal(10,2) | Not Null | Payment amount |
| payment_date | date | Not Null | Payment date |
| payment_method | varchar(100) | Nullable | Cash/bank/mobile banking |
| transaction_reference | varchar(150) | Nullable | Transaction reference |
| payment_status | enum | paid/unpaid/due/cancelled | Payment status |
| remarks | text | Nullable | Payment remarks |
| received_by | bigint | Foreign Key | Admin user ID |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

## 15.7 notifications table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Notification ID |
| user_id | bigint | Foreign Key | Receiver user ID |
| title | varchar(200) | Not Null | Notification title |
| message | text | Not Null | Notification message |
| type | enum | email/sms/system | Notification type |
| status | enum | pending/sent/failed/read | Notification status |
| sent_at | timestamp | Nullable | Sent time |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

## 15.8 activity_logs table

| Field | Type | Constraint | Description |
|---|---|---|---|
| id | bigint | Primary Key | Log ID |
| user_id | bigint | Foreign Key | User who performed action |
| action | varchar(200) | Not Null | Action name |
| description | text | Nullable | Action details |
| ip_address | varchar(50) | Nullable | User IP address |
| created_at | timestamp | Nullable | Created time |
| updated_at | timestamp | Nullable | Updated time |

---

# 16. Suggested Laravel Models

Recommended models:

1. User
2. Role
3. Member
4. Event
5. EventRegistration
6. Payment
7. Notification
8. ActivityLog

---

# 17. Suggested Laravel Relationships

## User Model

- User belongsTo Role
- User hasOne Member
- User hasMany Notifications
- User hasMany ActivityLogs

## Role Model

- Role hasMany Users

## Member Model

- Member belongsTo User
- Member hasMany Payments
- Member hasMany EventRegistrations

## Event Model

- Event belongsTo User as createdBy
- Event hasMany EventRegistrations
- Event hasMany Payments

## Payment Model

- Payment belongsTo Member
- Payment belongsTo Event
- Payment belongsTo User as receivedBy

## Notification Model

- Notification belongsTo User

## ActivityLog Model

- ActivityLog belongsTo User

---

# 18. Sample Laravel Migration Commands

```bash
php artisan make:model Role -m
php artisan make:model Member -m
php artisan make:model Event -m
php artisan make:model EventRegistration -m
php artisan make:model Payment -m
php artisan make:model Notification -m
php artisan make:model ActivityLog -m
```

---

# 19. Minimum Viable Product Data Model

If time is limited, use only these tables first:

1. users
2. members
3. events
4. payments
5. notifications

Optional tables for later:

1. roles
2. event_registrations
3. activity_logs

---

# 20. Requirement Collection Note for Term Paper

As the club authority does not have a formal written requirement document, the system requirements are prepared based on discussion with the authority, observation of general club management activities, and practical assumptions. The proposed requirements may be refined during development based on user feedback and testing.

---

# 21. Final Recommendation

For the first working version, complete the following features:

1. Admin login
2. Member online registration
3. Member approval
4. Admin dashboard
5. Event management
6. Payment management
7. Payment report
8. Email notification
9. Mobile responsive interface

After completing these features, SMS notification, online payment, PDF export, and advanced analytics can be added as future improvements.
