# GCMS REST API

Base URL: `http://127.0.0.1:8000/api/v1`

All requests should send `Accept: application/json`. Protected endpoints also require `Authorization: Bearer YOUR_TOKEN`.

## Authentication

### Login

`POST /auth/login`

```json
{
  "login_id": "SA-001",
  "password": "your-password",
  "device_name": "Postman"
}
```

The response contains `access_token`, `token_type`, `must_change_password`, and the user. Accounts that are inactive or suspended cannot log in. A user whose `must_change_password` value is true can only use the auth endpoints until the password is changed.

- `GET /auth/me`
- `PUT /auth/password` with `current_password`, `password`, and `password_confirmation`
- `POST /auth/logout`
- `POST /auth/logout-all`

## Member Endpoints

These endpoints only expose the authenticated member's own records.

- `GET /member/profile`
- `GET /member/events?from_date=2026-06-01&per_page=15`
- `GET /member/payments?per_page=15`
- `GET /member/notifications?per_page=15`

## Admin Endpoints

- `GET /admin/dashboard`
- `GET|POST /admin/members`
- `GET|PUT|PATCH|DELETE /admin/members/{member}`
- `GET|POST /admin/events`
- `GET|PUT|PATCH|DELETE /admin/events/{event}`
- `GET|POST /admin/payments`
- `GET|PUT|PATCH|DELETE /admin/payments/{payment}`
- `GET|POST /admin/notifications`
- `GET /admin/notifications/{notification}`

List endpoints accept `per_page` up to 100. Members accept `search`, `status`, and `membership_type`; events accept `search` and `status`; payments accept `search`, `payment_status`, and `member_id`; notifications accept `channel` and `status`.

## Reports

- `GET /admin/reports/members`
- `GET /admin/reports/payments`
- `GET /admin/reports/due-payments`
- `GET /admin/reports/events`
- `GET /admin/reports/date-wise-collection`
- `GET /admin/reports/member-wise-payments`

Report filters include `member_id`, `event_id`, `status`, `payment_status`, `payment_method`, `membership_type`, `from_date`, and `to_date` where relevant.

## Status Codes

- `200`: success
- `201`: created
- `401`: missing or invalid token
- `403`: inactive account, wrong role, or temporary password must be changed
- `404`: record not found
- `422`: validation or login error
- `429`: too many requests

Validation failures use Laravel's standard JSON `message` and `errors` structure. Never place API tokens in URLs or source control.
