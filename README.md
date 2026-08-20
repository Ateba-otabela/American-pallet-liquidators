# American Pallet Liquidators

A Laravel-based e-commerce platform for wholesale liquidation pallets and retail store truckloads.

## Features

- **Product Catalog**: Browse and search wholesale liquidation pallets by category
- **Shopping Cart**: Add items to cart and manage quantities
- **Multi-Step Checkout**: 
  - Step 1: Shipping/receiver information
  - Step 2: Multiple payment methods (Stripe, Bank Wire, Zelle, Cash App, Venmo, PayPal, USDT, Cash on Pickup)
- **User Authentication**: 
  - Email/password registration and login
  - Google OAuth integration
  - Guest checkout option
- **User Dashboard**: 
  - View order history
  - Submit payment proof for offline payments
  - Manage profile
- **Admin Panel**:
  - Product management (create, edit, delete with image uploads)
  - Category management
  - Order management with status updates
  - Payment settings configuration
  - User and subscriber management
  - Visitor analytics and logs
- **Email Notifications**:
  - Order confirmation emails
  - Payment submission notifications
  - New product announcements to subscribers
- **Real-time Chat**: Customer support chat system with file attachments
- **Freight Quote System**: Request shipping quotes for orders
- **Newsletter Subscription**: Email subscription for product updates

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Templates with Alpine.js
- **Styling**: TailwindCSS
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Payment Processing**: Stripe, PayPal
- **Authentication**: Laravel Breeze with Google OAuth

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd American-pallet-liquidators
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure environment variables in `.env`:
- Database connection settings
- Mail configuration
- Stripe API keys
- PayPal API credentials
- Google OAuth credentials

6. Run database migrations:
```bash
php artisan migrate
```

7. Link storage for file uploads:
```bash
php artisan storage:link
```

8. Build frontend assets:
```bash
npm run build
```

9. Start development server:
```bash
php artisan serve
```

## Environment Variables

Key environment variables to configure:

```env
APP_NAME="American Pallet Liquidators"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=american_pallet_liquidators
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="sales@americanpalletliquidators.shop"
MAIL_FROM_NAME="${APP_NAME}"

STRIPE_SECRET_KEY=your_stripe_secret_key
STRIPE_PUBLISHABLE_KEY=your_stripe_publishable_key

PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_MODE=sandbox

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT="${APP_URL}/auth/google/callback"
```

## Admin Access

Create an admin user by running:
```bash
php artisan tinker
```
Then in the tinker console:
```php
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'is_admin' => true
]);
```

## Testing

Run the test suite:
```bash
php artisan test
```

## Project Structure

- `app/Http/Controllers/` - Application controllers (Checkout, Admin, etc.)
- `app/Models/` - Eloquent models (Product, Order, User, etc.)
- `app/Mail/` - Email notification classes
- `database/migrations/` - Database schema migrations
- `resources/views/` - Blade templates
- `routes/` - Application routes
- `public/` - Public assets and entry point

## Payment Methods Supported

1. **Stripe** - Credit/Debit card processing
2. **Bank Wire Transfer** - Direct bank transfer
3. **Zelle** - Business Zelle payments
4. **Cash App** - Cash App payments
5. **Venmo** - Venmo transfers
6. **PayPal** - PayPal payments
7. **USDT** - Cryptocurrency (TRC-20 / ERC-20)
8. **Cash on Pickup** - Pay at warehouse

## License

This project is proprietary software. All rights reserved.
