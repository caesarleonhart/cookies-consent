# Cookies Consent Demo (PHP + MySQL)

A 4-page PHP website with a privacy consent banner, MySQL logging, and a secure admin portal to view consent acceptances.

## Features
- Privacy consent modal on first visit
- Floating "Manage Cookie Consent" button (bottom-right)
- Accept/Decline with automatic opposite cookie cleanup
- Reset choice option to clear cookies and re-prompt
- Admin dashboard with GMT+8 timezone display

## Requirements
- PHP 8.0+
- MySQL 5.7+
- Web server (Apache/Nginx) or PHP built-in server

## Project Structure
- `/index.php` Home
- `/about.php` About/Contact
- `/privacy.php` Privacy Policy
- `/terms.php` Terms & Conditions
- `/assets/consent.js` Consent modal + cookie logic + floating button
- `/assets/style.css` Responsive styles with sticky footer
- `/consent_api.php` Records consent acceptance (AJAX)
- `/admin/login.php` Admin login
- `/admin/dashboard.php` Admin dashboard listing consent entries
- `/admin/logout.php` Logout
- `/config.php` PDO DB connection

## Database Setup
Create a database (default name: `cookies_consent_db`) and run the schema below.

```sql
CREATE TABLE IF NOT EXISTS consent_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guid CHAR(36) NOT NULL,
    consent_time DATETIME NOT NULL,
    version INT NOT NULL
);

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
```

Seed a default admin user (username: `admin`, password: `admin123`):

```php
<?php
// Run this once from a temporary file or interactive shell
$pdo = new PDO('mysql:host=127.0.0.1;dbname=cookies_consent_db;charset=utf8mb4','root','', [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
]);
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)')->execute(['admin', $hash]);
```

## Configuring Database Connection
Edit `/config.php` or set environment variables:
- `DB_HOST` (default `127.0.0.1`)
- `DB_NAME` (default `cookies_consent_db`)
- `DB_USER` (default `root`)
- `DB_PASS` (default empty)

## Running Locally
Using PHP built-in server from the repo root:

```bash
php -S 127.0.0.1:8000
```
Open `http://127.0.0.1:8000`.

## Consent Behavior
- First visit: modal blocks scroll until user accepts or declines.
- Accept: creates `site_consent` cookie with GUID, timestamp, version, 1-year expiry; record saved in DB.
- Decline: creates `site_decline` cookie with decline timestamp, 1-day expiry.
- Banner reappears when cookies are missing/expired.
- Floating "Manage Cookie Consent" button always visible (bottom-right).
- Reset Choice: clears both cookies and re-opens modal.

## Default Admin Credentials
- Username: `admin`
- Password: `admin123`

## Cookie Details
- `site_consent`: Stores consent data (GUID, timestamp, version) for 1 year
- `site_decline`: Stores decline timestamp for 1 day