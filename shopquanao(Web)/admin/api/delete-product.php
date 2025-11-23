<?php
require_once '../../config/database.php';
require_once '../../includes/functions.php';

requireAdmin();

$product_id = (int)($_GET['id'] ?? 0);

if ($product_id <= 0) {
    setFlash('error', 'Sản phẩm không hợp lệ');
    redirect('/admin/products.php');
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
if (!$stmt->fetch()) {
    setFlash('error', 'Sản phẩm không tồn tại');
    redirect('/admin/products.php');
}

try {
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    setFlash('success', 'Xóa sản phẩm thành công');
} catch (Exception $e) {
    setFlash('error', 'Lỗi khi xóa sản phẩm: ' . $e->getMessage());
}

redirect('/admin/products.php');
