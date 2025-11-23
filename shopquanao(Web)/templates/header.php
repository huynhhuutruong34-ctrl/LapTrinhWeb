<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . SHOP_NAME : SHOP_NAME; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #d32f2f;
            text-decoration: none;
        }

        nav a {
            text-decoration: none;
            color: #333;
            margin-left: 25px;
            font-size: 16px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #d32f2f;
        }

        nav a.active {
            color: #d32f2f;
            font-weight: bold;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-badge {
            background-color: #d32f2f;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .content {
            min-height: calc(100vh - 200px);
        }

        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
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

        .btn {
            padding: 10px 20px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #b71c1c;
        }

        .btn-secondary {
            background-color: #666;
        }

        .btn-secondary:hover {
            background-color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 20px;
        }

        table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
            min-height: 40px;
        }

        .product-price {
            color: #d32f2f;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .product-actions form {
            flex: 1;
        }

        input[type="number"] {
            width: 50px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .admin-menu {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .admin-menu a {
            padding: 10px 15px;
            background-color: #666;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .admin-menu a:hover,
        .admin-menu a.active {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="/" class="logo">MODA.vn</a>
            <nav>
                <a href="/" <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'class="active"' : ''; ?>>Trang chủ</a>
                <a href="/catalog.php" <?php echo (basename($_SERVER['PHP_SELF']) === 'catalog.php') ? 'class="active"' : ''; ?>>Danh mục</a>
                <a href="/cart.php" <?php echo (basename($_SERVER['PHP_SELF']) === 'cart.php') ? 'class="active"' : ''; ?>>
                    Giỏ hàng
                    <?php 
                        $cart = getCart();
                        if (count($cart) > 0) {
                            echo '<span class="cart-badge">' . count($cart) . '</span>';
                        }
                    ?>
                </a>
                <a href="/admin/" <?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? 'class="active"' : ''; ?>>Admin</a>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="content">
