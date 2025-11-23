<?php
$page_title = 'Chi tiết đơn hàng - Laptop Shop';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireAdmin();

$order_id = (int)($_GET['id'] ?? 0);
if ($order_id <= 0) {
    redirect('/admin/orders.php');
}

$stmt = $pdo->prepare('SELECT o.*, u.email, u.full_name, u.phone FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?');
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    redirect('/admin/orders.php');
}

$stmt = $pdo->prepare('SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

require '../includes/header.php';
?>

<section style="padding: 2rem 0;">
    <a href="/admin/orders.php" style="color: #3498db; text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Quay lại</a>

    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Chi tiết đơn hàng #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem;">Thông tin khách hàng</h3>
            <p style="margin-bottom: 0.75rem;"><strong>Tên:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
            <p style="margin-bottom: 0.75rem;"><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
            <p style="margin-bottom: 0.75rem;"><strong>Điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem;">Thông tin đơn hàng</h3>
            <p style="margin-bottom: 0.75rem;"><strong>Ngày:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
            <p style="margin-bottom: 0.75rem;"><strong>Trạng thái:</strong>
                <?php if ($order['status'] === 'pending'): ?>
                    <span style="background: #95a5a6; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Chờ xử lý</span>
                <?php elseif ($order['status'] === 'confirmed'): ?>
                    <span style="background: #3498db; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Xác nhận</span>
                <?php elseif ($order['status'] === 'shipped'): ?>
                    <span style="background: #f39c12; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Đang giao</span>
                <?php elseif ($order['status'] === 'delivered'): ?>
                    <span style="background: #27ae60; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Đã giao</span>
                <?php endif; ?>
            </p>
            <p style="margin-bottom: 0.75rem;"><strong>Tổng tiền:</strong> <span style="color: #27ae60; font-size: 1.1rem; font-weight: bold;"><?php echo formatPrice($order['total_amount']); ?></span></p>
        </div>
    </div>

    <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem;">Địa chỉ giao hàng</h3>
        <p style="white-space: pre-wrap; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($order['shipping_address']); ?></p>
        <p><?php echo htmlspecialchars($order['shipping_city']); ?></p>
    </div>

    <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem;">Sản phẩm</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                    <th style="text-align: left; padding: 1rem;">Sản phẩm</th>
                    <th style="text-align: center; padding: 1rem;">Số lượng</th>
                    <th style="text-align: right; padding: 1rem;">Giá</th>
                    <th style="text-align: right; padding: 1rem;">Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;"><?php echo htmlspecialchars($item['name']); ?></td>
                        <td style="text-align: center; padding: 1rem;"><?php echo $item['quantity']; ?></td>
                        <td style="text-align: right; padding: 1rem;"><?php echo formatPrice($item['price']); ?></td>
                        <td style="text-align: right; padding: 1rem; font-weight: bold;"><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 1.5rem; border-top: 2px solid #ddd; padding-top: 1rem;">
            <div style="display: flex; justify-content: flex-end;">
                <div style="width: 300px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                        <span>Tạm tính:</span>
                        <span><?php echo formatPrice($order['total_amount']); ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span>Vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div style="border-top: 1px solid #ddd; padding-top: 1rem; display: flex; justify-content: space-between;">
                        <span style="font-weight: bold; font-size: 1.1rem;">Tổng cộng:</span>
                        <span style="font-size: 1.3rem; font-weight: bold; color: #27ae60;">
                            <?php echo formatPrice($order['total_amount']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="/admin/orders.php" style="display: inline-block; padding: 0.75rem 1.5rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 4px;">
        ← Quay lại
    </a>
</section>

<?php require '../includes/footer.php'; ?>
