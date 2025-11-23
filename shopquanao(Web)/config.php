<?php
session_start();

// Cấu hình cửa hàng
define('SHOP_NAME', 'MODA.vn - Cửa hàng quần áo');
define('ADMIN_PASSWORD', 'admin123'); // Đơn giản cho demo
define('CURRENCY', '₫');

// Danh sách sản phẩm (tạm thời - sẽ thay bằng database)
$products = [
    1 => [
        'id' => 1,
        'name' => 'Áo Thun Nam Cơ Bản',
        'price' => 150000,
        'description' => 'Áo thun nam cao cấp, thoải mái mặc cả ngày',
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop',
        'category' => 'nam'
    ],
    2 => [
        'id' => 2,
        'name' => 'Áo Sơ Mi Nam Trắng',
        'price' => 350000,
        'description' => 'Áo sơ mi nam đẹp, phù hợp cho công sở',
        'image' => 'https://images.unsplash.com/photo-1556821552-9f6db235933a?w=500&h=500&fit=crop',
        'category' => 'nam'
    ],
    3 => [
        'id' => 3,
        'name' => 'Quần Jean Nam Xanh',
        'price' => 450000,
        'description' => 'Quần jean nam chất lượng cao, bền và đẹp',
        'image' => 'https://images.unsplash.com/photo-1542272604-787c62d465d1?w=500&h=500&fit=crop',
        'category' => 'nam'
    ],
    4 => [
        'id' => 4,
        'name' => 'Áo Dây Nữ Hồng',
        'price' => 200000,
        'description' => 'Áo dây nữ mềm mại, thích hợp cho mùa hè',
        'image' => 'https://images.unsplash.com/photo-1551028719-00167b16ebc5?w=500&h=500&fit=crop',
        'category' => 'nu'
    ],
    5 => [
        'id' => 5,
        'name' => 'Quần Shorts Nữ Trắng',
        'price' => 280000,
        'description' => 'Quần shorts nữ form vừa vặn, thoáng mát',
        'image' => 'https://images.unsplash.com/photo-1506629082632-401017062ee9?w=500&h=500&fit=crop',
        'category' => 'nu'
    ],
    6 => [
        'id' => 6,
        'name' => 'Váy Liền Nữ Đen',
        'price' => 550000,
        'description' => 'Váy liền nữ thanh lịch, dễ phối đồ',
        'image' => 'https://images.unsplash.com/photo-1589411954174-786cb883fdf4?w=500&h=500&fit=crop',
        'category' => 'nu'
    ],
];

// Kiểm tra admin đã đăng nhập
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Chuyển hướng nếu chưa đăng nhập (cho admin pages)
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

// Lấy thông tin giỏ hàng từ session
function getCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

// Lưu giỏ hàng vào session
function saveCart($cart) {
    $_SESSION['cart'] = $cart;
}

// Format tiền tệ
function formatPrice($price) {
    return number_format($price, 0, ',', '.') . CURRENCY;
}
?>
