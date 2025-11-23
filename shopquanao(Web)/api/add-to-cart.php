<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$product_id = (int)($_POST['product_id'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 1);

if ($product_id <= 0 || $quantity <= 0) {
    setFlash('error', 'Dữ liệu không hợp lệ');
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    setFlash('error', 'Sản phẩm không tồn tại');
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}

if ($product['stock'] < $quantity) {
    setFlash('error', 'Không đủ hàng');
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}

addToCart($product_id, $quantity);
setFlash('success', 'Đã thêm sản phẩm vào giỏ hàng');
redirect($_SERVER['HTTP_REFERER'] ?? '/');
