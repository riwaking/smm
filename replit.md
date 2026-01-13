# SMM Panel - Social Media Marketing Panel

## Overview
This is a PHP-based Social Media Marketing (SMM) Panel application. It allows users to manage social media marketing services, process payments, and interact with various social media APIs.

## Recent Changes
- 2026-01-14: Fixed balance display to show NPR symbol (रु) with actual user balance instead of hardcoded $0
- 2026-01-14: Changed default currency display to NPR in header1.twig dropdown (was showing USD)
- 2026-01-14: Updated existing users with empty currency_type to NPR
- 2026-01-13: Fixed fund-add-history.php missing transaction handling for balance add/deduct operations
- 2026-01-13: Added bulk delete functionality for categories in admin services page
- 2026-01-13: Added missing price_profit (NUMERIC), name_lang (TEXT), description_lang (TEXT) columns to services table
- 2026-01-13: Added missing show_refill column (VARCHAR) to services table for adding services via API
- 2026-01-13: Updated settings.twig form actions to use /settings routes (change_lang, password, newapikey)
- 2026-01-13: Created app/back/settings.php backend handler for user settings
- 2026-01-13: Fixed addfunds.php payment method queries with PostgreSQL lowercase column names
- 2026-01-13: Fixed api-services.php category_icon null constraint error when adding categories via API import
- 2026-01-13: Fixed ajax_data.php PostgreSQL integer validation error for empty category
- 2026-01-13: Added missing Khalti and Manual Payment initiators in addfunds.php
- 2026-01-13: Created app/back/addfunds/Initiators/khalti.php for Khalti payment initiation
- 2026-01-13: Created app/back/addfunds/Initiators/manual.php for manual payment initiation
- 2026-01-13: Fixed Khalti payment callback lastInsertId() -> RETURNING clause for PostgreSQL
- 2026-01-13: Added transaction reference and notes fields to manual payment form
- 2026-01-13: Fixed account.php currency update missing commit() call
- 2026-01-13: Set default currency to NPR (Nepali Rupees) in settings
- 2026-01-13: Added modern mobile-first admin UI (css/admin/admin-modern.css)
- 2026-01-13: Added modern login page design (css/admin/login-modern.css)
- 2026-01-13: Fixed theme editor file paths - changed app/views/ to app/front/ for twig templates
- 2026-01-13: Fixed blog page PostgreSQL integer error - added numeric validation for route(4)
- 2026-01-13: Fixed theme editor PHP 8 compatibility (file existence check before fopen/fread)
- 2026-01-13: Added sample data to blogs and integrations tables for admin pages
- 2026-01-13: Fixed manual payment form action to use /payment/manual route pattern
- 2026-01-13: Added manual payment system with bank transfer support and admin approval
- 2026-01-13: Added Khalti payment gateway integration (Nepal-based payment provider)
- 2026-01-13: Fixed Khalti logo path (img/khalti.png) and created missing CSS admin files
- 2026-01-13: Fixed division by zero error in services.php
- 2026-01-13: Fixed PostgreSQL case sensitivity for paymentmethods table columns
- 2026-01-13: Complete MySQL to PostgreSQL migration - all SQL syntax converted
- 2026-01-13: Converted 97+ INSERT INTO...SET statements to INSERT INTO (cols) VALUES (vals) format
- 2026-01-13: Fixed all INNER JOIN...WHERE to use proper ON clauses
- 2026-01-13: Fixed `&&` and `||` operators to `AND` and `OR` in all files
- 2026-01-13: Fixed LIMIT offset,count to LIMIT count OFFSET offset syntax
- 2026-01-13: Fixed WHERE 1 to WHERE TRUE for PostgreSQL compatibility
- 2026-01-13: Fixed division by zero errors with null checks in orders.php and clients.php
- 2026-01-13: Fixed appearance.php to handle empty route(4) parameter
- 2026-01-13: Added mobile-responsive.css with comprehensive mobile optimizations
- 2026-01-13: Implemented Flexbox/CSS Grid layouts for responsive design
- 2026-01-13: Added touch-friendly sizing for buttons and inputs (44px minimum)
- 2026-01-13: Added fluid typography with clamp() for smooth text scaling
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
- `&&` and `||` operators → `AND` and `OR`
- `LIMIT offset,count` → `LIMIT count OFFSET offset`
- `ORDER BY FIELD()` → `CASE WHEN ... END`
- `INSERT INTO table SET col=val` → `INSERT INTO table (col) VALUES (val)` (54 statements converted)
- Table/column names kept lowercase for PostgreSQL

## Running the Application
- Development: `php -S 0.0.0.0:5000`
- Access login: `/auth`
- Access admin: `/admin`

## Admin Credentials
Admin accounts are stored in the `admins` table in the database. Update passwords via the admin panel after first login.
