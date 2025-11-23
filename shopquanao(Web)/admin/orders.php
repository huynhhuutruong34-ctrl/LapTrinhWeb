<?php
require '../config.php';
requireAdminLogin();
$pageTitle = 'Quản lý đơn hàng';

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action === 'update_status' && isset($_POST['order_index']) && isset($_POST['status'])) {
        $order_index = intval($_POST['order_index']);
        $status = $_POST['status'];

        if (isset($_SESSION['orders'][$order_index])) {
            $_SESSION['orders'][$order_index]['status'] = $status;
            $_SESSION['success'] = '✓ Cập nhật trạng thái thành công!';
        }
    }

    header('Location: orders.php');
    exit;
}

include_once '../templates/header.php';
?>

<style>
    .admin-header {
        background-color: #333;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: -20px;
        margin-left: -20px;
        margin-right: -20px;
        margin-bottom: 20px;
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

    .admin-menu a:hover {
        background-color: #d32f2f;
    }

    .alert {
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 4px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .order-detail {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .order-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
    }

    .order-info {
        margin-bottom: 15px;
    }

    .order-info strong {
        display: block;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 3px;
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
        margin-top: 10px;
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

    .status-select {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-shipped {
        background-color: #cce5ff;
        color: #004085;
    }

    .status-delivered {
        background-color: #d4edda;
        color: #155724;
    }

    .order-items {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        margin: 15px 0;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        background-color: white;
        border-radius: 8px;
    }
</style>

<div class="admin-header">
    <h1>MODA.vn - Quản lý đơn hàng</h1>
    <a href="logout.php">Đăng xuất</a>
</div>

<div>
    <div class="admin-menu">
        <a href="dashboard.php">← Quay lại Dashboard</a>
        <a href="products.php">Quản lý sản phẩm</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <h2>Danh sách đơn hàng</h2>

    <?php if (isset($_SESSION['orders']) && count($_SESSION['orders']) > 0): ?>

        <?php 
        $statuses = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipped' => 'Đang giao',
            'delivered' => 'Đã giao'
        ];

        foreach (array_reverse($_SESSION['orders'], true) as $index => $order):
            $order_index = count($_SESSION['orders']) - 1 - $index;
        ?>

        <div class="order-detail">
            <div class="order-header">
                <div class="order-info">
                    <strong>Mã đơn hàng</strong>
                    <?php echo htmlspecialchars($order['order_id']); ?>
                </div>
                <div class="order-info">
                    <strong>Ngày đặt</strong>
                    <?php echo $order['date']; ?>
                </div>
                <div class="order-info">
                    <strong>Tổng tiền</strong>
                    <span style="color: #d32f2f; font-size: 18px; font-weight: bold;"><?php echo formatPrice($order['total']); ?></span>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <strong>Thông tin khách hàng</strong>
                <p>
                    <?php echo htmlspecialchars($order['customer']['fullname']); ?><br>
                    <?php echo htmlspecialchars($order['customer']['phone']); ?> | 
                    <?php echo htmlspecialchars($order['customer']['email']); ?><br>
                    <?php echo htmlspecialchars($order['customer']['address']); ?>
                </p>
            </div>

            <div class="order-items">
                <strong>Sản phẩm đặt hàng:</strong>
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo formatPrice($item['price']); ?></td>
                            <td><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <strong>Trạng thái:</strong>
                <form method="POST" action="orders.php" style="display: flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="order_index" value="<?php echo array_search($order, $_SESSION['orders']); ?>">
                    <select name="status" class="status-select">
                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                        <option value="confirmed" <?php echo $order['status'] === 'confirmed' ? 'selected' : ''; ?>>Đã xác nhận</option>
                        <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Đang giao</option>
                        <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Đã giao</option>
                    </select>
                    <button type="submit" class="btn" style="padding: 8px 15px;">Cập nhật</button>
                </form>
            </div>
        </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="empty-state">
            <p style="font-size: 18px; margin-bottom: 20px;">Chưa có đơn hàng nào!</p>
            <a href="/" class="btn">Quay lại trang chủ</a>
        </div>

    <?php endif; ?>
</div>

<?php include '../templates/footer.php'; ?>
