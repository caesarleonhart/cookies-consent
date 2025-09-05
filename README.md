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
Please make sure that the main folder is named `cookies-consent`
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

### Step 1: Create Database
1. Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
2. Click "New" to create a new database
3. Name it `cookies_consent_db`
4. Click "Create"

### Step 2: Import Setup File
1. Select the `cookies_consent_db` database
2. Click the "Import" tab
3. Click "Choose File" and select `database_setup.sql`
4. Click "Go" to import

This will automatically create all necessary tables and seed a default admin user (username: `admin`, password: `admin123`).

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

## Troubleshooting

### Can't login to admin panel?
- Make sure you imported the `database_setup.sql` file correctly
- Check that the database name is exactly `cookies_consent_db`
- Verify your database credentials in `config.php` match your MySQL setup

### Assets not loading (CSS/JS broken)?
- Make sure you're running the site from the correct URL (e.g., `http://localhost/cookies-consent/`)
- Check that all files are in the correct directory structure

### Database connection errors?
- Ensure MySQL is running
- Check the database credentials in `config.php`
- Make sure the database `cookies_consent_db` exists
