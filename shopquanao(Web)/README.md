# 🛍️ Laptop Shop - PHP E-Commerce Platform

A complete, fully functional laptop e-commerce website built with PHP and MySQL featuring shopping cart, user authentication, order management, and an admin panel.

## ✨ Features

### Customer Features
- **Product Browsing**: Homepage showcase and complete product catalog
- **Product Details**: Detailed specifications (processor, RAM, storage, screen size, brand)
- **Shopping Cart**: Add/remove/update quantities with session persistence
- **Checkout**: Complete order process with shipping details
- **User Authentication**: Registration and login system
- **Order Management**: View order history and detailed order information
- **User Profile**: Manage personal information and change password

### Admin Features
- **Dashboard**: View key statistics (products, orders, users, revenue)
- **Product Management**: 
  - View all products
  - Add new products with full specifications
  - Edit existing product details
  - Delete products
- **Order Management**:
  - View all orders with customer details
  - Update order status (pending → confirmed → shipped → delivered)
  - View detailed order information
- **User Management**:
  - View all registered users
  - Delete user accounts

## 🚀 Quick Start

### System Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx, or PHP built-in)

### Installation

1. **Create the database**:
```bash
mysql -u root -p < config/schema.sql
```

2. **Configure database connection** in `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
define('DB_NAME', 'laptop_shop');
```

3. **Start the server**:
```bash
php -S localhost:8000
```

4. **Access the website**:
- Visit `http://localhost:8000`
- Register a new account
- The first registered user becomes admin

## 📁 Project Structure

```
/
├── config/
│   ├── database.php       # Database connection
│   └── schema.sql         # Database schema & sample data
├── includes/
│   ├── functions.php      # Helper functions
│   ├── header.php         # Header template
│   └── footer.php         # Footer template
├── admin/                 # Admin panel
│   ├── index.php          # Dashboard
│   ├── products.php       # Product management
│   ├── orders.php         # Order management
│   ├── users.php          # User management
│   ├── order-detail.php   # Order details
│   ├── products/
│   │   ├── add.php        # Add product
│   │   └── edit.php       # Edit product
│   └── api/
│       ├── delete-product.php
│       ├── update-order-status.php
│       └── delete-user.php
├── api/                   # API endpoints
│   ├── add-to-cart.php
│   ├── update-cart.php
│   └── remove-from-cart.php
├── index.php              # Homepage
├── shop.php               # Product listing
├── product.php            # Product detail
├── cart.php               # Shopping cart
├── checkout.php           # Checkout
├── order-success.php      # Order confirmation
├── orders.php             # User orders
├── order-detail.php       # Order details
├── login.php              # Login
├── register.php           # Registration
├── profile.php            # User profile
├── change-password.php    # Change password
└── contact.php            # Contact page
```

## 👥 User Roles

### Regular Customer
- Can browse and purchase products
- Manage their shopping cart
- View their order history and details
- Update profile information

### Admin
- Access to `/admin/` panel
- Full control over products (CRUD)
- Full control over orders (view & update status)
- Full control over users (view & delete)
- Dashboard with business statistics

**First user registered automatically becomes admin. To make another user admin, update the database:**
```sql
UPDATE users SET id = 1 WHERE email = 'admin_email@example.com';
```

## 🔐 Security

- **Password Security**: Uses PHP's `password_hash()` and `password_verify()`
- **Input Sanitization**: All inputs sanitized with `htmlspecialchars()` and `strip_tags()`
- **Email Validation**: Ensures valid email format
- **Session Authentication**: Session-based user authentication
- **Protected Routes**: Admin functions require authentication

## 📦 Database Schema

### Users Table
- id, email (unique), password (hashed), full_name, phone, address, city, created_at

### Products Table
- id, name, description, price, stock, brand, processor, ram, storage, screen_size, image_url, created_at, updated_at

### Orders Table
- id, user_id, total_amount, shipping_address, shipping_city, status, created_at

### Order Items Table
- id, order_id, product_id, quantity, price

## 🛒 Shopping Cart

The shopping cart uses PHP sessions to persist data:
- Add items with quantity
- Update quantities in real-time
- Remove individual items
- Clear entire cart after checkout
- No database storage needed (session-based)

## 💳 Checkout Process

1. **Add items to cart** → `/api/add-to-cart.php`
2. **View cart** → `/cart.php`
3. **Proceed to checkout** → Must be logged in
4. **Enter shipping details** → `/checkout.php`
5. **Confirm order** → Creates order in database
6. **View confirmation** → `/order-success.php`

## 📊 Admin Dashboard Features

- **Statistics**: Total products, orders, users, and revenue
- **Product Management**: Full CRUD operations
- **Order Management**: Status tracking and updates
- **User Management**: View and manage users
- **Order Details**: View detailed information for each order

## 🎨 Styling

All pages use inline CSS with a clean, professional design:
- Responsive grid layouts
- Color-coded status badges
- Consistent header/footer across all pages
- Mobile-friendly tables and forms

## 🔄 Order Status Flow

```
Pending → Confirmed → Shipped → Delivered
```

Admin can update status at `/admin/orders.php`

## 📧 Customer Features

- View order history at `/orders.php`
- View detailed order information at `/order-detail.php?id=X`
- Manage profile at `/profile.php`
- Change password at `/change-password.php`
- Contact form at `/contact.php`

## 🚀 Deployment

For production deployment:

1. **Database**: Use remote MySQL database
2. **Configuration**: Update `config/database.php` with production credentials
3. **Security**: 
   - Change default credentials
   - Use HTTPS
   - Add firewall rules
4. **Backups**: Set up regular database backups
5. **Email**: Integrate SMTP for order notifications

## 🐛 Troubleshooting

**Database Connection Error**
- Check credentials in `config/database.php`
- Ensure MySQL server is running
- Verify database and tables exist

**Session Issues**
- Check PHP session configuration
- Ensure `session_start()` is called
- Verify session directory is writable

**Admin Access Denied**
- Verify user ID is set correctly
- Check `$_SESSION['is_admin']` is set
- Clear browser cookies and re-login

## 📝 Sample Data

Database includes 6 sample laptop products with realistic specifications ready for testing.

## 🎯 Sample Workflow

1. Visit homepage: `http://localhost:8000`
2. Click "Sản phẩm" to view all products
3. Click product to see details
4. Add to cart
5. Click cart icon or go to `/cart.php`
6. Proceed to checkout
7. Register/Login
8. Complete order
9. View order in user dashboard

**Admin Testing:**
1. Login with first registered user account
2. Visit `/admin/`
3. Add/edit/delete products
4. View and update order statuses
5. Manage users

## 📄 License

Free to use and modify for personal and commercial projects.

## 🤝 Support

For issues or customization needs:
1. Check the SETUP.md guide
2. Review database schema in `config/schema.sql`
3. Modify functions in `includes/functions.php` as needed
4. Update table relationships in the database as required

---

**Built with PHP + MySQL | E-Commerce Solution**
