<?php
require_once '../../config/database.php';
require_once '../../includes/functions.php';

requireAdmin();

$order_id = (int)($_POST['order_id'] ?? 0);
$status = $_POST['status'] ?? '';

if ($order_id <= 0) {
    setFlash('error', 'Đơn hàng không hợp lệ');
    redirect('/admin/orders.php');
}

$valid_statuses = ['pending', 'confirmed', 'shipped', 'delivered'];
if (!in_array($status, $valid_statuses)) {
    setFlash('error', 'Trạng thái không hợp lệ');
    redirect('/admin/orders.php');
}

try {
    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $stmt->execute([$status, $order_id]);
    setFlash('success', 'Cập nhật trạng thái đơn hàng thành công');
} catch (Exception $e) {
    setFlash('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
}

redirect('/admin/orders.php');
