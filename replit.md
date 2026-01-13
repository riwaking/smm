# SMM Panel - Social Media Marketing Panel

## Overview
This is a PHP-based Social Media Marketing (SMM) Panel application. It allows users to manage social media marketing services, process payments, and interact with various social media APIs.

## Recent Changes
- 2026-01-13: Added mobile-responsive.css with comprehensive mobile optimizations
- 2026-01-13: Implemented Flexbox/CSS Grid layouts for responsive design
- 2026-01-13: Added touch-friendly sizing for buttons and inputs (44px minimum)
- 2026-01-13: Added fluid typography with clamp() for smooth text scaling
- 2026-01-13: Converted from MySQL to PostgreSQL for Replit compatibility
- 2026-01-13: Updated database configuration to use environment variables
- 2026-01-13: Fixed MySQL-specific SQL syntax (`&&` → `AND`) for PostgreSQL in app/ and myadmin/ directories
- 2026-01-13: Fixed substr trimming for dynamic WHERE clauses (-5 for AND, -4 for OR)
- 2026-01-13: Created 404.twig template to fix missing template errors
- 2026-01-13: Removed malicious Telegram credential exfiltration code from admin login
- 2026-01-13: Configured PHP development server on port 5000
- 2026-01-13: Suppressed PHP 8 compatibility warnings (app written for PHP 7.4)

## Project Architecture

### Key Files
- `index.php` - Main entry point and router
- `app/cn.php` - Database connection configuration
- `app/it.php` - Core initialization and session management
- `app/back/` - Backend PHP scripts for various features
- `app/helper/` - Helper functions and utilities
- `app/front/modified/` - Twig templates for frontend views
- `css/mobile-responsive.css` - Mobile-responsive CSS with Flexbox/Grid

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
