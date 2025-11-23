<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

$product_id = (int)($_GET['id'] ?? 0);

if ($product_id <= 0) {
    setFlash('error', 'Dữ liệu không hợp lệ');
    redirect('/cart.php');
}

removeFromCart($product_id);
setFlash('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
redirect('/cart.php');
