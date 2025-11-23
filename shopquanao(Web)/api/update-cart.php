<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$product_id = (int)($_POST['product_id'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 0);

if ($product_id <= 0) {
    setFlash('error', 'Dữ liệu không hợp lệ');
    redirect($_SERVER['HTTP_REFERER'] ?? '/cart.php');
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    setFlash('error', 'Sản phẩm không tồn tại');
    redirect($_SERVER['HTTP_REFERER'] ?? '/cart.php');
}

if ($quantity > 0 && $quantity > $product['stock']) {
    setFlash('error', 'Không ��ủ hàng');
    redirect($_SERVER['HTTP_REFERER'] ?? '/cart.php');
}

if ($quantity <= 0) {
    removeFromCart($product_id);
    setFlash('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
} else {
    updateCartItem($product_id, $quantity);
    setFlash('success', 'Đã cập nhật giỏ hàng');
}

redirect($_SERVER['HTTP_REFERER'] ?? '/cart.php');
