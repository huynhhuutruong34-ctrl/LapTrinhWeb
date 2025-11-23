<?php
$page_title = 'Đơn hàng của tôi - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

require 'includes/header.php';
?>

<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Đơn hàng của tôi</h1>

    <?php if (empty($orders)): ?>
        <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">Bạn chưa có đơn hàng nào</p>
            <a href="/shop.php" style="display: inline-block; padding: 0.75rem 1.5rem; background: #3498db; color: white; text-decoration: none; border-radius: 4px;">
                Bắt đầu mua sắm
            </a>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 1.5rem;">
            <?php foreach ($orders as $order): ?>
                <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <p style="color: #666; font-size: 0.9rem;">Mã đơn hàng</p>
                            <p style="font-weight: bold; font-size: 1.1rem;">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem;">Ngày đặt</p>
                            <p style="font-weight: bold; font-size: 1.1rem;"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem;">Tổng tiền</p>
                            <p style="font-weight: bold; font-size: 1.1rem; color: #27ae60;"><?php echo formatPrice($order['total_amount']); ?></p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem;">Trạng thái</p>
                            <p style="font-weight: bold; font-size: 1.1rem;">
                                <?php if ($order['status'] === 'confirmed'): ?>
                                    <span style="background: #3498db; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Xác nhận</span>
                                <?php elseif ($order['status'] === 'shipped'): ?>
                                    <span style="background: #f39c12; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Đang giao</span>
                                <?php elseif ($order['status'] === 'delivered'): ?>
                                    <span style="background: #27ae60; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Đã giao</span>
                                <?php else: ?>
                                    <span style="background: #95a5a6; color: white; padding: 0.25rem 0.75rem; border-radius: 4px;">Chờ xử lý</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <a href="/order-detail.php?id=<?php echo $order['id']; ?>" style="color: #3498db; text-decoration: none; font-weight: bold;">
                        Xem chi tiết →
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require 'includes/footer.php'; ?>
