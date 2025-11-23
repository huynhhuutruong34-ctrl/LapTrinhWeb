<?php
require '../config.php';
requireAdminLogin();
$pageTitle = 'Admin Dashboard';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SHOP_NAME; ?> - Admin</title>
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

        .admin-header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            font-size: 24px;
        }

        .admin-header a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #d32f2f;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .admin-header a:hover {
            background-color: #b71c1c;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .nav-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .nav-card h2 {
            color: #d32f2f;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .nav-card p {
            color: #666;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-box h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-box .number {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .stat-box .number.primary {
            color: #d32f2f;
        }

        .content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #b71c1c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>MODA.vn - Quản lý cửa hàng</h1>
        <a href="logout.php">Đăng xuất</a>
    </div>

    <div class="admin-container">
        <h2>Chào mừng quay lại, Admin!</h2>

        <!-- Thống kê -->
        <div class="stats">
            <div class="stat-box">
                <h3>Tổng sản phẩm</h3>
                <div class="number primary"><?php echo count($products); ?></div>
            </div>
            <div class="stat-box">
                <h3>Tổng đơn hàng</h3>
                <div class="number primary">
                    <?php 
                    $totalOrders = isset($_SESSION['orders']) ? count($_SESSION['orders']) : 0;
                    echo $totalOrders;
                    ?>
                </div>
            </div>
            <div class="stat-box">
                <h3>Doanh thu</h3>
                <div class="number primary">
                    <?php 
                    if (isset($_SESSION['orders'])) {
                        $revenue = 0;
                        foreach ($_SESSION['orders'] as $order) {
                            $revenue += $order['total'];
                        }
                        echo formatPrice($revenue);
                    } else {
                        echo '0₫';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Menu chính -->
        <div style="margin-bottom: 30px;">
            <h3>Quản lý</h3>
            <div class="admin-nav">
                <a href="products.php" class="nav-card">
                    <h2>📦 Sản phẩm</h2>
                    <p>Thêm, sửa, xóa sản phẩm</p>
                </a>
                <a href="orders.php" class="nav-card">
                    <h2>📋 Đơn hàng</h2>
                    <p>Xem và quản lý đơn hàng</p>
                </a>
            </div>
        </div>

        <!-- Đơn hàng mới nhất -->
        <?php if (isset($_SESSION['orders']) && count($_SESSION['orders']) > 0): ?>
        <div class="content">
            <h3>Đơn hàng mới nhất</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $recentOrders = array_slice($_SESSION['orders'], -5);
                    foreach (array_reverse($recentOrders) as $order):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer']['fullname']); ?></td>
                        <td><?php echo $order['date']; ?></td>
                        <td><?php echo formatPrice($order['total']); ?></td>
                        <td>
                            <span style="padding: 4px 8px; background-color: #fff3cd; color: #856404; border-radius: 4px; font-size: 12px;">
                                <?php 
                                $statuses = [
                                    'pending' => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipped' => 'Đang giao',
                                    'delivered' => 'Đã giao'
                                ];
                                echo isset($statuses[$order['status']]) ? $statuses[$order['status']] : $order['status'];
                                ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;">
                <a href="orders.php" class="btn">Xem tất cả đơn hàng →</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
