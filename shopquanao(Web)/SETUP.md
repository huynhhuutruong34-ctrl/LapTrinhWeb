# Laptop Shop - PHP E-Commerce Setup Guide

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web Server (Apache, Nginx, or PHP Built-in Server)

## Installation Steps

### 1. Database Setup

1. Create a new MySQL database:
```bash
mysql -u root -p < config/schema.sql
```

Or manually:
- Open MySQL and create a database named `laptop_shop`
- Import the SQL schema from `config/schema.sql`

### 2. Configuration

Edit `config/database.php` and update the database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
define('DB_NAME', 'laptop_shop');
```

### 3. Running the Application

**Option A: Using PHP Built-in Server**
```bash
php -S localhost:8000
```

Then visit: `http://localhost:8000`

**Option B: Using Apache/Nginx**
- Copy all files to your web root (e.g., `/var/www/html/laptop-shop/`)
- Configure your virtual host to point to the project directory
- Visit: `http://laptop-shop.local` (or your configured domain)

## Default Admin Account

The system automatically creates an admin account with ID = 1. To create the first admin user:

1. Register a new account at `/register.php`
2. Set `is_admin = 1` in the database for that user:
```sql
UPDATE users SET id = 1 WHERE email = 'your_admin_email@example.com';
```

Or simply make your first registered user an admin by modifying the database directly.

## Project Structure

```
/
├── config/
│   ├── database.php       # Database configuration
│   └── schema.sql         # Database schema
├── includes/
│   ├── functions.php      # Helper functions
│   ├── header.php         # Header template
│   └── footer.php         # Footer template
├── admin/
│   ├── index.php          # Admin dashboard
│   ├── products.php       # Product management
│   ├── orders.php         # Order management
│   ├── users.php          # User management
│   ├── order-detail.php   # Order details
│   ├── products/
│   │   ├── add.php        # Add product
│   │   └── edit.php       # Edit product
│   └── api/
│       ├── delete-product.php       # Delete product endpoint
│       ├── update-order-status.php  # Update order status
│       └── delete-user.php          # Delete user endpoint
├── api/
│   ├── add-to-cart.php    # Add item to cart
│   ├── update-cart.php    # Update cart item
│   └── remove-from-cart.php# Remove item from cart
├── index.php              # Homepage
├── shop.php               # Product listing
├── product.php            # Product detail
├── cart.php               # Shopping cart
├── checkout.php           # Checkout page
├── order-success.php      # Order confirmation
├── orders.php             # User orders
├── order-detail.php       # Order detail page
├── login.php              # Login page
├── register.php           # Registration page
├── logout.php             # Logout handler
├── profile.php            # User profile
└── change-password.php    # Change password page
```

## Features

### Customer Features
- ✅ Browse products
- ✅ View product details
- ✅ Add products to cart
- ✅ Manage shopping cart (add, update, remove)
- ✅ Checkout process
- ✅ User registration and login
- ✅ View order history
- ✅ View order details
- ✅ User profile management
- ✅ Change password

### Admin Features
- ✅ Dashboard with statistics
- ✅ Product management (add, edit, delete)
- ✅ Order management and status updates
- ✅ User management
- ✅ View order details
- ✅ Track revenue

## Database Tables

### users
- id (INT, PRIMARY KEY)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashed)
- full_name (VARCHAR)
- phone (VARCHAR)
- address (TEXT)
- city (VARCHAR)
- created_at (TIMESTAMP)

### products
- id (INT, PRIMARY KEY)
- name (VARCHAR)
- description (TEXT)
- price (DECIMAL)
- stock (INT)
- brand (VARCHAR)
- processor (VARCHAR)
- ram (VARCHAR)
- storage (VARCHAR)
- screen_size (VARCHAR)
- image_url (VARCHAR)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### orders
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- total_amount (DECIMAL)
- shipping_address (TEXT)
- shipping_city (VARCHAR)
- status (VARCHAR: pending, confirmed, shipped, delivered)
- created_at (TIMESTAMP)

### order_items
- id (INT, PRIMARY KEY)
- order_id (INT, FOREIGN KEY)
- product_id (INT, FOREIGN KEY)
- quantity (INT)
- price (DECIMAL)

## Usage

### Customer Workflow
1. Visit homepage `/index.php`
2. Browse products at `/shop.php`
3. View product details at `/product.php?id=1`
4. Add products to cart
5. Proceed to checkout at `/cart.php`
6. Register/Login for checkout
7. Complete order at `/checkout.php`
8. View orders at `/orders.php`

### Admin Workflow
1. Login with admin account
2. Access admin panel at `/admin/`
3. Manage products at `/admin/products.php`
4. Manage orders at `/admin/orders.php`
5. Manage users at `/admin/users.php`

## Security Notes

- Passwords are hashed using PHP's `password_hash()` function
- All user input is sanitized using `htmlspecialchars()` and `strip_tags()`
- Email validation is performed on registration
- Admin functions require authentication via `requireAdmin()` function
- Session-based authentication is used

## Customization

### Adding New Products
Admin can add products through `/admin/products/add.php` with details like:
- Product name
- Description
- Price
- Stock quantity
- Brand, Processor, RAM, Storage, Screen Size

### Changing Currency
Edit the `formatPrice()` function in `includes/functions.php` to change the currency symbol.

### Email Notifications
To add email notifications on orders, integrate an SMTP service and modify the checkout process.

## Troubleshooting

### Database Connection Error
- Check database credentials in `config/database.php`
- Ensure MySQL server is running
- Verify database name matches in schema

### Session Errors
- Ensure `session_start()` is called at the beginning of scripts
- Check PHP session configuration

### Admin Access Denied
- Verify user ID = 1 in the database
- Check `$_SESSION['is_admin']` is set correctly

## Support

For issues or feature requests, refer to the database schema and update the necessary tables as needed.
