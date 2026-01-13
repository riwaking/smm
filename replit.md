# SMM Panel - Social Media Marketing Panel

## Overview
This is a PHP-based Social Media Marketing (SMM) Panel application. It allows users to manage social media marketing services, process payments, and interact with various social media APIs.

## Recent Changes
- 2026-01-13: Converted from MySQL to PostgreSQL for Replit compatibility
- 2026-01-13: Updated database configuration to use environment variables
- 2026-01-13: Fixed MySQL-specific SQL syntax (`&&` → `AND`) for PostgreSQL
- 2026-01-13: Configured PHP development server on port 5000
- 2026-01-13: Suppressed PHP 8 compatibility warnings (app written for PHP 7.4)

## Project Architecture

### Key Files
- `index.php` - Main entry point and router
- `app/cn.php` - Database connection configuration
- `app/it.php` - Core initialization and session management
- `app/back/` - Backend PHP scripts for various features
- `app/helper/` - Helper functions and utilities
- `templates/` - Twig templates for frontend views

### Database
- Uses PostgreSQL (converted from MySQL)
- Connection via `DATABASE_URL` environment variable
- 40+ tables for users, services, orders, payments, etc.

### Features
- User authentication (login/register)
- Admin panel at `/admin`
- Payment gateway integrations (Stripe, PayPal, etc.)
- Service management
- Multi-language support

## Technical Notes

### PHP Compatibility
The application was written for PHP 7.4. Running on PHP 8.x produces warnings due to:
- Undefined array key access without null checks
- Deprecated automatic conversion of false to array
- These are suppressed in production but don't affect core functionality

### Database Migration Notes
The original MySQL schema was converted to PostgreSQL with these changes:
- ENUM types → VARCHAR with CHECK constraints
- AUTO_INCREMENT → SERIAL
- `NOW()` → `CURRENT_TIMESTAMP`
- `&&` operator → `AND`
- Table/column names kept lowercase for PostgreSQL

## Running the Application
- Development: `php -S 0.0.0.0:5000`
- Access login: `/auth`
- Access admin: `/admin`

## Default Admin Credentials
Check the `admin` table in the database for admin accounts.
