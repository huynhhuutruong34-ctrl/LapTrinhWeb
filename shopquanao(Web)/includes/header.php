<?php
$cartItems = getCart();
$cartCount = array_sum($cartItems);
$user = getCurrentUser($pdo);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Laptop Shop'; ?></title>
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #3498db;
        }

        .nav-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .cart-icon {
            position: relative;
            font-size: 1.5rem;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-menu-toggle {
            cursor: pointer;
            padding: 0.5rem 1rem;
            border: 1px solid white;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .user-menu-toggle:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .user-menu-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            color: #333;
            min-width: 200px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 0.5rem;
            z-index: 101;
        }

        .user-menu-dropdown.active {
            display: block;
        }

        .user-menu-dropdown a {
            display: block;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
            border-bottom: 1px solid #eee;
        }

        .user-menu-dropdown a:last-child {
            border-bottom: none;
        }

        .user-menu-dropdown a:hover {
            background-color: #f0f0f0;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/" class="logo">🛍️ Laptop Shop</a>
            <nav>
                <a href="/">Trang chủ</a>
                <a href="/shop.php">Sản phẩm</a>
                <?php if (isAdmin()): ?>
                    <a href="/admin/">Quản lý</a>
                <?php endif; ?>
            </nav>
            <div class="nav-right">
                <a href="/cart.php" class="cart-icon">
                    🛒
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-count"><?php echo $cartCount; ?></span>
                    <?php endif; ?>
                </a>
                <?php if ($user): ?>
                    <div class="user-menu">
                        <div class="user-menu-toggle">👤 <?php echo htmlspecialchars($user['full_name'] ?? 'User'); ?></div>
                        <div class="user-menu-dropdown">
                            <a href="/profile.php">Hồ sơ cá nhân</a>
                            <a href="/orders.php">Đơn hàng của tôi</a>
                            <a href="/logout.php">Đăng xuất</a>
                        </div>
                    </div>
                    <script>
                        document.querySelector('.user-menu-toggle').addEventListener('click', function() {
                            document.querySelector('.user-menu-dropdown').classList.toggle('active');
                        });
                        document.addEventListener('click', function(e) {
                            if (!e.target.closest('.user-menu')) {
                                document.querySelector('.user-menu-dropdown').classList.remove('active');
                            }
                        });
                    </script>
                <?php else: ?>
                    <a href="/login.php">Đăng nhập</a>
                    <a href="/register.php">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="main-container">
        <?php
        $success = getFlash('success');
        $error = getFlash('error');
        $warning = getFlash('warning');

        if ($success) {
            echo '<div class="alert alert-success">' . htmlspecialchars($success) . '</div>';
        }
        if ($error) {
            echo '<div class="alert alert-error">' . htmlspecialchars($error) . '</div>';
        }
        if ($warning) {
            echo '<div class="alert alert-warning">' . htmlspecialchars($warning) . '</div>';
        }
        ?>
